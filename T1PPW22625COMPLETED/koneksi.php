<?php
/**
 * File Koneksi Database MySQL
 * Menggunakan MySQLi Object-Oriented dengan error handling yang lebih baik
 */

// Konfigurasi database
$servername = "localhost";    // Sesuaikan dengan server database Anda
$username = "root";           // Sesuaikan dengan username database Anda
$password = "";               // Sesuaikan dengan password database Anda (kosong untuk XAMPP default)
$database = "registrasi";     // Nama database

// Set charset untuk menghindari masalah encoding
$charset = "utf8mb4";

try {
    // Membuat koneksi menggunakan MySQLi
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Set charset
    $conn->set_charset($charset);
    
    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set SQL mode untuk kompatibilitas yang lebih baik
    $conn->query("SET sql_mode = ''");
    
} catch (Exception $e) {
    // Log error (dalam production, sebaiknya log ke file)
    error_log("Database connection error: " . $e->getMessage());
    
    // Tampilkan pesan error yang user-friendly
    die("Maaf, terjadi kesalahan dalam koneksi database. Silakan coba lagi nanti.");
}

/**
 * Fungsi untuk menutup koneksi database
 */
function closeConnection() {
    global $conn;
    if ($conn) {
        $conn->close();
    }
}

/**
 * Fungsi untuk escape string (mencegah SQL injection)
 * Meski sudah menggunakan prepared statement, fungsi ini tetap berguna
 */
function escapeString($string) {
    global $conn;
    return $conn->real_escape_string($string);
}

/**
 * Fungsi untuk cek apakah tabel ada
 */
function checkTableExists($tableName) {
    global $conn;
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

// Cek apakah tabel anggota ada, jika tidak tampilkan peringatan
if (!checkTableExists('anggota')) {
    error_log("Tabel 'anggota' tidak ditemukan dalam database 'registrasi'");
    // Uncomment baris di bawah jika ingin menampilkan pesan error
    // die("Tabel 'anggota' tidak ditemukan. Pastikan database sudah dibuat dengan benar.");
}

?>