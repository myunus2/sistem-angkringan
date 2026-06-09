# Panduan Menambahkan Model 3D untuk AR Menu

## 📋 **Persiapan Model 3D**

### **Format yang Didukung**
- **Format**: .glb (GL Transmission Format Binary)
- **Ukuran**: Maksimal 5-10 MB untuk performa optimal
- **Kompleksitas**: 10,000-50,000 polygons (sesuaikan dengan device)

### **Sumber Model 3D**

#### **1. Sketchfab (Rekomendasi Utama)**
```
Website: https://sketchfab.com
Langkah:
1. Buka sketchfab.com
2. Cari "coffee", "kopi", atau "food"
3. Filter: Free, GLB format
4. Download model
5. Simpan sebagai coffee.glb
```

#### **2. Poly Haven**
```
Website: https://polyhaven.com
Langkah:
1. Cari model makanan/minuman
2. Download GLB format
3. Rename file menjadi coffee.glb
```

#### **3. TurboSquid**
```
Website: https://www.turbosquid.com
Langkah:
1. Cari free 3D models
2. Filter: Food/Beverage category
3. Download GLB format
```

#### **4. CGTrader**
```
Website: https://www.cgtrader.com
Langkah:
1. Cari free coffee models
2. Download GLB/GLTF format
```

## 🛠️ **Langkah-langkah Menambahkan Model**

### **Step 1: Download Model**
```bash
# Contoh model yang bisa digunakan:
# - Coffee cup: https://sketchfab.com/3d-models/coffee-cup-8d5880c
# - Food models: Cari "free coffee 3d model glb"
```

### **Step 2: Persiapan File**
1. **Pastikan format GLB**
2. **Kompresi jika terlalu besar**:
   - Gunakan online tools seperti gltf.report
   - Target ukuran: < 5MB
3. **Rename file**:
   ```
   nama_file_asli.glb → coffee.glb
   ```

### **Step 3: Upload ke Project**
```
Lokasi: public/models/coffee.glb
Struktur folder:
sistem-angkringan/
├── public/
│   ├── models/
│   │   └── coffee.glb  ← Letakkan di sini
│   └── ar.html
```

### **Step 4: Verifikasi Model**
1. **Buka browser** → `http://127.0.0.1:8000/ar.html`
2. **Periksa console browser** (F12 → Console)
3. **Cek pesan error**:
   - ✅ "Model loaded successfully"
   - ❌ "Error loading model" → Periksa path file

## 🎨 **Optimasi Model 3D**

### **Tools untuk Optimasi**
- **gltf.report**: Analisis dan optimasi model
- **Blender**: Edit dan simplify model
- **Online Compressor**: TinyPNG untuk textures

### **Checklist Optimasi**
- [ ] Ukuran file < 5MB
- [ ] Jumlah polygons < 50k
- [ ] Textures compressed (JPG/WebP)
- [ ] Normal maps jika diperlukan
- [ ] LOD (Level of Detail) jika kompleks

### **Tips Performa**
```javascript
// Di ar.html, sesuaikan scale jika model terlalu besar/kecil
model.scale.set(0.5, 0.5, 0.5); // Default scale
model.scale.set(0.2, 0.2, 0.2); // Jika model terlalu besar
model.scale.set(1.0, 1.0, 1.0); // Jika model terlalu kecil
```

## 🔧 **Troubleshooting**

### **Model Tidak Muncul**
```
Solusi:
1. Periksa path: public/models/coffee.glb
2. Periksa format: Harus .glb (bukan .gltf)
3. Periksa ukuran: < 10MB
4. Periksa CORS: Jika dari URL eksternal
```

### **Model Terlalu Besar/Kecil**
```javascript
// Edit di ar.html bagian model.scale.set()
model.scale.set(0.3, 0.3, 0.3); // Lebih kecil
model.scale.set(0.8, 0.8, 0.8); // Lebih besar
```

### **Error Loading Model**
```
Console error:
- "CORS error" → Gunakan model lokal
- "404 Not Found" → Periksa path file
- "Invalid format" → Convert ke GLB
```

### **Performa Lambat**
```
Solusi:
1. Kurangi polygons di Blender
2. Kompresi textures
3. Hapus unnecessary materials
4. Gunakan LOD (Level of Detail)
```

## 📝 **Model Alternatif**

### **Jika Tidak Ada Model GLB**
Sistem akan otomatis membuat **fallback model** (kotak coklat) jika:
- File coffee.glb tidak ditemukan
- Error loading model
- Format tidak didukung

### **Model dari URL Eksternal**
```javascript
// Edit di ar.html
loader.load(
    'https://example.com/models/coffee.glb', // URL eksternal
    // ... rest of code
);
```

## 🎯 **Rekomendasi Model**

### **Model Coffee Terbaik**
1. **Sketchfab**: "Coffee Cup" by various artists
2. **Poly Haven**: "Coffee" collection
3. **Free3D**: Coffee mug models

### **Kriteria Pemilihan**
- [ ] Realistis dan detail
- [ ] Ukuran file optimal
- [ ] License: Free for commercial use
- [ ] Format: GLB/GLTF
- [ ] Textures included

## 🚀 **Testing Model**

### **Langkah Testing**
1. **Upload model** ke `public/models/`
2. **Jalankan server**: `php artisan serve`
3. **Buka AR**: `http://127.0.0.1:8000/ar.html`
4. **Klik "Mulai AR"**
5. **Place objek** dengan tap
6. **Test interaksi**: Rotate, zoom, tap info

### **Debug Tools**
```javascript
// Tambahkan di console browser untuk debug
console.log('Model position:', model.position);
console.log('Model scale:', model.scale);
console.log('Model visible:', model.visible);
```

## 📞 **Support**

Jika mengalami kesulitan:
1. **Periksa console browser** untuk error messages
2. **Verifikasi file path** dan format
3. **Coba model alternatif** dari sumber terpercaya
4. **Optimalkan ukuran** jika performa lambat

---

**💡 Tip**: Mulai dengan model sederhana untuk testing, kemudian upgrade ke model yang lebih kompleks setelah fitur AR berfungsi dengan baik.