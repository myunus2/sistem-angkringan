<<<<<<< HEAD
# TODO - Sistem Angkringan

## Fix error utama checkout/kasir
- [x] Perbaiki insert `order_items`: field `quantity` tidak punya default value (karena tabel `order_items` memakai kolom `quantity`, sementara Kasir memakai `qty`).
- [x] Pastikan `OrderItem` dan migrasi konsisten (quantity vs qty).

## Perbaikan error lain (jika masih muncul)
- [x] Kembalikan/instal dependensi Filament QueryBuilder (Class `Filament\\QueryBuilder\\QueryBuilderServiceProvider` not found).
- [x] Perbaiki tipe property `navigationIcon` dan `view` di halaman Filament (sesuai Filament version).
- [x] Rapikan kompatibilitas `getHeading`, `getMaxContentWidth` di Page.
- [x] Perbaiki Midtrans: `Midtrans\\Config` tidak ditemukan dan ServerKey/ClientKey kosong (butuh config .env & instalasi package midtrans-php).
=======
# TODO - Perbaikan error saat checkout (order/index.blade.php)

- [ ] Buat plan edit: ubah `CheckoutController::store()` agar endpoint `POST /api/checkout` selalu mengembalikan response JSON.
- [ ] Edit file `app/Http/Controllers/CheckoutController.php`:
  - [ ] Deteksi request JSON (`wantsJson()` atau header Accept/Content-Type).
  - [ ] Pada sukses: return `response()->json({status:'success', ...})`.
  - [ ] Pada error (validasi/exception): return `response()->json({status:'error', message:...}, 422/500)`.
  - [ ] Pastikan flow halaman normal tetap redirect ke `checkout.success`.
- [x] Jalankan test minimal:
  - [x] Cek checkout dari halaman depan (browser) apakah pesan error hilang.
  - [ ] Pastikan data order tersimpan.

>>>>>>> 2292e59c6dfba701eae5cbd6fab8c6367bd7b54f

## Tambahan
- [x] Menambahkan kolom `name` di `order_items` agar sinkron dengan Kasir.
- [x] Menambahkan kolom `order_type` di `orders`.
- [x] Memindahkan migrasi index performa ke folder yang benar.
- [x] Memperbaiki nama kolom `composition` & `description` di `ProductsTable`.
