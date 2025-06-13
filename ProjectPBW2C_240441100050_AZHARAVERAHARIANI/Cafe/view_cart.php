<?php   
session_start();

// Contoh daftar voucher diskon dan voucher gratis ongkir
$valid_vouchers = [
    'NASI20' => ['type' => 'diskon', 'value' => 0.20],
    'GRATISMINUM' => ['type' => 'diskon', 'value' => 0.10],
    'ONGKIR0' => ['type' => 'gratis_ongkir', 'value' => 0],
    'CASHBACK10' => ['type' => 'diskon', 'value' => 0.10], // tambahkan ini
];

// Contoh daftar ongkir berdasarkan kota
$shipping_costs = [
    'Jakarta' => 15000,
    'Jawa' => 20000,
    'Kalimantan' => 25000,
    'Sumatera' => 18000,
    'Sulawesi' => 30000,
    
];

$voucher_code = '';
$discount_percent = 0;
$discount_amount = 0;
$selected_city = '';
$shipping_fee = 0;
$error_msg = '';
$free_shipping = false;  // MODIF: flag gratis ongkir

// Proses cek voucher jika dikirim POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['voucher_code'])) {
        $voucher_code = strtoupper(trim($_POST['voucher_code']));
        if (isset($valid_vouchers[$voucher_code])) {
            $voucher = $valid_vouchers[$voucher_code];
            if ($voucher['type'] === 'diskon') {
                $discount_percent = $voucher['value'];
                $free_shipping = false;
            } elseif ($voucher['type'] === 'gratis_ongkir') {
                $discount_percent = 0;
                $free_shipping = true;
            }
            $_SESSION['voucher_code'] = $voucher_code;
            $_SESSION['discount_percent'] = $discount_percent;
            $_SESSION['free_shipping'] = $free_shipping;  // MODIF
        } else {
            $_SESSION['voucher_code'] = '';
            $_SESSION['discount_percent'] = 0;
            $_SESSION['free_shipping'] = false;  // MODIF
            $error_msg = "Kode voucher tidak valid.";
        }
    }
    if (isset($_POST['shipping_city']) && array_key_exists($_POST['shipping_city'], $shipping_costs)) {
        $selected_city = $_POST['shipping_city'];
        $_SESSION['shipping_city'] = $selected_city;
    } elseif (isset($_SESSION['shipping_city'])) {
        $selected_city = $_SESSION['shipping_city'];
    }
} else {
    if (!empty($_SESSION['voucher_code'])) {
        $voucher_code = $_SESSION['voucher_code'];
        $discount_percent = $_SESSION['discount_percent'];
        $free_shipping = $_SESSION['free_shipping'] ?? false;  // MODIF
    }
    if (!empty($_SESSION['shipping_city'])) {
        $selected_city = $_SESSION['shipping_city'];
    }
}
?>

