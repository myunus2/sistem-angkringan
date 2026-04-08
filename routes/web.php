<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;

// Halaman utama untuk pelanggan pilih menu
Route::get('/', [OrderController::class, 'index'])->name('index');

// API Routes untuk Payment Methods
Route::prefix('api/payment-methods')->group(function () {
    // Get all active payment methods
    Route::get('/', [PaymentMethodController::class, 'getActive']);
    
    // Get payment methods by type (bank or ewallet)
    Route::get('/type/{type}', [PaymentMethodController::class, 'getByType']);
    
    // CRUD operations
    Route::post('/', [PaymentMethodController::class, 'store']);
    Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update']);
    Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy']);
});
