<?php
require_once __DIR__ . '/koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid!");
}

// ambil data produk
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Produk tidak ditemukan!");
}

// proses update
if (isset($_POST['update'])) {
    $nama_produk = trim($_POST['nama_produk']);
    $deskripsi   = trim($_POST['deskripsi']);
    $kategori    = trim($_POST['kategori']);
    $harga       = (float) $_POST['harga'];
    $stok        = (int) $_POST['stok'];
    $gambar      = $data['gambar']; // default gambar lama

    // cek upload baru
    if (!empty($_FILES['gambar']['name'])) {
        $filename  = time() . "_" . basename($_FILES['gambar']['name']);
        $targetDir = __DIR__ . "/uploads/";
        $targetFile = $targetDir . $filename;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            // hapus gambar lama kalau ada
            if (!empty($data['gambar']) && file_exists($targetDir . $data['gambar'])) {
                unlink($targetDir . $data['gambar']);
            }
            $gambar = $filename;
        }
    }

    $stmt = $conn->prepare("UPDATE products SET nama_produk=?, deskripsi=?, gambar=?, kategori=?, harga=?, stok=? WHERE id=?");
    $stmt->bind_param("ssssdii", $nama_produk, $deskripsi, $gambar, $kategori, $harga, $stok, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Edit Produk</h2>
  <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Gambar Produk</label><br>
      <?php if (!empty($data['gambar'])): ?>
        <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" width="120" class="mb-2">
      <?php endif; ?>
      <input type="file" name="gambar" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($data['kategori']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" step="0.01" class="form-control" value="<?= htmlspecialchars($data['harga']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Stok</label>
      <input type="number" name="stok" class="form-control" value="<?= htmlspecialchars($data['stok']) ?>">
    </div>
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>