<?php
session_start();
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "nngproperty"; // Ganti dengan nama database Anda

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Koneksi database gagal: ' . $e->getMessage()
    ]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_email = trim($_POST['username']);
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']) ? true : false;
    
    // Validasi input
    if (empty($username_email) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Username/Email dan password tidak boleh kosong!'
        ]);
        exit();
    }
    
    try {
        // Query untuk mencari user berdasarkan username atau email
        $stmt = $pdo->prepare("SELECT id, username, email, password, nama_lengkap, role, status FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username_email, $username_email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Verifikasi password (asumsi password di-hash dengan password_hash())
            if (password_verify($password, $user['password'])) {
                // Cek status user aktif
                if ($user['status'] != 'active') {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'
                    ]);
                    exit();
                }
                
                // Login berhasil - set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;
                
                // Jika remember me dicentang, set cookie
                if ($remember_me) {
                    // Generate token untuk remember me
                    $token = bin2hex(random_bytes(32));
                    $expires = time() + (30 * 24 * 60 * 60); // 30 hari
                    
                    // Simpan token ke database
                    $stmt = $pdo->prepare("UPDATE users SET remember_token = ?, remember_expires = ? WHERE id = ?");
                    $stmt->execute([$token, date('Y-m-d H:i:s', $expires), $user['id']]);
                    
                    // Set cookie
                    setcookie('remember_token', $token, $expires, '/', '', true, true);
                }
                
                // Update last login
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'nama_lengkap' => $user['nama_lengkap'],
                        'role' => $user['role']
                    ],
                    'redirect' => getDashboardUrl($user['role'])
                ]);
                
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Password yang Anda masukkan salah!'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Username atau email tidak ditemukan!'
            ]);
        }
        
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
        ]);
    }
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan!'
    ]);
}

// Function untuk menentukan redirect URL berdasarkan role
function getDashboardUrl($role) {
    switch($role) {
        case 'admin':
            return 'admin/dashboard.php';
        case 'agent':
            return 'agent/dashboard.php';
        case 'user':
            return 'user/dashboard.php';
        default:
            return 'dashboard.php';
    }
}
?>