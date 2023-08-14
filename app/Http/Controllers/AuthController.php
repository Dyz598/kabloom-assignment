<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class AuthController extends Controller
{
    public function me(Request $request): User
    {
        /** @var User $user */
        $user = $request->user();

        $user->load('profile');

        return $user;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $payload = $request->validated();

        if (Auth::attempt(['email' => $payload['email'], 'password' => $payload['password']])) {
            $request->session()->regenerate();

            return response()->json(['success' => true]);
        }

        throw new AuthorizationException('Email/Password is invalid.', 401);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    public function socialLogin(Request $request): RedirectResponse
    {
        return Socialite::driver($request->route('provider'))->redirect();
    }

    public function socialLoginCallback(Request $request): RedirectResponse
    {
        $provider = $request->route('provider');
        $socialiteUser = Socialite::driver($provider)->user();
        $user = User::query()
            ->where(sprintf('%s_id', $provider), $socialiteUser->getId())
            ->orWhere('email', $socialiteUser->getEmail())
            ->first();

        if (null === $user) {
            $user = new User();
            $user->fill(['name' => $socialiteUser->getName(), 'email' => $socialiteUser->getEmail()]);
        }

        $user->{sprintf('%sId', $provider)} = $socialiteUser->getId();

        $user->save();

        Auth::login($user);

        return redirect('app');
    }
}