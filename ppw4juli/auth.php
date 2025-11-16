<?php
// auth.php - Helper untuk authentication
session_start();

// Fungsi untuk cek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk mendapatkan data user
function getUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email']
        ];
    }
    return null;
}

// Fungsi untuk generate menu navigation berdasarkan status login
function getNavigationMenu($currentPage = '') {
    $user = getUser();
    $menu = '';
    
    // Menu utama
    $menu .= '<li' . ($currentPage == 'home' ? ' class="active"' : '') . '><a href="index.php">Home</a></li>';
    $menu .= '<li' . ($currentPage == 'makanan' ? ' class="active"' : '') . '><a href="makanan.php">Makanan Utama</a></li>';
    $menu .= '<li' . ($currentPage == 'minuman' ? ' class="active"' : '') . '><a href="minuman.php">Minuman</a></li>';
    $menu .= '<li' . ($currentPage == 'kue' ? ' class="active"' : '') . '><a href="kue.php">Kue</a></li>';
    $menu .= '<li' . ($currentPage == 'cemilan' ? ' class="active"' : '') . '><a href="cemilan.php">Cemilan</a></li>';
    
    // Menu berdasarkan status login
    if ($user) {
        $menu .= '<li' . ($currentPage == 'dashboard' ? ' class="active"' : '') . '><a href="dashboard.php">Dashboard</a></li>';
        $menu .= '<li><a href="process.php?logout=1">Logout (' . htmlspecialchars($user['name']) . ')</a></li>';
    } else {
        $menu .= '<li' . ($currentPage == 'akun' ? ' class="active"' : '') . '><a href="akun.php">Login/Daftar</a></li>';
    }
    
    return $menu;
}

// Fungsi untuk generate user greeting
function getUserGreeting() {
    $user = getUser();
    if ($user) {
        return '<div class="user-greeting" style="background: #f8f9fa; padding: 10px; text-align: center; margin-bottom: 20px;">
                    Selamat datang, <strong>' . htmlspecialchars($user['name']) . '</strong>! 
                    <a href="dashboard.php" style="margin-left: 10px;">Dashboard</a> | 
                    <a href="process.php?logout=1">Logout</a>
                </div>';
    }
    return '';
}

// Fungsi untuk redirect jika belum login (untuk halaman yang memerlukan login)
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: akun.php");
        exit();
    }
}
?>