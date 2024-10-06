<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\Response
    {

        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
