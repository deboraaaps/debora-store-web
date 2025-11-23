<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }
?>

<div class="container my-5">
    <h3 class="mb-4">Riwayat Pesanan Saya</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $query = mysqli_query($conn, "SELECT * FROM transactions WHERE user_id='$user_id' ORDER BY id DESC");
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        $status_badge = 'bg-secondary';
                        if ($row['status'] == 'pending') $status_badge = 'bg-warning text-dark';
                        if ($row['status'] == 'process') $status_badge = 'bg-info text-dark';
                        if ($row['status'] == 'completed') $status_badge = 'bg-success';
                        if ($row['status'] == 'cancelled') $status_badge = 'bg-danger';
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['transaction_date']; ?></td>
                        <td>Rp <?php echo number_format($row['total_amount'], 0,',','.'); ?></td>
                        <td><span class="badge <?php echo $status_badge; ?>"><?php echo strtoupper($row['status']); ?></span></td>
                        <td>
                            <?php if($row['status'] == 'pending' && empty($row['proof_image'])): ?>
                                <a href="payment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Bayar</a>
                            <?php elseif($row['proof_image']): ?>
                                <small class="text-success"><i class="fas fa-check"></i> Bukti Terkirim</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>