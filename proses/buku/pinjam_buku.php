<?php
require '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];

    $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' + 7 days'));

    $stok_stmt = $pdo->prepare("SELECT stok FROM buku WHERE id_buku = :id_buku");
    $stok_stmt->execute([':id_buku' => $id_buku]);
    $stok_buku = $stok_stmt->fetchColumn();

    if ($stok_buku > 0) {
        $sql = "INSERT INTO transaksi (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali) 
                VALUES (:id_anggota, :id_buku, :tanggal_pinjam, :tanggal_kembali)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_anggota' => $id_anggota,
            ':id_buku' => $id_buku,
            ':tanggal_pinjam' => $tanggal_pinjam,
            ':tanggal_kembali' => $tanggal_kembali
        ]);
        $pdo->query("UPDATE buku SET stok = stok - 1 WHERE id_buku = $id_buku");

        header("Location: ../../tampilan/transaksi/daftar_transaksi.php");
        exit();
    } else {
        echo "Stok buku tidak mencukupi.";
    }
}
?>
