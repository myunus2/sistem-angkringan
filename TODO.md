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


