<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| PRODUK
|--------------------------------------------------------------------------
*/
Route::get('/products/create', function () {
    return view('products.create');
});
Route::post('/products', [ProductController::class, 'store']);

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', [KasirController::class, 'index'])->name('index');

/*
|--------------------------------------------------------------------------
| CUSTOMER CHECKOUT
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
// Mengubah {order} menjadi {id} agar tidak mencari model Order yang sudah dihapus
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

/*
|--------------------------------------------------------------------------
| API PAYMENT
|--------------------------------------------------------------------------
*/
Route::prefix('api/payment-methods')->group(function () {
    Route::get('/', [PaymentMethodController::class, 'getActive']);
    Route::get('/type/{type}', [PaymentMethodController::class, 'getByType']);
    Route::post('/', [PaymentMethodController::class, 'store']);
    Route::put('/{paymentMethod}', [PaymentMethodController::class, 'update']);
    Route::delete('/{paymentMethod}', [PaymentMethodController::class, 'destroy']);
});

/*
|--------------------------------------------------------------------------
| 🔥 KASIR (POS SYSTEM)
|--------------------------------------------------------------------------
*/
Route::redirect('/kasir', '/admin/kasir')->name('kasir');
Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::get('/admin/orders/{order}/receipt', [OrderReceiptController::class, 'show'])
    ->name('admin.orders.receipt');
Route::redirect('/filament-fix', '/admin');
Route::redirect('/admind', '/admin');