<!-- Bagian hitung total dan ongkir -->
<?php if (!empty($_SESSION['cart'])): ?>
    <?php 
    $total = 0; 
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }

    $discount_amount = $total * $discount_percent;
    $total_after_discount = $total - $discount_amount;

    if (!empty($selected_city) && isset($shipping_costs[$selected_city])) {
        $shipping_fee = $free_shipping ? 0 : $shipping_costs[$selected_city];
    } else {
        $shipping_fee = 0;
    }

    $final_total = $total_after_discount + $shipping_fee;
    ?>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Keranjang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      /* Gradient background */
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 40px 15px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .cart-container {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 30px 40px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      max-width: 900px;
      width: 100%;
    }
    h2 {
      color: #4a148c;
      margin-bottom: 30px;
      font-weight: 700;
      text-align: center;
      letter-spacing: 1px;
    }
    table {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    thead {
      background-color: #764ba2;
      color: white;
      font-weight: 600;
    }
    tbody tr:hover {
      background-color: #f3e5f5;
      transition: background-color 0.3s ease;
    }
    .btn-warning {
      background-color: #ffb300;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-warning:hover {
      background-color: #ff8f00;
    }
    .btn-danger {
      background-color: #e53935;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-danger:hover {
      background-color: #b71c1c;
    }
    .btn-primary {
      background-color: #5e35b1;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #4527a0;
    }
    .btn-success {
      background-color: #43a047;
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-success:hover {
      background-color: #2e7d32;
    }
    form select, form input[type=text] {
      box-shadow: none !important;
      border-radius: 8px !important;
      border: 1.8px solid #764ba2 !important;
      padding: 6px 10px;
      font-weight: 600;
      color: #4a148c;
    }
    form label {
      font-weight: 600;
      color: #4a148c;
    }
    .alert-danger {
      border-radius: 8px;
      font-weight: 600;
    }
    p.fs-5 {
      color: #4a148c;
      font-weight: 700;
      margin-top: 20px;
    }
  </style>
</head>
<body>
<div class="cart-container shadow">
  <h2>Keranjang Belanja</h2>

  <?php if (!empty($_SESSION['cart'])): ?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Item</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th>Keterangan</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php 
      $total = 0; 
      foreach ($_SESSION['cart'] as $index => $item): 
        $sub = $item['price'] * $item['qty']; 
        $total += $sub; 
    ?>
      <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td>Rp <?= number_format($item['price']) ?></td>
        <td><?= (int)$item['qty'] ?></td>
        <td>Rp <?= number_format($sub) ?></td>
        <td><?= !empty($item['keterangan']) ? htmlspecialchars($item['keterangan']) : '-' ?></td>
        <td>
          <a href="edit_item.php?id=<?= urlencode($item['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="hapus.php?id=<?= urlencode($item['id']) ?>" class="btn btn-danger btn-sm">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Form Voucher Diskon dan Ongkir -->
  <form method="POST" class="mb-3">
    <div class="row g-3 align-items-center">
      <div class="col-md-5 col-sm-12">
        <label for="voucher_code" class="form-label mb-1">Kode Voucher:</label>
        <input type="text" name="voucher_code" id="voucher_code" class="form-control" placeholder="Contoh: NASI20" value="<?= htmlspecialchars($voucher_code) ?>">
      </div>
      <div class="col-md-5 col-sm-12">
        <label for="shipping_city" class="form-label mb-1">Pilih Kota Pengiriman:</label>
        <select name="shipping_city" id="shipping_city" class="form-select" required>
          <option value="" disabled <?= $selected_city==='' ? 'selected' : '' ?>>-- Pilih Kota --</option>
          <?php foreach ($shipping_costs as $city => $cost): ?>
            <option value="<?= htmlspecialchars($city) ?>" <?= ($selected_city === $city) ? 'selected' : '' ?>>
              <?= htmlspecialchars($city) ?> (Rp <?= number_format($cost) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 col-sm-12 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Update</button>
      </div>
    </div>
  </form>

  <?php if (!empty($error_msg)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
  <?php endif; ?>

  <p><strong>Total Sebelum Diskon: Rp <?= number_format($total) ?></strong></p>

  <?php 
  if ($discount_percent > 0): 
    $discount_amount = $total * $discount_percent;
    $total_after_discount = $total - $discount_amount;
  ?>
    <p class="text-success">
      Diskon (<?= htmlspecialchars($voucher_code) ?>): -Rp <?= number_format($discount_amount) ?>
    </p>
    <p><strong>Total Setelah Diskon: Rp <?= number_format($total_after_discount) ?></strong></p>
  <?php else: ?>
    <?php $total_after_discount = $total; ?>
  <?php endif; ?>

  <?php
  // Hitung ongkir ulang dengan cek free_shipping
  if (!empty($selected_city) && isset($shipping_costs[$selected_city])) {
      $shipping_fee = (!empty($_SESSION['free_shipping']) && $_SESSION['free_shipping'] === true)
                      ? 0
                      : $shipping_costs[$selected_city];
  } else {
      $shipping_fee = 0;
  }
  $final_total = $total_after_discount + $shipping_fee;
  ?>

  <?php if (!empty($_SESSION['free_shipping'])): ?>
    <p class="text-success"><strong>Voucher Gratis Ongkir Aktif (<?= htmlspecialchars($voucher_code) ?>)</strong></p>
  <?php endif; ?>

  <p><strong>Ongkir (<?= htmlspecialchars($selected_city ?: '-') ?>): Rp <?= number_format($shipping_fee) ?></strong></p>
  <p class="fs-5"><strong>Total Bayar: Rp <?= number_format($final_total) ?></strong></p>

    <form method="POST" action="checkout.php" class="d-flex flex-column gap-3">

  <div class="mb-3">
    <label for="customer_name" class="form-label">Nama Lengkap</label>
    <input type="text" name="customer_name" id="customer_name" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="phone_number" class="form-label">No Telepon</label>
    <input type="text" name="phone_number" id="phone_number" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="notes" class="form-label">Alamat Lengkap</label>
    <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
  </div>

  <select name="payment_method" class="form-select w-auto" required>
    <option value="COD">COD</option>
    <option value="Transfer">Transfer Bank</option>
    <option value="E-Wallet">E-Wallet</option>
  </select>

  <input type="hidden" name="total_final" value="<?= $final_total ?>">
  <input type="hidden" name="voucher_code" value="<?= htmlspecialchars($voucher_code) ?>">
  <input type="hidden" name="shipping_city" value="<?= htmlspecialchars($selected_city) ?>">

  <button type="submit" class="btn btn-success">Checkout</button>
  <a href="index.php" class="btn btn-primary">+ Tambah Item</a>
</form>

  <a href="index.php" class="btn btn-outline-secondary mt-3 d-block text-center">← Kembali ke Menu</a>

  <?php else: ?>
    <p class="text-center text-white fs-4 mt-5">Keranjang kosong.</p>
  <?php endif; ?>
</div>
</body>
</html>
