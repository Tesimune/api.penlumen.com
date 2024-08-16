<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Penlumen' => '1.0.0'];
});

Route::prefix("/v1")->group(function () {
    require __DIR__ . '/auth.php';
//    require __DIR__ . '/api/drive.php';
//    require __DIR__ . '/api/branch.php';


    Route::middleware(['api', "auth:sanctum"])->group(function () {
        Route::apiResource('books', BookController::class);
    });
});
