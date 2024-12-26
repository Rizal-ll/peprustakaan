<!--
Rizal Azhari
XII RPL 1 
-->
<?php
require '../config/koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Perpustakaan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-lg text-white" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5 flex-grow-1">
        <h1 class="text-center mb-5">Halaman Anggota/Pengunjung Perpustakaan</h1>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Daftar Buku</h5>
                        <p class="card-text">Lihat dan cari buku yang tersedia di perpustakaan.</p>
                        <a href="../tampilan/buku/daftar_buku.php" class="btn btn-primary">Lihat Buku</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pinjam Buku</h5>
                        <p class="card-text">Proses peminjaman buku.</p>
                        <a href="../tampilan/buku/pinjam_buku.php" class="btn btn-success">Pinjam Buku</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Pengembalian Buku</h5>
                        <p class="card-text">Kembalikan buku yang telah dipinjam.</p>
                        <a href="../tampilan/buku/pengembalian_buku.php" class="btn btn-warning">Kembalikan Buku</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4"></div>

            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">Riwayat Peminjaman</h5>
                        <p class="card-text">Lihat riwayat peminjaman dan pengembalian.</p>
                        <a href="../tampilan/transaksi/daftar_transaksi.php" class="btn btn-info">Lihat Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3">
    <p class="mb-0">&copy; 2024 Sistem Informasi Perpustakaan</p>
    <p class="mb-0">Dibuat oleh: Nama Pembuat</p>
</footer>

</body>
</html>
