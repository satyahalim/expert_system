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
        $kode_gejala = sanitize_input($_POST['kode_gejala']);
        $nama_gejala = sanitize_input($_POST['nama_gejala']);
        
        $query = "INSERT INTO gejala (kode_gejala, nama_gejala) VALUES ('$kode_gejala', '$nama_gejala')";
        if (safe_query($query)) {
            $message = "Gejala berhasil ditambahkan!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'edit') {
        $id_gejala = (int)$_POST['id_gejala'];
        $kode_gejala = sanitize_input($_POST['kode_gejala']);
        $nama_gejala = sanitize_input($_POST['nama_gejala']);
        
        $query = "UPDATE gejala SET kode_gejala='$kode_gejala', nama_gejala='$nama_gejala' WHERE id_gejala=$id_gejala";
        if (safe_query($query)) {
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
        $check_result = mysqli_fetch_assoc(safe_query($check_query));
        
        if ($check_result['count'] > 0) {
            $message = "Tidak dapat menghapus gejala karena masih digunakan dalam knowledge base!";
            $message_type = "error";
        } else {
            $query = "DELETE FROM gejala WHERE id_gejala = $id_gejala";
            if (safe_query($query)) {
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
$gejala_result = safe_query($gejala_query);

// Get edit data if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = "SELECT * FROM gejala WHERE id_gejala = $edit_id";
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
  <title>Kelola Gejala - Admin Sistem Pakar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="column-container">
  <nav class="navbar">
    <div class="logo">FUFUFAFA Admin</div>
    <div class="nav-links">
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_gejala.php" class="active">Gejala</a>
      <a href="admin_kondisi.php">Kondisi</a>
      <a href="admin_knowledge.php">Knowledge Base</a>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="main-content admin">
    <div class="page-header">
      <h1 class="page-title">Kelola Gejala</h1>
      <p class="page-subtitle">Tambah, edit, atau hapus gejala/pertanyaan dalam sistem pakar</p>
    </div>
    
    <?php if ($message): ?>
      <div class="message <?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="form-grid admin">
      <!-- Form Section -->
      <div class="card admin">
        <div class="card-header">
          <h3 class="card-title admin"><?= $edit_data ? 'Edit Gejala' : 'Tambah Gejala Baru' ?></h3>
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
                     value="<?= $edit_data ? htmlspecialchars($edit_data['kode_gejala']) : '' ?>" 
                     placeholder="Contoh: G019" required>
            </div>
            
            <div class="form-group">
              <label for="nama_gejala">Pertanyaan/Gejala</label>
              <textarea id="nama_gejala" name="nama_gejala" 
                        placeholder="Masukkan pertanyaan gejala..." required><?= $edit_data ? htmlspecialchars($edit_data['nama_gejala']) : '' ?></textarea>
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
      <div class="card admin">
        <div class="card-header">
          <h3 class="card-title admin">Daftar Gejala</h3>
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
                  <td><strong><?= htmlspecialchars($row['kode_gejala']) ?></strong></td>
                  <td><?= htmlspecialchars($row['nama_gejala']) ?></td>
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
</body>
</html>