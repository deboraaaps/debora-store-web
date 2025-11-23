<nav class="navbar navbar-expand-lg navbar-debora shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
        <i class="fas fa-utensils me-2"></i>Dapur Debora
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Menu</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Dropdown: Halo, Nama -->
            <li class="nav-item dropdown me-2">
                <a class="nav-link dropdown-toggle fw-bold text-warning" href="#" role="button" data-bs-toggle="dropdown">
                    Halo, <?php echo $_SESSION['name']; ?>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li><a class="dropdown-item" href="admin/index.php">Dashboard Admin</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="my_orders.php">Pesanan Saya</a></li>
                    <?php endif; ?>
                </ul>
            </li>

            <!-- Tombol Logout -->
            <li class="nav-item">
                <a class="btn btn-danger px-3 rounded-pill" href="logout.php">Logout</a>
            </li>

        <?php else: ?>
            <!-- Jika BELUM login -->
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-warning text-dark px-3 ms-2 rounded-pill" href="register.php">Daftar</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
