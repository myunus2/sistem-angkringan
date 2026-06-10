# TODO - Sistem Angkringan

## Fix error utama checkout/kasir
- [ ] Perbaiki insert `order_items`: field `quantity` tidak punya default value (karena tabel `order_items` memakai kolom `quantity`, sementara Kasir memakai `qty`).
- [ ] Pastikan `OrderItem` dan migrasi konsisten (quantity vs qty).

## Perbaikan error lain (jika masih muncul)
- [ ] Kembalikan/instal dependensi Filament QueryBuilder (Class `Filament\\QueryBuilder\\QueryBuilderServiceProvider` not found).
- [ ] Perbaiki tipe property `navigationIcon` dan `view` di halaman Filament (sesuai Filament version).
- [ ] Rapikan kompatibilitas `getHeading`, `getMaxContentWidth` di Page.
- [ ] Perbaiki Midtrans: `Midtrans\\Config` tidak ditemukan dan ServerKey/ClientKey kosong (butuh config .env & instalasi package midtrans-php).

