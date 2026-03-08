# 📱 Dokumentasi Fitur Payment & Proof of Payment

## 📋 Ringkasan Fitur

Fitur ini memungkinkan pelanggan untuk:
1. **Memilih metode pembayaran** (Transfer Bank, E-Wallet, atau Uang Tunai)
2. **Melihat nomor rekening/akun** ketika memilih Transfer Bank atau E-Wallet
3. **Upload bukti pembayaran** untuk metode Transfer Bank dan E-Wallet

---

## 🗂️ File yang Ditambahkan/Dimodifikasi

### 1. **Migrations**
- `database/migrations/2026_03_08_000001_create_payment_methods_table.php`
  - Membuat tabel `payment_methods` untuk menyimpan data rekening
  - Kolom: id, type (bank/ewallet), name, account_number, account_holder, is_active, timestamps

- `database/migrations/2026_03_08_000002_add_proof_of_payment_to_orders_table.php`
  - Menambah kolom `proof_of_payment` ke tabel `orders`
  - Menyimpan path file bukti pembayaran

### 2. **Models**
- `app/Models/PaymentMethod.php` (BARU)
  - Model untuk mengelola data payment methods

- `app/Models/Order.php` (UPDATE)
  - Menambah field `fillable`: `proof_of_payment`

### 3. **Controllers**
- `app/Http/Controllers/OrderController.php` (UPDATE)
  - Menambah import: `PaymentMethod`, `Storage`
  - Update `index()`: Pass `bankAccounts` & `ewalletAccounts` ke view
  - Update `store()`: 
    - Validasi file upload untuk bank & e-wallet
    - Handle file upload & simpan ke storage
    - Simpan proof_of_payment path ke database

- `app/Http/Controllers/PaymentMethodController.php` (BARU)
  - API endpoints untuk mengelola payment methods
  - `getActive()`: Ambil semua payment method aktif
  - `getByType($type)`: Ambil payment method berdasarkan type
  - `store()`: Tambah payment method baru
  - `update()`: Edit payment method
  - `destroy()`: Hapus payment method

### 4. **Views**
- `resources/views/order/index.blade.php` (UPDATE)
  - Menampilkan 3 metode pembayaran dengan radio button
  - Section untuk menampilkan bank accounts (saat dipilih)
  - Section untuk menampilkan e-wallet accounts (saat dipilih)
  - Form drag-and-drop untuk upload bukti pembayaran
  - Preview gambar bukti pembayaran sebelum submit
  - Validasi file (hanya image, max 5MB)

### 5. **Seeders**
- `database/seeders/PaymentMethodSeeder.php` (BARU)
  - Seeder untuk menambah data payment methods
  - 3 bank accounts (BCA, Mandiri, BRI)
  - 3 e-wallet accounts (GoPay, OVO, Dana)

---

## 🔄 Alur Penggunaan

### Alur Pelanggan:
```
1. Pelanggan membuka halaman menu dan memilih produk
2. Klik tombol "PESAN"
3. Modal form pembayaran muncul
4. Input nama dan nomor meja
5. Pilih metode pembayaran:
   
   Jika pilih "Transfer Bank":
   ├─ Tampilkan nomor rekening bank
   ├─ Tampilkan form upload bukti transfer
   └─ Wajib upload screenshot/foto transfer
   
   Jika pilih "E-Wallet":
   ├─ Tampilkan nomor akun e-wallet
   ├─ Tampilkan form upload bukti pembayaran
   └─ Wajib upload screenshot/foto pembayaran
   
   Jika pilih "Uang Tunai":
   ├─ Tidak perlu upload bukti
   └─ Langsung konfirmasi
   
6. Klik "Konfirmasi Pesanan"
7. Order disimpan ke database dengan bukti pembayaran
```

---

## 📦 Database Schema

