<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Auth\StoreUserRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);
        $validated["username"] = $validated["first_name"].$validated["last_name"] . rand(10, 9999);

        return DB::transaction(function () use($validated) {
            $user = User::create($validated);
            Profile::create([
                'user_id' => $user->id,
            ]);

            $token_expires_at = now()->addMinute(config("token_expires_at", 60));
            $token = $user->createToken('token', ["*"], $token_expires_at)->plainTextToken;

            return response()->json([
                "token" => $token,
                "token_expires_at" => $token_expires_at,
                "token_type" => "Bearer",
            ], 201);
        });
    }
}
