<?php
/**
 * File Konfigurasi Database
 * Memisahkan konfigurasi dari logika koneksi untuk keamanan yang lebih baik
 */

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');        // Kosong untuk XAMPP default
define('DB_NAME', 'registrasi');
define('DB_CHARSET', 'utf8mb4');

// Konfigurasi Error Reporting
// Untuk development
define('SHOW_ERRORS', true);
define('LOG_ERRORS', true);

// Untuk production, ubah menjadi:
// define('SHOW_ERRORS', false);
// define('LOG_ERRORS', true);

// Timezone
date_default_timezone_set('Asia/Makassar');

/**
 * Fungsi untuk mendapatkan konfigurasi database
 */
function getDatabaseConfig() {
    return [
        'host' => DB_HOST,
        'username' => DB_USERNAME,
        'password' => DB_PASSWORD,
        'database' => DB_NAME,
        'charset' => DB_CHARSET
    ];
}
?>