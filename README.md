# Sistem Pemesanan Angkringan

Aplikasi web ini adalah sistem pemesanan untuk usaha angkringan modern. Dibangun dengan Laravel dan Filament, proyek ini menyediakan antarmuka pelanggan untuk melihat menu serta dashboard admin untuk mengelola produk dan memonitor pesanan.

## Fitur Utama

- Menu pemesanan angkringan dengan filter kategori: makanan, minuman, snack.
- Tampilan daftar produk dengan foto, harga, stok, dan kategori.
- API `payment-methods` untuk mengelola metode pembayaran (CRUD).
- Dashboard admin dengan Filament untuk menampilkan statistik pesanan dan pendapatan.
- Model data lengkap untuk produk, kategori, pesanan, item pesanan, transaksi, meja, dan pengguna.

## Struktur Proyek

- `routes/web.php` - rute aplikasi utama dan API pembayaran.
- `app/Http/Controllers/OrderController.php` - halaman menu depan untuk pelanggan.
- `app/Http/Controllers/PaymentMethodController.php` - endpoint API metode pembayaran.
- `app/Http/Controllers/AdminController.php` - dashboard admin dan data agregasi pesanan.
- `app/Models/` - model Laravel untuk entitas aplikasi.
- `app/Filament/` - konfigurasi panel Filament, sumber daya, halaman, dan widget admin.
- `resources/views/order/index.blade.php` - halaman depan pemesanan dengan tampilan responsif.

## Teknologi

- Laravel
- PHP
- Filament Admin
- Tailwind CSS
- Blade Templates
- MySQL / database relasional

## Cara Menjalankan

1. Salin file `.env.example` menjadi `.env`.
2. Jalankan `composer install`.
3. Jalankan `php artisan key:generate`.
4. Atur koneksi database di `.env`.
5. Jalankan `php artisan migrate`.
6. Jalankan `php artisan serve`.

> Akses halaman utama di `http://127.0.0.1:8000` dan akses dashboard admin di `http://127.0.0.1:8000/admin`.

## Catatan

Aplikasi ini cocok untuk usaha angkringan yang ingin memperlihatkan menu online dan mengelola transaksi lewat panel admin. Struktur proyek juga memudahkan pengembangan fitur tambahan seperti checkout, notifikasi, atau integrasi pembayaran digital.
