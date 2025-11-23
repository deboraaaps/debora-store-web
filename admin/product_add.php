<?php
require_once '../config/database.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../login.php"); exit; }

$error = "";

// LOGIKA SIMPAN DATA
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    
    // Proses Upload Gambar
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_new_name = time() . '-' . $image_name; // Rename biar gak bentrok
    
    if (move_uploaded_file($image_tmp, "../assets/img/" . $image_new_name)) {
        $query = "INSERT INTO products (name, description, price, stock, category, image) 
                  VALUES ('$name', '$desc', '$price', '$stock', '$category', '$image_new_name')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: products.php");
            exit;
        } else {
            $error = "Gagal menyimpan ke database!";
        }
    } else {
        $error = "Gagal upload gambar!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu - Dapur Debora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Tambah Menu Baru</h5>
        </div>
        <div class="card-body">
            <?php if($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data"> <!-- Wajib enctype buat upload file -->
                <div class="mb-3">
                    <label>Nama Makanan/Minuman</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="category" class="form-select">
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stok Awal</label>
                        <input type="number" name="stock" class="form-control" required value="10">
                    </div>
                </div>
                <div class="mb-3">
                    <label>Foto Menu</label>
                    <input type="file" name="image" class="form-control" required accept="image/*">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">Simpan Menu</button>
                    <a href="products.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>