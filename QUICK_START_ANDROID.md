# Quick Start Guide - AR di Android 15

## 🚀 **Setup Cepat (5 Menit)**

### **Requirements**
- ✅ Android 8+ (optimal Android 13+)
- ✅ Chrome 125+ (update di Play Store)
- ✅ Internet connection

### **Step 1: Persiapkan Server (PC/Laptop)**
```bash
cd c:\xampp1\htdocs\sistem-angkringan
php artisan serve
# Output: http://127.0.0.1:8000
```

### **Step 2: Akses dari Android**

#### **Option A: Localhost (Device & PC di Network Sama)**
```
1. PC: Buka CMD → ipconfig
   Cari IPv4 Address: 192.168.x.x

2. Android Chrome:
   - URL: http://192.168.x.x:8000
   - Contoh: http://192.168.1.100:8000
```

#### **Option B: Ngrok (Lebih Mudah, dari mana saja)**
```bash
# Di terminal baru:
ngrok http 8000

# Output: https://xxx-xxx-xxx-xxx.ngrok.io
# Copy URL ke Android Chrome
```

### **Step 3: Test AR**
```
1. Buka URL di Android Chrome
2. Klik gambar produk apapun
3. Klik "Lihat dalam 3D (AR)" di modal
4. Klik "Mulai AR"
5. Izinkan akses kamera
6. Arahkan ke meja/lantai
7. Tap untuk place objek 3D
```

### **Step 4: Interaksi**
- **Geser jari**: Rotate objek
- **Pinch**: Zoom in/out
- **Tap objek**: Lihat info
- **←**: Kembali
- **↻**: Reset posisi

## ❌ **Jika Error**

| Error | Solusi |
|-------|--------|
| "AR Not Supported" | Update Chrome ke versi terbaru |
| Kamera tidak aktif | Berikan permission: Settings → Apps → Chrome → Permissions |
| Reticle tidak muncul | Arahkan ke permukaan datar, tunggu 2-3 detik |
| Model tidak load | Pastikan `public/models/coffee.glb` ada |

## 📱 **Tested Devices**
- ✅ Samsung Galaxy S20+ (Android 13+)
- ✅ Google Pixel 6+ (Android 13+)
- ✅ OnePlus 10+ (Android 13+)
- ✅ Xiaomi 12+ (Android 13+)
- ✅ Android 15 devices

## 🔗 **Useful Links**
- [Update Chrome](https://play.google.com/store/apps/details?id=com.android.chrome)
- [Download Ngrok](https://ngrok.com/download)
- [WebXR Docs](https://immersive-web.github.io/)

---

**Sekarang AR sudah siap untuk Android 15! 🎉**