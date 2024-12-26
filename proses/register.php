<?php
require '../config/koneksi.php';
session_start();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $nis_nip = $_POST['nis_nip'];
    $nama = $_POST['nama'];
    $kelas_unit = $_POST['kelas_unit'];
    $kontak = $_POST['kontak'];
    $role = $_POST['role'];

    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong.";
    } else {
        $stmt = $pdo->prepare("SELECT id_pengguna FROM pengguna WHERE username = :username");
        $stmt->execute([':username' => $username]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "Username sudah terdaftar.";
        }
    }

    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
    }

    if (empty($nis_nip)) {
        $errors[] = "NIS/NIP tidak boleh kosong.";
    } elseif (!is_numeric($nis_nip)) {
        $errors[] = "NIS/NIP harus berupa angka.";
    }

    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong.";
    }
    if (empty($kelas_unit)) {
        $errors[] = "Kelas/Unit tidak boleh kosong.";
    }
    if (empty($kontak)) {
        $errors[] = "Kontak tidak boleh kosong.";
    }

    if (empty($role)) {
        $errors[] = "Role tidak boleh kosong.";
    } elseif (!in_array($role, ['siswa', 'guru'])) {
        $errors[] = "Role tidak valid.";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: ../tampilan/register.php");
        exit;
    } else {
        try {
            $pdo->beginTransaction();
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $sqlUser = "INSERT INTO pengguna (username, password, role) VALUES (:username, :password, :role)";
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute([
                ':username' => $username,
                ':password' => $password_hashed,
                ':role' => $role
            ]);
            $id_pengguna = $pdo->lastInsertId();

            $sqlAnggota = "INSERT INTO anggota (id_pengguna, nis_nip, nama, kelas_unit, kontak) VALUES (:id_pengguna, :nis_nip, :nama, :kelas_unit, :kontak)";
            $stmtAnggota = $pdo->prepare($sqlAnggota);
            $stmtAnggota->execute([
                ':id_pengguna' => $id_pengguna,
                ':nis_nip' => $nis_nip,
                ':nama' => $nama,
                ':kelas_unit' => $kelas_unit,
                ':kontak' => $kontak
            ]);

            $pdo->commit();
            header("Location: ../login.php");
            exit();
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "Gagal melakukan registrasi: " . $e->getMessage();
        }
    }
}
?>
