<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['cf_kondisi'])) {
    echo "Tidak ada data hasil diagnosa.";
    exit;
}

$cf_kondisi = $_SESSION['cf_kondisi'];
arsort($cf_kondisi); // Urutkan dari tertinggi

$hasil_utama_id = key($cf_kondisi);
$nilai_utama = current($cf_kondisi);

// Ambil detail kondisi dari DB
$query = mysqli_query($conn, "SELECT * FROM kondisi WHERE id_kondisi_tubuh = $hasil_utama_id");
$kondisi = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Diagnosa</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    .hasil {
      padding: 20px;
      border: 1px solid #ccc;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <h2>Hasil Diagnosa Tipe Tubuh</h2>
  <div class="hasil">
    <p><strong>Tipe Tubuh:</strong> <?= $kondisi['kondisi']; ?></p>
    <p><strong>Nilai CF:</strong> <?= round($nilai_utama * 100, 2); ?>%</p>
    <p><strong>Deskripsi:</strong><br><?= $kondisi['deskripsi']; ?></p>
    <p><strong>Rekomendasi Diet:</strong><br>
      <?php
      if (isset($_SESSION['rekomendasi_diet']) && isset($_SESSION['rekomendasi_diet'][$hasil_utama_id])) {
          // Tampilkan rekomendasi diet jika tersedia
          $rekomendasi = $_SESSION['rekomendasi_diet'][$hasil_utama_id];
          if (is_array($rekomendasi)) {
              echo "<ul>";
              foreach ($rekomendasi as $kategori => $menu) {
                  echo "<li><strong>" . ucfirst($kategori) . ":</strong> $menu</li>";
              }
              echo "</ul>";
          } else {
              echo $rekomendasi;
          }
      } else {
          // Pesan fallback jika tidak ada data
          echo "Tidak ada rekomendasi diet untuk tipe tubuh ini.";
      }
      ?>
    </p>
  </div>

</body>
</html>
