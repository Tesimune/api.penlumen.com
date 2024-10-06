<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * @group Auth Endpoints.
 *
 */
class SocialiteController extends Controller
{
    /**
     * Google auth.
     *
     */
    public function google_redirect()
    {
        try {
            $redirectUrl = Socialite::driver('google')
            // ->scopes([
            //     'https://www.googleapis.com/auth/drive',
            //     'https://www.googleapis.com/auth/drive.file',
            //     'https://www.googleapis.com/auth/drive.metadata',
            //     'https://www.googleapis.com/auth/drive.metadata.readonly',
            //     'https://www.googleapis.com/auth/drive.photos.readonly',
            //     'https://www.googleapis.com/auth/drive.readonly',
            //     'https://www.googleapis.com/auth/drive.appdata'
            // ])
                ->redirect()
                ->getTargetUrl();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Redirect URL generated successfully',
                'data' => [
                    'message' => 'Redirect URL generated successfully',
                    'redirect_url' => $redirectUrl
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Unable to connect to google',
                'data' => [
                    'message' => 'Unable to connect to google',
                    'error' => $e->getMessage()
                ]
            ], 400);
        }
    }


    /**
     * Google callback.
     *
     */
    public function google_callback()
    {
        try {
            $user_data = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Unable to connect to Google',
                'data' => [
                    'message' => 'Unable to connect to Google',
                    'error' => $e->getMessage()
                ]
            ], 400);
        }

        $user = User::where('email', $user_data->email)->first();

        if ($user) {
            $user->google_token = $user_data->token;
            $user->save();

            $token = $user->createToken('token')->plainTextToken;
            session(['google_token' => $user_data->token]);
            return response()->json([
                "status" => 200,
                "success" => true,
                "message" => "success",
                "data" => [
                    "message" => "success",
                    "token" => $token
                ]
            ]);
        } else {
            $pass = Str::random(33);

            $user = User::create([
                'uuid' => Str::uuid(),
                'email' => $user_data->email,
                'username' => explode('@', $user_data->email)[0],
                'password' => Hash::make($pass),
            ]);

            Profile::create([
                "uuid" => Str::uuid(),
                "user_uuid" => $user->uuid,
                "first_name" => $user_data->user["given_name"],
                "last_name" => $user_data->user["family_name"],
                "profile" => $user_data->avatar,
            ]);

            Socialite::create([
                "uuid" => Str::uuid(),
                "user_uuid" => $user->uuid,
                "socialite" => "google",
                "email" => $user->email,
                "token" => $user_data->token,
                "auth_data" => $user_data,
            ]);

            $token = $user->createToken('token')->plainTextToken;

            session(['google_token' => $user_data->token]);

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
}
