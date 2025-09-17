<?php
// Cek apakah form dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $harga = htmlspecialchars($_POST['harga']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);

    //Validasi sederhana
    if (empty($nama) || empty($harga)) {
        echo "Name and Harga are required fields.";
        exit;
    }

    // Tampilkan data yang diterima
    echo "<h2>Data yang Anda kirim:</h2>";
    echo "Nama: " . $nama . "<br>";
    echo "Harga: " . $harga;
    echo "Deskripsi: " . $deskripsi;
} else {
    echo "Akses tidak sah.";
}
?>
