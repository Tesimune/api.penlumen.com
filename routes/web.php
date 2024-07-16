<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Penlumen' => '1.0.0'];
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

require __DIR__ . '/auth.php';
require __DIR__ . '/api/draft.php';
require __DIR__ . '/api/drive.php';
require __DIR__ . '/api/branch.php';
