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
        $id_kondisi = (int)$_POST['id_kondisi'];
        $id_gejala = (int)$_POST['id_gejala'];
        $value_cf = (float)$_POST['value_cf'];
        
        // Check if rule already exists
        $check_query = "SELECT COUNT(*) as count FROM know_base WHERE id_kondisi = $id_kondisi AND id_gejala = $id_gejala";
        $check_result = mysqli_fetch_assoc(safe_query($check_query));
        
        if ($check_result['count'] > 0) {
            $message = "Rule sudah ada untuk kombinasi kondisi dan gejala ini!";
            $message_type = "error";
        } else {
            $query = "INSERT INTO know_base (id_kondisi, id_gejala, value_cf) VALUES ($id_kondisi, $id_gejala, $value_cf)";
            if (safe_query($query)) {
                $message = "Rule berhasil ditambahkan!";
                $message_type = "success";
            } else {
                $message = "Error: " . mysqli_error($conn);
                $message_type = "error";
            }
        }
    }
    
    if ($action === 'edit') {
        $id = (int)$_POST['id'];
        $id_kondisi = (int)$_POST['id_kondisi'];
        $id_gejala = (int)$_POST['id_gejala'];
        $value_cf = (float)$_POST['value_cf'];
        
        $query = "UPDATE know_base SET id_kondisi=$id_kondisi, id_gejala=$id_gejala, value_cf=$value_cf WHERE id=$id";
        if (safe_query($query)) {
            $message = "Rule berhasil diupdate!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
    
    if ($action === 'delete') {
        $id = (int)$_POST['id'];
        
        $query = "DELETE FROM know_base WHERE id = $id";
        if (safe_query($query)) {
            $message = "Rule berhasil dihapus!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
    }
}

// Get all knowledge base rules with condition and symptom names
$knowledge_query = "SELECT kb.id, kb.id_kondisi, kb.id_gejala, kb.value_cf, 
                           k.kondisi, g.kode_gejala, g.nama_gejala
                    FROM know_base kb
                    JOIN kondisi k ON kb.id_kondisi = k.id_kondisi_tubuh
                    JOIN gejala g ON kb.id_gejala = g.id_gejala
                    ORDER BY k.kondisi, g.kode_gejala";
$knowledge_result = safe_query($knowledge_query);

// Get all conditions for dropdown
$kondisi_options = safe_query("SELECT * FROM kondisi ORDER BY kondisi");

// Get all symptoms for dropdown  
$gejala_options = safe_query("SELECT * FROM gejala ORDER BY kode_gejala");

// Get edit data if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = "SELECT * FROM know_base WHERE id = $edit_id";
    $edit_result = safe_query($edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}

// Get matrix view data
$matrix_query = "SELECT kb.id_kondisi, k.kondisi, kb.id_gejala, g.kode_gejala, kb.value_cf
                 FROM know_base kb
                 JOIN kondisi k ON kb.id_kondisi = k.id_kondisi_tubuh
                 JOIN gejala g ON kb.id_gejala = g.id_gejala
                 ORDER BY k.kondisi, g.kode_gejala";
$matrix_result = safe_query($matrix_query);

$matrix_data = [];
while ($row = mysqli_fetch_assoc($matrix_result)) {
    $matrix_data[$row['kondisi']][$row['kode_gejala']] = $row['value_cf'];
}

$all_conditions = safe_query("SELECT * FROM kondisi ORDER BY kondisi");
$all_symptoms = safe_query("SELECT * FROM gejala ORDER BY kode_gejala");

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
  <title>Knowledge Base - Admin Sistem Pakar</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="column-container">
  <nav class="navbar">
    <div class="logo">FUFUFAFA Admin</div>
    <div class="nav-links">
      <a href="admin_dashboard.php">Dashboard</a>
      <a href="admin_gejala.php">Gejala</a>
      <a href="admin_kondisi.php">Kondisi</a>
      <a href="admin_knowledge.php" class="active">Knowledge Base</a>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="main-content knowledge">
    <div class="page-header">
      <h1 class="page-title">Knowledge Base Management</h1>
      <p class="page-subtitle">Kelola aturan dan nilai certainty factor untuk diagnosis</p>
    </div>
    
    <?php if ($message): ?>
      <div class="message <?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>
    
    <div class="tabs">
      <button class="tab active" onclick="showTab('rules')">Rules Management</button>
      <button class="tab" onclick="showTab('matrix')">Matrix View</button>
    </div>
    
    <!-- Rules Management Tab -->
    <div id="rules" class="tab-content active">
      <div class="form-grid admin">
        <!-- Form Section -->
        <div class="card admin">
          <div class="card-header">
            <h3 class="card-title admin"><?= $edit_data ? 'Edit Rule' : 'Tambah Rule Baru' ?></h3>
          </div>
          <div class="card-content">
            <form method="POST">
              <input type="hidden" name="action" value="<?= $edit_data ? 'edit' : 'add' ?>">
              <?php if ($edit_data): ?>
                <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
              <?php endif; ?>
              
              <div class="form-group">
                <label for="id_kondisi">Kondisi/Tipe Tubuh</label>
                <select id="id_kondisi" name="id_kondisi" required>
                  <option value="">Pilih Kondisi</option>
                  <?php
                  mysqli_data_seek($kondisi_options, 0);
                  while ($kondisi = mysqli_fetch_assoc($kondisi_options)): ?>
                    <option value="<?= $kondisi['id_kondisi_tubuh'] ?>" 
                            <?= ($edit_data && $edit_data['id_kondisi'] == $kondisi['id_kondisi_tubuh']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($kondisi['kondisi']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              
              <div class="form-group">
                <label for="id_gejala">Gejala</label>
                <select id="id_gejala" name="id_gejala" required>
                  <option value="">Pilih Gejala</option>
                  <?php
                  mysqli_data_seek($gejala_options, 0);
                  while ($gejala = mysqli_fetch_assoc($gejala_options)): ?>
                    <option value="<?= $gejala['id_gejala'] ?>" 
                            <?= ($edit_data && $edit_data['id_gejala'] == $gejala['id_gejala']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($gejala['kode_gejala']) ?> - <?= htmlspecialchars(substr($gejala['nama_gejala'], 0, 30)) ?>...
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              
              <div class="form-group">
                <label for="value_cf">Certainty Factor (0.0 - 1.0)</label>
                <input type="number" id="value_cf" name="value_cf" step="0.1" min="0.0" max="1.0" 
                       value="<?= $edit_data ? $edit_data['value_cf'] : '' ?>" 
                       placeholder="0.8" required>
                <small style="color: #64748B; font-size: 12px;">
                  0.1-0.3: Rendah, 0.4-0.7: Sedang, 0.8-1.0: Tinggi
                </small>
              </div>
              
              <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                  <?= $edit_data ? 'Update Rule' : 'Tambah Rule' ?>
                </button>
                <?php if ($edit_data): ?>
                  <a href="admin_knowledge.php" class="btn btn-secondary">Batal</a>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
        
        <!-- List Section -->
        <div class="card admin">
          <div class="card-header">
            <h3 class="card-title admin">Daftar Rules</h3>
          </div>
          <div class="card-content">
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Kondisi</th>
                    <th>Kode Gejala</th>
                    <th>CF Value</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  mysqli_data_seek($knowledge_result, 0);
                  while ($row = mysqli_fetch_assoc($knowledge_result)): 
                    $cf_class = $row['value_cf'] >= 0.8 ? 'cf-high' : ($row['value_cf'] >= 0.4 ? 'cf-medium' : 'cf-low');
                  ?>
                  <tr>
                    <td><strong><?= htmlspecialchars($row['kondisi']) ?></strong></td>
                    <td><?= htmlspecialchars($row['kode_gejala']) ?></td>
                    <td>
                      <span class="cf-value <?= $cf_class ?>"><?= $row['value_cf'] ?></span>
                    </td>
                    <td>
                      <div class="actions">
                        <a href="admin_knowledge.php?edit=<?= $row['id'] ?>" class="btn btn-secondary btn-sm">Edit</a>
                        <form method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus rule ini?')">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="id" value="<?= $row['id'] ?>">
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
    
    <!-- Matrix View Tab -->
    <div id="matrix" class="tab-content">
      <div class="card admin">
        <div class="card-header">
          <h3 class="card-title admin">Knowledge Base Matrix</h3>
          <p style="color: #64748B; margin-top: 5px;">Matrix menampilkan nilai CF untuk setiap kombinasi kondisi dan gejala</p>
        </div>
        <div class="card-content">
          <div class="table-container">
            <table class="matrix-table">
              <thead>
                <tr>
                  <th class="condition-name">Kondisi / Gejala</th>
                  <?php
                  mysqli_data_seek($all_symptoms, 0);
                  while ($symptom = mysqli_fetch_assoc($all_symptoms)): ?>
                    <th><?= htmlspecialchars($symptom['kode_gejala']) ?></th>
                  <?php endwhile; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                mysqli_data_seek($all_conditions, 0);
                while ($condition = mysqli_fetch_assoc($all_conditions)): ?>
                <tr>
                  <td class="condition-name"><?= htmlspecialchars($condition['kondisi']) ?></td>
                  <?php
                  mysqli_data_seek($all_symptoms, 0);
                  while ($symptom = mysqli_fetch_assoc($all_symptoms)):
                    $cf_value = isset($matrix_data[$condition['kondisi']][$symptom['kode_gejala']]) 
                              ? $matrix_data[$condition['kondisi']][$symptom['kode_gejala']] 
                              : null;
                  ?>
                    <td class="cf-cell <?= $cf_value ? '' : 'empty' ?>">
                      <?= $cf_value ? $cf_value : '-' ?>
                    </td>
                  <?php endwhile; ?>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    function showTab(tabName) {
      // Hide all tab contents
      document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
      });
      
      // Remove active class from all tabs
      document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
      });
      
      // Show selected tab content
      document.getElementById(tabName).classList.add('active');
      
      // Add active class to clicked tab
      event.target.classList.add('active');
    }
  </script>
</body>
</html>