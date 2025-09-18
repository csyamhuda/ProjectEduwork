<?php
// pastikan path benar
$conn_path = __DIR__ . '/koneksi.php';
if (!file_exists($conn_path)) {
    die('File koneksi.php tidak ditemukan: ' . $conn_path);
}
require_once $conn_path;

// cek $conn terdefinisi dan valid
if (!isset($conn) || !($conn instanceof mysqli)) {
    die('Variabel $conn tidak tersedia. Pastikan koneksi.php mendefinisikan $conn sebagai objek mysqli.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4 text-center">Dashboard Produk</h2>
  <a href="tambah.php" class="btn btn-primary mb-3">Tambah Produk</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Deskripsi</th>
        <th>Gambar</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      try {
          $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
          while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
        <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
        <td>
          <?php if(!empty($row['gambar'])): ?>
            <img src="uploads/<?= rawurlencode($row['gambar']) ?>" width="80" alt="">
          <?php else: ?>
            -
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['kategori']) ?></td>
        <td>Rp <?= number_format($row['harga'],0,',','.') ?></td>
        <td><?= htmlspecialchars($row['stok']) ?></td>
        <td>
          <a href="form_edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="hapus.php?id=<?= (int)$row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
      <?php
          endwhile;
      } catch (Exception $e) {
          echo '<tr><td colspan="8">Error query: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>
</body>
</html>