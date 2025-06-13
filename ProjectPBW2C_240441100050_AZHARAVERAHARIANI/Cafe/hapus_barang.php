<?php
session_start();
include 'barang.php'; // berisi array $menu

$id = $_GET['id'];
foreach ($menu as $key => $item) {
  if ($item['id'] == $id) {
    unset($menu[$key]);
    break;
  }
}

// Reindex array dan simpan ulang
$menu = array_values($menu);
$_SESSION['menu'] = $menu;

header("Location: barang.php");
exit;
