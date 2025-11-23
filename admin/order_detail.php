<?php
require_once '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../login.php"); exit; }

$id = $_GET['id'];

// PROSES UPDATE STATUS
if (isset($_POST['update_status'])) {
    $status = $_POST['status'];
    mysqli_query($conn, "UPDATE transactions SET status='$status' WHERE id='$id'");
    echo "<script>alert('Status pesanan diperbarui!'); window.location.href='order_detail.php?id=$id';</script>";
}

// Ambil data transaksi
$q_trx = mysqli_query($conn, "SELECT transactions.*, users.name, users.phone, users.email 
                              FROM transactions 
                              JOIN users ON transactions.user_id = users.id 
                              WHERE transactions.id='$id'");
$trx = mysqli_fetch_assoc($q_trx);

// Ambil detail barang
$q_items = mysqli_query($conn, "SELECT transaction_details.*, products.name 
                                FROM transaction_details 
                                JOIN products ON transaction_details.product_id = products.id 
                                WHERE transaction_id='$id'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #<?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">
    <a href="orders.php" class="btn btn-secondary mb-3">&laquo; Kembali ke Daftar</a>
    
    <div class="row">
        <!-- Kolom Kiri: Info Pesanan -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Rincian Barang</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($item = mysqli_fetch_assoc($q_items)): ?>
                            <tr>
                                <td><?php echo $item['name']; ?></td>
                                <td>Rp <?php echo number_format($item['price'], 0,',','.'); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0,',','.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                            <tr class="fw-bold table-light">
                                <td colspan="3" class="text-end">TOTAL:</td>
                                <td>Rp <?php echo number_format($trx['total_amount'], 0,',','.'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info Pengiriman -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Info Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama Penerima:</strong> <?php echo $trx['name']; ?></p>
                    <p><strong>No. HP/WA:</strong> <?php echo $trx['phone']; ?> 
                        <a href="https://wa.me/<?php echo $trx['phone']; ?>" target="_blank" class="btn btn-sm btn-success ms-2">Chat WA</a>
                    </p>
                    <p><strong>Alamat:</strong><br><?php echo nl2br($trx['shipping_address']); ?></p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Bukti Bayar & Aksi -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Bukti Pembayaran</h5>
                </div>
                <div class="card-body text-center">
                    <?php if($trx['proof_image']): ?>
                        <img src="../assets/uploads/<?php echo $trx['proof_image']; ?>" class="img-fluid rounded border mb-2" style="max-height: 300px;">
                        <br>
                        <a href="../assets/uploads/<?php echo $trx['proof_image']; ?>" target="_blank" class="btn btn-sm btn-outline-dark">Lihat Ukuran Penuh</a>
                    <?php else: ?>
                        <div class="alert alert-danger">Belum ada bukti pembayaran.</div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Update Status</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Status Pesanan:</label>
                            <select name="status" class="form-select">
                                <option value="pending" <?php if($trx['status']=='pending') echo 'selected'; ?>>Pending (Menunggu Bayar)</option>
                                <option value="process" <?php if($trx['status']=='process') echo 'selected'; ?>>Process (Sedang Disiapkan)</option>
                                <option value="completed" <?php if($trx['status']=='completed') echo 'selected'; ?>>Completed (Selesai/Dikirim)</option>
                                <option value="cancelled" <?php if($trx['status']=='cancelled') echo 'selected'; ?>>Cancelled (Dibatalkan)</option>
                            </select>
                        </div>
                        <button type="submit" name="update_status" class="btn btn-success w-100">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>