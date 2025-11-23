<?php
// Mundur satu folder untuk panggil database
require_once '../config/database.php';

// 1. Cek Keamanan: Apakah yang login beneran Admin?
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php"); // Tendang balik ke login
    exit;
}

// 2. Ambil Data Statistik untuk Dashboard
$count_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$count_orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transactions"));
$count_users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='customer'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Dapur Debora</title>
    <!-- Bootstrap pakai CDN biar gampang -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <!-- Navbar Khusus Admin -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Panel - Dapur Debora</a>
            <div class="d-flex">
                <span class="navbar-text me-3">Halo, <?php echo $_SESSION['name']; ?></span>
                <a href="../logout.php" class="btn btn-sm btn-danger">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar Sederhana -->
            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="index.php" class="list-group-item list-group-item-action active bg-success">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="products.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-box me-2"></i> Kelola Produk
                    </a>
                    <a href="orders.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart me-2"></i> Kelola Pesanan
                    </a>
                    <a href="../index.php" class="list-group-item list-group-item-action" target="_blank">
                        <i class="fas fa-globe me-2"></i> Lihat Website
                    </a>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="col-md-9">
                <h3 class="mb-4">Ringkasan Toko</h3>
                
                <div class="row">
                    <!-- Card 1: Produk -->
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Menu</h5>
                                <p class="card-text display-4 fw-bold"><?php echo $count_products; ?></p>
                                <a href="products.php" class="text-white text-decoration-none">Lihat Detail &rarr;</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 2: Pesanan -->
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Pesanan</h5>
                                <p class="card-text display-4 fw-bold"><?php echo $count_orders; ?></p>
                                <a href="orders.php" class="text-white text-decoration-none">Lihat Detail &rarr;</a>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Pelanggan -->
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>