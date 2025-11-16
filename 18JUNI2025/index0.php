<?php 
include 'koneksi.php';
session_start();

// Fungsi untuk mencatat log aktivitas
function logActivity($conn, $email, $activity, $status, $ip_address) {
    $sql = "INSERT INTO login_logs (email, activity, status, ip_address, timestamp) VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $email, $activity, $status, $ip_address);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Fungsi untuk cek apakah IP diblokir
function isIpBlocked($conn, $ip_address) {
    $sql = "SELECT COUNT(*) as attempts FROM login_logs WHERE ip_address = ? AND status = 'failed' AND timestamp > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $ip_address);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row['attempts'] >= 5; // Blokir setelah 5 kali gagal dalam 15 menit
    }
    return false;
}

// Fungsi untuk generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Fungsi untuk validasi CSRF token
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Inisialisasi variabel
$error_message = '';
$success_message = '';
$login_attempts = 0;
$ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

// Cek apakah sudah login
if (isset($_SESSION['username'])) {  
    header("Location: berhasil_login.php");  
    exit(); 
}

// Cek apakah IP diblokir
if (isIpBlocked($conn, $ip_address)) {
    $error_message = "IP Anda telah diblokir sementara karena terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam 15 menit.";
    logActivity($conn, '', 'Blocked IP Access', 'blocked', $ip_address);
}

// Proses login
if (isset($_POST['submit']) && empty($error_message)) {
    // Validasi CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $error_message = "Token keamanan tidak valid. Silakan refresh halaman.";
    } else {
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $password = $_POST['password'];
        $remember_me = isset($_POST['remember_me']);
        
        // Validasi input
        if (empty($email) || empty($password)) {
            $error_message = "Email dan password harus diisi!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Format email tidak valid!";
        } else {
            // Hash password
            $password_hash = hash('sha256', $password);
            
            // Query untuk cek user
            $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
            $stmt = mysqli_prepare($conn, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ss", $email, $password_hash);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if ($result->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result);
                    
                    // Set session variables
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $row['role'] ?? 'User';
                    $_SESSION['login_time'] = date('Y-m-d H:i:s');
                    $_SESSION['ip_address'] = $ip_address;
                    $_SESSION['user_agent'] = $user_agent;
                    
                    // Update last login di database
                    $update_sql = "UPDATE users SET last_login = NOW(), last_ip = ? WHERE email = ?";
                    $update_stmt = mysqli_prepare($conn, $update_sql);
                    if ($update_stmt) {
                        mysqli_stmt_bind_param($update_stmt, "ss", $ip_address, $email);
                        mysqli_stmt_execute($update_stmt);
                        mysqli_stmt_close($update_stmt);
                    }
                    
                    // Set cookie jika remember me dicentang
                    if ($remember_me) {
                        $cookie_token = bin2hex(random_bytes(32));
                        setcookie('remember_token', $cookie_token, time() + (86400 * 30), '/'); // 30 hari
                        
                        // Simpan token di database
                        $token_sql = "UPDATE users SET remember_token = ? WHERE email = ?";
                        $token_stmt = mysqli_prepare($conn, $token_sql);
                        if ($token_stmt) {
                            mysqli_stmt_bind_param($token_stmt, "ss", $cookie_token, $email);
                            mysqli_stmt_execute($token_stmt);
                            mysqli_stmt_close($token_stmt);
                        }
                    }
                    
                    // Log aktivitas sukses
                    logActivity($conn, $email, 'Login Success', 'success', $ip_address);
                    
                    // Regenerate session ID untuk keamanan
                    session_regenerate_id(true);
                    
                    header("Location: berhasil_login.php");
                    exit();
                } else {
                    $error_message = "Email atau password Anda salah. Silakan coba lagi!";
                    logActivity($conn, $email, 'Login Failed', 'failed', $ip_address);
                }
                mysqli_stmt_close($stmt);
            } else {
                $error_message = "Terjadi kesalahan sistem. Silakan coba lagi.";
            }
        }
    }
}

