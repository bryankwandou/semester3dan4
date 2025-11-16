<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - NNGProperty Indonesia</title>
    <meta name="description" content="Login ke akun NNGProperty Anda">
    <meta name="keywords" content="login, property, indonesia">

    <!-- Favicons -->
    <link href="E:\bootstrap html project\EstateAgency\Property\ico.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2c5530;
            --secondary-color: #7db46c;
            --accent-color: #a8d5ba;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 0 20px rgba(0,0,0,0.1);
            --shadow-hover: 0 0 30px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-5px);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .logo:hover {
            color: var(--secondary-color);
            transform: scale(1.05);
        }

        .logo span {
            color: var(--secondary-color);
        }

        .welcome-text {
            color: var(--text-light);
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .form-tabs {
            display: flex;
            background: var(--bg-light);
            border-radius: 12px;
            padding: 5px;
            margin-bottom: 30px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 20px;
            background: transparent;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            color: var(--text-light);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .tab-btn.active {
            background: var(--white);
            color: var(--primary-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(125, 180, 108, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-primary {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            color: var(--white);
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(44, 85, 48, 0.3);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
            color: var(--text-light);
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
        }

        .divider span {
            background: var(--white);
            padding: 0 20px;
            position: relative;
        }

        .social-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: var(--white);
            color: var(--text-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            border-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-decoration: none;
            color: var(--text-dark);
        }

        .social-btn i {
            margin-right: 8px;
            font-size: 1.2rem;
        }

        .google { color: #db4437; }
        .facebook { color: #4267B2; }
        .instagram { color: #E4405F; }
        .twitter { color: #1DA1F2; }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-home:hover {
            background: var(--white);
            color: var(--primary-color);
            transform: translateX(-5px);
            text-decoration: none;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3em;
            color: var(--secondary-color);
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: rgba(125, 180, 108, 0.1);
            color: var(--primary-color);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 15px;
            }
            
            .login-card {
                padding: 30px 25px;
            }
            
            .social-login {
                grid-template-columns: 1fr;
            }
            
            .back-home {
                position: relative;
                top: 0;
                left: 0;
                display: block;
                text-align: center;
                margin-bottom: 20px;
                border-radius: 12px;
            }
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
        }

        .checkbox-wrapper label {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <a href="index.html" class="back-home">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>

    <div class="login-container">
        <div class="login-card" data-aos="fade-up" data-aos-duration="800">
            <div class="logo-section">
                <a href="index.html" class="logo">NNG<span>Property</span></a>
                <p class="welcome-text">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
            </div>

            <div class="form-tabs">
                <button class="tab-btn active" onclick="switchTab('login')">Masuk</button>
                <button class="tab-btn" onclick="switchTab('register')">Daftar</button>
            </div>

            <!-- Login Form -->
            <div id="login-section" class="form-section active">
                <form id="loginForm">
                    <div class="form-group">
                        <label class="form-label">Username atau Email</label>
                        <input type="text" class="form-control" id="loginUsername" placeholder="Masukkan username atau email" required>
                    </div>

                    <div class="form-group" style="position: relative;">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="loginPassword" placeholder="Masukkan password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')">
                            <i class="bi bi-eye" id="loginPasswordIcon"></i>
                        </button>
                    </div>

                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="rememberMe">
                        <label for="rememberMe">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </form>

                <div class="divider">
                    <span>atau masuk dengan</span>
                </div>

                <div class="social-login">
                    <a href="#" class="social-btn" onclick="socialLogin('google')">
                        <i class="bi bi-google google"></i>Google
                    </a>
                    <a href="#" class="social-btn" onclick="socialLogin('facebook')">
                        <i class="bi bi-facebook facebook"></i>Facebook
                    </a>
                    <a href="#" class="social-btn" onclick="socialLogin('instagram')">
                        <i class="bi bi-instagram instagram"></i>Instagram
                    </a>
                    <a href="#" class="social-btn" onclick="socialLogin('twitter')">
                        <i class="bi bi-twitter twitter"></i>Twitter
                    </a>
                </div>

                <div class="forgot-password">
                    <a href="#" onclick="switchTab('forgot')">Lupa password?</a>
                </div>
            </div>

            <!-- Register Form -->
            <div id="register-section" class="form-section">
                <form id="registerForm">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="regUsername" placeholder="Pilih username" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Masukkan nomor telepon" required>
                    </div>

                    <div class="form-group" style="position: relative;">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="regPassword" placeholder="Buat password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('regPassword')">
                            <i class="bi bi-eye" id="regPasswordIcon"></i>
                        </button>
                    </div>

                    <div class="form-group" style="position: relative;">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Ulangi password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                            <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                        </button>
                    </div>

                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="agreeTerms" required>
                        <label for="agreeTerms">Saya setuju dengan <a href="#" style="color: var(--secondary-color);">syarat dan ketentuan</a></label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </button>
                </form>

                <div class="divider">
                    <span>atau daftar dengan</span>
                </div>

                <div class="social-login">
                    <a href="#" class="social-btn" onclick="socialLogin('google')">
                        <i class="bi bi-google google"></i>Google
                    </a>
                    <a href="#" class="social-btn" onclick="socialLogin('facebook')">
                        <i class="bi bi-facebook facebook"></i>Facebook
                    </a>
                    <a href="#" class="social-btn" onclick="socialLogin('instagram')">
                        <i class="bi bi-instagram instagram"></i>Instagram
                    </a>
                    <a href="#" class="social-btn" onclick="socialLogin('twitter')">
                        <i class="bi bi-twitter twitter"></i>Twitter
                    </a>
                </div>
            </div>

            <!-- Forgot Password Form -->
            <div id="forgot-section" class="form-section">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h4 style="color: var(--primary-color); margin-bottom: 10px;">Lupa Password?</h4>
                    <p style="color: var(--text-light); font-size: 0.9rem;">Masukkan email Anda dan kami akan mengirimkan kode OTP untuk reset password.</p>
                </div>

                <form id="forgotForm">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="forgotEmail" placeholder="Masukkan email Anda" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-envelope me-2"></i>Kirim Kode OTP
                    </button>
                </form>

                <div class="forgot-password">
                    <a href="#" onclick="switchTab('login')">Kembali ke Login</a>
                </div>
            </div>

            <!-- OTP Verification Form -->
            <div id="otp-section" class="form-section">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h4 style="color: var(--primary-color); margin-bottom: 10px;">Verifikasi OTP</h4>
                    <p style="color: var(--text-light); font-size: 0.9rem;">Kami telah mengirimkan kode 6 digit ke email Anda.</p>
                </div>

                <form id="otpForm">
                    <div class="form-group">
                        <label class="form-label">Kode OTP</label>
                        <input type="text" class="form-control" id="otpCode" placeholder="Masukkan 6 digit kode OTP" maxlength="6" required>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Verifikasi OTP
                    </button>
                </form>

                <div class="forgot-password">
                    <a href="#" onclick="resendOTP()">Kirim ulang kode OTP</a> |
                    <a href="#" onclick="switchTab('forgot')">Ubah email</a>
                </div>
            </div>

            <!-- Reset Password Form -->
            <div id="reset-section" class="form-section">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h4 style="color: var(--primary-color); margin-bottom: 10px;">Buat Password Baru</h4>
                    <p style="color: var(--text-light); font-size: 0.9rem;">Buat password baru yang kuat untuk akun Anda.</p>
                </div>

                <form id="resetForm">
                    <div class="form-group" style="position: relative;">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="newPassword" placeholder="Masukkan password baru" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('newPassword')">
                            <i class="bi bi-eye" id="newPasswordIcon"></i>
                        </button>
                    </div>

                    <div class="form-group" style="position: relative;">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirmNewPassword" placeholder="Ulangi password baru" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmNewPassword')">
                            <i class="bi bi-eye" id="confirmNewPasswordIcon"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-check me-2"></i>Update Password
                    </button>
                </form>
            </div>

            <!-- Loading State -->
            <div id="loading" class="loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p style="margin-top: 15px; color: var(--text-light);">Sedang memproses...</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Switch between tabs
        function switchTab(tab) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected section
            if (tab === 'login') {
                document.getElementById('login-section').classList.add('active');
                document.querySelector('.tab-btn').classList.add('active');
            } else if (tab === 'register') {
                document.getElementById('register-section').classList.add('active');
                document.querySelectorAll('.tab-btn')[1].classList.add('active');
            } else if (tab === 'forgot') {
                document.getElementById('forgot-section').classList.add('active');
                // Hide tabs for forgot password flow
                document.querySelector('.form-tabs').style.display = 'none';
            } else if (tab === 'otp') {
                document.getElementById('otp-section').classList.add('active');
            } else if (tab === 'reset') {
                document.getElementById('reset-section').classList.add('active');
            }
        }

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + 'Icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Show loading state
        function showLoading() {
            document.querySelectorAll('.form-section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById('loading').style.display = 'block';
        }

        // Hide loading state
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }

        // Show alert message
        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
            `;
            
            const card = document.querySelector('.login-card');
            card.insertBefore(alertDiv, card.firstChild);
            
            // Remove alert after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Login form handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('loginUsername').value;
            const password = document.getElementById('loginPassword').value;
            
            showLoading();
            
            // Simulate API call
            setTimeout(() => {
                hideLoading();
                
                // Simulate successful login
                if (username && password) {
                    showAlert('Login berhasil! Mengarahkan ke dashboard...', 'success');
                    
                    // Store login state
                    const userData = {
                        username: username,
                        profileImage: "E:/bootstrap html project/EstateAgency/Property/noface.png",
                        isLoggedIn: true
                    };
                    
                    // In real app, you'd store this in localStorage or send to backend
                    console.log('User logged in:', userData);
                    
                    // Redirect to index after 2 seconds
                    setTimeout(() => {
                        window.location.href = 'index.html';
                    }, 2000);
                } else {
                    showAlert('Username dan password tidak boleh kosong!', 'danger');
                    switchTab('login');
                }
            }, 2000);
        });

        // Register form handler
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('regPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                showAlert('Password dan konfirmasi password tidak cocok!', 'danger');
                return;
            }
            
            if (password.length < 6) {
                showAlert('Password minimal 6 karakter!', 'danger');
                return;
            }
            
            showLoading();
            
            // Simulate API call
            setTimeout(() => {
                hideLoading();
                showAlert('Registrasi berhasil! Silakan login dengan akun baru Anda.', 'success');
                
                // Switch to login tab after successful registration
                setTimeout(() => {
                    switchTab('login');
                    document.querySelector('.form-tabs').style.display = 'flex';
                }, 2000);
            }, 2000);
        });

        // Forgot password form handler
        document.getElementById('forgotForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('forgotEmail').value;
            
            showLoading();
            
            // Simulate sending OTP
            setTimeout(() => {
                hideLoading();
                showAlert('Kode OTP telah dikirim ke email Anda!', 'success');
                
                setTimeout(() => {
                    switchTab('otp');
                }, 1500);
            }, 2000);
        });

// OTP form handler
document.getElementById('otpForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const otpCode = document.getElementById('otpCode').value;
    
    if (otpCode.length !== 6) {
        showAlert('Kode OTP harus 6 digit!', 'danger');
        return;
    }
    
    showLoading();
    
    // Simulate OTP verification
    setTimeout(() => {
        hideLoading();
        
        // Check if OTP is correct (in real app, this would be server verification)
        if (otpCode === '123456') { // Example valid OTP
            showAlert('Kode OTP berhasil diverifikasi!', 'success');
            
            setTimeout(() => {
                switchTab('reset'); // Switch to password reset form
            }, 1500);
        } else {
            showAlert('Kode OTP tidak valid! Silakan coba lagi.', 'danger');
            document.getElementById('otpCode').value = ''; // Clear input
            document.getElementById('otpCode').focus(); // Focus back to input
        }
    }, 2000);
});

// Reset password form handler
document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Validate password
    if (newPassword.length < 8) {
        showAlert('Password minimal 8 karakter!', 'danger');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showAlert('Konfirmasi password tidak cocok!', 'danger');
        return;
    }
    
    showLoading();
    
    // Simulate password reset
    setTimeout(() => {
        hideLoading();
        showAlert('Password berhasil diubah! Silakan login dengan password baru.', 'success');
        
        setTimeout(() => {
            switchTab('login'); // Return to login form
            document.getElementById('resetForm').reset(); // Clear form
        }, 2000);
    }, 2000);
});

// Resend OTP functionality
document.getElementById('resendOtp').addEventListener('click', function() {
    const email = document.getElementById('forgotEmail').value;
    
    showLoading();
    
    setTimeout(() => {
        hideLoading();
        showAlert('Kode OTP baru telah dikirim ke email Anda!', 'success');
    }, 1500);
});
// Social login handler
        function socialLogin(provider) {
            showLoading();
            
            setTimeout(() => {
                hideLoading();
                showAlert(`Login dengan ${provider} berhasil!`, 'success');
                
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 2000);
            }, 1500);
        }

        // Resend OTP functionality
        function resendOTP() {
            const email = document.getElementById('forgotEmail').value;
            
            if (!email) {
                showAlert('Email tidak ditemukan. Silakan kembali ke form lupa password.', 'danger');
                return;
            }
            
            showLoading();
            
            setTimeout(() => {
                hideLoading();
                showAlert('Kode OTP baru telah dikirim ke email Anda!', 'success');
            }, 1500);
        }

        // Return to login with tabs visible
        function returnToLogin() {
            document.querySelector('.form-tabs').style.display = 'flex';
            switchTab('login');
        }
    </script>
</body>
</html>