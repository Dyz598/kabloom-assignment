<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $user = new User();
        $user->fill($payload);

        $user->save();

        return response()->json(['success' => true]);
    }
}