<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$searchQuery = $_GET['q'] ?? ''; 
$filterTahun = $_GET['tahun'] ?? ''; 

$sql = "SELECT * FROM buku WHERE (judul LIKE :searchQuery OR pengarang LIKE :searchQuery)";
if (!empty($filterTahun)) {
    $sql .= " AND tahun_terbit = :tahun";
}

$stmt = $pdo->prepare($sql);
$params = [':searchQuery' => '%' . $searchQuery . '%'];
if (!empty($filterTahun)) {
    $params[':tahun'] = $filterTahun;
}
$stmt->execute($params);
$buku = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tahun_stmt = $pdo->query("SELECT DISTINCT tahun_terbit FROM buku ORDER BY tahun_terbit ASC");
$tahunList = $tahun_stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="text-center mb-4">Daftar Buku</h2>

                <form method="GET" action="daftar_buku.php" class="mb-3">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="q" class="form-label">Cari Buku</label>
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Cari judul atau pengarang..." value="<?= htmlspecialchars($searchQuery); ?>">
                                <button class="btn btn-outline-primary" type="submit">Cari</button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tahun" class="form-label">Filter Tahun Terbit</label>
                            <select name="tahun" class="form-select">
                                <option value="">Semua Tahun</option>
                                <?php foreach ($tahunList as $tahun): ?>
                                    <option value="<?= $tahun; ?>" <?= ($filterTahun == $tahun) ? 'selected' : ''; ?>><?= $tahun; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between mt-3 mb-3">
                    <a href="../../dashboard/<?php echo $_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'anggota_dashboard.php'; ?>" class="btn btn-secondary">Kembali</a>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="tambah_buku.php" class="btn btn-success">Tambah Buku</a>
                    <?php endif; ?>
                </div>

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>ISBN</th>
                            <th>Stok</th>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($buku) > 0): ?>
                            <?php foreach ($buku as $b): ?>
                                <tr>
                                    <td><?= $b['id_buku']; ?></td>
                                    <td><?= htmlspecialchars($b['judul']); ?></td>
                                    <td><?= htmlspecialchars($b['pengarang']); ?></td>
                                    <td><?= htmlspecialchars($b['penerbit']); ?></td>
                                    <td><?= $b['tahun_terbit']; ?></td>
                                    <td><?= htmlspecialchars($b['isbn']); ?></td>
                                    <td><?= $b['stok']; ?></td>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <td>
                                            <a href="edit_buku.php?id=<?= $b['id_buku']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="../../proses/buku/hapus_buku.php?id=<?= $b['id_buku']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?');">Hapus</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Buku tidak ditemukan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
