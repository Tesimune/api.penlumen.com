<?php

use App\Http\Controllers\DriveController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix("{lumen:username}/google/drive")->name("google.drive.")->group(function () {
    Route::get('/files', [DriveController::class, 'index']);
    Route::get('/file/{id}', [DriveController::class, 'show']);
    Route::post('/file', [DriveController::class, 'create']);
    Route::put('/file/{id}', [DriveController::class, 'update']);
    Route::delete('/file/{id}', [DriveController::class, 'delete']);
});
