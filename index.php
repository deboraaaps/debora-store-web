<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Banner / Hero Section -->
<div class="container-fluid p-5 bg-light text-center mb-4" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; color: white; border-radius: 0 0 20px 20px;">
    <h1 class="display-4 fw-bold">Selamat Datang di Dapur Debora</h1>
    <p class="lead">Nikmati masakan rumahan terbaik dengan bahan pilihan.</p>
    <a href="#" class="btn btn-warning btn-lg mt-3 fw-bold">Pesan Sekarang</a>
</div>

<main class="container my-5">
    <div class="row text-center">
        <div class="col-md-12">
            <h2 class="mb-4" style="color: var(--primary-color);">Menu Favorit Kami</h2>
        </div>
    </div>

    <!-- Contoh Card Produk (Statis dulu) -->
   <!-- List Produk Dari Database -->
    <div class="row">
        <?php
        // Ambil data produk dari database
        $query_products = mysqli_query($conn, "SELECT * FROM products WHERE stock > 0 ORDER BY id DESC");
        
        if(mysqli_num_rows($query_products) > 0) {
            while ($row = mysqli_fetch_assoc($query_products)) {
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <!-- Foto Produk -->
                    <div style="height: 200px; overflow: hidden;">
                        <img src="assets/img/<?php echo $row['image']; ?>" class="card-img-top w-100 h-100" style="object-fit: cover;" alt="<?php echo $row['name']; ?>">
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold"><?php echo $row['name']; ?></h5>
                        <p class="card-text text-muted small flex-grow-1">
                            <?php echo substr($row['description'], 0, 80); ?>...
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-success fw-bold mb-0">Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></h6>
                            <span class="badge bg-secondary">Stok: <?php echo $row['stock']; ?></span>
                        </div>
                        
                        <!-- Tombol Pesan: Arahkan ke Login jika belum masuk -->
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="cart_add.php?id=<?php echo $row['id']; ?>" class="btn btn-debora w-100 mt-auto">
                                <i class="fas fa-shopping-cart me-2"></i>Pesan
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-outline-success w-100 mt-auto">Login untuk Pesan</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php 
            } // Tutup While
        } else {
            echo '<div class="col-12 text-center py-5"><p class="text-muted">Belum ada menu yang tersedia saat ini.</p></div>';
        } 
        ?>
    </div>
    <?php include 'includes/footer.php'; ?>