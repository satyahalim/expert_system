<?php
session_start();

// If no results exist, redirect back to the survey
if (!isset($_SESSION['cf_kondisi']) || empty($_SESSION['cf_kondisi'])) {
    header('Location: survey.php');
    exit;
}

include 'koneksi.php';

$cf_kondisi = $_SESSION['cf_kondisi'];

$hasil_utama_id = key($cf_kondisi);
$nilai_utama = current($cf_kondisi);

// Sort conditions by CF value (descending)
uasort($cf_kondisi, function($a, $b) {
    return $b['nilai'] <=> $a['nilai'];
});

// Get the highest CF condition
$highest_kondisi_id = key($cf_kondisi);
$highest_cf = reset($cf_kondisi)['nilai'];

// Get condition details
$kondisi_query = mysqli_query($conn, "SELECT * FROM kondisi WHERE id_kondisi_tubuh = $highest_kondisi_id");
$kondisi_data = mysqli_fetch_assoc($kondisi_query);

// Function to convert CF to percentage
function cfToPercentage($cf) {
    return round($cf * 100);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Analisis Somatotype</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    
    :root {
      --primary: #6C63FF;
      --secondary: #FF6584;
      --accent: #43CBFF;
      --dark: #2A2A3C;
      --light: #F8FAFC;
      --success: #01E08F;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html, body {
      height: 100%;
      margin: 0;
    }
    
    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
      padding: 0;
    }
    
    .container {
      display: flex;
      width: 100%;
      min-height: 100vh;
    }
    
    .sidebar {
      width: 30%;
      background-color: var(--primary);
      display: flex;
      flex-direction: column;
      padding: 40px;
      position: relative;
      overflow: hidden;
      color: white;
    }
    
    .sidebar::before {
      content: "";
      position: absolute;
      width: 200%;
      height: 200%;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,0.05)' fill-rule='evenodd'/%3E%3C/svg%3E");
      top: -50%;
      left: -50%;
      opacity: 0.4;
      z-index: 0;
    }
    
    .logo {
      font-size: 28px;
      font-weight: 800;
      margin-bottom: 60px;
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
    }
    
    .logo::before {
      content: "";
      display: inline-block;
      width: 18px;
      height: 18px;
      background-color: var(--secondary);
      margin-right: 10px;
      border-radius: 4px;
      transform: rotate(45deg);
    }
    
    .sidebar-content {
      position: relative;
      z-index: 1;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    
    .sidebar-top {
      margin-bottom: auto;
    }
    
    .sidebar h2 {
      font-size: 42px;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 20px;
    }
    
    .tagline {
      font-size: 16px;
      font-weight: 400;
      opacity: 0.8;
      line-height: 1.6;
      margin-bottom: 40px;
    }
    
    .features {
      margin-top: 40px;
    }
    
    .feature {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .feature-icon {
      min-width: 40px;
      height: 40px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }
    
    .feature-text {
      font-size: 14px;
      font-weight: 500;
    }
    
    .main-content {
      width: 70%;
      padding: 40px;
      overflow-y: auto; /* Enable vertical scrolling */
      height: 100vh; /* Set height to viewport height */
    }
    
    .card {
      background: white;
      border-radius: 24px;
      box-shadow: 0 20px 50px rgba(42, 42, 60, 0.08);
      padding: 40px;
      width: 100%;
      max-width: 800px;
      position: relative;
      overflow: hidden;
      margin-bottom: 30px;
      margin-left: auto;
      margin-right: auto;
    }
    
    .card::before {
      content: "";
      position: absolute;
      width: 300px;
      height: 300px;
      background: linear-gradient(to right, var(--accent), var(--primary));
      border-radius: 50%;
      top: -150px;
      right: -150px;
      opacity: 0.1;
      pointer-events: none; /* Ensure this doesn't block scrolling */
    }
    
    .card::after {
      content: "";
      position: absolute;
      width: 200px;
      height: 200px;
      background: linear-gradient(to right, var(--secondary), var(--accent));
      border-radius: 50%;
      bottom: -100px;
      left: -100px;
      opacity: 0.1;
      pointer-events: none; /* Ensure this doesn't block scrolling */
    }
    
    .header {
      margin-bottom: 30px;
      text-align: center;
    }
    
    .eyebrow {
      text-transform: uppercase;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 1px;
      color: var(--primary);
      margin-bottom: 10px;
    }
    
    .card-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 15px;
      color: var(--dark);
    }
    
    .result-box {
      margin: 20px 0;
      padding: 25px;
      border-radius: 16px;
      background-color: var(--primary);
      color: white;
      text-align: center;
    }
    
    .result-box h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }
    
    .result-box p {
      font-size: 18px;
      font-weight: 600;
    }
    
    .description {
      text-align: left;
      padding: 25px;
      margin: 20px 0;
      background-color: var(--light);
      border-radius: 16px;
    }
    
    .description h3 {
      color: var(--dark);
      margin-bottom: 15px;
      font-size: 20px;
      font-weight: 600;
    }
    
    .description p {
      margin-bottom: 15px;
      line-height: 1.6;
    }
    
    .description ul {
      padding-left: 20px;
      margin-bottom: 15px;
    }
    
    .description li {
      margin-bottom: 8px;
      line-height: 1.5;
    }
    
    .recommendations {
      text-align: left;
      padding: 25px;
      margin: 20px 0;
      background-color: var(--light);
      border-radius: 16px;
    }
    
    .recommendations h3 {
      color: var(--dark);
      margin-bottom: 15px;
      font-size: 20px;
      font-weight: 600;
    }
    
    .recommendations ul {
      padding-left: 20px;
    }
    
    .recommendations li {
      margin-bottom: 8px;
      line-height: 1.5;
    }
    
    .other-results {
      margin-top: 30px;
      text-align: left;
      width: 100%;
    }
    
    .other-results h3 {
      color: var(--dark);
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: 600;
    }
    
    .other-results p {
      margin-bottom: 5px;
      font-weight: 500;
    }
    
    .progress-bar {
      width: 100%;
      background-color: #E2E8F0;
      border-radius: 12px;
      margin: 10px 0 20px 0;
      overflow: hidden;
    }
    
    .progress {
      height: 24px;
      border-radius: 12px;
      background-color: var(--primary);
      text-align: right;
      padding-right: 15px;
      color: white;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      font-weight: 500;
      font-size: 14px;
      transition: width 0.8s ease;
    }
    
    .back-button {
      padding: 15px 30px;
      border: none;
      border-radius: 14px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      background-color: var(--primary);
      color: white;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      margin-top: 20px;
      margin-bottom: 20px;
    }
    
    .back-button:hover {
      background-color: #5A52E0;
      transform: translateY(-2px);
    }
    
    .dots {
      position: absolute;
      bottom: 30px;
      right: 30px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 5px;
      opacity: 0.5;
    }
    
    .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background-color: white;
    }
    
    @media (max-width: 1024px) {
      .container {
        flex-direction: column;
        height: auto;
      }
      
      .sidebar {
        width: 100%;
        padding: 30px;
        min-height: auto;
        height: auto;
      }
      
      .main-content {
        width: 100%;
        padding: 30px;
        height: auto;
        overflow-y: visible;
      }
      
      .sidebar h2 {
        font-size: 32px;
      }
      
      .features {
        display: none;
      }
      
      .card {
        padding: 30px;
      }
    }
    
    @media (max-width: 640px) {
      .sidebar {
        padding: 20px;
      }
      
      .logo {
        margin-bottom: 30px;
      }
      
      .card {
        padding: 25px 20px;
      }
      
      .card-title {
        font-size: 24px;
      }
      
      .result-box, .description, .recommendations {
        padding: 20px;
      }

        .funny-image-card {
  background-color: white;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  padding: 25px;
  text-align: center;
  margin-top: 40px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.funny-img {
  display: block;         /* supaya bisa diatur marginnya */
  margin: 0 auto 15px;    /* center horizontal + bottom spacing */
  max-width: 300px;       /* batas lebar maksimal */
  width: 100%;            /* fleksibel */
  height: auto;           /* biar tidak terdistorsi */
  border-radius: 16px;
  object-fit: contain;
}
    }
  </style>
</head>
<body>
  <div class="container">
    <section class="sidebar">
      <div class="logo">FUFUFAFA</div>
      
      <div class="sidebar-content">
        <div class="sidebar-top">
          <h2>Hasil Analisis Somatotype Anda</h2>
          <p class="tagline">Sistem pakar telah menganalisis karakteristik tubuh Anda berdasarkan jawaban yang diberikan.</p>
        </div>
        
        <div class="features">
          <div class="feature">
            <div class="feature-icon">✓</div>
            <div class="feature-text">Analisis berbasis data antropometrik</div>
          </div>
          <div class="feature">
            <div class="feature-icon">✓</div>
            <div class="feature-text">Rekomendasi latihan yang dipersonalisasi</div>
          </div>
          <div class="feature">
            <div class="feature-icon">✓</div>
            <div class="feature-text">Panduan nutrisi berdasarkan metabolisme</div>
          </div>
        </div>
      </div>
      
      <div class="dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </section>
    
    <section class="main-content">
      <div class="card">
        <header class="header">
          <div class="eyebrow">Sistem Pakar</div>
          <h1 class="card-title">Hasil Analisis Somatotype</h1>
        </header>
        
        <div class="result-box">
          <h2>Tipe tubuh Anda adalah: <?php echo $kondisi_data['kondisi']; ?></h2>
          <p>Tingkat Keyakinan: <?php echo cfToPercentage($highest_cf); ?>%</p>
        </div>
        
        <div class="funny-image-card">
        <?php if ($kondisi_data['kondisi'] == "Endomorph") { ?> 
          <img src="./uploads/endomorph.jpg" alt="endomorph" class="funny-img">
        <?php } elseif ($kondisi_data['kondisi'] == "Ectomorph") { ?>
          <img src="./uploads/ectomorph.jpg" alt="ectomorph" class="funny-img">
        <?php } else { ?>
          <img src="./uploads/mesomorph.jpg" alt="mesomorph" class="funny-img">
        <?php } ?>
      </div>

        <div class="description">
          <h3>Deskripsi:</h3>
          <p><?php echo $kondisi_data['deskripsi']; ?></p>
          
          <h3>Gejala yang Anda pilih yang menunjukkan tipe ini:</h3>
          <ul>
            <?php 
              // Display symptoms that contributed to this condition
              $gejala_ids = implode(',', $cf_kondisi[$highest_kondisi_id]['gejala']);
              if (!empty($gejala_ids)) {
                  $gejala_query = mysqli_query($conn, "SELECT nama_gejala FROM gejala WHERE id_gejala IN ($gejala_ids)");
                  while ($row = mysqli_fetch_assoc($gejala_query)) {
                      echo "<li>" . $row['nama_gejala'] . "</li>";
                  }
              } else {
                  echo "<li>Tidak ada gejala yang mendukung diagnosis ini.</li>";
              }
            ?>
          </ul>
        </div>

        <div class="recommendations">
          <h3>Rekomendasi Diet:</h3>
          <?php
          if(isset($_SESSION['rekomendasi_diet']) && isset ($_SESSION['rekomendasi_diet'][$hasil_utama_id])){
              $rekomendasi = $_SESSION['rekomendasi_diet'][$hasil_utama_id];
              if(is_array($rekomendasi)){
                  echo "<ul>";
                  foreach($rekomendasi as $kategori => $menu){
                      echo "<li><strong>" . ucfirst($kategori) . "</strong> $menu </li>";
                  }
                  echo "</ul>";
              } else{
                  echo $rekomendasi;
              }
          } ?>
        </div>
        
        <div class="other-results">
          <h3>Kemungkinan tipe tubuh lainnya:</h3>
          
          <?php 
          // Skip the first (highest) result since we've already displayed it
          next($cf_kondisi);
          
          // Display other results
          while ($id_kondisi = key($cf_kondisi)) {
              $cf_value = current($cf_kondisi)['nilai'];
              $other_kondisi_query = mysqli_query($conn, "SELECT kondisi FROM kondisi WHERE id_kondisi_tubuh = $id_kondisi");
              $other_kondisi = mysqli_fetch_assoc($other_kondisi_query)['kondisi'];
              $percentage = cfToPercentage($cf_value);
              
              echo "<p><strong>$other_kondisi</strong></p>";
              echo "<div class='progress-bar'>";
              echo "<div class='progress' style='width: $percentage%'>$percentage%</div>";
              echo "</div>";
              
              next($cf_kondisi);
          }
          ?>
        </div>
        
        <a href="survei.php" class="back-button">Kembali ke Kuesioner</a>
      </div>
    </section>
  </div>
  
  <script>
    // Add animation for progress bars
    document.addEventListener('DOMContentLoaded', function() {
      const progressBars = document.querySelectorAll('.progress');
      
      setTimeout(() => {
        progressBars.forEach(bar => {
          const targetWidth = bar.style.width;
          bar.style.width = '0%';
          
          setTimeout(() => {
            bar.style.width = targetWidth;
          }, 300);
        });
      }, 500);
    });
  </script>
</body>
</html>