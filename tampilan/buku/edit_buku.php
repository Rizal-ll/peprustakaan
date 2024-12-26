<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$id_buku = $_GET['id'];
$sql = "SELECT * FROM buku WHERE id_buku = :id_buku";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_buku' => $id_buku]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    die("Buku tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Buku</h2>
        <form action="../../proses/buku/edit_buku.php" method="POST">
            <input type="hidden" name="id_buku" value="<?= $buku['id_buku']; ?>">
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($buku['judul']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="pengarang" class="form-label">Pengarang</label>
                <input type="text" class="form-control" name="pengarang" value="<?= htmlspecialchars($buku['pengarang']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" name="penerbit" value="<?= htmlspecialchars($buku['penerbit']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" class="form-control" name="tahun_terbit" value="<?= $buku['tahun_terbit']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="isbn" value="<?= htmlspecialchars($buku['isbn']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stok" value="<?= $buku['stok']; ?>" required>
            </div>
            <a href="daftar_buku.php" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
