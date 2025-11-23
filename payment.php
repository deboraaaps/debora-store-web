<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$trx_id = $_GET['id'];

// Ambil data transaksi
$query = mysqli_query($conn, "SELECT * FROM transactions WHERE id='$trx_id' AND user_id='$_SESSION[user_id]'");
$trx = mysqli_fetch_assoc($query);

if (!$trx) { header("Location: index.php"); exit; }

// LOGIKA UPLOAD BUKTI
if (isset($_POST['upload'])) {
    $image_name = time() . '-' . $_FILES['proof']['name'];
    $image_tmp = $_FILES['proof']['tmp_name'];
    
    // Pastikan folder uploads ada
    if(!is_dir("assets/uploads")) mkdir("assets/uploads");

    if (move_uploaded_file($image_tmp, "assets/uploads/" . $image_name)) {
        // Update database
        mysqli_query($conn, "UPDATE transactions SET proof_image='$image_name', status='process' WHERE id='$trx_id'");
        echo "<script>alert('Terima kasih! Bukti pembayaran berhasil dikirim.'); window.location.href='my_orders.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal upload gambar.');</script>";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center shadow">
                <div class="card-header bg-warning">
                    <h5 class="mb-0 fw-bold">Selesaikan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <p class="lead">ID Pesanan: #<?php echo $trx['id']; ?></p>
                    <h2 class="text-success fw-bold mb-4">Rp <?php echo number_format($trx['total_amount'], 0,',','.'); ?></h2>
                    
                    <div class="alert alert-info text-start">
                        <p class="mb-1">Silakan transfer ke rekening berikut:</p>
                        <strong>BCA: 123-456-7890</strong><br>
                        <strong>A.N. Dapur Debora</strong>
                    </div>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3 text-start">
                            <label class="form-label">Upload Bukti Transfer</label>
                            <input type="file" name="proof" class="form-control" required accept="image/*">
                        </div>
                        <button type="submit" name="upload" class="btn btn-primary w-100">Kirim Bukti Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>