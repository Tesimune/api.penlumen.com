<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * @group Auth Endpoints
 *
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * Login.
     */
    public function store(LoginRequest $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        $login = [
            'email' => $validated['email'],
            'password' => $validated['password']
        ];

        if (!Auth::attempt($login)) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' =>  'Bad Credentials'
            ], 401);
        }

        $user = User::where('email', $request['email'])->first();

        if ($user) {
            $token = $user->createToken('token')->plainTextToken;
            $user->save();
        } else {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' =>  'Account is currently disabled'
            ], 401);
        }

        $request = [
            'status' => 200,
            'success' => true,
            'message' => 'Login successful',
            'token' => $token
        ];

        return response()->json($request);
    }

    /**
     * Logout.
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->token()->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Logout successful'
        ]);
    }
}
