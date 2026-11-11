<?php
include'../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi,"DELETE FROM buku WHERE id_buku='$id'");
if($data){
    echo"<script>alert('Data Berhasil Dihapus'); window.location.assign('?halamman=data_buku');</script>";
}else{
    echo"<script>alert('Data gagal Dihapus'); window.location.assign('?halamman=data_buku');</script>";
}       