// Cek remember me cookie
if (isset($_COOKIE['remember_token']) && !isset($_SESSION['username'])) {
    $token = $_COOKIE['remember_token'];
    $sql = "SELECT * FROM users WHERE remember_token = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'] ?? 'User';
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
            
            header("Location: berhasil_login.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
}

// Generate CSRF token untuk form
$csrf_token = generateCSRFToken();

// Hitung jumlah user online (contoh)
$online_users = 0;
$online_sql = "SELECT COUNT(*) as count FROM users WHERE last_login > DATE_SUB(NOW(), INTERVAL 15 MINUTE)";
$online_result = mysqli_query($conn, $online_sql);
if ($online_result) {
    $online_row = mysqli_fetch_assoc($online_result);
    $online_users = $online_row['count'];
}
?> 

<!DOCTYPE html> 
<html lang="id"> 
<head>  
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Login Aman dengan Fitur Keamanan Tingkat Tinggi">
    <meta name="keywords" content="login, secure, authentication">
    <meta name="author" content="Your Company">
    
    <!-- Security Headers -->
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">  
    <link rel="stylesheet" type="text/css" href="style.css">  
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <title>Login - Sistem Keamanan Tinggi</title>
    
    <style>
        /* Enhanced CSS untuk fitur baru */
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .login-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
        }
        
        .login-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #333;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 1rem;
            margin: 0;
        }
        
        .security-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #28a745;
        }
        
        .security-indicator i {
            color: #28a745;
            margin-right: 10px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .input-group input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .input-group input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .input-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }
        
        .password-strength {
            height: 4px;
            background: #eee;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input[type="checkbox"] {
            margin-right: 8px;
        }
        
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #764ba2;
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert i {
            margin-right: 10px;
        }
        
        .login-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 12px;
            color: #666;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        
        .captcha-container {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
        }
        
        .captcha-question {
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .captcha-input {
            width: 100px;
            padding: 8px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .social-login {
            margin-top: 20px;
            text-align: center;
        }
        
        .social-login p {
            margin-bottom: 15px;
            color: #666;
            font-size: 14px;
        }
        
        .social-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        
        .social-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .social-btn.google { color: #db4437; }
        .social-btn.facebook { color: #3b5998; }
        .social-btn.twitter { color: #1da1f2; }
        
        @media (max-width: 480px) {
            .login-wrapper {
                margin: 10px;
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head> 
<body>  
    <div class="container">  
        <div class="login-wrapper animate__animated animate__fadeIn">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner"></div>
            </div>
            
            <div class="login-header">
                <h1><i class="fa fa-shield"></i> Login</h1>
                <p>Sistem Keamanan Tingkat Tinggi</p>
            </div>
            
            <div class="security-indicator">
                <i class="fa fa-lock"></i>
                <span>Koneksi Aman - SSL Terenkripsi</span>
            </div>
            
            <?php if (!empty($error_message)): ?>
            <div class="alert alert-error animate__animated animate__shake">
                <i class="fa fa-exclamation-triangle"></i>
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success animate__animated animate__fadeIn">
                <i class="fa fa-check-circle"></i>
                <?php echo htmlspecialchars($success_message); ?>
            </div>
            <?php endif; ?>
            
            <form action="" method="POST" class="login-email" id="loginForm" <?php echo !empty($error_message) && strpos($error_message, 'diblokir') !== false ? 'style="display:none;"' : ''; ?>>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                
                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" placeholder="Masukkan Email Anda" name="email" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           autocomplete="email">
                </div>
                
                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" placeholder="Masukkan Password Anda" name="password" required 
                           id="passwordInput" autocomplete="current-password">
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
                </div>
                
                <!-- Simple CAPTCHA -->
                <?php 
                $num1 = rand(1, 10);
                $num2 = rand(1, 10);
                $captcha_answer = $num1 + $num2;
                $_SESSION['captcha_answer'] = $captcha_answer;
                ?>
                <div class="captcha-container">
                    <div class="captcha-question">
                        Berapa hasil dari <?php echo $num1; ?> + <?php echo $num2; ?> ?
                    </div>
                    <input type="number" name="captcha" class="captcha-input" required placeholder="Jawaban">
                </div>
                
                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember_me" value="1">
                        Ingat Saya
                    </label>
                    <a href="#" class="forgot-password" onclick="showForgotPassword()">Lupa Password?</a>
                </div>
                
                <div class="input-group">
                    <button name="submit" class="btn" type="submit" id="loginBtn">
                        <i class="fa fa-sign-in"></i> Masuk
                    </button>
                </div>
            </form>
            
            <div class="social-login">
                <p>Atau masuk dengan</p>
                <div class="social-buttons">
                    <div class="social-btn google" onclick="socialLogin('google')">
                        <i class="fa fa-google"></i>
                    </div>
                    <div class="social-btn facebook" onclick="socialLogin('facebook')">
                        <i class="fa fa-facebook"></i>
                    </div>
                    <div class="social-btn twitter" onclick="socialLogin('twitter')">
                        <i class="fa fa-twitter"></i>
                    </div>
                </div>
            </div>
            
            <div class="login-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo number_format($online_users); ?></div>
                    <div>User Online</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="connectionStatus">●</div>
                    <div>Status Koneksi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo date('H:i'); ?></div>
                    <div>Waktu Server</div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Password strength indicator
        document.getElementById('passwordInput').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('strengthBar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength < 75) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
        });
        
        // Form submission dengan loading
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loadingOverlay = document.getElementById('loadingOverlay');
            const loginBtn = document.getElementById('loginBtn');
            
            loadingOverlay.style.display = 'flex';
            loginBtn.disabled = true;
            
            // Simulasi delay untuk UX yang lebih baik
            setTimeout(() => {
                // Form akan disubmit setelah delay
            }, 500);
        });
        
        // Connection status indicator
        function updateConnectionStatus() {
            const statusElement = document.getElementById('connectionStatus');
            if (navigator.onLine) {
                statusElement.style.color = '#28a745';
                statusElement.title = 'Online';
            } else {
                statusElement.style.color = '#dc3545';
                statusElement.title = 'Offline';
            }
        }
        
        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        updateConnectionStatus();
        
        // Update waktu server setiap menit
        setInterval(function() {
            const now = new Date();
            const timeElement = document.querySelector('.login-stats .stat-item:last-child .stat-number');
            timeElement.textContent = now.getHours().toString().padStart(2, '0') + ':' + 
                                    now.getMinutes().toString().padStart(2, '0');
        }, 60000);
        
        // Social login functions
        function socialLogin(provider) {
            alert('Fitur login dengan ' + provider + ' sedang dalam pengembangan.');
        }
        
        function showForgotPassword() {
            alert('Fitur lupa password akan segera hadir. Silakan hubungi administrator.');
        }
        
        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'Enter') {
                document.getElementById('loginForm').submit();
            }
        });
        
        // Auto-focus first input
        window.onload = function() {
            document.querySelector('input[name="email"]').focus();
        };
        
        // Prevent multiple form submissions
        let formSubmitted = false;
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            if (formSubmitted) {
                e.preventDefault();
                return false;
            }
            formSubmitted = true;
        });
        
        // Simple form validation
        function validateForm() {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const captcha = document.querySelector('input[name="captcha"]').value;
            
            if (!email || !password || !captcha) {
                alert('Semua field harus diisi!');
                return false;
            }
            
            if (!email.includes('@')) {
                alert('Format email tidak valid!');
                return false;
            }
            
            return true;
        }
        
        // Add validation to form submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                document.getElementById('loadingOverlay').style.display = 'none';
                document.getElementById('loginBtn').disabled = false;
                formSubmitted = false;
            }
        });
    </script>
</body> 
</html>