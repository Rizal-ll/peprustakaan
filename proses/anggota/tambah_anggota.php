<?php
require '../../config/koneksi.php';

// Fungsi validasi
function validate_input($data) {
    $errors = [];
    if (!preg_match('/^\d{4,12}$/', $data['nis_nip'])) {
        $errors[] = "NIS/NIP harus berupa angka dengan panjang antara 10 hingga 15 digit.";
    }
    if (empty($data['nama'])) {
        $errors[] = "Nama tidak boleh kosong.";
    }
    if (empty($data['kelas_unit'])) {
        $errors[] = "Kelas/Unit tidak boleh kosong.";
    }
    if (empty($data['kontak'])) {
        $errors[] = "Kontak tidak boleh kosong.";
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nis_nip' => trim($_POST['nis_nip']),
        'nama' => trim($_POST['nama']),
        'kelas_unit' => trim($_POST['kelas_unit']),
        'kontak' => trim($_POST['kontak']),
    ];

    $errors = validate_input($data);
    if (!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        header("Location: ../../tampilan/anggota/tambah_anggota.php");
        exit();
    }

    $sql = "INSERT INTO anggota (nis_nip, nama, kelas_unit, kontak)
            VALUES (:nis_nip, :nama, :kelas_unit, :kontak)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nis_nip' => $data['nis_nip'],
        ':nama' => $data['nama'],
        ':kelas_unit' => $data['kelas_unit'],
        ':kontak' => $data['kontak']
    ]);

    session_start();
    $_SESSION['success'] = "Anggota berhasil ditambahkan.";
    header("Location: ../../tampilan/anggota/daftar_anggota.php");
    exit();
}
?>
