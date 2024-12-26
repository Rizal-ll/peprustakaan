<!--
Rizal Azhari
XII RPL 1 
-->
<?php
$host = "localhost";
$dbname = "perpustakaan_";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: ".$e->getMessage());
    
}
?>