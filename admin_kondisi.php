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
        $kondisi = sanitize_input($_POST['kondisi']);
        $deskripsi = sanitize_input($_POST['deskripsi']);
        
        // Generate kode_kondisi automatically
        $kode_kondisi = 'K' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        
        $query = "INSERT INTO kondisi (kode_kondisi, kondisi, deskripsi) VALUES ('$kode_kondisi', '$kondisi', '$deskripsi')";
        if (safe_query($query)) {
            $message = "Kondisi berhasil ditambahkan!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'edit') {
        $id_kondisi_tubuh = (int)$_POST['id_kondisi_tubuh'];
        $kondisi = sanitize_input($_POST['kondisi']);
        $deskripsi = sanitize_input($_POST['deskripsi']);
        
        $query = "UPDATE kondisi SET kondisi='$kondisi', deskripsi='$deskripsi' WHERE id_kondisi_tubuh=$id_kondisi_tubuh";
        if (safe_query($query)) {
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
        $check_result = mysqli_fetch_assoc(safe_query($check_query));
        
        if ($check_result['count'] > 0) {
            $message = "Tidak dapat menghapus kondisi karena masih digunakan dalam knowledge base!";
            $message_type = "error";
        } else {
            $query = "DELETE FROM kondisi WHERE id_kondisi_tubuh = $id_kondisi_tubuh";
            if (safe_query($query)) {
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
$kondisi_result = safe_query($kondisi_query);

// Get edit data if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = "SELECT * FROM kondisi WHERE id_kondisi_tubuh = $edit_id";
    $edit_result = safe_query($edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}

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
  <title>Kelola Kondisi - Admin Sistem Pakar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="column-container">
  <nav class="navbar">
    <div class="logo">FUFUFAFA Admin</div>
    <div class="nav-links">
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_gejala.php">Gejala</a>
      <a href="admin_kondisi.php" class="active">Kondisi</a>
      <a href="admin_knowledge.php">Knowledge Base</a>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="main-content admin">
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
    
    <div class="form-grid admin">
      <!-- Form Section -->
      <div class="card admin">
        <div class="card-header">
          <h3 class="card-title admin"><?= $edit_data ? 'Edit Kondisi' : 'Tambah Kondisi Baru' ?></h3>
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
                     value="<?= $edit_data ? htmlspecialchars($edit_data['kondisi']) : '' ?>" 
                     placeholder="Contoh: Ectomorph" required>
            </div>
            
            <div class="form-group">
              <label for="deskripsi">Deskripsi Kondisi</label>
              <textarea id="deskripsi" name="deskripsi" 
                        placeholder="Deskripsi lengkap tentang tipe tubuh ini..." required><?= $edit_data ? htmlspecialchars($edit_data['deskripsi']) : '' ?></textarea>
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
          <div class="kondisi-name"><?= htmlspecialchars($row['kondisi']) ?></div>
          <div class="kondisi-description"><?= htmlspecialchars(substr($row['deskripsi'], 0, 200)) ?>...</div>
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
</body>
</html>