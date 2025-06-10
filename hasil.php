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
      <header class="header">
        <div class="eyebrow">Sistem Pakar</div>
        <h1 class="card-title">Hasil Analisis Somatotype</h1>
      </header>
      
      <div class="cards-container">
        <!-- Main Result Card (Left) -->
        <div class="card main-result-card">
          <div class="result-box">
            <h2>Tipe tubuh Anda adalah: <?php echo $kondisi_data['kondisi']; ?></h2>
            <p>Tingkat Keyakinan: <?php echo cfToPercentage($highest_cf); ?>%</p>
          </div>
          
          <div class="somatotype-image-section">
            <h3>Visualisasi Tipe Tubuh Anda</h3>
            <div class="image-container">
              <?php 
              $image_path = "";
              $image_alt = "";
              $somatotype_class = "";
              
              if (stripos($kondisi_data['kondisi'], "Endomorph") !== false) { 
                $image_path = "./uploads/endomorph.jpg";
                $image_alt = "Tipe Tubuh Endomorph";
                $somatotype_class = "endo";
              } elseif (stripos($kondisi_data['kondisi'], "Ectomorph") !== false) {
                $image_path = "./uploads/ectomorph.jpg";
                $image_alt = "Tipe Tubuh Ectomorph";
                $somatotype_class = "ecto";
              } else {
                $image_path = "./uploads/mesomorph.jpg";
                $image_alt = "Tipe Tubuh Mesomorph";
                $somatotype_class = "meso";
              }
              ?>
              
              <div class="somatotype-visual <?= $somatotype_class ?>">
                <?php if (file_exists($image_path)): ?>
                  <img src="<?= $image_path ?>" alt="<?= $image_alt ?>" class="somatotype-img">
                <?php else: ?>
                  <div class="somatotype-placeholder <?= $somatotype_class ?>">
                    <div class="placeholder-icon">
                      <?php if ($somatotype_class == "ecto"): ?>
                        <span class="icon">🏃‍♂️</span>
                      <?php elseif ($somatotype_class == "meso"): ?>
                        <span class="icon">💪</span>
                      <?php else: ?>
                        <span class="icon">🤗</span>
                      <?php endif; ?>
                    </div>
                    <p><?= $image_alt ?></p>
                  </div>
                <?php endif; ?>
              </div>
              
              <div class="somatotype-badge <?= $somatotype_class ?>">
                <span class="badge-text"><?= $kondisi_data['kondisi'] ?></span>
                <span class="confidence"><?= cfToPercentage($highest_cf) ?>% Confidence</span>
              </div>
            </div>
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
        
        <!-- Diet Recommendations Card (Right) -->
        <div class="card diet-recommendations-card">
          <div class="diet-recommendations-section compact">
            <h3>🍽️ Rekomendasi Diet untuk <?= $kondisi_data['kondisi'] ?></h3>
            
            <?php
            // Get the somatotype name for specific recommendations
            $somatotype = strtolower($kondisi_data['kondisi']);
            
            if (stripos($somatotype, 'ectomorph') !== false): ?>
              <!-- Ectomorph Diet Recommendations -->
              <div class="diet-card ecto compact">
                <div class="diet-header">
                  <span class="diet-icon">🏃‍♂️</span>
                  <h4>Diet Ectomorph - "Hard Gainer"</h4>
                </div>
                
                <div class="diet-grid">
                  <div class="macro-section">
                    <h5>Komposisi Makro</h5>
                    <div class="macro-breakdown compact">
                      <div class="macro-item">
                        <span class="macro-label">Karbohidrat</span>
                        <span class="macro-value">50%</span>
                      </div>
                      <div class="macro-item">
                        <span class="macro-label">Protein</span>
                        <span class="macro-value">25%</span>
                      </div>
                      <div class="macro-item">
                        <span class="macro-label">Lemak</span>
                        <span class="macro-value">25%</span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="meal-section">
                    <h5>Contoh Makanan</h5>
                    <div class="meal-examples">
                      <p><strong>Sarapan:</strong> Oatmeal + susu + pisang + selai kacang</p>
                      <p><strong>Siang:</strong> Nasi + daging + sayur + alpukat</p>
                      <p><strong>Malam:</strong> Pasta + saus daging + keju</p>
                      <p><strong>Snack:</strong> Smoothie protein + kacang</p>
                    </div>
                  </div>
                </div>
                
                <div class="tips-compact">
                  <h5>💡 Tips Utama:</h5>
                  <p>Makan setiap 2-3 jam • Surplus kalori 10-20% • Fokus karbohidrat kompleks • Hindari kardio berlebihan</p>
                </div>
              </div>
              
            <?php elseif (stripos($somatotype, 'mesomorph') !== false): ?>
              <!-- Mesomorph Diet Recommendations -->
              <div class="diet-card meso compact">
                <div class="diet-header">
                  <span class="diet-icon">💪</span>
                  <h4>Diet Mesomorph - "Natural Athlete"</h4>
                </div>
                
                <div class="diet-grid">
                  <div class="macro-section">
                    <h5>Komposisi Makro</h5>
                    <div class="macro-breakdown compact">
                      <div class="macro-item">
                        <span class="macro-label">Karbohidrat</span>
                        <span class="macro-value">40%</span>
                      </div>
                      <div class="macro-item">
                        <span class="macro-label">Protein</span>
                        <span class="macro-value">30%</span>
                      </div>
                      <div class="macro-item">
                        <span class="macro-label">Lemak</span>
                        <span class="macro-value">30%</span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="meal-section">
                    <h5>Contoh Makanan</h5>
                    <div class="meal-examples">
                      <p><strong>Sarapan:</strong> Telur + roti gandum + buah</p>
                      <p><strong>Siang:</strong> Ayam + quinoa + sayur</p>
                      <p><strong>Malam:</strong> Steak + ubi + asparagus</p>
                      <p><strong>Snack:</strong> Greek yogurt + granola</p>
                    </div>
                  </div>
                </div>
                
                <div class="tips-compact">
                  <h5>💡 Tips Utama:</h5>
                  <p>Kalori maintenance • Variasi protein • Waktu makan sesuai latihan • Monitor berat rutin</p>
                </div>
              </div>
              
            <?php else: ?>
              <!-- Endomorph Diet Recommendations -->
              <div class="diet-card endo compact">
                <div class="diet-header">
                  <span class="diet-icon">🤗</span>
                  <h4>Diet Endomorph - "Easy Gainer"</h4>
                </div>
                
                <div class="diet-grid">
                  <div class="macro-section">
                    <h5>Komposisi Makro</h5>
                    <div class="macro-breakdown compact">
                      <div class="macro-item">
                        <span class="macro-label">Karbohidrat</span>
                        <span class="macro-value">25%</span>
                      </div>
                      <div class="macro-item">
                        <span class="macro-label">Protein</span>
                        <span class="macro-value">40%</span>
                      </div>
                      <div class="macro-item">
                        <span class="macro-label">Lemak</span>
                        <span class="macro-value">35%</span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="meal-section">
                    <h5>Contoh Makanan</h5>
                    <div class="meal-examples">
                      <p><strong>Sarapan:</strong> Putih telur + roti gandum + alpukat</p>
                      <p><strong>Siang:</strong> Ikan + nasi merah sedikit + sayur</p>
                      <p><strong>Malam:</strong> Sup sayur + tahu/tempe</p>
                      <p><strong>Snack:</strong> Kacang almond + buah rendah gula</p>
                    </div>
                  </div>
                </div>
                
                <div class="tips-compact">
                  <h5>💡 Tips Utama:</h5>
                  <p>Defisit kalori 10-20% • Hindari gula • Banyak serat • Batas makan malam jam 7 • Kombinasi kardio & beban</p>
                </div>
              </div>
            <?php endif; ?>
            
            <div class="general-recommendations compact">
              <h4>🌟 Rekomendasi Umum</h4>
              <div class="general-tips compact">
                <span>💧 Minum 8+ gelas air/hari</span>
                <span>🏋️‍♂️ Olahraga sesuai tipe tubuh</span>
                <span>😴 Tidur 7-9 jam</span>
                <span>👩‍⚕️ Konsultasi ahli gizi</span>
              </div>
            </div>
          </div>
        </div>
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