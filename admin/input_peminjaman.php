<?php
include'../koneksi.php';
$anggota = mysqli_query($koneksi,"SELECT*FROM anggota");
$buku = mysqli_query($koneksi,"SELECT*FROM buku WHERE status='tersedia'");
?>
<h4>+ Tambah Data Peminjaman</h4>
<form method="post" actions="#" class="mt-3">
    <select name="id_anggota" class="form-control mb-2" required>
        <option value=""> ===Pilih Anggota===</option>
        <?php
         foreach($anggota as $data){
            echo"<option value='$data[id_anggota]'>$data[nama_anggota]</option>";
         }
         ?>
    </select>
    <select name="id_buku" class="form-control mb-2" required>
        <option value=""> ===Pilih Buku===</option>
        <?php
         foreach($buku as $data){
            echo"<option value='$data[id_buku]'>$data[judul_buku]</option>";
         }
         ?>
    </select>
    <input type="datetime-local" name="tanggal_peminjaman" class="form-control mb-2" required>
    <button type="submit" name="tombol" class="btn btn-primary">Simpan</button>
</form>
<?php
if(isset($_POST['tombol'])){
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_peminjaman = $_POST['tanggal_peminjaman'];
    $status_transaksi = "Peminjaman";
    include'../koneksi.php';
    $query = "INSERT INTO transaksi(id_anggota, id_buku, tgl_pinjam, status_transaksi) VALUES('$id_anggota', '$id_buku', '$tanggal_peminjaman', '$status_transaksi')";
    $data = mysqli_query($koneksi, $query);
    if($data){
        mysqli_query($koneksi,"UPDATE buku SET status='tidak' WHERE id_buku='$id_buku'");
       echo"<script>alert('Data Berhasil Disimpan'); window.location.assign('?halaman=data_peminjaman');</script>";
    }else{
        echo"<script>alert('Data gagal Disimpan'); window.location.assign('?halaman=input_peminjaman');</script>";
    }
}