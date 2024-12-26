<?php
require '../koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$searchQuery = $_GET['q'] ?? ''; 
$filterTahun = $_GET['tahun'] ?? ''; 
$role = $_SESSION['role'];
$id_user = $_SESSION['id_anggota']; // Pastikan id_anggota disimpan dalam session

$sql = "SELECT * FROM transaksi 
        INNER JOIN anggota ON transaksi.id_anggota = anggota.id_anggota
        INNER JOIN buku ON transaksi.id_buku = buku.id_buku
        WHERE (buku.judul LIKE :searchQuery OR anggota.nama LIKE :searchQuery)";

// Jika siswa atau guru, batasi hanya riwayat mereka sendiri
if ($role === 'siswa' || $role === 'guru') {
    $sql .= " AND transaksi.id_anggota = :id_user";
}

if (!empty($filterTahun)) {
    $sql .= " AND transaksi.tanggal_pinjam LIKE :filterTahun";
}

$stmt = $pdo->prepare($sql);

$params = [':searchQuery' => '%' . $searchQuery . '%'];
if ($role === 'siswa' || $role === 'guru') {
    $params[':id_user'] = $id_user;
}
if (!empty($filterTahun)) {
    $params[':filterTahun'] = '%' . $filterTahun . '%';  // Format: YYYY-MM untuk pencarian tahun
}

$stmt->execute($params);
$transaksi = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar tahun untuk filter
$tahun_stmt = $pdo->query("SELECT DISTINCT YEAR(tanggal_pinjam) AS tahun FROM transaksi ORDER BY tahun ASC");
$tahunList = $tahun_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center mb-4">Daftar Transaksi</h2>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="card-title">Pencarian & Filter</h5>
            <form method="GET" action="daftar_transaksi.php">
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="q" class="form-label">Cari Buku atau Anggota</label>
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari judul buku atau nama anggota..." value="<?= htmlspecialchars($searchQuery); ?>">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="tahun" class="form-label">Filter Tahun Pinjam</label>
                        <select name="tahun" class="form-select" id="tahun">
                            <option value="">Semua Tahun</option>
                            <?php foreach ($tahunList as $tahun): ?>
                                <option value="<?= $tahun; ?>" <?= ($filterTahun == $tahun) ? 'selected' : ''; ?> >
                                    <?= $tahun; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'siswa' || $_SESSION['role'] === 'guru')): ?>
                <a href="../anggota_dashboard.php" class="btn btn-secondary">Kembali</a>
            <?php endif; ?>
            
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="../admin_dashboard.php" class="btn btn-secondary">Kembali</a>
            <?php endif; ?>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (count($transaksi) > 0): ?>
                    <?php foreach ($transaksi as $t): ?>
                        <tr>
                            <td><?= $t['id_transaksi']; ?></td>
                            <td><?= htmlspecialchars($t['nama']); ?></td>
                            <td><?= htmlspecialchars($t['judul']); ?></td>
                            <td><?= $t['tanggal_pinjam']; ?></td>
                            <td><?= $t['tanggal_kembali']; ?></td>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <td>
                                    <a href="../proses/hapus_transaksi.php?id=<?= $t['id_transaksi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?');">Hapus</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Transaksi tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap Icon -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>
</html>
