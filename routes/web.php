<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

// Halaman utama untuk pelanggan pilih menu
Route::get('/', [OrderController::class, 'index'])->name('index');

// Proses pengiriman pesanan & potong stok
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
