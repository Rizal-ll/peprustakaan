<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$role = $_SESSION['role'];
$id_user = $_SESSION['id_anggota'];

try {
    if ($role === 'admin') {
        $transaksi_stmt = $pdo->query("
            SELECT t.id_transaksi, a.nama, b.judul, t.tanggal_kembali 
            FROM transaksi t 
            JOIN anggota a ON t.id_anggota = a.id_anggota 
            JOIN buku b ON t.id_buku = b.id_buku 
            WHERE t.tanggal_kembali IS NULL
            OR t.tanggal_kembali > CURDATE()
        ");
    } else {
        $transaksi_stmt = $pdo->prepare("
            SELECT t.id_transaksi, a.nama, b.judul, t.tanggal_kembali 
            FROM transaksi t 
            JOIN anggota a ON t.id_anggota = a.id_anggota 
            JOIN buku b ON t.id_buku = b.id_buku 
            WHERE (t.tanggal_kembali IS NULL OR t.tanggal_kembali > CURDATE())
            AND t.id_anggota = :id_user
        ");
        $transaksi_stmt->execute([':id_user' => $id_user]);
    }

    $transaksi = $transaksi_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Pengembalian Buku</h2>
        <form action="../../proses/buku/pengembalian_buku.php" method="POST">
            <div class="mb-3">
                <label for="id_transaksi" class="form-label">Pilih Transaksi</label>
                <select name="id_transaksi" class="form-control" required>
                    <?php foreach ($transaksi as $t): ?>
                        <option value="<?= $t['id_transaksi']; ?>">
                            <?= htmlspecialchars(
                                $t['nama'] . ' - ' . $t['judul'] . ' (Batas: ' . $t['tanggal_kembali'] . ')'
                            ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <a href="<?= ($role === 'admin') ? '../../dashboard/admin_dashboard.php' : '../../dashboard/anggota_dashboard.php'; ?>" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary">Kembalikan Buku</button>
        </form>
    </div>
</body>
</html>
