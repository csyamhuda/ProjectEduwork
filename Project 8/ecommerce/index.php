<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toko Madura Online Sederhana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <!-- Filter Kategori -->
  <form method="GET" class="mb-4 text-center">
    <label for="kategori" class="form-label">Filter berdasarkan kategori:</label>
    <select name="kategori" id="kategori" class="form-select w-auto d-inline-block">
      <option value="">Semua</option>
      <?php
      // ambil kategori unik dari database
      $katQuery = "SELECT DISTINCT kategori FROM products";
      $katResult = $conn->query($katQuery);
      if ($katResult && $katResult->num_rows > 0) {
          while($kat = $katResult->fetch_assoc()) {
              $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $kat['kategori']) ? 'selected' : '';
              echo '<option value="' . htmlspecialchars($kat['kategori']) . '" ' . $selected . '>' . htmlspecialchars($kat['kategori']) . '</option>';
          }
      }
      ?>
    </select>
    <button type="submit" class="btn btn-primary">Filter</button>
  </form>
   <div class="row g-4">
    <?php
    // filter produk jika kategori dipilih
    $where = "";
    if (!empty($_GET['kategori'])) {
        $kategori = $conn->real_escape_string($_GET['kategori']);
        $where = "WHERE kategori = '$kategori'";
    }

    $sql = "SELECT * FROM products $where";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '
            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="' . htmlspecialchars($row['gambar']) . '" class="card-img-top" alt="' . htmlspecialchars($row['nama_produk']) . '">
                <div class="card-body">
                  <h5 class="card-title">' . htmlspecialchars($row['nama_produk']) . '</h5>
                  <p class="card-text">' . htmlspecialchars($row['deskripsi']) . '</p>
                  <p class="fw-bold text-primary">Rp ' . number_format($row['harga'],0,",",".") . '</p>
                  <p><span class="badge bg-secondary">' . htmlspecialchars($row['kategori']) . '</span></p>
                  <a href="#" class="btn btn-success w-100">Beli Sekarang</a>
                </div>
              </div>
            </div>
            ';
        }
    } else {
        echo "<p class='text-center'>Produk tidak ditemukan.</p>";
    }
    ?>
  </div>
</div>

  <h1 class="text-center mb-4">Produk Kami</h1>
  <div class="row g-4">
    <?php
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '
            <div class="col-md-4">
              <div class="card h-100 shadow-sm">
                <img src="' .htmlspecialchars($row['gambar']) .'" class="card-img-top" alt="'.$row['nama_produk'].'">
                <div class="card-body">
                  <h5 class="card-title">'.htmlspecialchars($row['nama_produk']).'</h5>
                  <p class="card-text">'.htmlspecialchars($row['deskripsi']).'</p>
                  <p class="fw-bold text-primary">Rp '.number_format($row['harga'],0,",",".").'</p>
                  <a href="#" class="btn btn-success w-100">Beli Sekarang</a>
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

</body>
</html>