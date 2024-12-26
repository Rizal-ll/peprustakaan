<?php
require '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_anggota = $_POST['id_anggota'];
    $nis_nip = $_POST['nis_nip'];
    $nama = $_POST['nama'];
    $kelas_unit = $_POST['kelas_unit'];
    $kontak = $_POST['kontak'];

    $sql = "UPDATE anggota SET nis_nip = :nis_nip, nama = :nama, kelas_unit = :kelas_unit, 
            kontak = :kontak WHERE id_anggota = :id_anggota";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nis_nip' => $nis_nip,
        ':nama' => $nama,
        ':kelas_unit' => $kelas_unit,
        ':kontak' => $kontak,
        ':id_anggota' => $id_anggota
    ]);

    header("Location: ../../tampilan/anggota/daftar_anggota.php");
    exit();
}
?>
