<?php
include 'koneksi.php';
session_start();

// 1. Kumpulkan semua kode gejala yang jawabannya "ya"
$kodeDipilih = [];
for ($i = 1; $i <= 18; $i++) {
    $kodename = sprintf('G%03d', $i); // G001, G002, ...
    if (isset($_POST[$kodename]) && $_POST[$kodename] === 'ya') {
        $kodeDipilih[] = $kodename;
    }
    // We explicitly ignore "tidak" responses
}

// Handle case with no "ya" answers
if (empty($kodeDipilih)) {
    die("Silakan jawab minimal satu pertanyaan dengan 'Ya'.");
}

// 2. Dari kode gejala, cari id_gejala numeriknya
$inList = "'" . implode("','", $kodeDipilih) . "'"; 
$sql = "SELECT id_gejala, kode_gejala
        FROM gejala
        WHERE kode_gejala IN ($inList)";
$res = mysqli_query($conn, $sql);

$gejalaTerpilih = [];  // akan berisi id_gejala numeric
while ($row = mysqli_fetch_assoc($res)) {
    $gejalaTerpilih[] = $row['id_gejala'];
}

// 3. Calculate CF for each condition
$cf_kondisi = [];
$kondisi = mysqli_query($conn, "SELECT id_kondisi_tubuh FROM kondisi");

while ($k = mysqli_fetch_assoc($kondisi)) {
    $id_kondisi = $k['id_kondisi_tubuh'];
    $cf_sementara = null;
    
    // Track which symptoms actually contributed to this condition
    $gejala_berkontribusi = [];
    
    foreach ($gejalaTerpilih as $id_gejala) {
        $q = mysqli_query($conn,
            "SELECT value_cf 
             FROM know_base 
             WHERE id_kondisi = $id_kondisi 
               AND id_gejala = $id_gejala"
        );
        
        if ($r = mysqli_fetch_assoc($q)) {
            $cf = (float)$r['value_cf'];
            $gejala_berkontribusi[] = $id_gejala;
            
            if ($cf_sementara === null) {
                $cf_sementara = $cf;
            } else {
                // formula CF combination: CF1 + CF2 * (1 - CF1)
                $cf_sementara = $cf_sementara + $cf * (1 - $cf_sementara);
            }
        }
    }
    
    if ($cf_sementara !== null) {
        // Only include conditions where at least one symptom contributes
        if (!empty($gejala_berkontribusi)) {
            $cf_kondisi[$id_kondisi] = [
                'nilai' => $cf_sementara, 
                'gejala' => $gejala_berkontribusi
            ];
        }
    }
}

// 4. Simpan hasil dan redirect
$_SESSION['cf_kondisi'] = $cf_kondisi;
header('Location: hasil.php');
exit;