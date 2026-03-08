# 🧪 Testing Guide - Payment & Proof of Payment Features

## 📌 Quick Start

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Seed Payment Methods
```bash
php artisan db:seed --class=PaymentMethodSeeder
```

### 3. Start Server
```bash
php artisan serve
```

---

## 🌐 API Testing dengan cURL

### 1. Get All Active Payment Methods
```bash
curl -X GET http://localhost:8000/api/payment-methods
```

**Response:**
```json
[
  {
    "id": 1,
    "type": "bank",
    "name": "BCA",
    "account_number": "1234567890",
    "account_holder": "Angkringan Modern",
    "is_active": true
  },
  ...
]
```

### 2. Get Bank Accounts Only
```bash
curl -X GET http://localhost:8000/api/payment-methods/type/bank
```

### 3. Get E-Wallet Accounts Only
```bash
curl -X GET http://localhost:8000/api/payment-methods/type/ewallet
```

### 4. Add New Bank Account
```bash
curl -X POST http://localhost:8000/api/payment-methods \
  -H "Content-Type: application/json" \
  -d '{
    "type": "bank",
    "name": "BNI",
    "account_number": "1111222233",
    "account_holder": "Angkringan Modern"
  }'
```

### 5. Update Bank Account
```bash
curl -X PUT http://localhost:8000/api/payment-methods/1 \
  -H "Content-Type: application/json" \
  -d '{
    "type": "bank",
    "name": "BCA",
    "account_number": "9999888877",
    "account_holder": "Angkringan Modern",
    "is_active": true
  }'
```

### 6. Delete Payment Method
```bash
curl -X DELETE http://localhost:8000/api/payment-methods/1
```

---

## 🧩 Frontend Testing Steps

### Test Case 1: Transfer Bank dengan Bukti
**Expected Result:** 
- ✅ Nomor rekening bank terlihat
- ✅ Form upload bukti muncul
- ✅ File upload berhasil
- ✅ Order tersimpan dengan proof_of_payment

**Steps:**
1. Buka http://localhost:8000/
2. Pilih 2-3 produk (update quantity)
3. Klik tombol "PESAN"
4. Isi nama: "Budi"
5. Isi nomor meja: "Meja 5"
6. Pilih "Transfer Bank"
7. Verifikasi data bank terlihat:
   - BCA: 1234567890 (Angkringan Modern)
   - Mandiri: 0987654321 (Angkringan Modern)
   - BRI: 5555666677 (Angkringan Modern)
8. Drag & drop file bukti transfer ke drop zone
9. Verifikasi preview gambar muncul
10. Klik "Konfirmasi Pesanan"
11. Check Database:
    ```sql
    SELECT * FROM orders WHERE customer_name = 'Budi';
    ```
    - Verify: `payment_method = 'transfer_bank'`
    - Verify: `proof_of_payment` is NOT NULL
    - Verify: File exists di `storage/app/public/payment_proofs/`

---

### Test Case 2: E-Wallet dengan Bukti
**Expected Result:**
- ✅ Nomor akun e-wallet terlihat
- ✅ Form upload bukti muncul
- ✅ File upload berhasil
- ✅ Order tersimpan dengan proof_of_payment

**Steps:**
1. Buka http://localhost:8000/
2. Pilih produk
3. Klik tombol "PESAN"
4. Isi nama: "Ani"
5. Isi nomor meja: "Meja 3"
6. Pilih "E-Wallet"
7. Verifikasi data e-wallet terlihat:
   - GoPay: 081234567890 (Angkringan Modern)
   - OVO: 081234567890 (Angkringan Modern)
   - Dana: 081234567890 (Angkringan Modern)
8. Click drop zone untuk browse file
9. Pilih file gambar (JPG/PNG)
10. Klik "Konfirmasi Pesanan"
11. Check Database:
    ```sql
    SELECT * FROM orders WHERE customer_name = 'Ani';
    ```
    - Verify: `payment_method = 'e_wallet'`
    - Verify: `proof_of_payment` is NOT NULL

---

### Test Case 3: Uang Tunai (Cash)
**Expected Result:**
- ✅ Form upload tidak muncul
- ✅ Order tersimpan tanpa proof_of_payment

