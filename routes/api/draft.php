<?php

use App\Http\Controllers\DraftController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->prefix("{lumen:username}/draft")->name("draft.")->group(function () {
    Route::get('/', [DraftController::class, "index"])->name('index');
    Route::post('create/', [DraftController::class, "store"])->name('store');
    Route::get('/show/{draft:slug}', [DraftController::class, "show"])->name('show');
    Route::put('update/{draft:slug}', [DraftController::class, "update"])->name('update');
    Route::delete('delete/{draft:slug}', [DraftController::class, "destroy"])->name('delete');
});