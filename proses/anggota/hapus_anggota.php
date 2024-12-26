<?php
require '../../config/koneksi.php';

$id_anggota = $_GET['id'];
$sql = "DELETE FROM anggota WHERE id_anggota = :id_anggota";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_anggota' => $id_anggota]);

header("Location: ../../tampilan/anggota/daftar_anggota.php");
exit();
?>
