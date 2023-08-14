<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use LogicException;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class ProfileController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();
        $profileFollows = $user->profileFollows()
            ->wherePivot('followed', true)
            ->get();

        $profiles = Profile::with('user')->get()->map(function (Profile $profile) use ($user, $profileFollows) {
            return [
                'id'            => $profile->getKey(),
                'name'          => $profile->user->name,
                'email'         => $profile->user->email,
                'content_genre' => $profile->contentGenre,
                'followed'      => $profileFollows->contains(function (Profile $followedProfile) use ($profile) {
                    return $followedProfile->getKey() === $profile->getKey();
                })
            ];
        })->all();

        return Inertia::render('Creator/List', ['creators' => $profiles]);
    }

    public function show(Profile $profile, Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $profileFollow = $user
            ->profileFollows()
            ->wherePivot('profile_id', $profile->getKey())
            ->first();

        // Check Midtrans and update if already paid
        if (
            null !== $profileFollow &&
            $profileFollow->pivot->payment_id &&
            !$profileFollow->pivot->subscription_paid
        ) {
            $status = (array) Transaction::status($profileFollow->pivot->payment_id);

            if ('capture' === $status['transaction_status']) {
                $user->profileFollows()->updateExistingPivot(
                    $profile->getKey(),
                    ['subscription_paid' => true]
                );

                $profileFollow->pivot->subscription_paid = true;
            }
        }

        $profileData = [
            'id'                 => $profile->getKey(),
            'user_id'            => $profile->userId,
            'name'               => $profile->user->name,
            'email'              => $profile->user->email,
            'content_genre'      => $profile->contentGenre,
            'about'              => $profile->about,
            'subscription_price' => $profile->subscriptionPrice,
            'followed'           => $profileFollow->pivot->followed ?? false,
            'subscribed'         => $profileFollow->pivot->subscription_paid ?? false,
        ];

        return Inertia::render('Creator/Detail', ['profile' => $profileData, 'user' => $user]);
    }

    public function follow(Profile $profile, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->getKey() === $profile->user->getKey()) {
            throw new LogicException('User cannot follow its own profile.', 400);
        }

        /** @var Profile $profileFollow */
        $profileFollow = $user->profileFollows()
            ->wherePivot('profile_id', $profile->getKey())
            ->first();

        if (null === $profileFollow) {
            $user->profileFollows()->attach($profile->getKey());
        } else {
            $user->profileFollows()->updateExistingPivot(
                $profile->getKey(),
                ['followed' => !$profileFollow->pivot->followed]
            );
        }

        return response()->json(['success' => true]);
    }

    public function subscribe(Profile $profile, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->getKey() === $profile->user->getKey()) {
            throw new LogicException('User cannot subscribe to its own content.', 400);
        }

        /** @var Profile $profileFollow */
        $profileFollow = $user->profileFollows()
            ->wherePivot('profile_id', $profile->getKey())
            ->first();

        if ($profileFollow?->pivot?->subscription_paid) {
            throw new LogicException('User already subscribed.', 400);
        }

        $paymentId = Str::uuid()->toString();

        if (null === $profileFollow) {
            $user->profileFollows()->attach($profile->getKey());
        }

        $user->profileFollows()->updateExistingPivot(
            $profile->getKey(),
            ['payment_id' => $paymentId]
        );

        $transactionDetails = [
            'order_id'     => $paymentId,
            'gross_amount' => $profile->subscriptionPrice,
        ];

        $itemDetails = [
            [
                'id'       => $profile->getKey(),
                'price'    => $profile->subscriptionPrice,
                'quantity' => 1,
                'name'     => sprintf('Subscription to %s content.', $profile->user->name),
            ],
        ];

        $customerDetails = [
            'first_name' => $user->name,
            'email'      => $user->email,
        ];

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
            'item_details'        => $itemDetails,
            'callbacks'           => [
                'finish' => sprintf('%s/app/creators/%s', config('app.url'), $profile->getKey()),
            ],
        ];

        $paymentUrl = Snap::createTransaction($params)->redirect_url;

        return response()->json(['payment_url' => $paymentUrl]);
    }

    public function register(RegisterProfileRequest $request): JsonResponse
    {
        $payload = $request->validated();
        /** @var User $user */
        $user = $request->user();

        if ($user->profile) {
            throw new LogicException('User is already a content creator.', 400);
        }

        $profile = new Profile();
        $profile->fill($payload);

        $profile->user()->associate($user);

        $profile->save();

        return response()->json(['success' => true]);
    }
}