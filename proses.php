<?php
include 'koneksi.php';

if (isset($_POST['gejala'])) {
    $gejala_terpilih = $_POST['gejala'];
    $cf_kondisi = [];

    // Ambil semua kondisi
    $kondisi = mysqli_query($conn, "SELECT * FROM kondisi");

    while ($k = mysqli_fetch_assoc($kondisi)) {
        $id_kondisi = $k['id_kondisi_tubuh'];
        $cf_total = 0;
        $cf_sementara = null;

        // Ambil semua gejala dan CF yang berhubungan dengan kondisi ini
        foreach ($gejala_terpilih as $id_gejala) {
            $query = mysqli_query($conn, "SELECT value_cf FROM know_base WHERE id_kondisi = $id_kondisi AND id_gejala = $id_gejala");
            if ($row = mysqli_fetch_assoc($query)) {
                $cf = $row['value_cf'];
                if ($cf_sementara === null) {
                    $cf_sementara = $cf;
                } else {
                    // Gabungkan CF (Certainty Factor combination formula)
                    $cf_sementara = $cf_sementara + $cf * (1 - $cf_sementara);
                }
            }
        }

        if ($cf_sementara !== null) {
            $cf_kondisi[$id_kondisi] = $cf_sementara;
        }
    }

    // Simpan ke sesi dan arahkan ke hasil
    session_start();
    $_SESSION['cf_kondisi'] = $cf_kondisi;
    header('Location: hasil.php');
    exit;
} else {
    echo "Tidak ada gejala yang dipilih.";
}
?>
