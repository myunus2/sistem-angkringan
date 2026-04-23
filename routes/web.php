<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\AdminController;

// Halaman utama
Route::get('/', [OrderController::class, 'index'])->name('index');

// API payment
Route::prefix('api/payment-methods')->group(function () {
    Route::get('/', [PaymentMethodController::class, 'getActive']);
    Route::get('/type/{type}', [PaymentMethodController::class, 'getByType']);
    Route::post('/', [PaymentMethodController::class, 'store']);
    Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update']);
    Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy']);
});

// DASHBOARD ADMIN
Route::get('/admind', [AdminController::class, 'dashboard']);
Route::get('/filament-fix', function () {
    return redirect('/admin');
})->name('filament.admin.pages.dashboard');