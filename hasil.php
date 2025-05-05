<?php
session_start();

// If no results exist, redirect back to the survey
if (!isset($_SESSION['cf_kondisi']) || empty($_SESSION['cf_kondisi'])) {
    header('Location: survey.php');
    exit;
}

include 'koneksi.php';

$cf_kondisi = $_SESSION['cf_kondisi'];

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
        body {
            font-family: Arial, sans-serif;
            background-color: #E2DAD6;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #F5EDED;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #4a6790;
        }
        .result-box {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            background-color: #6482AD;
            color: white;
        }
        .description {
            text-align: left;
            padding: 15px;
            margin: 20px 0;
            background-color: white;
            border-radius: 8px;
        }
        .other-results {
            margin-top: 30px;
            text-align: left;
        }
        .progress-bar {
            width: 100%;
            background-color: #ddd;
            border-radius: 10px;
            margin: 10px 0;
        }
        .progress {
            height: 20px;
            border-radius: 10px;
            background-color: #6482AD;
            text-align: right;
            padding-right: 10px;
            color: white;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 30px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            background-color: #6482AD;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hasil Analisis Somatotype</h1>
        
        <div class="result-box">
            <h2>Tipe tubuh Anda adalah: <?php echo $kondisi_data['kondisi']; ?></h2>
            <p>Tingkat Keyakinan: <?php echo cfToPercentage($highest_cf); ?>%</p>
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
</body>
</html>