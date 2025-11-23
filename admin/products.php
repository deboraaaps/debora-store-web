<?php
require_once '../config/database.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// --- LOGIKA HAPUS PRODUK ---
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    // Ambil nama gambar dulu buat dihapus dari folder
    $q_gambar = mysqli_query($conn, "SELECT image FROM products WHERE id='$id'");
    $data_gambar = mysqli_fetch_assoc($q_gambar);
    
    // Hapus file gambar jika ada
    if ($data_gambar['image'] && file_exists("../assets/img/" . $data_gambar['image'])) {
        unlink("../assets/img/" . $data_gambar['image']);
    }

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
    
    // Refresh halaman
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Produk - Dapur Debora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Admin Panel</a>
        <a href="index.php" class="btn btn-sm btn-outline-light">Kembali ke Dashboard</a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar Menu Makanan</h3>
        <a href="product_add.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Menu Baru</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                    $no = 1;
                    
                    // Looping data
                    while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td>
                            <?php if($row['image']): ?>
                                <img src="../assets/img/<?php echo $row['image']; ?>" width="80" class="img-thumbnail">
                            <?php else: ?>
                                <span class="text-muted">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo $row['name']; ?></strong>
                            <br>
                            <small class="text-muted"><?php echo substr($row['description'], 0, 50); ?>...</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark"><?php echo $row['category']; ?></span>
                        </td>
                        <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['stock']; ?> Porsi</td>
                        <td>
                            <a href="product_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="products.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } // Tutup while ?>
                    
                    <?php if(mysqli_num_rows($query) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada menu yang ditambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>