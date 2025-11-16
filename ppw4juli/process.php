<?php
// process.php - Memproses registrasi dan login
session_start();
require_once 'config.php';

// Fungsi untuk membersihkan input
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fungsi untuk validasi email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Proses Registrasi
if (isset($_POST['send'])) {
    $nama = cleanInput($_POST['nama']);
    $email = cleanInput($_POST['email']);
    $password = cleanInput($_POST['password']);
    $confirmpass = cleanInput($_POST['confirmpass']);
    
    $errors = [];
    
    // Validasi input
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    
    if (empty($email)) {
        $errors[] = "Email tidak boleh kosong";
    } elseif (!isValidEmail($email)) {
        $errors[] = "Format email tidak valid";
    }
    
    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter";
    }
    
    if ($password !== $confirmpass) {
        $errors[] = "Konfirmasi password tidak sesuai";
    }
    
    // Cek apakah email sudah terdaftar
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $errors[] = "Email sudah terdaftar";
            }
        } catch(PDOException $e) {
            $errors[] = "Terjadi kesalahan sistem";
        }
    }
    
    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $pdo->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$nama, $email, $hashedPassword]);
            
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
            header("Location: akun.php");
            exit();
            
        } catch(PDOException $e) {
            $errors[] = "Gagal menyimpan data: " . $e->getMessage();
        }
    }
    
    // Simpan error dalam session
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        $_SESSION['old_data'] = $_POST;
        header("Location: akun.php");
        exit();
    }
}

// Proses Login
if (isset($_POST['login'])) {
    $nama = cleanInput($_POST['nama']);
    $password = cleanInput($_POST['password']);
    
    $errors = [];
    
    // Validasi input
    if (empty($nama)) {
        $errors[] = "Nama tidak boleh kosong";
    }
    
    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong";
    }
    
    // Jika tidak ada error, cek login
    if (empty($errors)) {
        try {
            // Cari user berdasarkan nama atau email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE nama = ? OR email = ?");
            $stmt->execute([$nama, $nama]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nama'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['success'] = "Login berhasil! Selamat datang, " . $user['nama'];
                
                header("Location: dashboard.php"); // atau halaman yang diinginkan
                exit();
            } else {
                $errors[] = "Nama/email atau password salah";
            }
            
        } catch(PDOException $e) {
            $errors[] = "Terjadi kesalahan sistem";
        }
    }
    
    // Simpan error dalam session
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: akun.php");
        exit();
    }
}

// Proses Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: akun.php");
    exit();
}
?>