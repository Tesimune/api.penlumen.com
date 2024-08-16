<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
            "remember" => ["nullable", "boolean"],
        ]);

        $user = User::where('email', $request['username'])
            ->orWhere('username', $request['username'])
            ->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response()->json([
                "data" => ["message" => "Invalid Credentials"],
            ], 422);
        }

        if ($user->status != UserStatus::ACTIVE->value) {
            $status = UserStatus::from($user->status)->name;
            return response()->json([
                "data" => ["message" => "Your account is $status Please contact your administrator."],
            ], 422);
        }


        $token_expires_at = now()->addMinute(config("token_expires_at", 60));
        $token = $user->createToken('token', ["*"], $token_expires_at)->plainTextToken;

        return response()->json([
            "token" => $token,
            "token_expires_at" => $token_expires_at,
            "token_type" => "Bearer",
        ], 200);
    }
}
