<?php
$host     = "localhost";
$user     = "root";     // ganti sesuai MySQL
$password = "Hdta4567wer19$";         // ganti kalau ada
$database = "toko"; // ganti sesuai nama DB

$conn = new mysqli($host, $user, $password, $database);

// cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>