**Steps:**
1. Buka http://localhost:8000/
2. Pilih produk
3. Klik tombol "PESAN"
4. Isi nama: "Citra"
5. Isi nomor meja: "Meja 7"
6. Pilih "Uang Tunai"
7. Verifikasi form upload bukti TIDAK muncul
8. Klik "Konfirmasi Pesanan"
9. Check Database:
    ```sql
    SELECT * FROM orders WHERE customer_name = 'Citra';
    ```
    - Verify: `payment_method = 'cash'`
    - Verify: `proof_of_payment` is NULL

---

### Test Case 4: File Upload Validation
**Expected Result:**
- ✅ Only image files allowed
- ✅ Max size 5MB
- ✅ Error message untuk invalid file

**Steps (Negative Test):**
1. Buka halaman order, pilih produk
2. Klik "PESAN"
3. Pilih "Transfer Bank"
4. Drag & drop file PDF/Word/non-image
5. **Expected:** Error "Hanya file gambar yang diperbolehkan!"
6. Try upload file > 5MB
7. **Expected:** Error "Ukuran file maksimal 5MB!"

---

### Test Case 5: Payment Method Switch
**Expected Result:**
- ✅ UI dinamis berubah saat switch method
- ✅ Form upload di-reset saat switch
- ✅ Nomor akun sesuai dengan method

**Steps:**
1. Klik "PESAN"
2. Pilih "Transfer Bank" → Verify bank section muncul
3. Pilih file gambar → Verify preview muncul
4. Switch ke "E-Wallet" → Verify:
   - Bank section hilang
   - E-wallet section muncul
   - File input direset (preview hilang)
5. Switch ke "Cash" → Verify:
   - E-wallet section hilang
   - Upload section hilang

---

## 🗄️ Database Queries untuk Verification

### Check semua orders dengan payment proof
```sql
SELECT id, customer_name, table_number, payment_method, 
       total_price, proof_of_payment, status, created_at
FROM orders
WHERE proof_of_payment IS NOT NULL
ORDER BY created_at DESC;
```

### Check payment methods
```sql
SELECT * FROM payment_methods ORDER BY type, name;
```

### Check total upload files per payment method
```sql
SELECT payment_method, COUNT(*) as total_orders, 
       COUNT(proof_of_payment) as dengan_bukti
FROM orders
GROUP BY payment_method;
```

### Check file storage usage
```bash
# List semua file bukti pembayaran
dir storage\app\public\payment_proofs

# Get file count
dir storage\app\public\payment_proofs | Find /C "payment"
```

---

## 📸 File Storage Verification

### Check file tersimpan:
```bash
# Windows
dir C:\xampp1\htdocs\sistem-angkringan\storage\app\public\payment_proofs

# Check ukuran files
dir /s C:\xampp1\htdocs\sistem-angkringan\storage\app\public\payment_proofs

# Access via browser
http://localhost/sistem-angkringan/public/storage/payment_proofs/[filename]
```

---

## ✅ Acceptance Criteria

| Feature | Tested | Status |
|---------|--------|--------|
| Display bank accounts | [ ] | ⏳ |
| Display e-wallet accounts | [ ] | ⏳ |
| Hide upload form untuk Cash | [ ] | ⏳ |
| Drag & drop upload | [ ] | ⏳ |
| File preview | [ ] | ⏳ |
| File validation (type) | [ ] | ⏳ |
| File validation (size) | [ ] | ⏳ |
| Save proof to database | [ ] | ⏳ |
| Save file to storage | [ ] | ⏳ |
| API get all methods | [ ] | ⏳ |
| API get by type | [ ] | ⏳ |
| API create method | [ ] | ⏳ |
| API update method | [ ] | ⏳ |
| API delete method | [ ] | ⏳ |

---

## 🐛 Troubleshooting

### Nomor Rekening tidak muncul
- Check: `SELECT * FROM payment_methods WHERE is_active = 1;`
- Verify: Seeder sudah dijalankan
- Check browser console untuk error

### File tidak tersimpan
- Check: Storage link sudah di-setup
  ```bash
  php artisan storage:link
  ```
- Check folder permissions: `storage/app/public/` harus writable
- Check: Disk config di `config/filesystems.php`

### Preview tidak muncul
- Check: File adalah image format yang valid
- Check browser console untuk JavaScript error
- Verify file size < 5MB

### Modal tidak hidup trigger
- Clear browser cache
- Check CSRF token: `<meta name="csrf-token">`
- Verify form di-submit dengan FormData (tidak JSON)

