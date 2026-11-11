<?php
$id = $_GET['id'];
$buku = $_GET['buku'];

include '../koneksi.php';

// Eksekusi query hapus
$data = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi='$id'");

if($data) {
    mysqli_query($koneksi, "UPDATE buku SET status='tersedia' WHERE id_buku='$buku'");
    echo "<script>alert('Data peminjaman berhasil dihapus'); window.location.assign('?halaman=data_peminjaman');</script>";
} else {
    echo "<script>alert('Data gagal dihapus: " . mysqli_error($koneksi) . "'); window.location.assign('?halaman=data_peminjaman');</script>";
}
?>