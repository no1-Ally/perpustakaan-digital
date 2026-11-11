<h4>Data Anggota</h4>
<a href="?halaman=input_anggota" class="btn btn-secondary mb-3">
    + Tambah Data Anggota
</a>
<table class="table table-bordered mt-3">
    <tr class="fw-bold">
        <td>No</td>
        <td>Nis</td>
        <td>Nama Anggota</td>
        <td>Username</td>
        <td>Password</td>
        <td>Kelas</td>
        <td>Aksi</td>
    </tr>
    <?php
    include'../koneksi.php';
    $no = 1;
    $query = "SELECT*FROM anggota ORDER BY id_anggota DESC";
    $data = mysqli_query($koneksi, $query);
    foreach($data as $anggota){ ?>
    <tr> 

        <td><?= $no++; ?></td>
        <td><?= $anggota['nis']?></td>
        <td><?= $anggota['nama_anggota']?></td>
        <td><?= $anggota['username']?></td>
       <td>
    <?php 
    // Mengubah karakter password menjadi bintang sesuai panjang string-nya
    echo str_repeat('*', strlen($anggota['password'])); 
    ?>
</td>
        <td><?= $anggota['kelas']?></td>
        <td> 

        <a class="btn btn-warning btn-sm" href="?halaman=edit_anggota&id=<?= $anggota['id_anggota'] ?>">📝 Edit </a>
        <a onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm" href="?halaman=hapus_anggota&id=<?= $anggota['id_anggota'] ?>">🗑️ hapus </a>

        </td>
    </tr>
    <?php } ?>
</table>