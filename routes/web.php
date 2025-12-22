<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelOrderController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TravelOrderController::class, 'index'])->name('dashboard');

    Route::post('/travel-orders', [TravelOrderController::class, 'store'])->name('travel-orders.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
