<?php 
session_start(); 
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$keterangan = $_POST['keterangan'] ?? '';

$item = [
  'id' => $id,
  'name' => $name,
  'price' => $price,
  'qty' => 1,
  'keterangan' => $keterangan
];

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

$found = false;
foreach ($_SESSION['cart'] as &$c) {
  if ($c['id'] == $id) {
    $c['qty']++;
    $found = true;
    break;
  }
}

if (!$found) $_SESSION['cart'][] = $item;

header('Location: view_cart.php');
?>
