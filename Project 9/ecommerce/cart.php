<?php
session_start();
include __DIR__ . '/koneksi.php';

// --- Hapus item jika ada request ---
if (isset($_POST['remove_id'])) {
    $remove_id = (int) $_POST['remove_id'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
    header("Location: cart.php"); // refresh biar bersih dari POST
    exit;
}

// --- Ambil data keranjang ---
$cart_items = [];
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $ids = array_keys($_SESSION['cart']);
    $ids_str = implode(",", array_map('intval', $ids));

    $sql = "SELECT * FROM products WHERE id IN ($ids_str)";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $cart_items[$id] = $row;
        $cart_items[$id]['qty'] = $_SESSION['cart'][$id];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
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
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : '' ?>" href="cart.php">
            Keranjang 
            <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
              <span class="badge bg-danger"><?= array_sum($_SESSION['cart']); ?></span>
            <?php endif; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h1 class="mb-4">🛒 Keranjang Belanja</h1>

  <?php if (empty($cart_items)) { ?>
      <div class="alert alert-info">Keranjang masih kosong. <a href="index.php">Belanja sekarang</a></div>
  <?php } else { ?>
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php 
        $total = 0;
        foreach ($cart_items as $item) {
            $subtotal = $item['harga'] * $item['qty'];
            $total += $subtotal;
            echo "
            <tr>
              <td>".htmlspecialchars($item['nama_produk'])."</td>
              <td>Rp ".number_format($item['harga'],0,",",".")."</td>
              <td>".$item['qty']."</td>
              <td>Rp ".number_format($subtotal,0,",",".")."</td>
              <td>
                <form method='POST' class='d-inline'>
                  <input type='hidden' name='remove_id' value='".$item['id']."'>
                  <button type='submit' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus produk ini dari keranjang?')\">Hapus</button>
                </form>
              </td>
            </tr>";
        }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <th colspan="4" class="text-end">Total</th>
            <th>Rp <?= number_format($total,0,",",".") ?></th>
          </tr>
        </tfoot>
      </table>
  <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
