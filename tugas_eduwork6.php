<?php
// Cek apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan bersihkan input
    $nama = trim($_POST['nama'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    // Validasi sederhana
    $errors = [];

    if (empty($nama)) {
        $errors[] = "Nama produk tidak boleh kosong.";
    }

    if (empty($harga)) {
        $errors[] = "Harga produk tidak boleh kosong.";
    } elseif (!is_numeric($harga)) {
        $errors[] = "Harga harus berupa angka.";
    }

    if (empty($deskripsi)) {
        $errors[] = "Deskripsi produk tidak boleh kosong.";
    }

    // Jika ada kesalahan, tampilkan
    if (!empty($errors)) {
        echo "<h3>Terjadi Kesalahan:</h3><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
    } else {
        // Simpan ke database (contoh koneksi dan query)
        $conn = new mysqli("localhost", "username", "password", "ecommerce");

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO product (nama_produk, harga, deskripsi, stok) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sds", $nama, $harga, $deskripsi);

        if ($stmt->execute()) {
            echo "<p>Produk berhasil ditambahkan.</p>";
        } else {
            echo "<p>Gagal menambahkan produk: " . $conn->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "<p>Akses tidak sah.</p>";
}
?>
