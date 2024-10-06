<?php

use App\Http\Controllers\Api\V1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\ProfileController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\SocialiteController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Guest Routes
Route::middleware(["guest"])->prefix("/auth")->group(function () {
    Route::post('/register', RegisterController::class)->name('register');

    Route::post('/login', LoginController::class)->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::middleware(['api'])->group(function () {
        Route::get('google/redirect', [SocialiteController::class, 'google_redirect']);
        Route::get('google/callback', [SocialiteController::class, 'google_callback']);
    });
});

//Auth Routes
Route::middleware(['auth:sanctum'])->prefix('/auth')->group(function () {

    Route::get("/user", function (Request $request) {
        return \App\Http\Resources\UserResource::make($request->user());
    });

    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});
