# Panduan Setup AR di Android 15

## ✅ **Kompatibilitas Android 15**

### **Requirements**
- **Android**: 8.0+ (API 26+), optimal untuk Android 13+
- **Browser**: Chrome 81+ (WebXR support)
- **Chrome Versi**: 125+ untuk Android 15 (terbaru)
- **RAM**: Minimal 2GB, rekomendasi 4GB+
- **Kamera**: AR-capable device (Tilt Sensor + Accelerometer)

## 🚀 **Langkah-langkah Setup**

### **Step 1: Persiapkan Android Device**

#### **Update Browser Chrome**
```
1. Buka Play Store
2. Cari "Chrome"
3. Klik "Update" (pastikan versi terbaru)
4. Verifikasi versi: Chrome menu → About Chrome
   (Harus 125+ untuk optimal WebXR)
```

#### **Aktifkan Developer Options** (Optional)
```
Settings → About phone → Build number
Tap "Build number" 7 kali hingga developer mode aktif
→ Settings → Developer options
```

#### **Izin Kamera**
```
Settings → Apps → Chrome → Permissions → Camera
Pastikan Camera permission: "Allow"
```

### **Step 2: Konfigurasi Server**

#### **Install HTTPS Certificate (Penting untuk WebXR)**
```bash
# WebXR memerlukan HTTPS atau localhost
# Untuk local testing, gunakan localhost dengan port forward

# Option 1: Gunakan ngrok (easiest)
ngrok http 8000

# Option 2: Gunakan self-signed certificate
# Buat certificate di server
```

#### **Run Laravel Server**
```bash
cd c:\xampp1\htdocs\sistem-angkringan
php artisan serve
```

### **Step 3: Testing di Android 15**

#### **Via Localhost (Device & PC di Network Sama)**
```
1. PC: Jalankan php artisan serve
2. PC: Buka CMD → ipconfig → lihat IP lokal
   Contoh: 192.168.1.100
3. Android: Buka Chrome
4. URL: http://192.168.1.100:8000
5. Klik produk → Modal → "Lihat dalam 3D (AR)"
```

#### **Via Ngrok (Recommended)**
```bash
# Di PC/Server:
ngrok http 8000
# Output: https://xxxx-xx-xxx-xx-xx.ngrok.io

# Di Android:
1. Chrome → URL: https://xxxx-xx-xxx-xx-xx.ngrok.io
2. Klik produk → Modal → "Lihat dalam 3D (AR)"
```

### **Step 4: Troubleshooting WebXR**

#### **WebXR Tidak Terdeteksi**
```
Solusi:
1. Update Chrome ke versi terbaru (125+)
2. Check device compatibility: android.com/xr
3. Restart Chrome
4. Clear cache: Settings → Privacy → Clear browsing data
```

#### **"AR Not Supported" Error**
```
Berarti:
- Device tidak support AR (jarang)
- Chrome version terlalu lama
- Akses HTTPS/localhost diperlukan

Solusi:
1. Update Chrome ke versi 125+
2. Gunakan ngrok untuk HTTPS
3. Test di device berbeda
```

#### **Kamera Tidak Aktif**
```
Solusi:
1. Berikan permission kamera
   Settings → Apps → Chrome → Permissions → Camera
2. Restart Chrome
3. Check apakah app lain menggunakan kamera
4. Restart device
```

#### **Reticle Tidak Muncul**
```
Berarti plane detection belum mendeteksi permukaan

Solusi:
1. Arahkan ke permukaan datar (meja, lantai)
2. Pastikan pencahayaan cukup
3. Hindari area gelap atau terlalu cerah
4. Permukaan harus terlihat tekstur (bukan blank white)
5. Tunggu 2-3 detik untuk detection
```

#### **Model Tidak Load**
```
Solusi:
1. Check path: public/models/coffee.glb
2. Buka Chrome DevTools (F12) → Console
3. Check error messages
4. Pastikan file ukuran < 10MB
5. Test dengan URL eksternal model
```

## 🔧 **Optimasi untuk Android 15**

