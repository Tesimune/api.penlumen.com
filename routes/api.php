<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Penlumen' => '1.0.0'];
});

Route::prefix("/v1")->group(function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/api/draft.php';
    require __DIR__ . '/api/drive.php';
    require __DIR__ . '/api/branch.php';
});
