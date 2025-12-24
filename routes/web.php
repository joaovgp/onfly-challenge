<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TravelOrderController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TravelOrderController::class, 'index'])->name('dashboard');

    Route::get('/travel-orders/{id}', [TravelOrderController::class, 'show'])->name('travel-orders.show');
    Route::post('/travel-orders', [TravelOrderController::class, 'store'])->name('travel-orders.store');

    Route::post('/travel-orders/{order}/approve', [TravelOrderController::class, 'approve'])->name('travel-orders.approve');
    Route::post('/travel-orders/{order}/cancel', [TravelOrderController::class, 'cancel'])->name('travel-orders.cancel');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
