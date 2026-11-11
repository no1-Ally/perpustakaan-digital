<?php
session_start();

$error = "";

if(isset($_POST['tombol_login'])){
    include '../koneksi.php';
    
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    
    // Cek data ke tabel anggota
    $query = "SELECT * FROM anggota WHERE username='$username' AND password='$password'";
    $data = mysqli_query($koneksi, $query);
    
    if($data && mysqli_num_rows($data) > 0){
        $row = mysqli_fetch_array($data);
        $_SESSION['id_anggota']   = $row['id_anggota'];
        $_SESSION['username']     = $row['username'];
        $_SESSION['nama_anggota'] = $row['nama_anggota'];
        
        // Berhasil login, arahkan ke dashboard anggota
        // Ubah dari 'dashboard_anggota.php' menjadi 'dashboard.php'
        echo "<script>alert('Login Berhasil!'); window.location.assign('dashboard.php');</script>";
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Anggota - Aplikasi Perpustakaan Sekolah Digital</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="vh-100 row justify-content-center align-items-center m-0">
        <form method="post" action="" class="col-md-3 border p-4 bg-white rounded-4 shadow-sm">
            <h4 class="text-center">Login Anggota</h4>
            <h5 class="text-center mb-3 text-muted fs-6">Aplikasi Perpustakaan Sekolah Digital</h5>
            
            <?php if($error != ""): ?>
                <div class="alert alert-danger py-2 text-center" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <input type="text" name="username" class="form-control mb-3" placeholder="Masukan Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Masukan Password" required>
 
           <button type="submit" name="tombol_login" class="btn btn-success w-100 mb-3">Login</button>
            
            <div class="text-center">
                <a href="pendaftaran_anggota.php" class="text-decoration-none">Belum punya akun? Daftar di sini</a>
            </div>
        </form>
    </div>
</body>
</html>