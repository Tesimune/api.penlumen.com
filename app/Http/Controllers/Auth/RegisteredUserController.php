<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $username = explode('@', $request->email)[0];
        $user = User::create([
            'uuid' => Str::uuid(),
            'username' => $username,
            
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        Profile::create([
            'uuid' => Str::uuid(),
            'user_uuid' => $user->uuid,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        event(new Registered($user));

        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
                "token" => $token
            ]
        ]);
    }
}
