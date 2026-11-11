<h4>+ Tambah Data Buku</h4>
<form method="post" action="" class="mt-3">
    <input type="text" name="judul_buku" class="form-control mb-2" placeholder="Masukan Judul Buku" required>
    <input type="text" name="pengarang" class="form-control mb-2" placeholder="Masukan pengarang" required>
    <input type="text" name="penerbit" class="form-control mb-2" placeholder="Masukan penerbit" required>
    <input maxlength="4" type="number" name="tahun_terbit" class="form-control mb-2" placeholder="Masukan Tahun Terbit" required>
    <button type="submit" name="tombol" class="btn btn-primary">Simpan</button>
</form>

<?php
if(isset($_POST['tombol'])){
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    
    include '../koneksi.php';
    
    $query = "INSERT INTO buku (judul_buku, pengarang, penerbit, tahun_terbit, status) VALUES ('$judul_buku', '$pengarang', '$penerbit', '$tahun_terbit', 'tersedia')";
    $data = mysqli_query($koneksi, $query);
    
    if($data){
        echo "<script>alert('Data Berhasil Disimpan'); window.location.assign('?halaman=data_buku');</script>";
    } else {
        echo "<script>alert('Data gagal Disimpan'); window.location.assign('?halaman=input_buku');</script>";
    }
}
?>