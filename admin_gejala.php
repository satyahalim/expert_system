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
        $kode_gejala = mysqli_real_escape_string($conn, $_POST['kode_gejala']);
        $nama_gejala = mysqli_real_escape_string($conn, $_POST['nama_gejala']);
        
        $query = "INSERT INTO gejala (kode_gejala, nama_gejala) VALUES ('$kode_gejala', '$nama_gejala')";
        if (mysqli_query($conn, $query)) {
            $message = "Gejala berhasil ditambahkan!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'edit') {
        $id_gejala = (int)$_POST['id_gejala'];
        $kode_gejala = mysqli_real_escape_string($conn, $_POST['kode_gejala']);
        $nama_gejala = mysqli_real_escape_string($conn, $_POST['nama_gejala']);
        
        $query = "UPDATE gejala SET kode_gejala='$kode_gejala', nama_gejala='$nama_gejala' WHERE id_gejala=$id_gejala";
        if (mysqli_query($conn, $query)) {
            $message = "Gejala berhasil diupdate!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'delete') {
        $id_gejala = (int)$_POST['id_gejala'];
        
        // First check if this symptom is used in knowledge base
        $check_query = "SELECT COUNT(*) as count FROM know_base WHERE id_gejala = $id_gejala";
        $check_result = mysqli_fetch_assoc(mysqli_query($conn, $check_query));
        
        if ($check_result['count'] > 0) {
            $message = "Tidak dapat menghapus gejala karena masih digunakan dalam knowledge base!";
            $message_type = "error";
        } else {
            $query = "DELETE FROM gejala WHERE id_gejala = $id_gejala";
            if (mysqli_query($conn, $query)) {
                $message = "Gejala berhasil dihapus!";
                $message_type = "success";
            } else {
                $message = "Error: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    }
}

// Get all symptoms
$gejala_query = "SELECT * FROM gejala ORDER BY kode_gejala";
$gejala_result = mysqli_query($conn, $gejala_query);

// Get edit data if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = "SELECT * FROM gejala WHERE id_gejala = $edit_id";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Gejala - Admin Sistem Pakar</title>
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
      grid-template-columns: 1fr 2fr;
      gap: 20px;
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
      min-height: 100px;
      resize: vertical;
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
    
    .table-container {
      overflow-x: auto;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #E2E8F0;
    }
    
    th {
      background-color: var(--light);
      font-weight: 600;
      color: var(--dark);
    }
    
    .actions {
      display: flex;
      gap: 10px;
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
      <a href="admin_gejala.php" style="background-color: var(--primary); color: white;">Gejala</a>
      <a href="admin_kondisi.php">Kondisi</a>
      <a href="admin_knowledge.php">Knowledge Base</a>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="container">
    <div class="page-header">
      <h1 class="page-title">Kelola Gejala</h1>
      <p class="page-subtitle">Tambah, edit, atau hapus gejala/pertanyaan dalam sistem pakar</p>
    </div>
    
    <?php if ($message): ?>
      <div class="message <?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="form-grid">
      <!-- Form Section -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?= $edit_data ? 'Edit Gejala' : 'Tambah Gejala Baru' ?></h3>
        </div>
        <div class="card-content">
          <form method="POST">
            <input type="hidden" name="action" value="<?= $edit_data ? 'edit' : 'add' ?>">
            <?php if ($edit_data): ?>
              <input type="hidden" name="id_gejala" value="<?= $edit_data['id_gejala'] ?>">
            <?php endif; ?>
            
            <div class="form-group">
              <label for="kode_gejala">Kode Gejala</label>
              <input type="text" id="kode_gejala" name="kode_gejala" 
                     value="<?= $edit_data ? $edit_data['kode_gejala'] : '' ?>" 
                     placeholder="Contoh: G019" required>
            </div>
            
            <div class="form-group">
              <label for="nama_gejala">Pertanyaan/Gejala</label>
              <textarea id="nama_gejala" name="nama_gejala" 
                        placeholder="Masukkan pertanyaan gejala..." required><?= $edit_data ? $edit_data['nama_gejala'] : '' ?></textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
              <button type="submit" class="btn btn-primary">
                <?= $edit_data ? 'Update Gejala' : 'Tambah Gejala' ?>
              </button>
              <?php if ($edit_data): ?>
                <a href="admin_gejala.php" class="btn btn-secondary">Batal</a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>
      
      <!-- List Section -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Gejala</h3>
        </div>
        <div class="card-content">
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Gejala/Pertanyaan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($gejala_result)): ?>
                <tr>
                  <td><strong><?= $row['kode_gejala'] ?></strong></td>
                  <td><?= $row['nama_gejala'] ?></td>
                  <td>
                    <div class="actions">
                      <a href="admin_gejala.php?edit=<?= $row['id_gejala'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                      <form method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus gejala ini?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id_gejala" value="<?= $row['id_gejala'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php if (isset($_GET['logout'])): ?>
  <script>
    if (confirm('Yakin ingin logout?')) {
      window.location.href = 'admin_login.php';
    } else {
      window.location.href = 'admin_gejala.php';
    }
  </script>
  <?php endif; ?>
</body>
</html>