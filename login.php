<!--
Rizal Azhari
XII RPL 1 
-->
<?php
session_start();
require 'config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = $pdo->prepare("SELECT * FROM pengguna WHERE username = :username");
    $query->execute([':username' => $username]);
    $user = $query->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['id_anggota'] = $user['id_anggota'];

        if ($user['role'] === 'siswa' || $user['role'] === 'guru') {
            $anggotaQuery = $pdo->prepare("SELECT id_anggota FROM anggota WHERE id_pengguna = :id_pengguna");
            $anggotaQuery->execute([':id_pengguna' => $user['id_pengguna']]);
            $anggota = $anggotaQuery->fetch();

            if ($anggota) {
                $_SESSION['id_anggota'] = $anggota['id_anggota'];
            } else {
                $error = "Data anggota tidak ditemukan.";
            }
        }

        if ($user['role'] === 'admin') {
            header("Location: dashboard/admin_dashboard.php");
            exit();
        } elseif ($user['role'] === 'siswa' || $user['role'] === 'guru') {
            header("Location: dashboard/anggota_dashboard.php");
            exit();
        }
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id_pengguna">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <h2 class="text-center mb-4">Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">
            Belum punya akun? <a href="tampilan/register.php">Daftar di sini</a>
        </p>
    </div>
</body>
</html>
