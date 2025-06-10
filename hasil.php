<?php
session_start();

// If no results exist, redirect back to the survey
if (!isset($_SESSION['cf_kondisi']) || empty($_SESSION['cf_kondisi'])) {
    header('Location: survei.php');
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
  <link rel="stylesheet" href="style.css">
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
    
    <section class="main-content scrollable">
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
              if (isset($cf_kondisi[$highest_kondisi_id]['gejala']) && !empty($cf_kondisi[$highest_kondisi_id]['gejala'])) {
                  $gejala_ids = implode(',', $cf_kondisi[$highest_kondisi_id]['gejala']);
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
          if(isset($_SESSION['rekomendasi_diet']) && isset($_SESSION['rekomendasi_diet'][$hasil_utama_id])){
              $rekomendasi = $_SESSION['rekomendasi_diet'][$hasil_utama_id];
              if(is_array($rekomendasi)){
                  echo "<ul>";
                  foreach($rekomendasi as $kategori => $menu){
                      echo "<li><strong>" . ucfirst($kategori) . ":</strong> " . $menu . "</li>";
                  }
                  echo "</ul>";
              } else{
                  echo "<p>" . $rekomendasi . "</p>";
              }
          } else {
              echo "<p>Tidak ada rekomendasi diet yang tersedia.</p>";
          }
          ?>
        </div>
        
        <div class="other-results">
          <h3>Kemungkinan tipe tubuh lainnya:</h3>
          
          <?php 
          // Skip the first (highest) result since we've already displayed it
          next($cf_kondisi);
          
          // Display other results
          while ($id_kondisi = key($cf_kondisi)) {
              if ($id_kondisi !== null) {
                  $cf_value = current($cf_kondisi)['nilai'];
                  $other_kondisi_query = mysqli_query($conn, "SELECT kondisi FROM kondisi WHERE id_kondisi_tubuh = $id_kondisi");
                  if ($other_kondisi_result = mysqli_fetch_assoc($other_kondisi_query)) {
                      $other_kondisi = $other_kondisi_result['kondisi'];
                      $percentage = cfToPercentage($cf_value);
                      
                      echo "<p><strong>$other_kondisi</strong></p>";
                      echo "<div class='progress-bar'>";
                      echo "<div class='progress' style='width: $percentage%'>$percentage%</div>";
                      echo "</div>";
                  }
              }
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