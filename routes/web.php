<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;

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
Route::redirect('/filament-fix', '/admin')->name('filament.admin.pages.dashboard');
Route::redirect('/admind', '/admin');
Route::middleware('auth')->get('/admin/order-receipts/{order}', [OrderReceiptController::class, 'show'])
    ->name('admin.orders.receipt');
