<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\Response
    {

        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
