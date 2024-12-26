<?php
require '../config/koneksi.php';
session_start();

$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Register</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="../proses/register.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required placeholder="Masukkan password">
            </div>
            <div class="mb-3">
                <label for="nis_nip" class="form-label">NIS/NIP</label>
                <input type="text" class="form-control" name="nis_nip" required placeholder="Masukkan NIS/NIP">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" required placeholder="Masukkan nama lengkap">
            </div>
            <div class="mb-3">
                <label for="kelas_unit" class="form-label">Kelas/Unit</label>
                <input type="text" class="form-control" name="kelas_unit" required placeholder="Masukkan kelas/unit">
            </div>
            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" class="form-control" name="kontak" required placeholder="Masukkan kontak">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role (Siswa/Guru)</label>
                <select class="form-select" name="role" required>
                    <option value="siswa">Siswa</option>
                    <option value="guru">Guru</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
        </form>
        <p class="text-center mt-3">
            Sudah punya akun? <a href="../login.php">Login di sini</a>
        </p>
    </div>
</body>
</html>
