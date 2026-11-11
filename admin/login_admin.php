<?php
session_start();
include "../koneksi.php";

$error = "";

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Ambil data admin dari database
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");

    if ($query && mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        
        // Verifikasi password
        if ($password === $data['password']) {
            // Set session login dengan benar
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama_admin'] = $data['nama_admin'];

            // PENTING: Gunakan JavaScript redirect agar browser langsung pindah tanpa terhalang header buffer
            echo "<script>
                alert('Login Berhasil! Selamat datang, " . $data['nama_admin'] . "');
                window.location.href = 'dashboard.php';
            </script>";
            exit();
        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Username tidak ditemukan di database!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Perpustakaan Sekolah Digital</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center mb-3">Login Admin</h3>
        
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?= $error; ?>
            </div>
        <?php } ?>

        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-success w-100">Masuk</button>
        </form>
    </div>
</body>
</html>