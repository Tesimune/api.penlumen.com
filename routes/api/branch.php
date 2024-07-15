<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;

Route::middleware(['auth:sanctum', 'verified'])->prefix("{lumen:username}/{draft:slug}/branch")->name("draft.branch.")->group(function () {
    Route::get('/', [BranchController::class, "index"])->name('index');
    Route::post('/create', [BranchController::class, "store"])->name('store');
    Route::get('/show/{branch:slug}', [BranchController::class, "show"])->name('show');
    Route::put('update/{branch:slug}', [BranchController::class, "update"])->name('update');
    Route::delete('delete/{branch:slug}', [BranchController::class, "destroy"])->name('delete');
});