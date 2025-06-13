<?php
session_start();
include 'db.php'; // pastikan file ini sudah benar dan koneksi ke DB berhasil

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $jumlah = isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : 1;

    // Ambil data barang dari database
    $query = mysqli_query($conn, "SELECT * FROM barang WHERE id = $id");
    $barang = mysqli_fetch_assoc($query);

    if ($barang) {
        $item = [
            'id' => $barang['id'],
            'name' => $barang['nama'],
            'qty' => $jumlah,
            'price' => $barang['harga'],
            'keterangan' => $barang['keterangan'] ?? ''
        ];

        // Cek apakah barang sudah ada di keranjang, kalau ada update qty-nya
        $found = false;
        foreach ($_SESSION['cart'] ?? [] as $index => $existing_item) {
            if ($existing_item['id'] == $id) {
                $_SESSION['cart'][$index]['qty'] += $jumlah;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }
    }

    // Redirect ke keranjang setelah menambahkan
    header("Location: keranjang.php");
    exit;
}
?>
