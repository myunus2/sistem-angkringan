# Instruksi Setup AR Menu Viewer - WebXR Version

## Persiapan Model 3D

1. **Download Model GLB**:
   - Kunjungi situs seperti [Sketchfab](https://sketchfab.com) atau [Poly Haven](https://polyhaven.com)
   - Cari model kopi atau makanan sederhana (gratis, format .glb)
   - Simpan sebagai `coffee.glb` di folder `public/models/`

2. **Model Alternatif**:
   - Jika tidak ada model, sistem akan membuat kotak coklat sebagai fallback

## Browser Requirements

- **Chrome Android** versi 81+ (terbaik untuk WebXR)
- **HTTPS** atau **localhost** (diperlukan untuk WebXR)
- **WebXR API** harus didukung

## Cara Menjalankan

1. **Jalankan Server Laravel**:
   ```bash
   php artisan serve
   ```

2. **Akses Aplikasi**:
   - Buka `http://127.0.0.1:8000` (localhost)
   - Klik gambar produk
   - Klik tombol "Lihat dalam 3D (AR)" di modal

3. **Penggunaan AR**:
   - Klik "Mulai AR" setelah loading
   - Izinkan akses kamera
   - Arahkan kamera ke permukaan datar (meja, lantai)
   - Reticle (lingkaran putih) akan muncul
   - Tap layar untuk menempatkan objek 3D

## Fitur yang Telah Diimplementasi

- ✅ **WebXR Immersive AR** (tanpa marker)
- ✅ **Plane Detection** otomatis
- ✅ **Objek 3D GLB** dengan lighting realistis
- ✅ **Interaksi Touch**: Rotate (geser), Zoom (pinch)
- ✅ **Tap untuk Info**: Menampilkan detail menu
- ✅ **Tombol Overlay**: Kembali, Reset Posisi
- ✅ **Loading Screen** dengan indikator
- ✅ **UI Modern**: Floating buttons, transparan
- ✅ **Responsive Design** untuk mobile
- ✅ **Fallback** untuk browser tidak mendukung

## Cara Kerja

1. **Deteksi Permukaan**: Kamera mendeteksi permukaan datar
2. **Penempatan Objek**: Tap untuk place objek di dunia nyata
3. **Interaksi**: Geser untuk rotate, pinch untuk zoom
4. **Informasi**: Tap objek untuk lihat detail menu

## Troubleshooting

- **AR tidak muncul**: Pastikan Chrome Android terbaru
- **Kamera tidak aktif**: Izinkan permission kamera
- **Model tidak load**: Periksa path `public/models/coffee.glb`
- **Reticle tidak muncul**: Arahkan ke permukaan datar yang cukup cahaya
- **Touch tidak responsif**: Pastikan layar bersih

## Optimasi Performa

- Model 3D dioptimalkan untuk mobile
- Lighting menggunakan shadow mapping
- Touch events dioptimalkan untuk 60fps
- Memory management untuk objek 3D

## Catatan Teknis

- Menggunakan Three.js r128 untuk kompatibilitas
- WebXR session dengan hit-test untuk placement
- GLTFLoader untuk model 3D
- Touch events untuk gesture recognition
- CSS backdrop-filter untuk efek modern

## Troubleshooting

- Jika kamera tidak aktif: Pastikan HTTPS atau localhost
- Jika model tidak muncul: Periksa path file dan format .glb
- Jika overlay tidak responsif: Periksa CSS media queries