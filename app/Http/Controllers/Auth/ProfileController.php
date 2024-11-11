<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


/**
 * @group Auth Endpoints.
 * 
 */
class ProfileController extends Controller
{
    /**
     * Show profile.
     */
    public function show(Request $request)
    {
        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' =>  [
                'message' => 'success',

            ]
        ]);
    }

    /**
     * Update profile.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' =>  [
                'message' => 'success',

            ]
        ]);
    }

    /**
     * Delete account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current-password'],
        ]);

        $user = Auth::user();
        $user->token()->delete();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'success',
            'data' =>  [
                'message' => 'success',

            ]
        ]);
    }
}
