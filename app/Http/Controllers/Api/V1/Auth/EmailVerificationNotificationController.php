<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * @group Auth Endpoints.
 *
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send email verify.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                "status" => 200,
                "success" => true,
                "message" => "success",
                "data" => [
                    "message" => "success",
                ]
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "success",
            "data" => [
                "message" => "success",
            ]
        ]);
    }
}
