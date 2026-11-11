<?php
include "../koneksi.php";

if (isset($conn) && !isset($koneksi)) {
    $koneksi = $conn;
}

// 1. PROSES TAMBAH PEMINJAMAN
if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tgl_pinjam = $_POST['tgl_pinjam'] . ' ' . date('H:i:s');

    $query_simpan = mysqli_query($koneksi, "INSERT INTO transaksi (id_buku, id_anggota, tgl_pinjam, status_transaksi) VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', 'Peminjaman')");

    if ($query_simpan) {
        mysqli_query($koneksi, "UPDATE buku SET status='dipinjam' WHERE id_buku='$id_buku'");
        echo "<script>
            alert('Data peminjaman berhasil ditambahkan!');
            document.location.href = 'dashboard.php?halaman=data_peminjaman';
        </script>";
        exit();
    }
}

// 2. PROSES PENGEMBALIAN BUKU
if (isset($_GET['aksi']) && $_GET['aksi'] == 'pengembalian' && isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $id_buku = $_GET['buku'];
    $tgl_kembali_hari_ini = date('Y-m-d H:i:s');

    $update_transaksi = mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi = 'Pengembalian', tgl_kembali = '$tgl_kembali_hari_ini' WHERE id_transaksi = '$id_transaksi'");

    if ($update_transaksi) {
        mysqli_query($koneksi, "UPDATE buku SET status = 'tersedia' WHERE id_buku = '$id_buku'");
        echo "<script>
            alert('Buku berhasil dikembalikan!');
            document.location.href = 'dashboard.php?halaman=data_peminjaman';
        </script>";
        exit();
    }
}

// 3. PROSES HAPUS TRANSAKSI
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus' && isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $id_buku = isset($_GET['buku']) ? $_GET['buku'] : '';
    $status_transaksi = isset($_GET['status']) ? $_GET['status'] : '';

    if ($status_transaksi == 'Peminjaman' && !empty($id_buku)) {
        mysqli_query($koneksi, "UPDATE buku SET status = 'tersedia' WHERE id_buku = '$id_buku'");
    }

    $hapus = mysqli_query($koneksi, "DELETE FROM transaksi WHERE id_transaksi = '$id_transaksi'");

    if ($hapus) {
        echo "<script>
            alert('Data transaksi berhasil dihapus!');
            document.location.href = 'dashboard.php?halaman=data_peminjaman';
        </script>";
        exit();
    }
}
?>

