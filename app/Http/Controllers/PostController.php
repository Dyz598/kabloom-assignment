<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class PostController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $user */
        $user = $request->user();
        $subscribedProfiles = $user->profileFollows()
            ->wherePivot('subscription_paid', true)
            ->get();

        $posts = Post::query()
            ->latest()
            ->with(['profile.user'])
            ->get()
            ->map(function (Post $post) use ($subscribedProfiles, $user) {
                return [
                    'id'                => $post->getKey(),
                    'title'             => $post->title,
                    'content'           => $post->content,
                    'public'            => $post->public,
                    'created_at'        => $post->createdAt->format('M d, Y'),
                    'content_genre'     => $post->profile->contentGenre,
                    'profile_name'      => $post->profile->user->name,
                    'subscription_paid' => $user->getKey() === $post->profile->user->getKey() || $subscribedProfiles->contains(function (Profile $subscribedProfile) use ($post) {
                        return $subscribedProfile->getKey() === $post->profile->getKey();
                    }),
                ];
            })->all();

        return Inertia::render('Post/List', ['posts' => $posts]);
    }

    public function show(Post $post, Request $request): Response|RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $subscriptionPaid = null !== $user
            ->profileFollows()
            ->wherePivot('profile_id', $post->profile->getKey())
            ->wherePivot('subscription_paid', true)
            ->first();

        if ($user->getKey() !== $post->profile->user->getKey() && !$post->public) {
            if (!$subscriptionPaid) {
                return to_route('app');
            }
        }

        $postData = [
            'id'                => $post->getKey(),
            'title'             => $post->title,
            'content'           => $post->content,
            'public'            => $post->public,
            'created_at'        => $post->createdAt->format('M d, Y'),
            'content_genre'     => $post->profile->contentGenre,
            'profile_name'      => $post->profile->user->name,
        ];

        return Inertia::render('Post/Detail', ['post' => $postData]);
    }

    public function store(CreatePostRequest $request): JsonResponse
    {
        $payload = $request->validated();
        /** @var User $user */
        $user = $request->user();

        $post = new Post();
        $post->fill($payload);

        $post->profile()->associate($user->profile);

        $post->save();

        return response()->json(['success' => true]);
    }
}