### Tabel: `payment_methods`
```sql
CREATE TABLE payment_methods (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  type ENUM('bank', 'ewallet') NOT NULL,
  name VARCHAR(100) NOT NULL,
  account_number VARCHAR(50) NOT NULL,
  account_holder VARCHAR(100) NOT NULL,
  is_active BOOLEAN DEFAULT true,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Tabel: `orders` (UPDATE)
```sql
ALTER TABLE orders ADD (
  customer_name VARCHAR(100) NULLABLE,
  table_number VARCHAR(50) NULLABLE,
  payment_method ENUM('transfer_bank', 'e_wallet', 'cash') NULLABLE,
  total_price DECIMAL(10,2) NULLABLE,
  status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
  proof_of_payment VARCHAR(255) NULLABLE
);
```

---

## 🔧 Setup & Installation

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Run Seeder (Optional - untuk data sample)
```bash
php artisan db:seed --class=PaymentMethodSeeder
```

### 3. Setup Storage Link
```bash
php artisan storage:link
```
Storage link untuk mengakses file upload: `storage/app/public/payment_proofs`

---

## 💾 Menyimpan File Upload

File bukti pembayaran akan disimpan di:
- **Path Storage**: `storage/app/public/payment_proofs/`
- **Public URL**: `/storage/payment_proofs/[filename]`
- **Max Size**: 5MB
- **Format**: JPG, PNG, GIF

Contoh path di database:
```
proof_of_payment: payment_proofs/2026_03_08_bukti_transfer_ABC123.jpg
```

---

## 🛠️ Working with Payment Methods

### Update Nomor Rekening (melalui API)

#### 1. Get All Payment Methods
```bash
GET /api/payment-methods
```

#### 2. Get by Type
```bash
GET /api/payment-methods/type/bank
GET /api/payment-methods/type/ewallet
```

#### 3. Add New Payment Method
```bash
POST /api/payment-methods
Content-Type: application/json

{
  "type": "bank",
  "name": "BNI",
  "account_number": "1111222233",
  "account_holder": "Angkringan Modern"
}
```

#### 4. Update Payment Method
```bash
PUT /api/payment-methods/{id}

{
  "type": "bank",
  "name": "BNI",
  "account_number": "1111222233_updated",
  "account_holder": "Angkringan Modern",
  "is_active": true
}
```

#### 5. Delete Payment Method
```bash
DELETE /api/payment-methods/{id}
```

---

## 📸 File Upload Handling

### Frontend Features:
- ✅ Drag & Drop untuk upload file
- ✅ Click to browse file
- ✅ Preview gambar sebelum submit
- ✅ Validasi file type (gambar saja)
- ✅ Validasi ukuran file (max 5MB)

### Backend Features:
- ✅ Server-side validation
- ✅ File stored ke `storage/app/public/payment_proofs/`
- ✅ Database record dengan path file
- ✅ Accessible via public URL

---

## ✅ Checklist Features

- [x] Modal form dengan 3 pilihan payment method
- [x] Dynamic display nomor rekening berdasarkan metode
- [x] Form upload bukti pembayaran dengan preview
- [x] Drag & drop file upload
- [x] File validation (type & size)
- [x] Database transaction untuk order + items
- [x] Unique filename untuk setiap upload
- [x] Public accessible file storage
- [x] Admin controller untuk manage payment methods
- [x] Seeder untuk sample data

---

## 🐛 Testing

### Test Bank Transfer Flow:
1. Buka halaman order
2. Pilih beberapa produk
3. Klik "PESAN"
4. Isi nama & nomor meja
5. Pilih "Transfer Bank"
6. Verifikasi nomor rekening BCA/Mandiri/BRI muncul
7. Upload screenshot bukti transfer
8. Klik "Konfirmasi Pesanan"
9. Check database apakah proof_of_payment tersimpan

### Test E-Wallet Flow:
1. Ikuti langkah 1-5
2. Pilih "E-Wallet"
3. Verifikasi nomor akun GoPay/OVO/Dana muncul
4. Upload screenshot bukti e-wallet
5. Klik "Konfirmasi Pesanan"
6. Check database

### Test Cash Flow:
1. Ikuti langkah 1-5
2. Pilih "Uang Tunai"
3. Verifikasi form upload tidak muncul
4. Klik "Konfirmasi Pesanan"
5. Check database (proof_of_payment = NULL)

---

## 📝 Notes

- Semua file upload disimpan di folder yang terpisah untuk keamanan
- Path file di-generate otomatis dengan unique filename
- Proof of payment wajib untuk bank & e-wallet, optional untuk cash
- Admin dapat mengelola nomor rekening melalui PaymentMethodController
- Setiap order menyimpan reference ke file bukti pembayaran

---

## 🔐 Security

- Server-side validation untuk semua input
- File type & size validation
- CSRF token protection
- Database transaction untuk data consistency
- File stored outside public folder untuk proteksi

