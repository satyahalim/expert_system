<?php
$host     = "localhost";   // biasanya tetap localhost
$user     = "root";        // ganti jika Anda pakai user lain
$password = "";            // isi jika Anda pakai password untuk MySQL
$database = "expertsys";  // ganti sesuai nama database Anda

$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
