# TODO - Sistem Angkringan

## Fix error utama checkout/kasir
- [x] Perbaiki insert `order_items`: field `quantity` tidak punya default value (karena tabel `order_items` memakai kolom `quantity`, sementara Kasir memakai `qty`).
- [x] Pastikan `OrderItem` dan migrasi konsisten (quantity vs qty).

## Perbaikan error lain (jika masih muncul)
- [x] Kembalikan/instal dependensi Filament QueryBuilder (Class `Filament\\QueryBuilder\\QueryBuilderServiceProvider` not found).
- [x] Perbaiki tipe property `navigationIcon` dan `view` di halaman Filament (sesuai Filament version).
- [x] Rapikan kompatibilitas `getHeading`, `getMaxContentWidth` di Page.
- [x] Perbaiki Midtrans: `Midtrans\\Config` tidak ditemukan dan ServerKey/ClientKey kosong (butuh config .env & instalasi package midtrans-php).

## Tambahan
- [x] Menambahkan kolom `name` di `order_items` agar sinkron dengan Kasir.
- [x] Menambahkan kolom `order_type` di `orders`.
- [x] Memindahkan migrasi index performa ke folder yang benar.
- [x] Memperbaiki nama kolom `composition` & `description` di `ProductsTable`.
