<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @group Auth Endpoints.
 *
 */
class RegisteredUserController extends Controller
{
    /**
     * Register.
     * @bodyParam password_confirmation string Example: password_confirmation
     *
     * @throws ValidationException
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        event(new Registered($user));

        $token = $user->createToken('token', ["*"], now()->addHour(24))->plainTextToken;

        return response()->json([
            "token" => $token,
            "token_expires_at" => now()->addHour(24),
            "token_type" => "Bearer",
        ], 201);
    }
}
