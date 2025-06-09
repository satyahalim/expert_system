<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

include 'koneksi.php';

// Get statistics
$total_gejala = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM gejala"))['count'];
$total_kondisi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM kondisi"))['count'];
$total_rules = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM know_base"))['count'];

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Sistem Pakar Somatotype</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    
    :root {
      --primary: #6C63FF;
      --secondary: #FF6584;
      --accent: #43CBFF;
      --dark: #2A2A3C;
      --light: #F8FAFC;
      --success: #01E08F;
      --warning: #FFA502;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--light);
      color: var(--dark);
    }
    
    .navbar {
      background: white;
      padding: 20px 40px;
      box-shadow: 0 2px 10px rgba(42, 42, 60, 0.1);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .logo {
      font-size: 24px;
      font-weight: 800;
      color: var(--primary);
    }
    
    .nav-right {
      display: flex;
      align-items: center;
      gap: 20px;
    }
    
    .admin-info {
      font-weight: 500;
    }
    
    .logout-btn {
      padding: 10px 20px;
      background-color: var(--secondary);
      color: white;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .logout-btn:hover {
      background-color: #E55571;
    }
    
    .container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 40px;
    }
    
    .page-title {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
      color: var(--dark);
    }
    
    .page-subtitle {
      color: #64748B;
      margin-bottom: 40px;
      font-size: 16px;
    }
    
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }
    
    .stat-card {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 5px 15px rgba(42, 42, 60, 0.08);
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    
    .stat-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(to right, var(--primary), var(--accent));
    }
    
    .stat-number {
      font-size: 36px;
      font-weight: 800;
      color: var(--primary);
      margin-bottom: 10px;
    }
    
    .stat-label {
      font-size: 16px;
      color: #64748B;
      font-weight: 500;
    }
    
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }
    
    .menu-card {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 5px 15px rgba(42, 42, 60, 0.08);
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
      position: relative;
      overflow: hidden;
    }
    
    .menu-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(42, 42, 60, 0.15);
    }
    
    .menu-card::before {
      content: "";
      position: absolute;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      top: -50px;
      right: -50px;
      opacity: 0.1;
      transition: all 0.3s ease;
    }
    
    .menu-card.gejala::before {
      background-color: var(--primary);
    }
    
    .menu-card.kondisi::before {
      background-color: var(--secondary);
    }
    
    .menu-card.knowledge::before {
      background-color: var(--accent);
    }
    
    .menu-icon {
      font-size: 48px;
      margin-bottom: 20px;
      display: block;
    }
    
    .menu-card.gejala .menu-icon {
      color: var(--primary);
    }
    
    .menu-card.kondisi .menu-icon {
      color: var(--secondary);
    }
    
    .menu-card.knowledge .menu-icon {
      color: var(--accent);
    }
    
    .menu-title {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 10px;
      color: var(--dark);
    }
    
    .menu-description {
      color: #64748B;
      line-height: 1.6;
    }
    
    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }
      
      .container {
        padding: 0 20px;
      }
      
      .nav-right {
        gap: 10px;
      }
      
      .admin-info {
        display: none;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="logo">FUFUFAFA Admin</div>
    <div class="nav-right">
      <span class="admin-info">Welcome, Admin</span>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="container">
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Kelola knowledge base sistem pakar somatotype</p>
    
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number"><?= $total_gejala ?></div>
        <div class="stat-label">Total Gejala</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= $total_kondisi ?></div>
        <div class="stat-label">Total Kondisi</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= $total_rules ?></div>
        <div class="stat-label">Total Rules</div>
      </div>
    </div>
    
    <div class="menu-grid">
      <a href="admin_gejala.php" class="menu-card gejala">
        <span class="menu-icon">🔍</span>
        <h3 class="menu-title">Kelola Gejala</h3>
        <p class="menu-description">Tambah, edit, atau hapus gejala/pertanyaan dalam sistem pakar</p>
      </a>
      
      <a href="admin_kondisi.php" class="menu-card kondisi">
        <span class="menu-icon">🎯</span>
        <h3 class="menu-title">Kelola Kondisi</h3>
        <p class="menu-description">Atur tipe tubuh dan deskripsi kondisi somatotype</p>
      </a>
      
      <a href="admin_knowledge.php" class="menu-card knowledge">
        <span class="menu-icon">🧠</span>
        <h3 class="menu-title">Knowledge Base</h3>
        <p class="menu-description">Kelola aturan dan nilai certainty factor untuk diagnosis</p>
      </a>
    </div>
  </div>
</body>
</html>