<?php
include 'db.php'; // Pastikan file ini ada dan koneksi $conn berhasil
session_start();


// Ambil order_id dari URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Order ID tidak ditemukan.";
    exit;
}

$order_id = (int)$_GET['id'];


// Ambil detail pesanan berdasarkan order_id
$query = mysqli_query($conn, "SELECT do.*, b.nama_barang 
                              FROM detail_order do 
                              JOIN barang b ON do.barang_id = b.id_barang 
                              WHERE do.order_id = $order_id");

if (!$query) {
    echo "Query error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h3>Detail Barang untuk Order #<?= $order_id; ?></h3>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $total_all = 0;
            while ($row = mysqli_fetch_assoc($query)) : 
                $total = $row['jumlah'] * $row['harga'];
                $total_all += $total;
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp<?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td>Rp<?= number_format($total, 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th>Rp<?= number_format($total_all, 0, ',', '.'); ?></th>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
