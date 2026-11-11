<?php
// Cek apakah tombol daftar/submit ditekan
if(isset($_POST['tombol'])){
    // Mundur satu folder keluar dari 'anggota' untuk mencari koneksi.php
    include '../koneksi.php';
    
    $nis          = $_POST['nis'];
    $nama_anggota = $_POST['nama_anggota'];
    $username     = $_POST['username'];
    $password     = $_POST['password'];
    $kelas        = $_POST['kelas'];
    
    // Query untuk menyimpan data ke tabel anggota
    $query = "INSERT INTO anggota (nis, nama_anggota, username, password, kelas) VALUES ('$nis', '$nama_anggota', '$username', '$password', '$kelas')";
    $simpan = mysqli_query($koneksi, $query);
    
    if($simpan){
        echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location.assign('login_anggota.php');</script>";
    } else {
        echo "<script>alert('Pendaftaran Gagal!'); window.location.assign('pendaftaran_anggota.php');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Anggota - Aplikasi Perpustakaan Sekolah Digital</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="vh-100 row justify-content-center align-items-center m-0">
        <form method="post" action="" class="col-md-3 border p-4 bg-white rounded-4 shadow-sm">
            <h4 class="text-center">Pendaftaran Anggota</h4>
            <h5 class="text-center mb-3 text-muted fs-6">Aplikasi Perpustakaan Sekolah Digital</h5>
            
            <input type="text" name="nis" class="form-control mb-3" placeholder="Masukan NIS" required>
            <input type="text" name="nama_anggota" class="form-control mb-3" placeholder="Masukan Nama Anggota" required>
            <input type="text" name="username" class="form-control mb-3" placeholder="Masukan Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Masukan Password" required>
            <input type="text" name="kelas" class="form-control mb-3" placeholder="Masukan Kelas" required>

            <button type="submit" name="tombol" class="btn btn-success w-100">Daftar</button>
            <a href="login_anggota.php" class="d-block text-center text-decoration-none mt-3">Sudah punya akun? Login Di sini</a>
        </form>
    </div>
</body>
</html>