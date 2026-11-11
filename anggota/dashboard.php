<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: login_anggota.php");
    exit();
}
include '../koneksi.php';

// PROSES PINJAM BUKU DARI DASHBOARD ANGGOTA
if (isset($_GET['halaman']) && $_GET['halaman'] == 'pinjam' && isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];
    $id_anggota = $_SESSION['id_anggota'];
    $tgl_pinjam = date('Y-m-d H:i:s');

    // Masukkan ke tabel transaksi dengan status 'Peminjaman'
    $query_pinjam = mysqli_query($koneksi, "INSERT INTO transaksi (id_buku, id_anggota, tgl_pinjam, status_transaksi) VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', 'Peminjaman')");

    if ($query_pinjam) {
        // Update status buku jadi 'dipinjam'
        mysqli_query($koneksi, "UPDATE buku SET status = 'dipinjam' WHERE id_buku = '$id_buku'");
        echo "<script>alert('Berhasil meminjam buku!'); window.location.href='dashboard.php';</script>";
        exit();
    }
}

// PROSES PENGEMBALIAN BUKU DARI DASHBOARD ANGGOTA
if (isset($_GET['halaman']) && $_GET['halaman'] == 'pengembalian' && isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];
    $id_buku = $_GET['id_buku'];
    $tgl_kembali = date('Y-m-d H:i:s');

    $query_kembali = mysqli_query($koneksi, "UPDATE transaksi SET status_transaksi = 'Pengembalian', tgl_kembali = '$tgl_kembali' WHERE id_transaksi = '$id_transaksi'");

    if ($query_kembali) {
        mysqli_query($koneksi, "UPDATE buku SET status = 'tersedia' WHERE id_buku = '$id_buku'");
        echo "<script>alert('Buku berhasil dikembalikan!'); window.location.href='dashboard.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Anggota | Aplikasi Perpustakaan Sekolah Digital</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-3 mb-3">
        <h4>Halaman Anggota | Aplikasi Perpustakaan Sekolah Digital</h4>
        <a href="dashboard.php" class="btn btn-success text-white">Dashboard</a>
        <a href="dashboard.php?halaman=history" class="btn btn-success text-white">History Peminjaman</a>
        <a href="logout.php" class="btn btn-danger text-white">Logout</a>
        
        <div class="card p-3 mt-3">
            <?php
            $halaman = isset($_GET['halaman']) ? $_GET['halaman'] : "";
            
            if (!empty($halaman) && $halaman != 'pinjam' && $halaman != 'pengembalian' && file_exists($halaman . ".php")) {
                include $halaman . ".php";
            } else { 
            ?>
                <h4>Selamat Datang <?= htmlspecialchars($_SESSION['nama_anggota'] ?? 'Anggota'); ?> 👋</h4>

                <!-- FORM PENCARIAN BUKU -->
                <form action="dashboard.php?halaman=cari" method="GET" class="mt-3">
                    <input type="hidden" name="halaman" value="cari">
                    <label class="text-muted">Cari Buku:</label>
                    <div class="input-group mb-2">
                        <input type="text" name="kunci" class="form-control" required placeholder="Masukkan judul buku">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </form>

                <!-- TABEL Buku YANG SEDANG DIPINJAM -->
                <h4 class="mt-4">Daftar Buku yang Sedang Dipinjam</h4>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr class="fw-bold">
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $id_user = $_SESSION['id_anggota'];
                        $query_pinjam = "SELECT transaksi.*, buku.* FROM transaksi JOIN buku ON buku.id_buku = transaksi.id_buku WHERE transaksi.id_anggota = '$id_user' AND transaksi.status_transaksi = 'Peminjaman'";
                        $data_pinjam = mysqli_query($koneksi, $query_pinjam);
                        
                        if ($data_pinjam && mysqli_num_rows($data_pinjam) > 0) {
                            while($peminjaman = mysqli_fetch_array($data_pinjam)) { 
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($peminjaman['judul_buku']); ?></td>
                                    <td><?= htmlspecialchars($peminjaman['tgl_pinjam']); ?></td>
                                    <td>
                                        <?php 
                                        $pesan_kembali = "Apakah anda yakin ingin mengembalikan buku " . $peminjaman['judul_buku'] . "?";
                                        ?>
                                        <button onclick="pengembalian('<?= $pesan_kembali; ?>', <?= $peminjaman['id_transaksi']; ?>, <?= $peminjaman['id_buku']; ?>)" class="btn btn-success btn-sm text-white">Pengembalian</button>
                                    </td>
                                </tr>
                            <?php 
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted'>Tidak ada buku yang sedang dipinjam.</td></tr>";
                        } 
                        ?>
                    </tbody>
                </table>

                <!-- DAFTAR SEMUA BUKU -->
                <h4 class="mt-4">Daftar Buku</h4>
                <div class="row">
                <?php
                $data_buku = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku DESC");
                while ($buku = mysqli_fetch_array($data_buku)) {
                ?>
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm p-3 d-flex h-100">
                            <h5><?= htmlspecialchars($buku['judul_buku']); ?></h5>
                            <p class="mb-1"><strong>Pengarang:</strong> <?= htmlspecialchars($buku['pengarang']); ?></p>
                            <p class="mb-1"><strong>Penerbit:</strong> <?= htmlspecialchars($buku['penerbit']); ?></p>
                            <p class="mb-3"><strong>Tahun Terbit:</strong> <?= htmlspecialchars($buku['tahun_terbit']); ?></p>
                            
                            <div class="mt-auto">
                                <?php if (strtolower($buku['status']) == 'tersedia') { ?>
                                    <span class="badge bg-success mb-2 d-block">Tersedia</span>
                                    <?php 
                                    $pesan_pinjam = "Apakah anda yakin ingin meminjam buku " . $buku['judul_buku'] . "?";
                                    ?>
                                    <button onclick="pinjam('<?= $pesan_pinjam; ?>', <?= $buku['id_buku']; ?>)" class="btn btn-primary text-white w-100">Pinjam</button>
                                <?php } else { ?>
                                    <span class="badge bg-danger mb-2 d-block">Tidak Tersedia</span>
                                    <button class="btn btn-secondary text-white disabled w-100" disabled>Pinjam</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?> 
                </div>
            <?php } ?>
        </div> 
    </div>
    
    <script>
        function pinjam(pesan, id_buku){
            if(confirm(pesan)){
                window.location.href = 'dashboard.php?halaman=pinjam&id_buku=' + id_buku;
            }
        }

        function pengembalian(pesan, id_transaksi, id_buku){
            if(confirm(pesan)){
                window.location.href = 'dashboard.php?halaman=pengembalian&id_transaksi=' + id_transaksi + '&id_buku=' + id_buku;
            }
        }

        function pengembalian(pesan, id_transaksi, id_buku){
            if(confirm(pesan)){
                window.location.href = 'dashboard.php?halaman=pengembalian&id_transaksi=' + id_transaksi + '&id_buku=' + id_buku;
            }
        }

    </script>
</body>
</html>