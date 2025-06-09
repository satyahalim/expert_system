<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

include 'koneksi.php';

$message = '';
$message_type = '';

// Handle form submissions
if ($_POST) {
    $action = $_POST['action'];
    
    if ($action === 'add') {
        $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        
        $query = "INSERT INTO kondisi (kondisi, deskripsi) VALUES ('$kondisi', '$deskripsi')";
        if (mysqli_query($conn, $query)) {
            $message = "Kondisi berhasil ditambahkan!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'edit') {
        $id_kondisi_tubuh = (int)$_POST['id_kondisi_tubuh'];
        $kondisi = mysqli_real_escape_string($conn, $_POST['kondisi']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
        
        $query = "UPDATE kondisi SET kondisi='$kondisi', deskripsi='$deskripsi' WHERE id_kondisi_tubuh=$id_kondisi_tubuh";
        if (mysqli_query($conn, $query)) {
            $message = "Kondisi berhasil diupdate!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'delete') {
        $id_kondisi_tubuh = (int)$_POST['id_kondisi_tubuh'];
        
        // First check if this condition is used in knowledge base
        $check_query = "SELECT COUNT(*) as count FROM know_base WHERE id_kondisi = $id_kondisi_tubuh";
        $check_result = mysqli_fetch_assoc(mysqli_query($conn, $check_query));
        
        if ($check_result['count'] > 0) {
            $message = "Tidak dapat menghapus kondisi karena masih digunakan dalam knowledge base!";
            $message_type = "error";
        } else {
            $query = "DELETE FROM kondisi WHERE id_kondisi_tubuh = $id_kondisi_tubuh";
            if (mysqli_query($conn, $query)) {
                $message = "Kondisi berhasil dihapus!";
                $message_type = "success";
            } else {
                $message = "Error: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    }
}

// Get all conditions
$kondisi_query = "SELECT * FROM kondisi ORDER BY kondisi";
$kondisi_result = mysqli_query($conn, $kondisi_query);

// Get edit data if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = "SELECT * FROM kondisi WHERE id_kondisi_tubuh = $edit_id";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Kondisi - Admin Sistem Pakar</title>
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
    
    .nav-links {
      display: flex;
      gap: 20px;
      align-items: center;
    }
    
    .nav-links a {
      text-decoration: none;
      color: var(--dark);
      font-weight: 500;
      padding: 8px 16px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .nav-links a:hover {
      background-color: var(--light);
    }
    
    .logout-btn {
      padding: 10px 20px;
      background-color: var(--secondary);
      color: white !important;
      border-radius: 8px;
    }
    
    .container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 40px;
    }
    
    .page-header {
      margin-bottom: 40px;
    }
    
    .page-title {
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
      color: var(--dark);
    }
    
    .page-subtitle {
      color: #64748B;
      font-size: 16px;
    }
    
    .message {
      padding: 15px 20px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-weight: 500;
    }
    
    .message.success {
      background-color: rgba(1, 224, 143, 0.1);
      color: var(--success);
      border: 1px solid rgba(1, 224, 143, 0.2);
    }
    
    .message.error {
      background-color: rgba(255, 71, 87, 0.1);
      color: var(--danger);
      border: 1px solid rgba(255, 71, 87, 0.2);
    }
    
    .card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 5px 15px rgba(42, 42, 60, 0.08);
      margin-bottom: 30px;
      overflow: hidden;
    }
    
    .card-header {
      padding: 25px 30px;
      border-bottom: 1px solid #E2E8F0;
      background-color: var(--light);
    }
    
    .card-title {
      font-size: 20px;
      font-weight: 700;
      color: var(--dark);
    }
    
    .card-content {
      padding: 30px;
    }
    
    .form-grid {
      display: grid;
      grid-template-columns: 400px 1fr;
      gap: 30px;
      align-items: start;
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
    
    input[type="text"], textarea {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #E2E8F0;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    
    input[type="text"]:focus, textarea:focus {
      outline: none;
      border-color: var(--primary);
    }
    
    textarea {
      min-height: 120px;
      resize: vertical;
      font-family: inherit;
    }
    
    .btn {
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      text-align: center;
    }
    
    .btn-primary {
      background-color: var(--primary);
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #5A52E0;
      transform: translateY(-2px);
    }
    
    .btn-secondary {
      background-color: #64748B;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #475569;
    }
    
    .btn-danger {
      background-color: var(--danger);
      color: white;
    }
    
    .btn-danger:hover {
      background-color: #E03E50;
    }
    
    .btn-sm {
      padding: 8px 16px;
      font-size: 12px;
    }
    
    .kondisi-card {
      background: white;
      border: 2px solid #E2E8F0;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }
    
    .kondisi-card:hover {
      border-color: var(--primary);
      box-shadow: 0 5px 15px rgba(108, 99, 255, 0.1);
    }
    
    .kondisi-header {
      display: flex;
      justify-content: between;
      align-items: center;
      margin-bottom: 15px;
    }
    
    .kondisi-name {
      font-size: 18px;
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 10px;
    }
    
    .kondisi-description {
      color: #64748B;
      line-height: 1.6;
      margin-bottom: 15px;
    }
    
    .kondisi-actions {
      display: flex;
      gap: 10px;
    }
    
    .somatotype-badges {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    
    .badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      color: white;
    }
    
    .badge.ecto {
      background-color: var(--primary);
    }
    
    .badge.meso {
      background-color: var(--secondary);
    }
    
    .badge.endo {
      background-color: var(--accent);
    }
    
    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }
      
      .container {
        padding: 0 20px;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }
      
      .nav-links {
        gap: 10px;
      }
      
      .nav-links a {
        padding: 6px 12px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="logo">FUFUFAFA Admin</div>
    <div class="nav-links">
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_gejala.php">Gejala</a>
      <a href="admin_kondisi.php" style="background-color: var(--secondary); color: white;">Kondisi</a>
      <a href="admin_knowledge.php">Knowledge Base</a>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Kelola Kondisi Tubuh</h1>
      <p class="page-subtitle">Atur tipe tubuh somatotype dan deskripsinya</p>
      
      <div class="somatotype-badges">
        <span class="badge ecto">Ectomorph</span>
        <span class="badge meso">Mesomorph</span>
        <span class="badge endo">Endomorph</span>
      </div>
    </div>
    
    <?php if ($message): ?>
      <div class="message <?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="form-grid">
      <!-- Form Section -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?= $edit_data ? 'Edit Kondisi' : 'Tambah Kondisi Baru' ?></h3>
        </div>
        <div class="card-content">
          <form method="POST">
            <input type="hidden" name="action" value="<?= $edit_data ? 'edit' : 'add' ?>">
            <?php if ($edit_data): ?>
              <input type="hidden" name="id_kondisi_tubuh" value="<?= $edit_data['id_kondisi_tubuh'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
              <label for="kondisi">Nama Kondisi/Tipe Tubuh</label>
              <input type="text" id="kondisi" name="kondisi" 
                     value="<?= $edit_data ? $edit_data['kondisi'] : '' ?>" 
                     placeholder="Contoh: Ectomorph" required>
            </div>
            
            <div class="form-group">
              <label for="deskripsi">Deskripsi Kondisi</label>
              <textarea id="deskripsi" name="deskripsi" 
                        placeholder="Deskripsi lengkap tentang tipe tubuh ini..." required><?= $edit_data ? $edit_data['deskripsi'] : '' ?></textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
              <button type="submit" class="btn btn-primary">
                <?= $edit_data ? 'Update Kondisi' : 'Tambah Kondisi' ?>
              </button>
              <?php if ($edit_data): ?>
                <a href="admin_kondisi.php" class="btn btn-secondary">Batal</a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>
      
      <!-- List Section -->
      <div>
        <h3 style="margin-bottom: 20px; color: var(--dark); font-weight: 700;">Daftar Kondisi Tubuh</h3>
        
        <?php while ($row = mysqli_fetch_assoc($kondisi_result)): ?>
        <div class="kondisi-card">
          <div class="kondisi-name"><?= $row['kondisi'] ?></div>
          <div class="kondisi-description"><?= substr($row['deskripsi'], 0, 200) ?>...</div>
          <div class="kondisi-actions">
            <a href="admin_kondisi.php?edit=<?= $row['id_kondisi_tubuh'] ?>" class="btn btn-secondary btn-sm">Edit</a>
            <form method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kondisi ini?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id_kondisi_tubuh" value="<?= $row['id_kondisi_tubuh'] ?>">
              <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
  
  <?php if (isset($_GET['logout'])): ?>
  <script>
    if (confirm('Yakin ingin logout?')) {
      window.location.href = 'admin_login.php';
    } else {
      window.location.href = 'admin_kondisi.php';
    }
  </script>
  <?php endif; ?>
</body>
</html>