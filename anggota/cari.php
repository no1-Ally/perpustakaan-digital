<?php
// Mendukung pencarian lewat POST maupun GET agar tidak error
$kunci = "";
if (isset($_POST['kunci'])) {
    $kunci = mysqli_real_escape_string($koneksi, $_POST['kunci']);
} elseif (isset($_GET['kunci'])) {
    $kunci = mysqli_real_escape_string($koneksi, $_GET['kunci']);
}
?>

<!-- Form Pencarian -->
<form action="dashboard.php?halaman=cari" method="GET">
    <!-- Wajib menyertakan input hidden halaman agar sistem tahu tetap membuka halaman cari -->
    <input type="hidden" name="halaman" value="cari">
    <label class="text-muted">Cari Buku:</label>
    <div class="input-group mb-2">
        <input type="text" name="kunci" value="<?= htmlspecialchars($kunci); ?>" class="form-control" required placeholder="Masukkan judul buku">
        <button type="submit" class="btn btn-primary">Cari</button>
    </div>
</form>

<h4 class="mt-4">Pencarian Buku "<?= htmlspecialchars($kunci); ?>"</h4>
<div class="row">
<?php
if (!empty($kunci)) {
    // Perbaikan Query SQL: Menambahkan WHERE judul_buku LIKE ...
    $query_cari = "SELECT * FROM buku WHERE judul_buku LIKE '%$kunci%' ORDER BY id_buku DESC";
    $data_buku = mysqli_query($koneksi, $query_cari);

    if ($data_buku && mysqli_num_rows($data_buku) > 0) {
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
<?php 
        }
    } else {
        echo "<div class='col-12'><p class='text-muted'>Buku yang dicari tidak ditemukan.</p></div>";
    }
}
?> 
</div>