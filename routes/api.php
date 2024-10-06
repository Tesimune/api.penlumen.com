<?php

use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Penlumen' => '1.0.0'];
});

Route::prefix("/v1")->group(function () {
    // Health Check
    Route::get("/health", function () {
        return "Working Fine and Healthy";
    });

    require __DIR__ . '/auth.php';
//    require __DIR__ . '/api/drive.php';
//    require __DIR__ . '/api/branch.php';


    Route::middleware(['api', "auth:sanctum", "verified"])->group(function () {
        Route::apiResource('books', BookController::class);

    });
});
