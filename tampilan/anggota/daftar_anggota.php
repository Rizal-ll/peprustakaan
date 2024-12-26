<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini hanya untuk admin.');</script>";
    echo "<script>window.location.href = '../dashboard/anggota_dashboard.php';</script>";
    exit;
}

$searchQuery = $_GET['q'] ?? '';
$filterKelas = $_GET['kelas'] ?? ''; 

$sql = "SELECT * FROM anggota WHERE (nama LIKE :searchQuery OR nis_nip LIKE :searchQuery)";
if (!empty($filterKelas)) {
    $sql .= " AND kelas_unit = :kelas";
}

$stmt = $pdo->prepare($sql);
$params = [':searchQuery' => '%' . $searchQuery . '%'];
if (!empty($filterKelas)) {
    $params[':kelas'] = $filterKelas;
}
$stmt->execute($params);
$anggota = $stmt->fetchAll(PDO::FETCH_ASSOC);

$kelas_stmt = $pdo->query("SELECT DISTINCT kelas_unit FROM anggota ORDER BY kelas_unit ASC");
$kelasList = $kelas_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Anggota</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center mb-4">Daftar Anggota</h2>

                <form method="GET" action="daftar_anggota.php" class="mb-3">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="q" class="form-label">Cari Anggota</label>
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Cari nama atau NIS/NIP..." value="<?= htmlspecialchars($searchQuery); ?>">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="kelas" class="form-label">Filter Kelas/Unit</label>
                            <select name="kelas" class="form-select">
                                <option value="">Semua Kelas/Unit</option>
                                <?php foreach ($kelasList as $kelas): ?>
                                    <option value="<?= $kelas; ?>" <?= ($filterKelas == $kelas) ? 'selected' : ''; ?>><?= $kelas; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between mt-3 mb-3">
                    <a href="../../dashboard/admin_dashboard.php" class="btn btn-secondary">Kembali</a>
                    <a href="tambah_anggota.php" class="btn btn-success">Tambah Anggota</a>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>NIS/NIP</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas/Unit</th>
                            <th>Kontak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($anggota) > 0): ?>
                            <?php foreach ($anggota as $b): ?>
                                <tr>
                                    <td><?= $b['id_anggota']; ?></td>
                                    <td><?= htmlspecialchars($b['nis_nip']); ?></td>
                                    <td><?= htmlspecialchars($b['nama']); ?></td>
                                    <td><?= htmlspecialchars($b['kelas_unit']); ?></td>
                                    <td><?= htmlspecialchars($b['kontak']); ?></td>
                                    <td>
                                        <a href="edit_anggota.php?id=<?= $b['id_anggota']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="../../proses/anggota/hapus_anggota.php?id=<?= $b['id_anggota']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Anggota tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>