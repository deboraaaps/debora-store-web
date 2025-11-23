<?php
require_once '../config/database.php';

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../login.php"); exit; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan - Dapur Debora</title>
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
    <h3 class="mb-4">Daftar Pesanan Masuk</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Bukti Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Join tabel transactions dengan users supaya dapat nama pelanggan
                    $query = mysqli_query($conn, "SELECT transactions.*, users.name as customer_name 
                                                  FROM transactions 
                                                  JOIN users ON transactions.user_id = users.id 
                                                  ORDER BY transactions.id DESC");
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        $status_badge = 'bg-secondary';
                        if ($row['status'] == 'pending') $status_badge = 'bg-warning text-dark';
                        if ($row['status'] == 'process') $status_badge = 'bg-info text-dark';
                        if ($row['status'] == 'completed') $status_badge = 'bg-success';
                        if ($row['status'] == 'cancelled') $status_badge = 'bg-danger';
                    ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($row['transaction_date'])); ?></td>
                        <td>Rp <?php echo number_format($row['total_amount'], 0,',','.'); ?></td>
                        <td><span class="badge <?php echo $status_badge; ?>"><?php echo strtoupper($row['status']); ?></span></td>
                        <td>
                            <?php if($row['proof_image']): ?>
                                <span class="text-success"><i class="fas fa-check-circle"></i> Ada</span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="order_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>