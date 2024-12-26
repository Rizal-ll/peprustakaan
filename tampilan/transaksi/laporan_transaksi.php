<?php
require '../../config/koneksi.php';
require '../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$query = $pdo->query("SELECT t.id_transaksi, a.nama, b.judul, t.tanggal_pinjam, t.tanggal_kembali
                      FROM transaksi t
                      JOIN anggota a ON t.id_anggota = a.id_anggota
                      JOIN buku b ON t.id_buku = b.id_buku");
$daftar_transaksi = $query->fetchAll(PDO::FETCH_ASSOC);

$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 8px; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 style="text-align: center;">Laporan Transaksi Peminjaman/Pengembalian</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>';

foreach ($daftar_transaksi as $index => $transaksi) {
    $html .= '
                <tr>
                    <td>' . ($index + 1) . '</td>
                    <td>' . htmlspecialchars($transaksi['nama']) . '</td>
                    <td>' . htmlspecialchars($transaksi['judul']) . '</td>
                    <td>' . htmlspecialchars($transaksi['tanggal_pinjam']) . '</td>
                    <td>' . htmlspecialchars($transaksi['tanggal_kembali'] ?: 'Belum Kembali') . '</td>
                </tr>';
}

$html .= '
            </tbody>
        </table>
    </div>
</body>
</html>';

$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_transaksi.pdf", ["Attachment" => false]);
?>