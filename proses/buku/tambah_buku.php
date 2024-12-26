<?php
require '../../config/koneksi.php';
session_start();

function validate_input($data) {
    $errors = [];
    if (empty($data['judul'])) {
        $errors[] = "Judul buku tidak boleh kosong.";
    }
    if (empty($data['pengarang'])) {
        $errors[] = "Pengarang tidak boleh kosong.";
    }
    if (empty($data['penerbit'])) {
        $errors[] = "Penerbit tidak boleh kosong.";
    }
    if (!is_numeric($data['tahun_terbit']) || $data['tahun_terbit'] < 1000 || $data['tahun_terbit'] > date('Y')) {
        $errors[] = "Tahun terbit harus berupa angka antara 1000 dan " . date('Y') . ".";
    }
    if (!preg_match('/^\d{10}(\d{3})?$/', $data['isbn'])) {
        $errors[] = "ISBN harus berupa 10 atau 13 angka.";
    }
    if (!is_numeric($data['stok']) || $data['stok'] < 1) {
        $errors[] = "Stok harus lebih dari 0.";
    }
    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'judul' => trim($_POST['judul']),
        'pengarang' => trim($_POST['pengarang']),
        'penerbit' => trim($_POST['penerbit']),
        'tahun_terbit' => trim($_POST['tahun_terbit']),
        'isbn' => trim($_POST['isbn']),
        'stok' => trim($_POST['stok']),
    ];

    $errors = validate_input($data);
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../../tampilan/buku/tambah_buku.php");
        exit;
    }

    $query = $pdo->prepare("INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, stok) 
                            VALUES (:judul, :pengarang, :penerbit, :tahun_terbit, :isbn, :stok)");
    $query->execute([
        ':judul' => $data['judul'],
        ':pengarang' => $data['pengarang'],
        ':penerbit' => $data['penerbit'],
        ':tahun_terbit' => $data['tahun_terbit'],
        ':isbn' => $data['isbn'],
        ':stok' => $data['stok'],
    ]);

    $_SESSION['success'] = "Buku berhasil ditambahkan.";
    header("Location: ../../tampilan/buku/daftar_buku.php");
    exit;
}
?>
