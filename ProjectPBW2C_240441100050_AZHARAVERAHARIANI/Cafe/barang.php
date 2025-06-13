
<?php
session_start();

// Inisialisasi data awal jika belum ada di session
if (!isset($_SESSION['menu'])) {
  $_SESSION['menu'] = [
    ["id"=>1, "name"=>"Nasi Pecel", "price"=>20000, "stock"=>25, "category"=>"Makanan Berat"],
    ["id"=>2, "name"=>"Nasi Goreng", "price"=>15000, "stock"=>30, "category"=>"Makanan Berat"],
    ["id"=>3, "name"=>"Soto Ayam", "price"=>20000, "stock"=>22, "category"=>"Makanan Berat"],
    ["id"=>4, "name"=>"Chicken Katsu", "price"=>25000, "stock"=>18, "category"=>"Makanan Berat"],
    ["id"=>5, "name"=>"Seblak Pedas", "price"=>22000, "stock"=>16, "category"=>"Makanan Berat"],
    ["id"=>6, "name"=>"Mie Goreng", "price"=>25000, "stock"=>20, "category"=>"Makanan Berat"],
    ["id"=>7, "name"=>"Sate Ayam", "price"=>20000, "stock"=>21, "category"=>"Makanan Berat"],
    ["id"=>8, "name"=>"Bakso", "price"=>16000, "stock"=>19, "category"=>"Makanan Berat"],
    ["id"=>9, "name"=>"Kentang Goreng", "price"=>10000, "stock"=>27, "category"=>"Camilan"],
    ["id"=>10, "name"=>"Roti Bakar", "price"=>10000, "stock"=>17, "category"=>"Camilan"],
    ["id"=>11, "name"=>"Tahu Gejrot", "price"=>10000, "stock"=>23, "category"=>"Camilan"],
    ["id"=>12, "name"=>"Pisang Lumer", "price"=>12000, "stock"=>20, "category"=>"Camilan"],
    ["id"=>13, "name"=>"Sosis Solo", "price"=>12000, "stock"=>24, "category"=>"Camilan"],
    ["id"=>14, "name"=>"Kebab", "price"=>15000, "stock"=>19, "category"=>"Camilan"],
    ["id"=>15, "name"=>"Churos", "price"=>10000, "stock"=>22, "category"=>"Camilan"],
    ["id"=>16, "name"=>"Jasuke", "price"=>10000, "stock"=>21, "category"=>"Camilan"],
    ["id"=>17, "name"=>"Air Mineral", "price"=>8000, "stock"=>30, "category"=>"Minuman"],
    ["id"=>18, "name"=>"Es Teh", "price"=>8000, "stock"=>30, "category"=>"Minuman"],
    ["id"=>19, "name"=>"Es Jeruk", "price"=>10000, "stock"=>25, "category"=>"Minuman"],
    ["id"=>20, "name"=>"Es Leci Tea", "price"=>15000, "stock"=>26, "category"=>"Minuman"],
    ["id"=>21, "name"=>"Red Velvet", "price"=>15000, "stock"=>18, "category"=>"Minuman"],
    ["id"=>22, "name"=>"Es Thai Tea", "price"=>13000, "stock"=>20, "category"=>"Minuman"],
    ["id"=>23, "name"=>"Matcha Latte", "price"=>15000, "stock"=>17, "category"=>"Minuman"],
    ["id"=>24, "name"=>"Hot Coffee", "price"=>12000, "stock"=>14, "category"=>"Minuman"],
  ];
}

$menu = $_SESSION['menu'];
$editItem = null;

// Handle update jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
  foreach ($_SESSION['menu'] as &$item) {
    if ($item['id'] == $_POST['edit_id']) {
      $item['name'] = $_POST['name'];
      $item['price'] = (int)$_POST['price'];
      $item['stock'] = (int)$_POST['stock'];
      $item['category'] = $_POST['category'];
      break;
    }
  }
  unset($_POST);
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

// Ambil data yang ingin diedit (kalau ada)
if (isset($_GET['id'])) {
  foreach ($menu as $item) {
    if ($item['id'] == $_GET['id']) {
      $editItem = $item;
      break;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Data Barang</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
  <style>
    .btn-edit {
      margin-right: 5px;
    }
  </style>
</head>
<body>
<div class="container">
  <h2 class="text-center">Data Barang</h2>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Kategori</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($menu as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item["name"]) ?></td>
          <td>Rp. <?= number_format($item["price"], 0, ',', '.') ?></td>
          <td><?= $item["stock"] ?></td>
          <td><?= htmlspecialchars($item["category"]) ?></td>
          <td>
            <a href="?id=<?= $item["id"] ?>" class="btn btn-success btn-sm btn-edit">Edit</a>
            <a href="hapus_barang.php?id=<?= $item["id"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <?php if ($editItem): ?>
    <h3>Edit Barang: <?= htmlspecialchars($editItem['name']) ?></h3>
    <form method="post">
      <input type="hidden" name="edit_id" value="<?= $editItem['id'] ?>">
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" value="<?= htmlspecialchars($editItem['name']) ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Harga</label>
        <input type="number" name="price" value="<?= $editItem['price'] ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Stok</label>
        <input type="number" name="stock" value="<?= $editItem['stock'] ?>" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Kategori</label>
        <select name="category" class="form-control">
          <?php foreach (["Makanan Berat", "Camilan", "Minuman"] as $kategori): ?>
            <option value="<?= $kategori ?>" <?= $editItem['category'] == $kategori ? 'selected' : '' ?>>
              <?= $kategori ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
      <a href="data_barang.php" class="btn btn-default">Batal</a>
    </form>
  <?php endif; ?>
  <div class="mt-4">
    <a href="home.php" class="btn btn-primary">← Kembali ke Beranda</a>
  </div>


</div>
</body>
</html>
