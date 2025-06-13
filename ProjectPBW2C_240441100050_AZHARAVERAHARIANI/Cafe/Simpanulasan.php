<?php
session_start();

// Ambil data dari form
$ulasan = trim($_POST['ulasan'] ?? '');
$rating = intval($_POST['rating'] ?? 0);

// Validasi sederhana
if ($ulasan === '' || $rating < 1 || $rating > 5) {
    echo "<p>Ulasan dan rating wajib diisi!</p>";
    echo "<a href='index.php'>Kembali ke Beranda</a>";
    exit;
}

// Simpan ulasan ke file (alternatif: ke database)
$ulasanData = [
    'ulasan' => $ulasan,
    'rating' => $rating,
    'tanggal' => date('Y-m-d H:i:s')
];

$file = 'ulasan.json';
$existing = [];

if (file_exists($file)) {
    $existing = json_decode(file_get_contents($file), true);
}

$existing[] = $ulasanData;
file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT));

// Tampilkan halaman konfirmasi
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ulasan Terkirim</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 text-center">
  <h3>Terima kasih atas ulasan Anda! 😊</h3>
  <p>Rating: <?= str_repeat("⭐", $rating) ?></p>
  <blockquote class="blockquote">
    “<?= htmlspecialchars($ulasan) ?>”
  </blockquote>
  <a href="index.php" class="btn btn-success mt-3">Kembali ke Beranda</a>
</div>
</body>
</html>
