<?php
session_start();
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $role = $_POST['role']; // 'admin' atau 'pembeli'

    // Validasi input
    if (empty($username) || empty($password)) {
        $message = "Username dan password harus diisi.";
    } elseif (!in_array($role, ['admin', 'pembeli'])) {
        $message = "Role tidak valid.";
    } else {
        // Cek apakah username sudah ada
        $stmt = mysqli_prepare($conn, "SELECT id FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "Username sudah digunakan.";
        } else {
            // Simpan user baru
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $insertStmt = mysqli_prepare($conn, "INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($insertStmt, "sss", $username, $hashedPass, $role);

            if (mysqli_stmt_execute($insertStmt)) {
                $message = "Registrasi berhasil! <a href='login.php'>Login di sini</a>.";
            } else {
                $message = "Gagal mendaftar: " . mysqli_error($conn);
            }

            mysqli_stmt_close($insertStmt);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Registrasi User - Vera's Cafe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
  <h2 class="mb-4">Registrasi User</h2>

  <?php if ($message): ?>
    <div class="alert alert-info"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" name="username" id="username" required />
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" id="password" required />
    </div>

    <div class="mb-3">
      <label class="form-label">Pilih Peran</label>
      <select class="form-select" name="role" required>
        <option value="pembeli" selected>Pembeli</option>
        <option value="admin">Admin / Penjual</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">Daftar</button>
  </form>

  <p class="mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>

</body>
</html>
