<?php
include 'koneksi.php';

if (isset($_POST['gejala'])) {
    $gejala_terpilih = $_POST['gejala'];
    $cf_kondisi = [];
    $rekomendasi_diet = [];

    // Ambil semua kondisi
    $kondisi = mysqli_query($conn, "SELECT * FROM kondisi");

    while ($k = mysqli_fetch_assoc($kondisi)) {
        $id_kondisi = $k['id_kondisi_tubuh'];
        $nama_kondisi = $k['kondisi']; // Kolom 'kondisi' berisi nama kondisi tubuh seperti Ectomorph, Mesomorph, Endomorph
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

            // Tambahkan rekomendasi diet berdasarkan kondisi tubuh
            switch (strtolower($nama_kondisi)) {
                case 'ectomorph':
        $rekomendasi_diet[$id_kondisi] = [
            'Kebutuhan Kalori' => "Karena metabolisme cepat, ectomorph membutuhkan asupan kalori lebih tinggi dari rata-rata untuk menambah massa otot dan berat badan. Disarankan menaikkan asupan 10–20% di atas TDEE (Total Daily Energy Expenditure).",
            'Komposisi Makronutrien' => "Karbohidrat 50%, protein 25–30%, lemak sehat 20–25%.",
            'Strategi' => "Makan 5–6 kali sehari dengan porsi sedang hingga besar. Fokus pada karbohidrat kompleks seperti oats, nasi, kentang, dan pasta gandum. Tambahkan smoothies tinggi kalori (misalnya campuran pisang, susu, selai kacang, dan oats). Latihan kekuatan disarankan dibandingkan kardio berlebihan agar kalori tidak terbuang. Suplemen seperti whey protein dan kreatin dapat membantu menambah massa otot jika sulit memenuhi kebutuhan protein dari makanan.",
            'Sarapan' => "Oatmeal dengan susu full cream, pisang, dan selai kacang.",
            'Makan Siang' => "Nasi putih dengan daging sapi tumis dan sayur bayam.",
            'Makan Malam' => "Pasta gandum dengan saus daging dan keju parmesan.",
            'Snack' => "Smoothies buah dengan whey protein dan granola bar."
        ];
        break;

    case 'mesomorph':
        $rekomendasi_diet[$id_kondisi] = [
            'Kebutuhan Kalori' => "Memiliki efisiensi metabolisme, sehingga bisa dengan mudah menaikkan atau menurunkan berat badan tergantung kalori masuk dan aktivitas fisik.",
            'Komposisi Makronutrien' => "Karbohidrat 40%, protein 30–35%, lemak sehat 25–30%.",
            'Strategi' => "Makan teratur 3 kali sehari dengan 1–2 snack sehat. Pastikan kombinasi antara karbohidrat kompleks dan protein tanpa lemak. Jaga variasi makanan untuk menunjang pembentukan otot dan mempertahankan lemak tubuh rendah. Kombinasikan latihan kardio dan latihan beban secara rutin. Mesomorph perlu menjaga disiplin pola makan karena berat badan dapat cepat naik jika konsumsi berlebih.",
            'Sarapan' => "Telur orak-arik, roti gandum, dan buah potong.",
            'Makan Siang' => "Dada ayam panggang dengan quinoa dan sayuran kukus.",
            'Makan Malam' => "Steak sapi tanpa lemak dengan ubi jalar dan brokoli.",
            'Snack' => "Greek yogurt dengan granola atau buah segar seperti apel atau jeruk."
        ];
        break;

    case 'endomorph':
        $rekomendasi_diet[$id_kondisi] = [
            'Kebutuhan Kalori' => "Metabolisme cenderung lambat, maka kontrol kalori sangat penting. Disarankan untuk konsumsi 10–20% di bawah TDEE untuk penurunan berat badan.",
            'Komposisi Makronutrien' => "Karbohidrat 25–30%, protein 35–40%, lemak sehat 30–35%.",
            'Strategi' => "Fokus pada makanan rendah kalori tinggi nutrisi, seperti sayur berdaun hijau, ikan, kacang-kacangan, dan protein nabati. Hindari karbohidrat sederhana seperti roti putih dan makanan manis. Perbanyak aktivitas fisik, khususnya kombinasi antara cardio dan latihan beban. Konsumsi makanan tinggi serat agar kenyang lebih lama. Intermittent fasting bisa menjadi salah satu strategi efektif jika dilakukan dengan pengawasan.",
            'Sarapan' => "Putih telur rebus dengan roti gandum dan teh hijau.",
            'Makan Siang' => "Ikan bakar dengan sayur bening dan sedikit nasi merah.",
            'Makan Malam' => "Sup sayuran dengan tahu atau tempe.",
            'Snack' => "Kacang-kacangan seperti almond atau walnut."
        ];
        break;

    default:
        $rekomendasi_diet[$id_kondisi] = [
            'Sarapan' => "Menu sarapan sehat sesuai kebutuhan tubuh.",
            'Makan Siang' => "Menu makan siang sehat sesuai kebutuhan tubuh.",
            'Makan Malam' => "Menu makan malam sehat sesuai kebutuhan tubuh.",
            'Snack' => "Snack sehat seperti buah atau kacang-kacangan."
        ];
        break;
            }
        }
    }

    // Simpan ke sesi dan arahkan ke hasil
    session_start();
    $_SESSION['cf_kondisi'] = $cf_kondisi;
    $_SESSION['rekomendasi_diet'] = $rekomendasi_diet;
    header('Location: hasil.php');
    exit;
} else {
    echo "Tidak ada gejala yang dipilih.";
}
?>
