<?php
session_start();

// Contoh data user (biasanya dari database)
$valid_username = 'admin';
$valid_password = '1234';

// Ambil input dari form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);

// Verifikasi login
if ($username === $valid_username && $password === $valid_password) {
    // Simpan di session
    $_SESSION['username'] = $username;

    // Jika pilih "ingat saya", set cookie untuk 7 hari
    if ($remember) {
        setcookie('username', $username, time() + (86400 * 7), "/");
    }

    // Redirect ke dashboard
    header("Location: dashboard.php");
    exit;
} else {
    echo "Login gagal. <a href='login.html'>Coba lagi</a>";
}
?>
