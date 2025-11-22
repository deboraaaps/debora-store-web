<?php
include 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<!-- Hero Section (Banner) -->
<section class="hero-section">
    <div class="container">
        <h1 class="display-4 fw-bold">Selamat Datang di Dapur Debora</h1>
        <p class="lead">Nikmati masakan rumahan terbaik dengan harga terjangkau.</p>
        <a href="#menu" class="btn btn-primary btn-lg">Pesan Sekarang</a>
    </div>
</section>

<!-- Daftar Menu -->
<section id="menu" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">Daftar Menu Favorit</h2>
        <div class="row">
            <?php
            // Ambil data produk dari database
            $query = mysqli_query($conn, "SELECT * FROM products");
            
            // Cek jika ada produk
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) {
            ?>
                <div class="col-md-4 col-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Gambar Placeholder jika belum ada gambar asli -->
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span>Gambar Produk</span> 
                            <!-- Nanti ganti dengan: <img src="assets/img/<?= $row['gambar']; ?>" ...> -->
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= $row['nama_produk']; ?></h5>
                            <p class="card-text text-muted small"><?= $row['deskripsi']; ?></p>
                            <h6 class="text-primary fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></h6>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <button class="btn btn-outline-primary w-100">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center'><p>Belum ada menu yang tersedia.</p></div>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>