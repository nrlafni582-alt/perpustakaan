<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan_db_2"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Definisikan fungsi sanitize di sini agar bisa dipakai di semua file
if (!function_exists('sanitize')) {
    function sanitize($data) {
        global $conn;
        return mysqli_real_escape_string($conn, htmlspecialchars(stripslashes(trim($data))));
    }
}
?>