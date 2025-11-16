<?php
// config/database.php
class Database {
    private $host = "localhost";
    private $db_name = "nngproperty_db";
    private $username = "root";
    private $password = "";
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch(PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}

// classes/User.php
class User {
    private $conn;
    private $table_name = "users";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Register user baru
    public function register($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (username, email, password, full_name, phone) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash password
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt->execute([
                $data['username'],
                $data['email'],
                $hashed_password,
                $data['full_name'],
                $data['phone']
            ]);
            return $this->conn->lastInsertId();
        } catch(PDOException $e) {
            return false;
        }
    }
    
    // Login user
    public function login($username, $password) {
        $query = "SELECT id, username, email, password, full_name, status, role 
                  FROM " . $this->table_name . " 
                  WHERE (username = ? OR email = ?) AND status = 'active'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $username]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            if (password_verify($password, $user['password'])) {
                // Update last_login akan otomatis di trigger
                return $user;
            }
        }
        return false;
    }
    
    // Cek apakah username atau email sudah ada
    public function checkExists($username, $email) {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = ? OR email = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $email]);
        
        return $stmt->rowCount() > 0;
    }
    
    // Get user by ID
    public function getUserById($id) {
        $query = "SELECT id, username, email, full_name, phone, email_verified, 
                         profile_picture, status, role, created_at, last_login 
                  FROM " . $this->table_name . " 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch();
    }
    
    // Get user by email
    public function getUserByEmail($email) {
        $query = "SELECT id, username, email, full_name, phone, status, role 
                  FROM " . $this->table_name . " 
                  WHERE email = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        
        return $stmt->fetch();
    }
    
    // Update password
    public function updatePassword($user_id, $new_password) {
        $query = "UPDATE " . $this->table_name . " 
                  SET password = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        return $stmt->execute([$hashed_password, $user_id]);
    }
    
    // Update login attempts
    public function updateLoginAttempts($user_id, $attempts) {
        $query = "UPDATE " . $this->table_name . " 
                  SET login_attempts = ?, 
                      account_locked_until = ? 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        // Lock account for 30 minutes after 5 failed attempts
        $lock_until = $attempts >= 5 ? date('Y-m-d H:i:s', strtotime('+30 minutes')) : null;
        
        return $stmt->execute([$attempts, $lock_until, $user_id]);
    }
    
    // Check if account is locked
    public function isAccountLocked($user_id) {
        $query = "SELECT account_locked_until FROM " . $this->table_name . " 
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
            if ($result['account_locked_until'] && strtotime($result['account_locked_until']) > time()) {
                return true;
            }
        }
        return false;
    }
}

// classes/Session.php
class Session {
    private $conn;
    private $table_name = "user_sessions";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Buat session baru
    public function createSession($user_id, $remember_me = false) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, session_token, remember_token, ip_address, user_agent, expires_at) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $session_token = bin2hex(random_bytes(32));
        $remember_token = $remember_me ? bin2hex(random_bytes(32)) : null;
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $expires_at = $remember_me ? 
            date('Y-m-d H:i:s', strtotime('+30 days')) : 
            date('Y-m-d H:i:s', strtotime('+1 day'));
        
        if ($stmt->execute([$user_id, $session_token, $remember_token, $ip_address, $user_agent, $expires_at])) {
            return [
                'session_token' => $session_token,
                'remember_token' => $remember_token
            ];
        }
        
        return false;
    }
    
    // Validasi session
    public function validateSession($session_token) {
        $query = "SELECT s.*, u.username, u.email, u.full_name, u.status, u.role 
                  FROM " . $this->table_name . " s
                  JOIN users u ON s.user_id = u.id
                  WHERE s.session_token = ? 
                  AND s.is_active = TRUE 
                  AND s.expires_at > NOW()
                  AND u.status = 'active'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$session_token]);
        
        return $stmt->fetch();
    }
    
    // Hapus session (logout)
    public function destroySession($session_token) {
        $query = "UPDATE " . $this->table_name . " 
                  SET is_active = FALSE 
                  WHERE session_token = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$session_token]);
    }
    
    // Hapus semua session user
    public function destroyAllUserSessions($user_id) {
        $query = "UPDATE " . $this->table_name . " 
                  SET is_active = FALSE 
                  WHERE user_id = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id]);
    }
}

// classes/PasswordReset.php
class PasswordReset {
    private $conn;
    private $table_name = "password_reset_tokens";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Generate OTP token
    public function generateOTP($user_id, $email) {
        // Hapus OTP lama yang belum expired
        $this->deleteOldOTP($user_id);
        
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, email, token, otp_code, expires_at) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $token = bin2hex(random_bytes(32));
        $otp_code = sprintf('%06d', random_int(100000, 999999));
        $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        if ($stmt->execute([$user_id, $email, $token, $otp_code, $expires_at])) {
            return [
                'token' => $token,
                'otp_code' => $otp_code
            ];
        }
        
        return false;
    }
    
    // Validasi OTP
    public function validateOTP($token, $otp_code) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE token = ? AND otp_code = ? 
                  AND is_used = FALSE 
                  AND expires_at > NOW()";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$token, $otp_code]);
        
        return $stmt->fetch();
    }
    
    // Tandai OTP sebagai used
    public function markOTPAsUsed($token) {
        $query = "UPDATE " . $this->table_name . " 
                  SET is_used = TRUE 
                  WHERE token = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$token]);
    }
    
    // Hapus OTP lama
    private function deleteOldOTP($user_id) {
        $query = "DELETE FROM " . $this->table_name . " 
                  WHERE user_id = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$user_id]);
    }
}

// classes/LoginHistory.php
class LoginHistory {
    private $conn;
    private $table_name = "login_history";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Log login attempt
    public function logLogin($user_id, $username, $email, $method, $status, $failure_reason = null) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (user_id, username, email, ip_address, user_agent, login_method, status, failure_reason) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        return $stmt->execute([
            $user_id,
            $username,
            $email,
            $ip_address,
            $user_agent,
            $method,
            $status,
            $failure_reason
        ]);
    }
    
    // Get login history by user
    public function getUserLoginHistory($user_id, $limit = 10) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE user_id = ? 
                  ORDER BY created_at DESC 
                  LIMIT ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $limit]);
        
        return $stmt->fetchAll();
    }
}

// utils/helpers.php
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePhone($phone) {
    return preg_match('/^[\+]?[0-9\-\s]+$/', $phone);
}

function validatePassword($password) {
    // Minimal 6 karakter, mengandung huruf dan angka
    return strlen($password) >= 6 && preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password);
}

function sendEmail($to, $subject, $message) {
    // Implementasi sesuai dengan email provider yang digunakan
    // Contoh menggunakan PHPMailer atau mail() function
    return mail($to, $subject, $message);
}

function logError($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'logs/error.log');
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function redirectTo($url) {
    header("Location: $url");
    exit;
}

function jsonResponse($data, $status_code = 200) {
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>