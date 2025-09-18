<?php
include __DIR__ . '/koneksi.php';
session_start();

// --- Filter kategori ---
$where = "";
if (isset($_GET['kategori']) && $_GET['kategori'] != "") {
    $kategori = $conn->real_escape_string($_GET['kategori']);
    $where = "WHERE kategori = '$kategori'";
}

// --- Ambil daftar kategori unik ---
$kategori_sql = "SELECT DISTINCT kategori FROM products";
$kategori_result = $conn->query($kategori_sql);

if (!$kategori_result) {
    die("Query kategori gagal: " . $conn->error);
}

// --- Query produk ---
$sql = "SELECT * FROM products $where";
$result = $conn->query($sql);

// --- Tambah ke keranjang ---
$alert = "";
if (isset($_POST['add_to_cart'])) {
    $product_id = (int) $_POST['product_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += 1; // tambah qty
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    $alert = "<div class='alert alert-success text-center'>Produk berhasil ditambahkan ke keranjang!</div>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Toko Online Madura</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="index.php">🛒 Toko Madura</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Keranjang 
            <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
              <span class="badge bg-danger"><?= array_sum($_SESSION['cart']); ?></span>
            <?php endif; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <?= $alert ?> <!-- ✅ alert ditaruh di sini -->

  <h1 class="text-center mb-4">Produk Toko Madura Kami</h1>

  <!-- Filter kategori -->
  <form method="GET" class="mb-4 text-center">
    <select name="kategori" class="form-select w-50 d-inline">
      <option value="">-- Semua Kategori --</option>
      <?php while($kat = $kategori_result->fetch_assoc()) { ?>
        <option value="<?= htmlspecialchars($kat['kategori']) ?>"
          <?= (isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($kat['kategori']) ?>
        </option>
      <?php } ?>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="index.php" class="btn btn-secondary">Reset</a>
  </form>

  <div class="row g-4">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="' . htmlspecialchars($row['gambar']) . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_produk']) . '">
                <div class="card-body">
                  <h5 class="card-title">' . htmlspecialchars($row['nama_produk']) . '</h5>
                  <p class="card-text">' . htmlspecialchars($row['deskripsi']) . '</p>
                  <p class="fw-bold text-primary">Rp ' . number_format($row['harga'],0,",",".") . '</p>
                  <form method="POST">
                    <input type="hidden" name="product_id" value="' . $row['id'] . '">
                    <button type="submit" name="add_to_cart" class="btn btn-success w-100">+ Tambah ke Keranjang</button>
                  </form>
                </div>
              </div>
            </div>
            ';
        }
    } else {
        echo "<p class='text-center'>Belum ada produk tersedia.</p>";
    }
    ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
