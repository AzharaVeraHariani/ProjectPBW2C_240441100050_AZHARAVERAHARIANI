<?php
session_start();
$id = $_GET['id'];
foreach ($_SESSION['cart'] as $key => $item) {
  if ($item['id'] == $id) {
    unset($_SESSION['cart'][$key]);
    break;
  }
}
$_SESSION['cart'] = array_values($_SESSION['cart']);
header("Location: view_cart.php");
?>
