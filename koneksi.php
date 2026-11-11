<?php
$server   = "localhost";
$pengguna = "root";
$password = "";
$db_nama  = "perpustakaan1";
$port     = 3306; // Ubah ke 3307 jika kamu mengubah port di my.ini

// 1. Koneksi ke Server MySQL
$koneksi = mysqli_connect($server, $pengguna, $password, "", $port);

if (!$koneksi) {
    die("Koneksi ke server MySQL gagal. Pastikan MySQL di XAMPP sudah di-START! <br>Detail: " . mysqli_connect_error());
}

// 2. Buat database jika belum ada
$sql = "CREATE DATABASE IF NOT EXISTS `$db_nama`";
if (mysqli_query($koneksi, $sql)) {
    // 3. Pilih database
    mysqli_select_db($koneksi, $db_nama);
} else {
    die("Gagal membuat atau memilih database: " . mysqli_error($koneksi));
}
?>