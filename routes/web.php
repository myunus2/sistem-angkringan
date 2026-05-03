<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KasirController;


use App\Http\Controllers\ProductController;

Route::get('/products/create', function () {
    return view('products.create');
});

Route::post('/products', [ProductController::class, 'store']);
/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', [OrderController::class, 'index'])->name('index');

/*
|--------------------------------------------------------------------------
| CUSTOMER CHECKOUT
|--------------------------------------------------------------------------
*/
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

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
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');

/*
|--------------------------------------------------------------------------
| PRINT STRUK
|--------------------------------------------------------------------------
*/
Route::get('/print/{id}', function ($id) {
    $order = \App\Models\Order::with('items.product')->findOrFail($id);
    return view('print.thermal', compact('order'));
})->name('print.struk');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::redirect('/filament-fix', '/admin');
Route::redirect('/admind', '/admin');

Route::middleware('auth')->group(function () {
    Route::get('/admin/order-receipts/{order}', [OrderReceiptController::class, 'show'])
        ->name('admin.orders.receipt');
});