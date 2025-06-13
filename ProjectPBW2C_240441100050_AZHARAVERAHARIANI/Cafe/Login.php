<?php 
session_start();
include 'db.php'; // Pastikan file ini ada dan benar

$error = '';

if (isset($_POST['Login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Login sebagai admin
  if ($username === 'admin' && $password === '12345') {
    $_SESSION['Login'] = true;
    $_SESSION['username'] = 'admin';
    header("Location: home.php");
    exit;
  }

  // Login sebagai user
  if ($username === 'user' && $password === '12345') {
    $_SESSION['Login'] = true;
    $_SESSION['username'] = 'user';
    header("Location: index.php");
    exit;
  }

  // Jika tidak sesuai
  $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Eatzy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-header bg-danger text-white text-center">
            <h4>Login</h4>
          </div>
          <div class="card-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="post">
              <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" name="Login" class="btn btn-danger w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
