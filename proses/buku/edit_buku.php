<?php
require '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_buku = $_POST['id_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $isbn = $_POST['isbn'];
    $stok = $_POST['stok'];

    $sql = "UPDATE buku SET judul = :judul, pengarang = :pengarang, penerbit = :penerbit, 
            tahun_terbit = :tahun_terbit, isbn = :isbn, stok = :stok WHERE id_buku = :id_buku";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':judul' => $judul,
        ':pengarang' => $pengarang,
        ':penerbit' => $penerbit,
        ':tahun_terbit' => $tahun_terbit,
        ':isbn' => $isbn,
        ':stok' => $stok,
        ':id_buku' => $id_buku
    ]);

    header("Location: ../../tampilan/buku/daftar_buku.php");
    exit();
}
?>
