<?php
// Database configuration
$host     = "localhost";   // Database host
$user     = "root";        // Database username
$password = "";            // Database password  
$database = "expertsys";   // Database name

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset to utf8mb4 for better unicode support
mysqli_set_charset($conn, "utf8mb4");

// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Function to execute safe queries
function safe_query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        error_log("Database query failed: " . mysqli_error($conn) . " - Query: " . $query);
        return false;
    }
    return $result;
}
?>