<?php
require '../../vendor/autoload.php'; 
require '../../config/koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

$query = $pdo->query("SELECT * FROM anggota");
$daftar_anggota = $query->fetchAll(PDO::FETCH_ASSOC);

$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Anggota</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 8px; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Daftar Anggota</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS/NIP</th>
                <th>Nama</th>
                <th>Kelas/Unit</th>
                <th>Kontak</th>
            </tr>
        </thead>
        <tbody>';

foreach ($daftar_anggota as $index => $anggota) {
    $html .= '
        <tr>
            <td>' . ($index + 1) . '</td>
            <td>' . htmlspecialchars($anggota['nis_nip']) . '</td>
            <td>' . htmlspecialchars($anggota['nama']) . '</td>
            <td>' . htmlspecialchars($anggota['kelas_unit']) . '</td>
            <td>' . htmlspecialchars($anggota['kontak']) . '</td>
        </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_daftar_anggota.pdf", ["Attachment" => false]);
?>