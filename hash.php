<?php
include 'koneksi.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$query = $pdo->prepare("INSERT INTO pengguna (username, password, role) VALUES (?, ?, 'admin')");
$query->execute([$username, $password]);

echo "Admin berhasil ditambahkan.";
?>
