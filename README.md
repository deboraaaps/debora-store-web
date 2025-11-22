# 🍱 Aplikasi Penjualan Online UMKM Dapur Debora

> **Desain Aplikasi Penjualan Online dengan Pendekatan User Interface dan User Experience pada UMKM Debora Store.**

![Project Status](https://img.shields.io/badge/Status-In%20Development-orange)
![PHP Version](https://img.shields.io/badge/PHP-8.2-777BB4)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3)

## 📖 Latar Belakang
Proyek ini bertujuan untuk mendigitalisasi proses pemesanan pada **UMKM Dapur Debora (D-Kitchen)**. Sebelumnya, pemesanan dilakukan secara manual melalui WhatsApp yang sering menyebabkan penumpukan chat dan kesalahan pencatatan. 

Aplikasi ini dirancang berbasis web dengan fokus pada kemudahan penggunaan (**User Experience**) dan tampilan yang menarik (**User Interface**), memungkinkan pelanggan memesan makanan secara mandiri dan pemilik usaha mengelola pesanan dengan lebih efisien.

## 🚀 Fitur Utama
### Sisi Pelanggan (Frontend)
- **Katalog Menu Digital:** Menampilkan daftar makanan lengkap dengan foto, deskripsi, dan harga.
- **Keranjang Belanja:** Menyimpan pesanan sementara sebelum checkout.
- **Checkout Pemesanan:** Form konfirmasi pesanan dan upload bukti pembayaran.
- **Responsive Design:** Tampilan optimal di HP (Mobile-First) maupun Desktop.

### Sisi Admin/Pemilik (Backend) - *Coming Soon*
- **Dashboard:** Ringkasan penjualan harian/bulanan.
- **Manajemen Produk:** Tambah, Edit, dan Hapus menu makanan.
- **Manajemen Pesanan:** Konfirmasi pesanan masuk (Pending -> Proses -> Selesai).

## 🛠️ Teknologi yang Digunakan
- **Bahasa Pemrograman:** PHP (Native)
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Server Environment:** XAMPP / PHP Built-in Server
- **Tools Desain:** Figma (untuk prototyping UI/UX)

## 📂 Struktur Folder
```
debora-store-web/
├── assets/             # File statis (CSS, Gambar, JS)
├── config/             # Konfigurasi database
├── includes/           # Potongan layout (Header, Navbar, Footer)
├── index.php           # Halaman Utama
├── db_debora.sql       # File Database SQL
└── README.md           # Dokumentasi Proyek
```

## 💻 Cara Menjalankan (Instalasi)

### 1. Persiapan Database
1. Pastikan **XAMPP** sudah terinstall dan **MySQL** sudah dijalankan.
2. Buka `http://localhost/phpmyadmin`.
3. Buat database baru dengan nama **`db_debora`**.
4. Import file `db_debora.sql` atau jalankan query SQL yang tersedia.

### 2. Konfigurasi Koneksi
Buka file `config/database.php` dan sesuaikan dengan settingan XAMPP Anda:
```php
$host = "localhost";
$user = "root";
$pass = "";       // Default XAMPP kosong
$db   = "db_debora";
```

### 3. Menjalankan Server
Jika tidak menggunakan folder `htdocs`, Anda bisa menggunakan terminal:

1. Buka Terminal / PowerShell di folder proyek.
2. Jalankan perintah berikut:
   ```powershell
   php -S localhost:8000
   ```
3. Buka browser dan akses: **http://localhost:8000**

## 📝 To-Do List (Roadmap Pengembangan)
- [x] **Fase 1: Inisialisasi**
    - [x] Setup Struktur Folder & Git.
    - [x] Desain Database (ERD & SQL).
    - [x] Koneksi Database PHP.
- [x] **Fase 2: Tampilan Dasar**
    - [x] Implementasi Bootstrap 5.
    - [x] Halaman Landing Page & Daftar Menu.
    - [x] Styling CSS (Tema Hijau Dapur Debora).
- [ ] **Fase 3: Transaksi**
    - [ ] Fitur Login & Register Pelanggan.
    - [ ] Logika Keranjang Belanja (Session).
    - [ ] Halaman Checkout & Kirim Pesanan ke Database.
- [ ] **Fase 4: Admin Panel**
    - [ ] Halaman Login Admin.
    - [ ] CRUD Data Produk (Tambah/Hapus Menu).
    - [ ] Rekap Laporan Penjualan.

## 👥 Kontributor
* **Muhammad Rafi Norikhsan** - *Developer & Researcher*
* **Tamara Debora Permata Sianipar** - *Developer & Researcher*

---
*Dibuat untuk memenuhi Tugas Mata Kuliah Metodologi Penelitian - Universitas Pamulang.*


### Cara Menggunakannya:
1.  Buat file baru di VS Code bernama `README.md`.
2.  Paste kode di atas.
3.  Simpan.
4.  Lakukan commit lagi agar file ini masuk ke GitHub:
    ```powershell
    git add README.md
    git commit -m "Menambahkan dokumentasi README project"
    git push
