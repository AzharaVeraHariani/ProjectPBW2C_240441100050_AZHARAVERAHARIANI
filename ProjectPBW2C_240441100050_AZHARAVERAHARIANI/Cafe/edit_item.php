<?php
session_start();
$id = $_GET['id'];
$item = null;

// Cari item berdasarkan ID
foreach ($_SESSION['cart'] as $i) {
  if ($i['id'] == $id) {
    $item = $i;
    break;
  }
}

if (!$item) {
  echo "Item tidak ditemukan.";
  exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_qty = (int)$_POST['qty'];
  $new_ket = $_POST['keterangan'];

  foreach ($_SESSION['cart'] as &$i) {
    if ($i['id'] == $id) {
      $i['qty'] = $new_qty;
      $i['keterangan'] = $new_ket;
      break;
    }
  }
  header('Location: view_cart.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3>Edit Item Keranjang</h3>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama Menu</label>
      <input type="text" class="form-control" value="<?= $item['name'] ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Jumlah</label>
      <input type="number" name="qty" class="form-control" value="<?= $item['qty'] ?>" min="1" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Keterangan</label>
      <textarea name="keterangan" class="form-control" rows="3"><?= isset($item['keterangan']) ? $item['keterangan'] : '' ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="view_cart.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
