<?php
// Konfigurasi Database
$host = "localhost";
$username = "root";
$password = "";
$database = "yibbi_db";

// Membuat koneksi ke database menggunakan mysqli
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set karakter encoding
$conn->set_charset("utf8mb4");
?>
