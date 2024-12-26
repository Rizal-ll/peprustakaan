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

$query = $pdo->query("SELECT * FROM buku");
$daftar_buku = $query->fetchAll(PDO::FETCH_ASSOC);

$html = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Buku</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid black; padding: 8px; }
        .table th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Daftar Buku</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
            </tr>
        </thead>
        <tbody>';

foreach ($daftar_buku as $index => $buku) {
    $html .= '
        <tr>
            <td>' . ($index + 1) . '</td>
            <td>' . htmlspecialchars($buku['judul']) . '</td>
            <td>' . htmlspecialchars($buku['pengarang']) . '</td>
            <td>' . htmlspecialchars($buku['penerbit']) . '</td>
            <td>' . htmlspecialchars($buku['tahun_terbit']) . '</td>
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
$dompdf->stream("laporan_daftar_buku.pdf", ["Attachment" => false]);
?>
