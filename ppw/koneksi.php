<?php
/**
 * File Koneksi Database untuk Sistem Pendaftaran Anggota
 * 
 * Pastikan konfigurasi sesuai dengan setup MySQL Anda
 */

// Konfigurasi Database
$servername = "localhost";        // Host database
$username = "root";               // Username MySQL (sesuaikan dengan setup Anda)
$password = "";                   // Password MySQL (sesuaikan dengan setup Anda)
$dbname = "anggota";             // Nama database

// Membuat koneksi menggunakan MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Set charset UTF-8 untuk mendukung karakter khusus
$conn->set_charset("utf8mb4");

// Cek koneksi
if ($conn->connect_error) {
    // Log error untuk debugging (jangan tampilkan di production)
    error_log("Connection failed: " . $conn->connect_error);
    
    // Tampilkan pesan error yang user-friendly
    die("
    <div style='
        font-family: Arial, sans-serif; 
        max-width: 600px; 
        margin: 50px auto; 
        padding: 20px; 
        border: 1px solid #ff6b6b; 
        border-radius: 10px; 
        background-color: #ffe6e6;
        color: #d63447;
        text-align: center;
    '>
        <h2>🚫 Koneksi Database Gagal</h2>
        <p><strong>Tidak dapat terhubung ke database!</strong></p>
        <p>Silakan periksa:</p>
        <ul style='text-align: left; display: inline-block;'>
            <li>Apakah MySQL server sudah berjalan?</li>
            <li>Apakah kredensial database sudah benar?</li>
            <li>Apakah database 'anggota' sudah dibuat?</li>
        </ul>
        <p><small>Hubungi administrator sistem jika masalah berlanjut.</small></p>
    </div>
    ");
}

// Optional: Set timezone (sesuaikan dengan lokasi Anda)
date_default_timezone_set('Asia/Jakarta');

// Optional: Function helper untuk escape string
function escape_string($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Optional: Function untuk sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Optional: Function untuk validasi email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Optional: Function untuk cek apakah email sudah ada
function email_exists($email) {
    global $conn;
    $email = escape_string($email);
    $query = "SELECT id FROM tabel_user WHERE email = '$email' LIMIT 1";
    $result = $conn->query($query);
    return $result && $result->num_rows > 0;
}

// Optional: Function untuk generate unique ID
function generate_member_id() {
    return 'MBR' . date('Ymd') . sprintf('%04d', rand(1, 9999));
}

// Success message jika koneksi berhasil (hanya untuk testing)
// echo "<script>console.log('Database connected successfully!');</script>";

/*
===========================================
CATATAN KONFIGURASI:
===========================================

1. XAMPP/WAMP/LAMP (Local Development):
   - $servername = "localhost";
   - $username = "root";
   - $password = ""; (kosong untuk XAMPP default)

2. Hosting Shared:
   - $servername = "localhost" atau IP yang diberikan hosting
   - $username = username database dari hosting
   - $password = password database dari hosting
   - $dbname = nama database yang sudah dibuat di hosting

3. Cloud Database (seperti AWS RDS, Google Cloud SQL):
   - $servername = endpoint database
   - Port mungkin perlu ditambahkan
   - SSL connection mungkin diperlukan

4. Untuk Production:
   - Simpan kredensial di environment variables
   - Gunakan file konfigurasi terpisah
   - Aktifkan error logging
   - Nonaktifkan display errors

CARA TROUBLESHOOTING:
===========================================
1. Cek apakah MySQL service berjalan
2. Pastikan database 'anggota' sudah dibuat
3. Jalankan SQL script yang sudah disediakan
4. Periksa username/password MySQL
5. Cek firewall dan port (default MySQL: 3306)

*/
?>