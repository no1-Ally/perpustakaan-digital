<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: login_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin | Aplikasi Perpustakaan Sekolah Digital</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-3 mb-3">
        <h4>Halaman Admin | Aplikasi Perpustakaan Sekolah Digital</h4>
<a href="dashboard.php" class="btn btn-success text-white">Dashboard</a>
        <a href="dashboard.php?halaman=data_buku" class="btn btn-success text-white">Buku</a>
        <a href="dashboard.php?halaman=data_anggota" class="btn btn-success text-white">Anggota</a>
        <a href="dashboard.php?halaman=data_peminjaman" class="btn btn-success text-white">Peminjaman</a>
        <a href="logout.php" class="btn btn-danger text-white">Logout</a>
        
        <div class="card p-3 mt-3">
            <?php
            $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : "";
            
            if (!empty($halaman) && file_exists($halaman . ".php")) {
                include $halaman . ".php";
            } else { 
            ?>
                <h4>Selamat Datang <?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?> 👋</h4>
                <p class="text-justify text-muted">
                    Aplikasi Perpustakaan Sekolah Digital merupakan sistem berbasis website yang dirancang untuk membantu pengelola data buku, data anggota, dan data peminjaman secara terorganisir dan cepat.
                </p>
            <?php } ?>
        </div>
    </div>
</body>
</html>