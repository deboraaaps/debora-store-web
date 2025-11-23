<?php
session_start();

// Cek login dulu
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID produk dari URL
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($product_id) {
    // Jika keranjang belum ada, buat array kosong
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Jika produk sudah ada di keranjang, tambah jumlahnya
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += 1;
    } else {
        // Jika belum ada, set jadi 1
        $_SESSION['cart'][$product_id] = 1;
    }

    // Redirect ke halaman keranjang (biar user tau barangnya masuk)
    header("Location: cart.php");
    exit;
} else {
    header("Location: index.php");
}
?>