<?php
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
</head>
<body>
  <h2>Selamat datang, Admin <?= $_SESSION['username'] ?></h2>
  <a href="logout.php">Logout</a>
</body>
</html>
