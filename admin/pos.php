<?php
require_once '../config/database.php';

// Cek akses: Admin atau Kasir boleh masuk
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'kasir')) {
    header("Location: ../login.php");
    exit;
}

// 1. LOGIKA TAMBAH ITEM KE KERANJANG KASIR
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    if (!isset($_SESSION['pos_cart'])) $_SESSION['pos_cart'] = [];
    
    if (isset($_SESSION['pos_cart'][$id])) {
        $_SESSION['pos_cart'][$id]++;
    } else {
        $_SESSION['pos_cart'][$id] = 1;
    }
    header("Location: pos.php");
    exit;
}

// 2. LOGIKA RESET KERANJANG
if (isset($_GET['clear'])) {
    unset($_SESSION['pos_cart']);
    header("Location: pos.php");
    exit;
}

// 3. LOGIKA PROSES BAYAR (CHECKOUT)
if (isset($_POST['checkout'])) {
    if (!empty($_SESSION['pos_cart'])) {
        $user_id = 999; // ID Walk-in Customer
        $total = $_POST['total_amount'];
        $tunai = $_POST['tunai']; // Uang yang diterima
        
        if ($tunai < $total) {
            echo "<script>alert('Uang tunai kurang!');</script>";
        } else {
            // Insert Transaksi (Langsung Completed)
            $query_trx = "INSERT INTO transactions (user_id, total_amount, status, shipping_address, proof_image) 
                          VALUES ('$user_id', '$total', 'completed', 'Dine-in / Takeaway', 'CASH')";
            mysqli_query($conn, $query_trx);
            $trx_id = mysqli_insert_id($conn);

            // Insert Detail & Kurangi Stok
            foreach ($_SESSION['pos_cart'] as $pid => $qty) {
                $q_prod = mysqli_query($conn, "SELECT price FROM products WHERE id='$pid'");
                $d_prod = mysqli_fetch_assoc($q_prod);
                $price = $d_prod['price'];

                mysqli_query($conn, "INSERT INTO transaction_details (transaction_id, product_id, quantity, price) 
                                     VALUES ('$trx_id', '$pid', '$qty', '$price')");
                
                mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id='$pid'");
            }

            unset($_SESSION['pos_cart']);
            $kembalian = $tunai - $total;
            echo "<script>alert('Transaksi Berhasil! Kembalian: Rp " . number_format($kembalian,0,',','.') . "'); window.location.href='pos.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kasir (POS) - Dapur Debora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-card { cursor: pointer; transition: 0.2s; }
        .product-card:hover { transform: scale(1.02); border-color: #145a46; }
        .scroll-area { height: 75vh; overflow-y: auto; }
    </style>
</head>
<body class="bg-light overflow-hidden">

<div class="container-fluid">
    <div class="row">
        
        <!-- KOLOM KIRI: Daftar Menu -->
        <div class="col-md-8 p-4">
            <div class="d-flex justify-content-between mb-3">
                <h4><i class="fas fa-cash-register me-2"></i>Kasir Dapur Debora</h4>
                <a href="index.php" class="btn btn-outline-dark">Kembali ke Dashboard</a>
            </div>
            
            <div class="row scroll-area">
                <?php
                $products = mysqli_query($conn, "SELECT * FROM products WHERE stock > 0");
                while($p = mysqli_fetch_assoc($products)):
                ?>
                <div class="col-md-3 mb-3">
                    <a href="pos.php?add=<?php echo $p['id']; ?>" class="text-decoration-none text-dark">
                        <div class="card product-card h-100">
                            <img src="../assets/img/<?php echo $p['image']; ?>" class="card-img-top" style="height: 120px; object-fit: cover;">
                            <div class="card-body p-2 text-center">
                                <h6 class="mb-1" style="font-size: 0.9rem;"><?php echo $p['name']; ?></h6>
                                <span class="text-success fw-bold">Rp <?php echo number_format($p['price'],0,',','.'); ?></span>
                                <br><small class="text-muted">Stok: <?php echo $p['stock']; ?></small>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- KOLOM KANAN: Keranjang / Struk -->
        <div class="col-md-4 bg-white border-start p-4 d-flex flex-column" style="height: 100vh;">
            <h5 class="mb-3 border-bottom pb-2">Pesanan Saat Ini</h5>
            
            <div class="flex-grow-1 overflow-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grand_total = 0;
                        if(isset($_SESSION['pos_cart']) && !empty($_SESSION['pos_cart'])):
                            foreach($_SESSION['pos_cart'] as $pid => $qty):
                                $q = mysqli_query($conn, "SELECT name, price FROM products WHERE id='$pid'");
                                $d = mysqli_fetch_assoc($q);
                                $subtotal = $d['price'] * $qty;
                                $grand_total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $d['name']; ?></td>
                            <td>x<?php echo $qty; ?></td>
                            <td class="text-end"><?php echo number_format($subtotal,0,',','.'); ?></td>
                        </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-auto">
                <div class="d-flex justify-content-between fw-bold fs-4 mb-3">
                    <span>Total:</span>
                    <span>Rp <?php echo number_format($grand_total,0,',','.'); ?></span>
                </div>

                <form method="POST">
                    <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>">
                    <div class="mb-3">
                        <label>Uang Tunai (Rp)</label>
                        <input type="number" name="tunai" class="form-control form-control-lg" required placeholder="0">
                    </div>
                    <div class="row g-2">
                        <div class="col-8">
                            <button type="submit" name="checkout" class="btn btn-success w-100 py-3 fw-bold" <?php if($grand_total==0) echo 'disabled'; ?>>
                                BAYAR & SELESAI
                            </button>
                        </div>
                        <div class="col-4">
                            <a href="pos.php?clear=true" class="btn btn-danger w-100 py-3">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>