### **Performance Tuning**
```javascript
// Di ar.html, sesuaikan untuk performa optimal

// 1. Kurangi texture quality
renderer.setPixelRatio(window.devicePixelRatio * 0.75);

// 2. Limit frame rate jika perlu (untuk battery)
let frameCount = 0;
const maxFrameSkip = 2;
if (frameCount++ % maxFrameSkip === 0) {
    // render
}

// 3. Adjust shadow quality
directionalLight.shadow.mapSize.width = 512;
directionalLight.shadow.mapSize.height = 512;
```

### **Battery Optimization**
```
1. Reduce screen brightness (device setting)
2. Close background apps
3. Use device performance mode (if available)
4. Keep session duration < 10 minutes (recharge battery)
```

### **Memory Management**
```javascript
// Dispose resources jika perlu
if (model) {
    model.traverse((child) => {
        if (child.geometry) child.geometry.dispose();
        if (child.material) child.material.dispose();
    });
}
```

## 📱 **Device Compatibility Check**

### **Cek Support WebXR**
```
Di Chrome DevTools (F12) → Console:
navigator.xr.isSessionSupported('immersive-ar')
    .then(supported => console.log('AR Support:', supported));
```

### **Device yang Tested OK**
- Samsung Galaxy S20+ (Android 13+) ✅
- Google Pixel 6+ (Android 13+) ✅
- OnePlus 10+ (Android 13+) ✅
- Xiaomi 12+ (Android 13+) ✅
- Android 15 devices (latest) ✅

## 🌐 **HTTPS Setup untuk Production**

### **Option 1: Let's Encrypt (Recommended)**
```bash
# Install certbot
sudo apt-get install certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --standalone -d your-domain.com

# Copy certificate ke app
cp /etc/letsencrypt/live/your-domain.com/fullchain.pem project/
cp /etc/letsencrypt/live/your-domain.com/privkey.pem project/
```

### **Option 2: Self-Signed (Development)**
```bash
# Generate certificate
openssl req -x509 -newkey rsa:4096 -keyout key.pem -out cert.pem -days 365

# Run with PHP
php -S 127.0.0.1:8000 -t public/ --ssl-cert=cert.pem --ssl-key=key.pem
```

## 🎯 **Testing Checklist**

- [ ] Chrome updated ke 125+
- [ ] Device support AR (check di device settings)
- [ ] Camera permission granted
- [ ] HTTPS atau localhost digunakan
- [ ] Network connection stabil
- [ ] Model 3D tersedia (coffee.glb)
- [ ] Pencahayaan cukup untuk plane detection
- [ ] Device memory cukup (free 1GB+)

## 📞 **Debug Info**

### **Collect Debug Information**
```javascript
// Copy-paste di Console untuk debug info
console.log('Device Info:', {
    userAgent: navigator.userAgent,
    pixelRatio: window.devicePixelRatio,
    screenSize: `${window.innerWidth}x${window.innerHeight}`,
    memory: performance.memory
});

// Check WebXR support
navigator.xr.isSessionSupported('immersive-ar')
    .then(supported => console.log('AR Supported:', supported));
```

### **Chrome Flags (Advanced)**
```
chrome://flags → Cari:
- "WebXR Incubations" → Enable
- "WebGL 2.0 Compute" → Enable
- Restart Chrome
```

## 🚨 **Common Issues & Solutions**

| Issue | Penyebab | Solusi |
|-------|---------|--------|
| "AR Not Supported" | Chrome lama / Device tidak support | Update Chrome 125+ |
| Reticle tidak muncul | Plane detection timeout | Arahkan ke permukaan datar, tunggu |
| Kamera tidak aktif | Permission denied | Berikan akses camera |
| Model tidak load | File tidak ada / Format salah | Check path & format .glb |
| Performa lambat | Model terlalu kompleks | Kompresi model 3D |
| Freeze / Crash | Memory penuh | Restart app & close bg apps |

## 📞 **Support Resources**

- **WebXR Docs**: https://immersive-web.github.io/
- **Three.js Docs**: https://threejs.org/docs/
- **Android AR**: https://developers.google.com/ar
- **Chrome Support**: https://support.google.com/chrome

---

**💡 Tips untuk Pengalaman Terbaik:**
1. Gunakan device dengan RAM 4GB+ untuk performa optimal
2. Pastikan pencahayaan area AR cukup baik
3. Test di beberapa device untuk compatibility
4. Update browser secara berkala
5. Monitor memory usage saat AR running