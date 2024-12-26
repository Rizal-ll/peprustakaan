<?php
require '../../config/koneksi.php';

$id_buku = $_GET['id'];
$sql = "DELETE FROM buku WHERE id_buku = :id_buku";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_buku' => $id_buku]);

header("Location: ../../tampilan/buku/daftar_buku.php");
exit();
?>
