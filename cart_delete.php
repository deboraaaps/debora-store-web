<?php
session_start();
$id = $_GET['id'];

if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]); // Hapus item dari array session
}

header("Location: cart.php");
exit;
?>