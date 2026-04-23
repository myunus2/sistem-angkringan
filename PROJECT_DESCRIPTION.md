# Project Description

## Sistem Pemesanan Angkringan Modern

Aplikasi ini adalah sistem pemesanan berbasis web untuk usaha angkringan. Proyek dibuat dengan Laravel dan Filament untuk menghadirkan pengalaman pelanggan sederhana sekaligus menyediakan panel admin yang mudah digunakan untuk manajemen produk dan pemesanan.

## Tujuan

- Menyediakan tampilan menu online untuk pelanggan angkringan.
- Mengelola produk, kategori, dan stok melalui dashboard admin.
- Menyajikan ringkasan pesanan dan statistik pendapatan kepada administrator.
- Menyediakan API dasar untuk pengelolaan metode pembayaran.

## Fitur Utama

- Halaman depan menu dengan daftar produk, kategori, dan pencarian.
- Kategori produk: makanan, minuman, snack.
- Informasi produk meliputi nama, harga, stok, kategori, dan gambar.
- Dashboard admin dengan Filament untuk mengelola produk dan melihat metrik pesanan.
- Endpoint API `payment-methods` untuk membuat, membaca, memperbarui, dan menghapus metode pembayaran.

## Struktur Utama

- `routes/web.php`
  - Rute halaman utama pelanggan.
  - Rute API `payment-methods`.
  - Rute dashboard admin.
- `app/Http/Controllers/OrderController.php`
  - Menampilkan halaman menu pelanggan.
- `app/Http/Controllers/PaymentMethodController.php`
  - Mengelola metode pembayaran melalui API.
- `app/Http/Controllers/AdminController.php`
  - Menyediakan data statistik untuk tampilan dashboard admin.
- `app/Models/`
  - Model Laravel untuk `Product`, `Category`, `Order`, `OrderItem`, `Transaction`, `Table`, `PaymentMethod`, dan `User`.
- `app/Filament/`
  - Sumber daya dan halaman admin serta konfigurasi Filament.
- `resources/views/order/index.blade.php`
  - Halaman depan pemesanan dengan antarmuka responsif.

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
4. Konfigurasikan koneksi database di file `.env`.
5. Jalankan migrasi dengan `php artisan migrate`.
6. Jalankan server lokal dengan `php artisan serve`.

Akses aplikasi:
- Halaman publik: `http://127.0.0.1:8000`
- Dashboard admin: `http://127.0.0.1:8000/admin`

## Catatan Tambahan

Proyek ini cocok dikembangkan lebih lanjut dengan fitur checkout, integrasi pembayaran digital, otentikasi pelanggan, dan pengelolaan status pesanan secara real-time.