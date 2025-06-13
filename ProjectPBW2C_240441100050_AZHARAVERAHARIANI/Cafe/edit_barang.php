<?php
session_start();

if (!isset($_SESSION['menu'])) {
  echo "Data tidak tersedia.";
  exit;
}

$id = (int)$_GET['id'];
$menu = $_SESSION['menu'];
$index = array_search($id, array_column($menu, 'id'));

if ($index === false) {
  echo "Data tidak ditemukan.";
  exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_SESSION['menu'][$index]['name'] = $_POST['name'];
  $_SESSION['menu'][$index]['price'] = (int)$_POST['price'];
  $_SESSION['menu'][$index]['stock'] = (int)$_POST['stock'];
  $_SESSION['menu'][$index]['category'] = $_POST['category'];

  header("Location: barang.php");
  exit;
}

$item = $menu[$index];
?>

<h2>Edit Barang</h2>
<form method="post">
  Nama: <input type="text" name="name" value="<?= $item['name'] ?>"><br>
  Harga: <input type="number" name="price" value="<?= $item['price'] ?>"><br>
  Stok: <input type="number" name="stock" value="<?= $item['stock'] ?>"><br>
  Kategori: <input type="text" name="category" value="<?= $item['category'] ?>"><br>
  <button type="submit">Simpan</button>
</form>
