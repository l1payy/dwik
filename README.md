# E-Surat BPBD Kota Binjai

Sistem Informasi Manajemen Surat & Dokumen Elektronik untuk Badan Penanggulangan Bencana Daerah (BPBD) Kota Binjai. Project ini dibangun untuk mempermudah pengelolaan administrasi surat masuk dan surat keluar secara digital, cepat, dan efisien.

## 🚀 Teknologi yang Digunakan

- **Framework**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL / MariaDB
- **Frontend**: Tailwind CSS & Alpine.js (Laravel Breeze)
- **Icons**: Heroicons
- **Export Tools**: 
  - `barryvdh/laravel-dompdf` (Export PDF)
  - `phpoffice/phpword` (Export Word)

## ✨ Fitur Utama

- **Dashboard**: Statistik ringkas jumlah surat masuk, surat keluar, dan notifikasi belum dibaca.
- **Manajemen Surat Masuk**: Pencatatan nomor surat, pengirim, perihal, sifat, prioritas, dan unggah file lampiran.
- **Manajemen Surat Keluar**: Pencatatan nomor surat manual, ditujukan kepada siapa, perihal, dan unggah draf dokumen.
- **Arsip Terpusat**: Seluruh data surat masuk dan keluar dapat difilter berdasarkan tipe dan tahun di halaman dashboard.
- **Sistem Notifikasi**: Notifikasi otomatis setiap ada aktivitas surat baru.
- **Export Data**: Kemampuan untuk mengunduh laporan atau detail surat ke dalam format PDF dan Microsoft Word.
- **Filter Canggih**: Pencarian surat berdasarkan nomor, perihal, tanggal, sifat, maupun prioritas.

## 🛠️ Langkah-langkah Instalasi (Clone)

Ikuti panduan di bawah ini untuk menjalankan project ini di komputer lokal Anda:

### 1. Persiapan Awal
Pastikan Anda sudah menginstal:
- [PHP >= 8.2](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js & NPM](https://nodejs.org/)
- Web Server (Laragon / XAMPP)

### 2. Clone Project
Buka terminal dan jalankan perintah berikut:
```bash
git clone https://github.com/username/repo-name.git
cd dwi
```

### 3. Instalasi Dependency
Instal library PHP dan paket pendukung frontend:
```bash
composer install
npm install
npm run build
```

### 4. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan pengaturan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dwi_esurat
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate Key & Link Storage
```bash
php artisan key:generate
php artisan storage:link
```

### 6. Migrasi Database & Seeding
Jalankan perintah ini untuk membuat tabel dan mengisi data awal (akun login):
```bash
php artisan migrate:fresh --seed
```

### 7. Jalankan Server
```bash
php artisan serve
```
Akses di browser: `http://127.0.0.1:8000`

---

## 🔑 Akun Login Default
Anda dapat menggunakan akun berikut setelah menjalankan perintah `--seed`:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Sekretaris** | `sekretaris@bpbd.binjaikota.go.id` | `password` |
| **Pimpinan** | `pimpinan@bpbd.binjaikota.go.id` | `password` |
| **Staff** | `staff@bpbd.binjaikota.go.id` | `password` |

---
*© 2026 BPBD Kota Binjai - Dikembangkan dengan ❤️ menggunakan Laravel.*
