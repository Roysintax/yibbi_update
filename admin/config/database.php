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

// Membuat koneksi ke database menggunakan PDO (Untuk fitur baru seperti Blog)
try {
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    die("Koneksi PDO gagal: " . $e->getMessage());
}
?>
