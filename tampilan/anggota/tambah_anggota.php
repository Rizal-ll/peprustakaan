<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Anggota</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="../../proses/anggota/tambah_anggota.php" method="POST">
            <div class="mb-3">
                <label for="nis_nip" class="form-label">NIS/NIP</label>
                <input type="text" class="form-control" name="nis_nip">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama">
            </div>
            <div class="mb-3">
                <label for="kelas_unit" class="form-label">Kelas/Unit</label>
                <input type="text" class="form-control" name="kelas_unit">
            </div>
            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" class="form-control" name="kontak">
            </div>
            <a href="daftar_anggota.php" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary">Tambah Anggota</button>
        </form>
    </div>
</body>
</html>
