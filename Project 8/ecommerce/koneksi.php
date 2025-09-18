<?php
// Konfigurasi Database
$host = 'localhost'; // Host database
$user = 'root'; // Username database
$password = 'Hdta4567wer19$'; // Password database
$dbname = 'toko'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

//Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    echo "Koneksi berhasil";
}
?>