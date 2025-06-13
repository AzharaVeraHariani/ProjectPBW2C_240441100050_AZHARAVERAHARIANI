<?php include 'db.php'; session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Tambah Menu Baru</h2>
  <form method="POST" action="cart_handler.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="create">
    <div class="mb-3">
      <label class="form-label">Nama Menu</label>
      <input type="text" class="form-control" name="name" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea class="form-control" name="description"></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" class="form-control" name="price" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="kategori" class="form-select" required>
        <option value="makanan">Makanan</option>
        <option value="minuman">Minuman</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Upload Gambar</label>
      <input type="file" class="form-control" name="image" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
