<?php
session_start();
include "../koneksi.php";

echo "<h1>Proses Pengecekan Debug...</h1>";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    echo "<p>Username yang dikirim: <b>$username</b></p>";
    echo "<p>Password yang dikirim: <b>$password</b></p>";

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    
    if ($query) {
        echo "<p>Query database berhasil dijalankan. Jumlah baris ditemukan: " . mysqli_num_rows($query) . "</p>";
        
        if (mysqli_num_rows($query) === 1) {
            $data = mysqli_fetch_assoc($query);
            echo "<p>Password di database: <b>" . $data['password'] . "</b></p>";

            if ($password === $data['password']) {
                echo "<p style='color: green; font-weight: bold;'>PASSWORD COCOK! Mencoba membuat session dan mengalihkan...</p>";
                
                $_SESSION['id_admin'] = $data['id_admin'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['nama_admin'] = $data['nama_admin'];

                // Test redirect manual via PHP
                header("Refresh: 3; URL=dashboard.php");
                echo "<p>Jika halaman tidak otomatis pindah dalam 3 detik, <a href='dashboard.php'>klik link ini untuk masuk ke dashboard</a>.</p>";
                exit();
            } else {
                echo "<p style='color: red;'>Password SALAH!</p>";
            }
        } else {
            echo "<p style='color: red;'>Username tidak ditemukan di database!</p>";
        }
    } else {
        echo "<p style='color: red;'>Query Error: " . mysqli_error($koneksi) . "</p>";
    }
} else {
    echo "<p style='color: red;'>Akses ditolak! Silakan login melalui form.</p>";
}
echo "<br><a href='login_admin.php'>Kembali ke Form Login</a>";
?>