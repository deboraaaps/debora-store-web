<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Cek login & keranjang
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
if (empty($_SESSION['cart'])) { header("Location: index.php"); exit; }

// Ambil data user untuk auto-fill alamat
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);

// Hitung Total Belanja lagi (untuk validasi)
$total_belanja = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $q = mysqli_query($conn, "SELECT price FROM products WHERE id='$id'");
    $d = mysqli_fetch_assoc($q);
    $total_belanja += ($d['price'] * $qty);
}

// --- LOGIKA PROSES PESANAN ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $grand_total = $total_belanja; // Bisa ditambah ongkir kalau mau, sementara sama dulu

    // 1. Simpan ke tabel TRANSACTIONS
    $query_trx = "INSERT INTO transactions (user_id, total_amount, status, shipping_address) 
                  VALUES ('$user_id', '$grand_total', 'pending', '$address')";
    
    if (mysqli_query($conn, $query_trx)) {
        // Ambil ID Transaksi yang baru saja dibuat
        $transaction_id = mysqli_insert_id($conn);

        // 2. Simpan detail barang ke TRANSACTION_DETAILS & Kurangi Stok
        foreach ($_SESSION['cart'] as $prod_id => $qty) {
            // Ambil harga saat ini
            $q_prod = mysqli_query($conn, "SELECT price FROM products WHERE id='$prod_id'");
            $d_prod = mysqli_fetch_assoc($q_prod);
            $price = $d_prod['price'];

            // Insert Detail
            mysqli_query($conn, "INSERT INTO transaction_details (transaction_id, product_id, quantity, price) 
                                 VALUES ('$transaction_id', '$prod_id', '$qty', '$price')");
            
            // Kurangi Stok
            mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id='$prod_id'");
        }

        // 3. Kosongkan Keranjang
        unset($_SESSION['cart']);

        // 4. Arahkan ke Halaman Pembayaran
        echo "<script>alert('Pesanan berhasil dibuat!'); window.location.href='payment.php?id=$transaction_id';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-file-invoice me-2"></i>Konfirmasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Ringkasan Pesanan:</h6>
                    <ul class="list-group mb-3">
                        <?php foreach($_SESSION['cart'] as $pid => $qty): 
                             $pq = mysqli_query($conn, "SELECT name, price FROM products WHERE id='$pid'");
                             $pd = mysqli_fetch_assoc($pq);
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $pd['name']; ?> <span class="badge bg-secondary rounded-pill">x<?php echo $qty; ?></span>
                            <span>Rp <?php echo number_format($pd['price'] * $qty, 0,',','.'); ?></span>
                        </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between bg-light fw-bold">
                            <span>TOTAL BAYAR</span>
                            <span>Rp <?php echo number_format($total_belanja, 0,',','.'); ?></span>
                        </li>
                    </ul>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Alamat Pengiriman</label>
                            <textarea name="address" class="form-control" rows="3" required><?php echo $user['address']; ?></textarea>
                            <small class="text-muted">Pastikan alamat lengkap agar kurir tidak nyasar.</small>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-debora fw-bold p-3">
                                BUAT PESANAN <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>