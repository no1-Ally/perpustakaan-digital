<?php
include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'];
$tgl_pinjam = date('Y-m-d H:i:s');  
$query = "INSERT INTO transaksi (id_anggota, id_buku, tgl_pinjam, status_transaksi) VALUES ('".$_SESSION['id_anggota']."', '$id', '$tgl_pinjam', 'Peminjaman')";
$data = mysqli_query($koneksi, $query);
if ($data) {
        mysqli_query($koneksi, "UPDATE buku SET status='tidak' WHERE id_buku='$id'");
        echo "<script>alert('Buku sudah dipinjam'); window.location.assign('dashboard.php');</script>";
}