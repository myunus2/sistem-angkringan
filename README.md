# Sistem Pemesanan Angkringan

## 📌 Angkringan Cakra 
Sistem Pemesanan Angkringan Berbasis Web

---

## 📖 Deskripsi
Aplikasi web ini adalah sistem pemesanan untuk usaha angkringan modern. Dibangun menggunakan Laravel dan Filament, sistem ini menyediakan antarmuka pelanggan untuk melihat menu serta dashboard admin untuk mengelola produk dan memonitor pesanan.

Aplikasi ini bertujuan untuk membantu digitalisasi usaha angkringan agar lebih efisien, terorganisir, dan mudah dalam pengelolaan transaksi serta pelayanan pelanggan.

---

## 👥 Tim Pengembang

| Nama | NIM |
|------|-----|
| (M.Yunus) | (2330407027) |
| (Anisatun Fauziah) | (2330407005) |
| (Eva Rahmayanti Br Saragih) | (2330407010) |
| (Fadillah Akmal) | (2430407056 ) |

---

## 🚀 Fitur Utama

- Menu pemesanan angkringan dengan filter kategori: makanan, minuman, snack
- Tampilan daftar produk dengan foto, harga, stok, dan kategori
- Sistem pemesanan sederhana untuk pelanggan
- API `payment-methods` untuk mengelola metode pembayaran (CRUD)
- Dashboard admin dengan Filament untuk menampilkan statistik pesanan dan pendapatan
- Manajemen data produk, kategori, pesanan, dan transaksi
- Struktur database lengkap (produk, kategori, pesanan, item pesanan, transaksi, meja, pengguna)

---

## 🗂️ Struktur Proyek

- `routes/web.php` - rute aplikasi utama dan API pembayaran  
- `app/Http/Controllers/OrderController.php` - halaman menu depan untuk pelanggan  
- `app/Http/Controllers/PaymentMethodController.php` - endpoint API metode pembayaran  
- `app/Http/Controllers/AdminController.php` - dashboard admin dan data agregasi pesanan  
- `app/Models/` - model Laravel untuk entitas aplikasi  
- `app/Filament/` - konfigurasi panel Filament, resource, halaman, dan widget admin  
- `resources/views/order/index.blade.php` - halaman depan pemesanan  

---

## 🛠️ Teknologi yang Digunakan

- Laravel (PHP Framework)
- PHP
- Filament Admin Panel
- Blade Template Engine
- Tailwind CSS
- MySQL (Database)
- Composer

---

## ⚙️ Cara Instalasi Lokal

1. Clone repository:
```bash
git clone https://github.com/username/sistem-angkringan.git