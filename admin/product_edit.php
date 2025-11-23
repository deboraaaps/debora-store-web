<?php
require_once '../config/database.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../login.php"); exit; }

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Jika ID tidak ditemukan
if (!$data) { header("Location: products.php"); exit; }

// LOGIKA UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    // Cek apakah user upload gambar baru?
    if ($_FILES['image']['name'] != "") {
        // 1. Hapus gambar lama
        if ($data['image'] && file_exists("../assets/img/" . $data['image'])) {
            unlink("../assets/img/" . $data['image']);
        }

        // 2. Upload gambar baru
        $image_name = time() . '-' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/img/" . $image_name);
        
        // Query Update DENGAN gambar
        $sql = "UPDATE products SET 
                name='$name', description='$desc', price='$price', stock='$stock', category='$category', image='$image_name' 
                WHERE id='$id'";
    } else {
        // Query Update TANPA gambar (pakai gambar lama)
        $sql = "UPDATE products SET 
                name='$name', description='$desc', price='$price', stock='$stock', category='$category' 
                WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: products.php");
        exit;
    } else {
        echo "Gagal Update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Menu - Dapur Debora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0 fw-bold">Edit Menu</h5>
        </div>
        <div class="card-body">
            
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Nama Makanan/Minuman</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>" required>
                </div>
                
                <div class="mb-3">
                    <label>Kategori</label>
                    <select name="category" class="form-select">
                        <option value="makanan" <?php if($data['category']=='makanan') echo 'selected'; ?>>Makanan</option>
                        <option value="minuman" <?php if($data['category']=='minuman') echo 'selected'; ?>>Minuman</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo $data['description']; ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" value="<?php echo $data['price']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Stok</label>
                        <input type="number" name="stock" class="form-control" value="<?php echo $data['stock']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Ganti Foto (Kosongkan jika tidak ingin mengganti)</label>
                    <div class="mb-2">
                        <img src="../assets/img/<?php echo $data['image']; ?>" width="100" class="img-thumbnail">
                    </div>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-warning fw-bold">Update Menu</button>
                    <a href="products.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>