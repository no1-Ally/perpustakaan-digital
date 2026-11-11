<?php
include'../koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi,"DELETE FROM anggota WHERE id_anggota='$id'");
if($data){
    echo"<script>alert('Data Berhasil Dihapus'); window.location.assign('?halamman=data_anggota');</script>";
}else{
    echo"<script>alert('Data gagal Dihapus'); window.location.assign('?halamman=data_anggota');</script>";
}       
