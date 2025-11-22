-- Buat Tabel User
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'kasir', 'konsumen') DEFAULT 'konsumen',
    no_hp VARCHAR(15)
);

-- Insert User Default (Password: admin123)
INSERT INTO users (nama, email, password, role, no_hp) 
VALUES ('Admin Debora', 'admin@debora.com', '$2y$10$E.s.T... (Hash Password)', 'admin', '08123456789');

-- Buat Tabel Produk
CREATE TABLE products (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100),
    deskripsi TEXT,
    harga DECIMAL(10, 2),
    stok INT DEFAULT 0,
    gambar VARCHAR(255)
);

-- Insert Contoh Produk
INSERT INTO products (nama_produk, deskripsi, harga, stok, gambar) VALUES 
('Ayam Bakar Madu', 'Ayam bakar dengan olesan madu spesial + lalapan', 25000, 20, 'ayam_bakar.jpg'),
('Paket Nasi Box A', 'Nasi, Ayam Goreng, Tahu, Tempe, Sambal', 30000, 50, 'paket_a.jpg');