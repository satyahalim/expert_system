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
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    
    :root {
      --primary: #6C63FF;
      --secondary: #FF6584;
      --accent: #43CBFF;
      --dark: #2A2A3C;
      --light: #F8FAFC;
      --success: #01E08F;
      --danger: #FF4757;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Outfit', sans-serif;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--dark);
    }
    
    .login-container {
      background: white;
      border-radius: 24px;
      box-shadow: 0 20px 50px rgba(42, 42, 60, 0.2);
      padding: 40px;
      width: 100%;
      max-width: 400px;
      position: relative;
      overflow: hidden;
    }
    
    .login-container::before {
      content: "";
      position: absolute;
      width: 200px;
      height: 200px;
      background: linear-gradient(to right, var(--accent), var(--primary));
      border-radius: 50%;
      top: -100px;
      right: -100px;
      opacity: 0.1;
    }
    
    .logo {
      text-align: center;
      font-size: 28px;
      font-weight: 800;
      margin-bottom: 30px;
      color: var(--primary);
    }
    
    .login-title {
      text-align: center;
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 10px;
      color: var(--dark);
    }
    
    .login-subtitle {
      text-align: center;
      color: #64748B;
      margin-bottom: 30px;
      font-size: 14px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
    }
    
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 15px;
      border: 2px solid #E2E8F0;
      border-radius: 12px;
      font-size: 16px;
      transition: all 0.3s ease;
      background-color: var(--light);
    }
    
    input[type="text"]:focus, input[type="password"]:focus {
      outline: none;
      border-color: var(--primary);
      background-color: white;
    }
    
    .login-btn {
      width: 100%;
      padding: 15px;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .login-btn:hover {
      background-color: #5A52E0;
      transform: translateY(-2px);
    }
    
    .error {
      background-color: rgba(255, 71, 87, 0.1);
      color: var(--danger);
      padding: 15px;
      border-radius: 12px;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 500;
    }
    
    .back-link {
      text-align: center;
      margin-top: 20px;
    }
    
    .back-link a {
      color: var(--primary);
      text-decoration: none;
      font-weight: 500;
    }
    
    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
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