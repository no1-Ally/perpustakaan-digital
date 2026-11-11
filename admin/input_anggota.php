<h4>+ Tambah Data Anggota</h4>
<form method="POST" action="" class="mt-3">
    <div class="mb-2">
        <label>NIS</label>
        <input type="text" name="nis" class="form-control" placeholder="Masukan NIS" required>
    </div>
    <div class="mb-2">
        <label>Nama Anggota</label>
        <input type="text" name="nama_anggota" class="form-control" placeholder="Masukan Nama Anggota" required>
    </div>
    <div class="mb-2">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukan Username" required>
    </div>
    <div class="mb-2">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukan Password" required>
    </div>
    <div class="mb-2">
        <label>Kelas</label>
        <input type="text" name="kelas" class="form-control" placeholder="Masukan Kelas" required>
    </div>
    <button type="submit" name="tombol" class="btn btn-primary">Simpan</button>
</form>

<?php
if(isset($_POST['tombol'])){
    include '../koneksi.php';
    
    $nis          = $_POST['nis'];
    $nama_anggota = $_POST['nama_anggota'];
    $username     = $_POST['username'];
    $password     = $_POST['password'];
    $kelas        = $_POST['kelas'];
    
    // Pastikan urutan kolom database dan variabelnya cocok
    $query = "INSERT INTO anggota (nis, nama_anggota, username, password, kelas) VALUES ('$nis', '$nama_anggota', '$username', '$password', '$kelas')";
    $data  = mysqli_query($koneksi, $query);
    
    if($data){
        echo "<script>alert('Data Berhasil Disimpan'); window.location.assign('?halaman=data_anggota');</script>";
    } else {
        // Menampilkan pesan error asli dari MySQL jika query gagal
        echo "<script>alert('Data Gagal Disimpan: " . mysqli_error($koneksi) . "'); window.location.assign('?halaman=input_anggota');</script>";
    }
}
?>