<?php
include '../koneksi.php';
date_default_timezone_set('Asia/Jakarta');
$id = $_GET['id'];
$tgl_kembali = date('Y-m-d H:i:s');
$buku = $_GET['buku'];
$query = "UPDATE transaksi SET tgl_kembali = '$tgl_kembali',status_transaksi='Pengembalian' WHERE ID_transaksi='$id'";
$data = mysqli_query($koneksi, $query);
if ($data) {
        mysqli_query($koneksi, "UPDATE buku SET status='tersedia' WHERE id_buku='$buku'");
        echo "<script>alert('Buku berhasil dikembalikan '); window.location.assign('history.php');</script>";
}