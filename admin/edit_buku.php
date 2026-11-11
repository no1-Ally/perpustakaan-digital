<?php
include'../koneksi.php';
$id = $_GET['id'];
$query_buku = mysqli_query($koneksi,"SELECT*FROM buku WHERE id_buku='$id'");
$data_buku  = mysqli_fetch_array($query_buku);
?>
<h4>⚙️ Edit Data Buku</h4>
<form method="post" actions="#" class="mt-3">
    <input value="<?= $data_buku ['judul_buku'] ?>" type="text" name="judul_buku" class="form-control mb-2" placeholder="Masukan Judul Buku" required>
    <input value="<?= $data_buku ['pengarang'] ?>" type="text" name="pengarang" class="form-control mb-2" placeholder="Masukan pengarang" required>
    <input value="<?= $data_buku ['penerbit'] ?>" type="text" name="penerbit" class="form-control mb-2" placeholder="Masukan penerbit" required>
    <input value="<?= $data_buku ['tahun_terbit'] ?>" maxlength="4" type="number" name="tahun_terbit" class="form-control mb-2" placeholder="Masukan Masukan Tahun Terbit" required>
    <button type="submit" name="tombol" class="btn btn-primary">Simpan</button>
</form>
<?php
if(isset($_POST['tombol'])){
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    include'../koneksi.php';
    $query = "UPDATE buku SET judul_buku='$judul_buku',pengarang='$pengarang',penerbit='$penerbit',tahun_terbit='$tahun_terbit' WHERE id_buku='$id'";
    if($data){
        echo"<script>alert('Data Berhasil Disimpan'); window.location.assign('?halamman=data_buku');</script>";
    }else{
        echo"<script>alert('Data gagal Disimpan'); window.location.assign('?halamman=input_buku');</script>";
    }
}