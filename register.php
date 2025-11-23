<?php
require_once 'config/database.php';

// Kalau sudah login, ngapain daftar lagi?
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']); // MD5 lagi
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Cek apakah email sudah ada?
    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        $error = "Email sudah terdaftar! Silakan login.";
    } else {
        // Simpan User Baru (Role otomatis 'customer')
        $query = "INSERT INTO users (name, email, password, phone, address, role) 
                  VALUES ('$name', '$email', '$password', '$phone', '$address', 'customer')";
        
        if (mysqli_query($conn, $query)) {
            $success = "Pendaftaran berhasil! Silakan login.";
        } else {
            $error = "Gagal mendaftar: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Dapur Debora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center my-5">

    <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4" style="color: var(--primary-color);">Daftar Pelanggan Baru</h3>
        
        <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?> <br>
                <a href="login.php" class="fw-bold">Klik disini untuk Login</a>
            </div>
        <?php else: ?>

        <form method="POST">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nomor WhatsApp/HP</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat Lengkap (Untuk Pengiriman)</label>
                <textarea name="address" class="form-control" rows="2" required></textarea>
            </div>
            <button type="submit" class="btn btn-debora w-100">Daftar Sekarang</button>
        </form>
        
        <div class="text-center mt-3">
            <small>Sudah punya akun? <a href="login.php">Login disini</a></small>
        </div>

        <?php endif; ?>
    </div>

</body>
</html>