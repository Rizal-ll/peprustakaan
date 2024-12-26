<?php
require '../../config/koneksi.php';
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$id_anggota = $_GET['id'];
$sql = "SELECT * FROM anggota WHERE id_anggota = :id_anggota";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_anggota' => $id_anggota]);
$anggota = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anggota) {
    die("Anggota tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Anggota</h2>
        <form action="../../proses/anggota/edit_anggota.php" method="POST">
            <input type="hidden" name="id_anggota" value="<?= $anggota['id_anggota']; ?>">
            <div class="mb-3">
                <label for="nis_nip" class="form-label">NIS/NIP</label>
                <input type="text" class="form-control" name="nis_nip" value="<?= htmlspecialchars($anggota['nis_nip']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($anggota['nama']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelas_unit" class="form-label">Kelas/Unit</label>
                <input type="text" class="form-control" name="kelas_unit" value="<?= htmlspecialchars($anggota['kelas_unit']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" class="form-control" name="kontak" value="<?= htmlspecialchars($anggota['kontak']); ?>" required>
            </div>
            <a href="daftar_anggota.php" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
