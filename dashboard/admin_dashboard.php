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
    <title>Sistem Informasi Perpustakaan</title>
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
        <h1 class="text-center mb-5">Selamat Datang di Sistem Informasi Perpustakaan</h1>
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Manajemen Buku</h5>
                        <p class="card-text">Kelola data buku yang tersedia di perpustakaan.</p>
                        <a href="../tampilan/buku/daftar_buku.php" class="btn btn-primary rounded-pill shadow-sm">Lihat Daftar Buku</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Manajemen Anggota</h5>
                        <p class="card-text">Kelola data anggota yang ada di perpustakaan.</p>
                        <a href="../tampilan/anggota/daftar_anggota.php" class="btn btn-primary rounded-pill shadow-sm">Lihat Daftar Anggota</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Riwayat Transaksi</h5>
                        <p class="card-text">Lihat riwayat peminjaman dan pengembalian buku.</p>
                        <a href="../tampilan/transaksi/daftar_transaksi.php" class="btn btn-primary rounded-pill shadow-sm">Lihat Riwayat</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center mt-4">
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center">
                        <h5 class="card-title text-warning">Pengembalian Buku</h5>
                        <p class="card-text">Proses pengembalian buku oleh anggota.</p>
                        <a href="../tampilan/buku/pengembalian_buku.php" class="btn btn-warning rounded-pill shadow-sm">Pengembalian Buku</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center d-flex flex-column justify-content-between">
                        <h5 class="card-title mb-4 text-primary">Cetak Laporan</h5>
                        <p class="card-text mb-4">Cetak laporan untuk memantau data di perpustakaan.</p>
                        <div class="d-flex flex-column align-items-center">
                            <a href="../tampilan/buku/laporan_buku.php" target="_blank" class="btn btn-outline-primary mb-3 w-100 rounded-pill shadow-sm">Laporan Buku</a>
                            <a href="../tampilan/anggota/laporan_anggota.php" target="_blank" class="btn btn-outline-primary mb-3 w-100 rounded-pill shadow-sm">Laporan Anggota</a>
                            <a href="../tampilan/transaksi/laporan_transaksi.php" target="_blank" class="btn btn-outline-primary mb-3 w-100 rounded-pill shadow-sm">Laporan Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Peminjaman Buku</h5>
                        <p class="card-text">Proses peminjaman buku untuk anggota.</p>
                        <a href="../tampilan/buku/pinjam_buku.php" class="btn btn-success rounded-pill shadow-sm">Peminjaman Buku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3">
        <p class="mb-0">&copy; 2024 Sistem Informasi Perpustakaan</p>
    </footer>
</body>
</html>
