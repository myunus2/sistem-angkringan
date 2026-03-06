<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController; // Pastikan baris ini ada

// Halaman utama untuk pelanggan pilih menu
Route::get('/', [OrderController::class, 'index'])->name('menu.index');

// Proses pengiriman pesanan & potong stok
Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
