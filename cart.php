<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Cek login
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

// Inisialisasi keranjang
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<div class="container my-5">
    <h2 class="mb-4"><i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-warning text-center">
            Keranjang kamu masih kosong. <br> 
            <a href="index.php" class="btn btn-sm btn-warning mt-2">Belanja Sekarang</a>
        </div>
    <?php else: ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th style="width: 15%;">Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_belanja = 0;
                            // Loop setiap item di session cart
                            foreach ($cart as $id_produk => $jumlah):
                                // Ambil detail produk dari DB
                                $query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id_produk'");
                                $produk = mysqli_fetch_assoc($query);
                                $subtotal = $produk['price'] * $jumlah;
                                $total_belanja += $subtotal;
                            ?>
                            <tr class="align-middle">
                                <td class="text-start ps-4">
                                    <strong><?php echo $produk['name']; ?></strong>
                                </td>
                                <td>Rp <?php echo number_format($produk['price'], 0,',','.'); ?></td>
                                <td>
                                    <!-- Form update jumlah sederhana -->
                                    <span class="badge bg-secondary p-2"><?php echo $jumlah; ?></span>
                                </td>
                                <td class="fw-bold">Rp <?php echo number_format($subtotal, 0,',','.'); ?></td>
                                <td>
                                    <a href="cart_delete.php?id=<?php echo $id_produk; ?>" class="text-danger" onclick="return confirm('Hapus item ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ringkasan Belanja -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Ringkasan Pesanan</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Belanja</span>
                        <span class="fw-bold fs-5">Rp <?php echo number_format($total_belanja, 0,',','.'); ?></span>
                    </div>
                    <hr>
                    <a href="checkout.php" class="btn btn-debora w-100 fw-bold py-2">Lanjut ke Pembayaran <i class="fas fa-arrow-right ms-2"></i></a>
                    <a href="index.php" class="btn btn-outline-secondary w-100 mt-2">Tambah Menu Lain</a>
                </div>
            </div>
        </div>
    </div>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>