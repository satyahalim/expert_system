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
        $check_result = mysqli_fetch_assoc(mysqli_query($conn, $check_query));
        
        if ($check_result['count'] > 0) {
            $message = "Rule sudah ada untuk kombinasi kondisi dan gejala ini!";
            $message_type = "error";
        } else {
            $query = "INSERT INTO know_base (id_kondisi, id_gejala, value_cf) VALUES ($id_kondisi, $id_gejala, $value_cf)";
            if (mysqli_query($conn, $query)) {
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
        if (mysqli_query($conn, $query)) {
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
        if (mysqli_query($conn, $query)) {
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
$knowledge_result = mysqli_query($conn, $knowledge_query);

// Get all conditions for dropdown
$kondisi_options = mysqli_query($conn, "SELECT * FROM kondisi ORDER BY kondisi");

// Get all symptoms for dropdown  
$gejala_options = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kode_gejala");

// Get edit data if editing
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = "SELECT * FROM know_base WHERE id = $edit_id";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}

// Get matrix view data
$matrix_query = "SELECT kb.id_kondisi, k.kondisi, kb.id_gejala, g.kode_gejala, kb.value_cf
                 FROM know_base kb
                 JOIN kondisi k ON kb.id_kondisi = k.id_kondisi_tubuh
                 JOIN gejala g ON kb.id_gejala = g.id_gejala
                 ORDER BY k.kondisi, g.kode_gejala";
$matrix_result = mysqli_query($conn, $matrix_query);

$matrix_data = [];
while ($row = mysqli_fetch_assoc($matrix_result)) {
    $matrix_data[$row['kondisi']][$row['kode_gejala']] = $row['value_cf'];
}

$all_conditions = mysqli_query($conn, "SELECT * FROM kondisi ORDER BY kondisi");
$all_symptoms = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kode_gejala");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Knowledge Base - Admin Sistem Pakar</title>
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
      max-width: 1400px;
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
    
    .tabs {
      display: flex;
      gap: 20px;
      margin-bottom: 30px;
      border-bottom: 2px solid #E2E8F0;
    }
    
    .tab {
      padding: 15px 25px;
      background: none;
      border: none;
      font-size: 16px;
      font-weight: 600;
      color: #64748B;
      cursor: pointer;
      border-bottom: 3px solid transparent;
      transition: all 0.3s ease;
    }
    
    .tab.active {
      color: var(--primary);
      border-bottom-color: var(--primary);
    }
    
    .tab-content {
      display: none;
    }
    
    .tab-content.active {
      display: block;
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
    
    select, input[type="number"] {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #E2E8F0;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    
    select:focus, input[type="number"]:focus {
      outline: none;
      border-color: var(--primary);
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
      max-height: 500px;
      overflow-y: auto;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }
    
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #E2E8F0;
    }
    
    th {
      background-color: var(--light);
      font-weight: 600;
      color: var(--dark);
      position: sticky;
      top: 0;
    }
    
    .cf-value {
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: 600;
      color: white;
      font-size: 12px;
    }
    
    .cf-high {
      background-color: var(--success);
    }
    
    .cf-medium {
      background-color: var(--warning);
    }
    
    .cf-low {
      background-color: var(--secondary);
    }
    
    .actions {
      display: flex;
      gap: 5px;
    }
    
    .matrix-table {
      font-size: 12px;
    }
    
    .matrix-table th {
      writing-mode: vertical-lr;
      text-orientation: mixed;
      padding: 8px 4px;
      min-width: 60px;
      max-width: 60px;
    }
    
    .matrix-table td {
      text-align: center;
      padding: 8px 4px;
      min-width: 60px;
      max-width: 60px;
    }
    
    .matrix-table .condition-name {
      writing-mode: horizontal-tb;
      font-weight: 700;
      background-color: var(--primary);
      color: white;
      min-width: 120px;
    }
    
    .cf-cell {
      background-color: #f8f9fa;
      color: var(--dark);
      font-weight: 600;
    }
    
    .cf-cell.empty {
      background-color: #fff;
      color: #ccc;
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
      
      .tabs {
        gap: 10px;
      }
      
      .tab {
        padding: 10px 15px;
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
      <a href="admin_kondisi.php">Kondisi</a>
      <a href="admin_knowledge.php" style="background-color: var(--accent); color: white;">Knowledge Base</a>
      <a href="?logout=1" class="logout-btn">Logout</a>
    </div>
  </nav>
  
  <div class="container">
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
      <div class="form-grid">
        <!-- Form Section -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><?= $edit_data ? 'Edit Rule' : 'Tambah Rule Baru' ?></h3>
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
                      <?= $kondisi['kondisi'] ?>
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
                      <?= $gejala['kode_gejala'] ?> - <?= substr($gejala['nama_gejala'], 0, 30) ?>...
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
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Daftar Rules</h3>
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
                    <td><strong><?= $row['kondisi'] ?></strong></td>
                    <td><?= $row['kode_gejala'] ?></td>
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
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Knowledge Base Matrix</h3>
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
                    <th><?= $symptom['kode_gejala'] ?></th>
                  <?php endwhile; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                mysqli_data_seek($all_conditions, 0);
                while ($condition = mysqli_fetch_assoc($all_conditions)): ?>
                <tr>
                  <td class="condition-name"><?= $condition['kondisi'] ?></td>
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
  
  <?php if (isset($_GET['logout'])): ?>
  <script>
    if (confirm('Yakin ingin logout?')) {
      window.location.href = 'admin_login.php';
    } else {
      window.location.href = 'admin_knowledge.php';
    }
  </script>
  <?php endif; ?>
</body>
</html>