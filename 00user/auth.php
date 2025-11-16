<?php
// auth.php - Authentication Handler
session_start();
require_once 'config.php';

class AuthHandler {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    // Registrasi user baru
    public function register($name, $username, $email, $password) {
        $conn = $this->db->getConnection();
        
        try {
            // Cek apakah username atau email sudah ada
            $checkSql = "SELECT COUNT(*) FROM users WHERE username = ? OR email = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->execute([$username, $email]);
            
            if ($checkStmt->fetchColumn() > 0) {
                return [
                    'success' => false,
                    'message' => 'Username atau email sudah terdaftar!'
                ];
            }
            
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user baru
            $sql = "INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$name, $username, $email, $hashedPassword])) {
                return [
                    'success' => true,
                    'message' => 'Registrasi berhasil! Silakan login dengan akun baru Anda.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Gagal melakukan registrasi!'
                ];
            }
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    // Login user
    public function login($username, $password) {
        $conn = $this->db->getConnection();
        
        try {
            // Cari user berdasarkan username atau email
            $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['login_time'] = time();
                
                return [
                    'success' => true,
                    'message' => 'Login berhasil!',
                    'redirect' => 'index.php'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Username/email atau password salah!'
                ];
            }
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    // Generate dan kirim OTP
    public function sendOTP($email) {
        $conn = $this->db->getConnection();
        
        try {
            // Cek apakah email terdaftar
            $checkSql = "SELECT COUNT(*) FROM users WHERE email = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->execute([$email]);
            
            if ($checkStmt->fetchColumn() == 0) {
                return [
                    'success' => false,
                    'message' => 'Email tidak terdaftar!'
                ];
            }
            
            // Generate OTP 6 digit
            $otp = sprintf("%06d", mt_rand(1, 999999));
            $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            
            // Hapus OTP lama yang belum digunakan
            $deleteSql = "DELETE FROM password_resets WHERE email = ? AND is_used = FALSE";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->execute([$email]);
            
            // Simpan OTP baru
            $sql = "INSERT INTO password_resets (email, otp, expires_at) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$email, $otp, $expiresAt])) {
                // Di sini Anda bisa mengirim email OTP
                // Untuk demo, kita akan menampilkan OTP di response
                return [
                    'success' => true,
                    'message' => 'Kode OTP telah dikirim ke email Anda!',
                    'otp' => $otp // Hapus ini di production, kirim via email
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Gagal mengirim OTP!'
                ];
            }
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    // Verifikasi OTP
    public function verifyOTP($email, $otp) {
        $conn = $this->db->getConnection();
        
        try {
            $sql = "SELECT * FROM password_resets WHERE email = ? AND otp = ? AND is_used = FALSE AND expires_at > NOW()";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$email, $otp]);
            $otpRecord = $stmt->fetch();
            
            if ($otpRecord) {
                // Set session untuk reset password
                $_SESSION['reset_email'] = $email;
                $_SESSION['otp_verified'] = true;
                
                return [
                    'success' => true,
                    'message' => 'OTP berhasil diverifikasi!'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'OTP tidak valid atau sudah expired!'
                ];
            }
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    // Reset password
    public function resetPassword($email, $newPassword) {
        $conn = $this->db->getConnection();
        
        try {
            // Cek apakah OTP sudah diverifikasi
            if (!isset($_SESSION['otp_verified']) || $_SESSION['reset_email'] !== $email) {
                return [
                    'success' => false,
                    'message' => 'Silakan verifikasi OTP terlebih dahulu!'
                ];
            }
            
            // Hash password baru
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update password
            $sql = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt->execute([$hashedPassword, $email])) {
                // Mark OTP as used
                $updateOtpSql = "UPDATE password_resets SET is_used = TRUE WHERE email = ? AND is_used = FALSE";
                $updateOtpStmt = $conn->prepare($updateOtpSql);
                $updateOtpStmt->execute([$email]);
                
                // Clear session
                unset($_SESSION['reset_email']);
                unset($_SESSION['otp_verified']);
                
                return [
                    'success' => true,
                    'message' => 'Password berhasil diubah! Silakan login dengan password baru.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Gagal mengubah password!'
                ];
            }
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
    
    // Logout
    public function logout() {
        session_start();
        session_destroy();
        return [
            'success' => true,
            'message' => 'Logout berhasil!',
            'redirect' => 'login.php'
        ];
    }
    
    // Cek apakah user sudah login
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Get user info
    public function getUserInfo() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email']
            ];
        }
        return null;
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new AuthHandler();
    $action = $_POST['action'] ?? '';
    
    header('Content-Type: application/json');
    
    switch ($action) {
        case 'register':
            $result = $auth->register(
                $_POST['name'],
                $_POST['username'],
                $_POST['email'],
                $_POST['password']
            );
            echo json_encode($result);
            break;
            
        case 'login':
            $result = $auth->login($_POST['username'], $_POST['password']);
            echo json_encode($result);
            break;
            
        case 'forgot_password':
            $result = $auth->sendOTP($_POST['email']);
            echo json_encode($result);
            break;
            
        case 'verify_otp':
            $result = $auth->verifyOTP($_POST['email'], $_POST['otp']);
            echo json_encode($result);
            break;
            
        case 'reset_password':
            $result = $auth->resetPassword($_POST['email'], $_POST['new_password']);
            echo json_encode($result);
            break;
            
        case 'logout':
            $result = $auth->logout();
            echo json_encode($result);
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
    exit;
}
?>