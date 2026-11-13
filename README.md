# TGN Parfume

TGN Parfume adalah aplikasi web e-commerce parfum modern yang dibangun menggunakan **Laravel 12**, **MongoDB**, dan **Bootstrap 5**. Aplikasi ini merupakan hasil modernisasi menyeluruh dari sistem PHP legacy dengan arsitektur MVC, tema visual konsisten (white theme), kompresi gambar tanpa penurunan kualitas pixel, dan kesesuaian endpoint (backward compatibility).

---

## Fitur Utama

- **Katalog & Navigasi**: Katalog parfum pria & wanita, pencarian instan, filter kategori, dan detail parfum.
- **Keranjang & Checkout**: Sistem keranjang belanja dinamis, penyesuaian jumlah item, checkout dengan metode pembayaran (COD / Transfer Bank).
- **Profil Pengguna & Administrator**:
  - Upload dan perbarui foto profil dengan fitur kompresi otomatis (JPG, PNG, WEBP, GIF).
  - Algoritma kompresi menjaga keutuhan resolusi pixel dengan batas maksimal ukuran file hasil kompresi 3MB.
  - Pengelolaan data akun dan riwayat pesanan pelanggan.
- **Back Office / Admin**:
  - Manajemen katalog produk (CRUD produk parfum dengan upload gambar terkompresi).
  - Manajemen akun staf dan pengguna pelanggan (aktifkan / nonaktifkan akun).
  - Pengelolaan status pembayaran pesanan pelanggan.
  - Pengelolaan pesan masuk kontak pelanggan.
- **White Theme**: Desain tampilan antarmuka yang bersih, modern, dan konsisten di seluruh halaman storefront dan admin.
- **Bebas Emoji**: Desain profesional dengan ikon vektor berbasis Bootstrap Icons.

---

## Persyaratan Sistem

- PHP >= 8.2 (Direkomendasikan PHP 8.4+)
- Ekstensi PHP: `mongodb`, `gd`, `mbstring`, `openssl`, `curl`
- Composer >= 2.0
- Node.js & NPM (untuk build Vite)
- MongoDB Database (Lokal atau MongoDB Atlas)

---

## Panduan Instalasi Lokal

1. **Clone Repository**:
   ```bash
   git clone https://github.com/1iki/tgn-parfume.git
   cd tgn-parfume
   ```

2. **Install Dependensi PHP & Node**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Sesuaikan konfigurasi database MongoDB di file `.env`:
   ```env
   DB_CONNECTION=mongodb
   DB_URI="mongodb://127.0.0.1:27017"
   DB_DATABASE=tgn_parfume
   ```

4. **Jalankan Database Seeder**:
   ```bash
   php artisan db:seed
   ```

5. **Build Aset Frontend**:
   ```bash
   npm run build
   ```

6. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui `http://127.0.0.1:8000`.

---

## Pengujian Otomatis (Testing)

Aplikasi dilengkapi dengan pengujian unit & feature lengkap:
```bash
php artisan test
```

---

## Lisensi

Proyek ini dikembangkan untuk TGN Parfume.
