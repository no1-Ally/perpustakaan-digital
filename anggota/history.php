<h4 class="mt-2">History Peminjaman & Pengembalian Buku</h4>
<table class="table table-bordered mt-3">
    <thead>
        <tr class="fw-bold">
            <th>No</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $id_user = $_SESSION['id_anggota'];
        // Query untuk mengambil seluruh riwayat transaksi (baik yang masih dipinjam maupun sudah dikembalikan)
        $query_history = "SELECT transaksi.*, buku.* FROM transaksi JOIN buku ON buku.id_buku = transaksi.id_buku WHERE transaksi.id_anggota = '$id_user' ORDER BY transaksi.id_transaksi DESC";
        $data_history = mysqli_query($koneksi, $query_history);
        
        if ($data_history && mysqli_num_rows($data_history) > 0) {
            while($row = mysqli_fetch_array($data_history)) { 
        ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                    <td><?= htmlspecialchars($row['tgl_pinjam']); ?></td>
                    <td><?= !empty($row['tgl_kembali']) ? htmlspecialchars($row['tgl_kembali']) : '-'; ?></td>
                    <td>
                        <?php if($row['status_transaksi'] == 'Peminjaman') { ?>
                            <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                        <?php } else { ?>
                            <span class="badge bg-success">Sudah Dikembalikan</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php 
            }
        } else {
            echo "<tr><td colspan='5' class='text-center text-muted'>Belum ada history peminjaman buku.</td></tr>";
        } 
        ?>
    </tbody>
</table>