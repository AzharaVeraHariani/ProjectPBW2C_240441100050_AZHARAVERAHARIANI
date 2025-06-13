<?php 
session_start();
include 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die('Keranjang kosong');
}

// Ambil isi keranjang sebelum dikosongkan
$cart_items = $_SESSION['cart'];

$method         = $_POST['payment_method'] ?? '';
$total_final    = $_POST['total_final'] ?? 0;
$voucher_code   = $_POST['voucher_code'] ?? '';
$customer_name  = $_POST['customer_name'] ?? '';
$phone_number   = $_POST['phone_number'] ?? '';
$notes          = $_POST['notes'] ?? '';
$tanggal        = date('Y-m-d H:i:s');
$status         = 'Diproses';

// Simpan ke database
$query = "INSERT INTO checkout (nama, alamat, telepon, status, tanggal, voucher, catatan, total, metode)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssssssis',
    $customer_name,
    $notes, // sebagai alamat
    $phone_number,
    $status,
    $tanggal,
    $voucher_code,
    $notes, // sebagai catatan juga
    $total_final,
    $method
);
$stmt->execute();

$checkout_id = $stmt->insert_id;
// Simpan detail barang ke tabel checkout_detail
foreach ($cart_items as $item) {
    $nama_barang = $item['nama_barang'] ?? '';
    $jumlah = $item['jumlah'] ?? 1;

    $detail_stmt = $conn->prepare("INSERT INTO checkout_detail (checkout_id, nama_barang, jumlah) VALUES (?, ?, ?)");
    $detail_stmt->bind_param('isi', $checkout_id, $nama_barang, $jumlah);
    $detail_stmt->execute();
}

// Kosongkan keranjang
$_SESSION['cart'] = [];
$_SESSION['voucher_code'] = '';
$_SESSION['discount_percent'] = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Konfirmasi Pesanan - Eatzy Juara</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body style="background:#f8f9fa;">
  <div class="container mt-5">
    <div class="card shadow-sm p-4 rounded">
      <div class="text-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" style="color:#198754" width="72" height="72" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0L11.03 8.03a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.53 8.47a.75.75 0 0 0-1.06 1.06l1.5 1.5z"/>
        </svg>
        <h2 class="mt-3">Pesanan Anda Berhasil!</h2>
      </div>
      
      <p>Terima kasih sudah berbelanja di <strong>Eatzy Juara</strong>. Pesanan Anda sedang kami proses.</p>

      <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between">
          <span>Nama Pelanggan:</span>
          <strong><?= htmlspecialchars($customer_name) ?></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span>No Telepon:</span>
          <strong><?= htmlspecialchars($phone_number) ?></strong>
        </li>
        <?php if (!empty($notes)): ?>
        <li class="list-group-item">
          <strong>Alamat Lengkap:</strong><br>
          <em><?= nl2br(htmlspecialchars($notes)) ?></em>
        </li>
        <?php endif; ?>

        <li class="list-group-item d-flex justify-content-between">
          <span>Metode Pembayaran:</span>
          <strong><?= htmlspecialchars($method) ?></strong>
        </li>
        <?php if (!empty($voucher_code)): ?>
        <li class="list-group-item d-flex justify-content-between">
          <span>Voucher Digunakan:</span>
          <strong><?= htmlspecialchars($voucher_code) ?></strong>
        </li>
        <?php endif; ?>
        <li class="list-group-item d-flex justify-content-between">
          <span>Total Bayar:</span>
          <strong>Rp <?= number_format($total_final, 0, ',', '.') ?></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <span>Status Pesanan:</span>
          <span class="badge bg-warning text-dark">Diproses</span>
        </li>
      </ul>

      <div class="text-center">
        <button onclick="window.print()" class="btn btn-success me-2 mb-2">Cetak Struk</button>
        <a href="index.php" class="btn btn-primary me-2 mb-2">Kembali ke Beranda</a>
        <a href="logout.php" class="btn btn-danger mb-2">Logout</a>
      </div>
    </div>
  </div>
</body>
</html>
