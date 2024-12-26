<?php
require '../../config/koneksi.php';

$id_transaksi = $_GET['id'];
$sql = "DELETE FROM transaksi WHERE id_transaksi = :id_transaksi";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_transaksi' => $id_transaksi]);

header("Location: ../../tampilan/transaksi/daftar_transaksi.php");
exit();
?>
