<?php  
include 'db.php';

$query = "SELECT * FROM checkout ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Order - Vera's Cafe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .badge-status {
            padding: 5px 10px;
            border-radius: 10px;
        }
        .badge-lunas { background-color: orange; color: white; }
        .badge-dikirim { background-color: green; color: white; }
        .badge-konfirmasi { background-color: blue; color: white; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand font-weight-bold" href="#">Eatzy Rasa Juara</a>
  <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active"><a class="nav-link" href="#">Beranda</a></li>
      <li class="nav-item"><a class="nav-link" href="barang.php">Barang</a></li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="#"><strong>Eatzy Juara Admin</strong></a></li>
      <li class="nav-item"><a class="nav-link" href="logout.php">Keluar</a></li>
    </ul>
  </div>
</nav>

<!-- Konten -->
<div class="container mt-5">
    <h2 class="mb-4">Daftar Order</h2>
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Alamat Pengiriman</th>
                <th>No Telepon</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $badge = '';
                if ($row['status'] == 'Lunas') $badge = 'badge-lunas';
                else if ($row['status'] == 'Barang Dikirim') $badge = 'badge-dikirim';
                else $badge = 'badge-konfirmasi';

                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>" . date('Y-m-d', strtotime($row['tanggal'])) . "</td>
                        <td>{$row['alamat']}</td>
                        <td>{$row['telepon']}</td>
                        <td><span class='badge badge-status $badge'>{$row['status']}</span></td>
                    </tr>";

                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

<!-- JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
