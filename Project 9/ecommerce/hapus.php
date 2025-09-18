<?php
require_once __DIR__ . 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid!");
}

// ambil data dulu (buat hapus gambar)
$stmt = $koneksi->prepare("SELECT gambar FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

// hapus dari DB
$stmt = $koneksi->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// hapus file gambar kalau ada
if ($data && !empty($data['gambar'])) {
    $filePath = __DIR__ . "/uploads/" . $data['gambar'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

header("Location: dashboard.php");
exit;
?>