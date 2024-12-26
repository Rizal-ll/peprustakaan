<?php
require '../../config/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['login'])) {
        header("Location: ../../login.php");
        exit;
    }

    $id_transaksi = $_POST['id_transaksi'];
    $tanggal_sekarang = date('Y-m-d');
    $role = $_SESSION['role'];
    $id_user = $_SESSION['id_anggota'];

    if (empty($id_transaksi) || !is_numeric($id_transaksi)) {
        echo "ID Transaksi tidak valid.";
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT id_buku, tanggal_kembali, id_anggota 
        FROM transaksi 
        WHERE id_transaksi = :id_transaksi
    ");
    $stmt->execute([':id_transaksi' => $id_transaksi]);
    $transaksi = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$transaksi) {
        echo "Transaksi tidak ditemukan.";
        exit;
    }

    if ($role !== 'admin' && $transaksi['id_anggota'] != $id_user) {
        echo "Anda tidak berhak mengembalikan transaksi ini.";
        exit;
    }

    $id_buku = $transaksi['id_buku'];
    $tanggal_kembali = $transaksi['tanggal_kembali'];
    $denda = 0;

    if ($tanggal_kembali && $tanggal_sekarang > $tanggal_kembali) {
        $selisih_hari = (strtotime($tanggal_sekarang) - strtotime($tanggal_kembali)) / (60 * 60 * 24);
        $denda = $selisih_hari * 1000;
    }

    $pdo->prepare("UPDATE transaksi SET tanggal_kembali = :tanggal_kembali, denda = :denda WHERE id_transaksi = :id_transaksi")
        ->execute([
            ':tanggal_kembali' => $tanggal_sekarang,
            ':denda' => $denda,
            ':id_transaksi' => $id_transaksi
        ]);

    $pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id_buku = :id_buku")
        ->execute([':id_buku' => $id_buku]);

    $_SESSION['message'] = "Pengembalian berhasil! Anda dikenakan denda sebesar Rp" . number_format($denda);
    header("Location: ../../tampilan/transaksi/daftar_transaksi.php");
    exit();
}
?>
