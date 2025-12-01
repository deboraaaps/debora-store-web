# 🍱 Aplikasi Penjualan Online & POS UMKM Dapur Debora

> **Digitalisasi Sistem Pemesanan dan Kasir UMKM Dapur Debora Berbasis Web (Full Stack PHP Native).**

![Project Status](https://img.shields.io/badge/Status-Completed-success)
![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777BB4)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3)
![Database](https://img.shields.io/badge/MySQL-Database-orange)

## 📖 Tentang Proyek
Aplikasi ini dibangun untuk memodernisasi operasional **UMKM Dapur Debora**. Sistem ini menggabungkan dua fungsi utama:
1.  **Online Ordering (Web Store):** Memungkinkan pelanggan memesan makanan secara online, melakukan pembayaran transfer, dan mengunggah bukti bayar.
2.  **Point of Sale (Kasir):** Memudahkan karyawan toko menginput pesanan *walk-in* (makan di tempat/bungkus) secara cepat tanpa proses checkout yang rumit.

## 🚀 Fitur Lengkap

### 👤 Sisi Pelanggan (Frontend Store)
*   **Katalog Menu Digital:** Tampilan menu responsif (Mobile-First) dengan foto, harga, dan stok realtime.
*   **Registrasi & Login:** Sistem akun pelanggan untuk keamanan pesanan.
*   **Keranjang Belanja (Cart):** Menambah item, update jumlah, dan hapus item.
*   **Checkout & Pembayaran:** Konfirmasi alamat kirim dan upload bukti transfer manual.
*   **Riwayat Pesanan:** Memantau status pesanan (Pending / Process / Completed).

### 👮 Sisi Admin & Kasir (Backend Panel)
*   **Dashboard Statistik:** Ringkasan total produk, total pesanan, dan jumlah pelanggan.
*   **Manajemen Produk (CRUD):** Tambah, Edit, Hapus menu, update harga & stok, upload foto produk.
*   **Manajemen Pesanan:** Verifikasi bukti bayar pelanggan dan update status pesanan.
*   **Aplikasi Kasir (POS):** Halaman khusus input transaksi tunai (*Walk-in Customer*) dengan kalkulasi kembalian otomatis.
*   **Laporan:** (Terintegrasi di Dashboard & List Pesanan).

## 🛠️ Teknologi (Tech Stack)
*   **Backend:** PHP Native (Tanpa Framework) - *Struktur Modular*.
*   **Frontend:** Bootstrap 5 (CSS/JS Framework).
*   **Database:** MySQL / MariaDB.
*   **Server:** Apache (XAMPP) atau PHP Built-in Server.
*   **Aset:** Font Awesome (Ikon).

## 📂 Struktur Folder
```text
debora-store-web/
├── admin/              # Halaman Panel Admin & POS
│   ├── includes/       # Navbar Admin
│   ├── index.php       # Dashboard
│   ├── products.php    # CRUD Produk
│   ├── orders.php      # Manajemen Pesanan
│   └── pos.php         # Aplikasi Kasir
├── assets/             # File Statis
│   ├── css/            # Style Custom
│   ├── img/            # Foto Produk
│   └── uploads/        # Bukti Transfer User
├── config/             # Koneksi Database
├── includes/           # Layout Frontend (Navbar, Footer)
├── debora_store.sql    # File Backup Database
├── index.php           # Halaman Utama Toko
├── cart.php            # Halaman Keranjang
├── checkout.php        # Proses Pesanan
├── login.php           # Login Page
└── README.md           # Dokumentasi
```

## 💻 Cara Instalasi & Menjalankan

### 1. Persiapan Database
1.  Pastikan **XAMPP** (Apache & MySQL) sudah berjalan.
2.  Buka `http://localhost/phpmyadmin`.
3.  Buat database baru bernama: **`debora_store`**.
4.  Import file **`debora_store.sql`** yang ada di dalam folder proyek ini.

### 2. Konfigurasi Proyek
Buka file `config/database.php` dan sesuaikan jika ada perbedaan password XAMPP:
```php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika default XAMPP
$db   = "debora_store";
```

### 3. Menjalankan Aplikasi
Buka terminal di folder proyek, lalu jalankan:
```powershell
php -S localhost:8000
```
Buka browser dan akses: **[http://localhost:8000](http://localhost:8000)**

---

## 🔑 Akun Demo (Default)

| Role | Email | Password | Fungsi |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@debora.com` | `admin123` | Akses Penuh (Dashboard, Produk, Order, POS) |
| **Kasir** | `kasir@debora.com` | `kasir123` | Akses POS & Validasi Order |
| **Customer** | *(Daftar Sendiri)* | *(Bebas)* | Belanja Online |

*(Catatan: Password menggunakan enkripsi MD5)*

---

## ✅ Checklist Pengembangan
- [x] **Fase 1: Inisialisasi** (Setup Git, DB, Config)
- [x] **Fase 2: Frontend Toko** (Katalog, Keranjang, Checkout)
- [x] **Fase 3: Autentikasi** (Login Admin & Customer)
- [x] **Fase 4: Backend Admin** (CRUD Produk, Kelola Stok)
- [x] **Fase 5: Manajemen Transaksi** (Verifikasi Bukti Bayar)
- [x] **Fase 6: Fitur Kasir/POS** (Transaksi Tunai Walk-in)
- [x] **Fase 7: Finishing** (Perbaikan UI/UX & Dokumentasi)

## 👥 Tim Pengembang
*   **Tamara Debora Permata Sianipar** - *UI/UX Designer & Researcher & Full Stack Developer*

---
*Dibuat dengan ❤️ untuk UMKM Indonesia.*
