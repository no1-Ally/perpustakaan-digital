<?php
// Karena file ini dipanggil dari folder admin, koneksinya naik satu tingkat ke ../
include '../koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$buku = isset($_GET['buku']) ? $_GET['buku'] : '';

if (!empty($id)) {
    // Eksekusi hapus data peminjaman
    $query = "DELETE FROM transaksi WHERE id_transaksi='$id'";
    $hapus = mysqli_query($koneksi, $query);

    if ($hapus) {
        // Kembalikan status buku jadi tersedia
        if (!empty($buku)) {
            mysqli_query($koneksi, "UPDATE buku SET status='tersedia' WHERE id_buku='$buku'");
        }
        
        echo "<script>
            alert('Data peminjaman berhasil dihapus!');
            window.location.href = 'dashboard.php?halaman=data_peminjaman';
        </script>";
        exit();
    } else {
        $err = mysqli_error($koneksi);
        echo "<script>
            alert('Gagal menghapus: " . addslashes($err) . "');
            window.location.href = 'dashboard.php?halaman=data_peminjaman';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('ID Transaksi kosong!');
        window.location.href = 'dashboard.php?halaman=data_peminjaman';
    </script>";
    exit();
}
?>