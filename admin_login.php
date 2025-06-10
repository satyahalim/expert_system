<?php
session_start();

// Simple admin credentials (in production, use proper authentication)
$admin_username = "admin";
$admin_password = "admin123";

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Sistem Pakar Somatotype</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="column-container" style="background: linear-gradient(135deg, var(--primary), var(--accent)); justify-content: center; align-items: center;">
  <div class="login-container">
    <div class="logo">FUFUFAFA</div>
    <h1 class="login-title">Admin Login</h1>
    <p class="login-subtitle">Masuk untuk mengelola knowledge base</p>
    
    <?php if (isset($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    
    <form method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      
      <button type="submit" class="login-btn">Masuk</button>
    </form>
    
    <div class="back-link">
      <a href="index.php">← Kembali ke Beranda</a>
    </div>
  </div>
</body>
</html>