<div class="container-fluid px-4">
    <h2 class="mt-4">Data Peminjaman & Pengembalian Buku</h2>
    <hr>

    <?php if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') { ?>
        <!-- FORM TAMBAH PEMINJAMAN -->
        <h4 class="mt-4">Form Tambah Peminjaman</h4>
        <form method="POST" action="" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Pilih Buku</label>
                <select name="id_buku" class="form-control" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php
                    $buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE status='tersedia' OR status IS NULL");
                    while($b = mysqli_fetch_assoc($buku)){
                        echo "<option value='".$b['id_buku']."'>".$b['judul_buku']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Pilih Anggota</label>
                <select name="id_anggota" class="form-control" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php
                  $anggota = mysqli_query($koneksi, "SELECT * FROM anggota GROUP BY nama_anggota, nis");
                    while($a = mysqli_fetch_assoc($anggota)){
                        echo "<option value='".$a['id_anggota']."'>".$a['nis']." - ".$a['nama_anggota']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-secondary">Simpan</button>
            <a href="dashboard.php?halaman=data_peminjaman" class="btn btn-danger">Batal</a>
        </form>
    <?php } else { ?>
        <!-- TOMBOL TAMBAH (LEBAR & ABU-ABU) -->
        <div class="d-grid gap-2 mb-3">
            <a href="dashboard.php?halaman=data_peminjaman&aksi=tambah" class="btn btn-secondary">+ Tambah Peminjaman</a>
        </div>

        <!-- TABEL 1: DATA PEMINJAMAN -->
        <h4 class="mt-4">Data Sedang Dipinjam</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal & Jam Pinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
             $query_pinjam = "SELECT transaksi.*, buku.*, anggota.*, 
                 transaksi.tgl_pinjam AS tgl_pinjam_asli 
                 FROM transaksi 
                 JOIN buku ON buku.id_buku = transaksi.id_buku 
                 JOIN anggota ON anggota.id_anggota = transaksi.id_anggota 
                 WHERE transaksi.status_transaksi = 'Peminjaman' 
                 ORDER BY transaksi.id_transaksi DESC";
                $data_pinjam = mysqli_query($koneksi, $query_pinjam);

                if ($data_pinjam && mysqli_num_rows($data_pinjam) > 0) {
                    foreach($data_pinjam as $peminjam){ ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $peminjam['nis']; ?></td>
                            <td><?= $peminjam['nama_anggota']; ?></td>
                            <td><?= $peminjam['judul_buku']; ?></td>
                            <td><?= isset($peminjam['tgl_pinjam_asli']) ? $peminjam['tgl_pinjam_asli'] : '-'; ?></td>
                            <td>
                                <button onclick="prosesPengembalian('Yakin ingin memproses pengembalian buku ini?', <?= $peminjam['id_transaksi']; ?>, <?= $peminjam['id_buku']; ?>)" class="btn btn-success btn-sm">Pengembalian</button>
                                <a href="dashboard.php?halaman=data_peminjaman&aksi=hapus&id=<?= $peminjam['id_transaksi']; ?>&buku=<?= $peminjam['id_buku']; ?>&status=Peminjaman" 
                                   onclick="return confirm('Yakin ingin menghapus data peminjaman ini?');" 
                                   class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data peminjaman aktif.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- TABEL 2: DATA PENGEMBALIAN -->
        <h4 class="mt-4">Riwayat Pengembalian Buku</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Anggota</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal & Jam Pengembalian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no_kembali = 1;
                $query_kembali = "SELECT transaksi.*, buku.*, anggota.*, 
                                  transaksi.tgl_pinjam AS tgl_pinjam_asli, 
                                  transaksi.tgl_kembali AS tgl_kembali_asli 
                                  FROM transaksi 
                                  JOIN buku ON buku.id_buku = transaksi.id_buku 
                                  JOIN anggota ON anggota.id_anggota = transaksi.id_anggota 
                                  WHERE transaksi.status_transaksi = 'Pengembalian' 
                                  ORDER BY transaksi.id_transaksi DESC";
                $data_kembali = mysqli_query($koneksi, $query_kembali);

                if ($data_kembali && mysqli_num_rows($data_kembali) > 0) {
                    foreach($data_kembali as $kembali){ ?>
                        <tr>
                            <td><?= $no_kembali++; ?></td>
                            <td><?= $kembali['nis']; ?></td>
                            <td><?= $kembali['nama_anggota']; ?></td>
                            <td><?= $kembali['judul_buku']; ?></td>
                            <td><?= isset($kembali['tgl_pinjam_asli']) ? $kembali['tgl_pinjam_asli'] : '-'; ?></td>
                            <td><?= isset($kembali['tgl_kembali_asli']) ? $kembali['tgl_kembali_asli'] : '-'; ?></td>
                            <td>
                                <a href="dashboard.php?halaman=data_peminjaman&aksi=hapus&id=<?= $kembali['id_transaksi']; ?>&buku=<?= $kembali['id_buku']; ?>&status=Pengembalian" 
                                   onclick="return confirm('Yakin ingin menghapus riwayat pengembalian ini?');" 
                                   class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat pengembalian.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<!-- JavaScript untuk Trigger Pengembalian -->
<script>
    function prosesPengembalian(pesan, id_transaksi, id_buku){
        if(confirm(pesan)){
            window.location.href = `dashboard.php?halaman=data_peminjaman&aksi=pengembalian&id=${id_transaksi}&buku=${id_buku}`;
        }
    }
</script>