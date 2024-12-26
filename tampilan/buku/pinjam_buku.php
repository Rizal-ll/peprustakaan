<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$role = $_SESSION['role'];
$id_anggota = $_SESSION['id_anggota'] ?? null;
$anggota = [];

if ($role === 'admin') {
    $anggota_stmt = $pdo->query("SELECT id_anggota, nama, nis_nip FROM anggota");
    $anggota = $anggota_stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($id_anggota) {
    $anggota_stmt = $pdo->prepare("SELECT id_anggota, nama, nis_nip FROM anggota WHERE id_anggota = :id_anggota");
    $anggota_stmt->execute([':id_anggota' => $id_anggota]);
    $anggota = $anggota_stmt->fetch(PDO::FETCH_ASSOC);
}

$buku_stmt = $pdo->query("SELECT id_buku, judul FROM buku WHERE stok > 0");
$buku = $buku_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Peminjaman Buku</h2>
        <form action="../../proses/buku/pinjam_buku.php" method="POST">
            <?php if ($role === 'admin'): ?>
                <div class="mb-3">
                    <label for="id_anggota" class="form-label">Pilih Anggota</label>
                    <select name="id_anggota" class="form-control" required>
                        <?php foreach ($anggota as $a): ?>
                            <option value="<?= $a['id_anggota']; ?>">
                                <?= htmlspecialchars($a['nis_nip'] . ' - ' . $a['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php else: ?>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($anggota['nama'] ?? 'Data tidak ditemukan'); ?>" disabled>
                    <input type="hidden" name="id_anggota" value="<?= $anggota['id_anggota'] ?? ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="nis_nip" class="form-label">NIS/NIP</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($anggota['nis_nip'] ?? 'Data tidak ditemukan'); ?>" disabled>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="id_buku" class="form-label">Pilih Buku</label>
                <select name="id_buku" class="form-control" required>
                    <?php foreach ($buku as $b): ?>
                        <option value="<?= $b['id_buku']; ?>">
                            <?= htmlspecialchars($b['judul']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" name="tanggal_pinjam" required>
            </div>
            <?php if ($_SESSION['role'] === 'siswa' || $_SESSION['role'] === 'guru'): ?>
                <a href="../../dashboard/anggota_dashboard.php" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Pinjam Buku</button>
            <?php endif; ?>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="../../dashboard/admin_dashboard.php" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Pinjam Buku</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
