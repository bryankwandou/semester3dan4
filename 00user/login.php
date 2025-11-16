<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Property</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #134e4a 0%, #0f766e 50%, #14b8a6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255,255,255,0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 900px;
            min-height: 600px;
            display: flex;
            overflow: hidden;
            position: relative;
            margin: 20px;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            position: relative;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .brand {
            position: relative;
            z-index: 1;
        }

        .brand h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .brand p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .feature-list {
            list-style: none;
            text-align: left;
        }

        .feature-list li {
            margin: 15px 0;
            padding-left: 30px;
            position: relative;
            opacity: 0.9;
        }

        .feature-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: #fbbf24;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .right-panel {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h2 {
            color: #134e4a;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #6b7280;
            font-size: 1rem;
        }

        .form-tabs {
            display: flex;
            margin-bottom: 30px;
            background: #f3f4f6;
            border-radius: 10px;
            padding: 4px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background: transparent;
            color: #6b7280;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background: #0f766e;
            color: white;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.3);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            color: #374151;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .input-group input:focus {
            outline: none;
            border-color: #0f766e;
            background: white;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 25px;
        }

        .forgot-password a {
            color: #0f766e;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .btn-primary {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(15, 118, 110, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 118, 110, 0.4);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
            color: #6b7280;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 20px;
            position: relative;
        }

        .social-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .social-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .social-btn:hover {
            border-color: #0f766e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .google { color: #db4437; }
        .facebook { color: #4267b2; }
        .instagram { color: #e4405f; }
        .twitter { color: #1da1f2; }

        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-to-home:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                max-width: 400px;
                margin: 10px;
            }

            .left-panel {
                padding: 30px 20px;
                order: 2;
            }

            .right-panel {
                padding: 30px 20px;
                order: 1;
            }

            .brand h1 {
                font-size: 2rem;
            }

            .social-buttons {
                flex-wrap: wrap;
            }

            .social-btn {
                flex: 0 0 calc(50% - 5px);
            }
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .left-panel {
            animation: slideInLeft 0.8s ease-out;
        }

        .right-panel {
            animation: slideInRight 0.8s ease-out;
        }

        /* OTP and Reset Password Styles */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .otp-input:focus {
            border-color: #0f766e;
            outline: none;
        }

        .resend-otp {
            text-align: center;
            margin-top: 15px;
        }

        .resend-otp button {
            background: none;
            border: none;
            color: #0f766e;
            cursor: pointer;
            font-weight: 600;
            text-decoration: underline;
        }

        /* Success Message Styles */
        .success-message {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-to-home">← Kembali ke Dashboard</a>
    
    <div class="container">
        <div class="left-panel">
            <div class="brand">
                <h1>Property</h1>
                <p>Platform terpercaya untuk menemukan properti impian Anda</p>
                <ul class="feature-list">
                    <li>Ribuan pilihan properti terkini</li>
                    <li>Pencarian dengan filter canggih</li>
                    <li>Konsultasi gratis dengan ahli</li>
                    <li>Proses transaksi yang aman</li>
                </ul>
            </div>
        </div>

        <div class="right-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Selamat Datang</h2>
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <div class="form-tabs">
                    <button class="tab-btn active" onclick="switchTab('login')">Masuk</button>
                    <button class="tab-btn" onclick="switchTab('register')">Daftar</button>
                </div>

                <!-- Login Form -->
                <div id="login" class="form-section active">
                    <div id="login-success-message" class="success-message" style="display: none;"></div>
                    <form onsubmit="handleLogin(event)">
                        <div class="input-group">
                            <label for="username">Username atau Email</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">👁️</button>
                        </div>
                        <div class="forgot-password">
                            <a href="#" onclick="showForgotPassword()">Lupa Password?</a>
                        </div>
                        <button type="submit" class="btn-primary">Masuk</button>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="register" class="form-section">
                    <div id="register-success-message" class="success-message" style="display: none;"></div>
                    <form onsubmit="handleRegister(event)">
                        <div class="input-group">
                            <label for="reg-name">Nama Lengkap</label>
                            <input type="text" id="reg-name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="reg-email">Email</label>
                            <input type="email" id="reg-email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="reg-username">Username</label>
                            <input type="text" id="reg-username" name="username" required>
                        </div>
                        <div class="input-group">
                            <label for="reg-password">Password</label>
                            <input type="password" id="reg-password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('reg-password')">👁️</button>
                        </div>
                        <div class="input-group">
                            <label for="reg-confirm-password">Konfirmasi Password</label>
                            <input type="password" id="reg-confirm-password" name="confirm-password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('reg-confirm-password')">👁️</button>
                        </div>
                        <button type="submit" class="btn-primary">Daftar</button>
                    </form>
                </div>

                <!-- Forgot Password Form -->
                <div id="forgot-password" class="form-section">
                    <div class="form-header">
                        <h2>Lupa Password</h2>
                        <p>Masukkan email Anda untuk mendapatkan kode OTP</p>
                    </div>
                    <form onsubmit="handleForgotPassword(event)">
                        <div class="input-group">
                            <label for="forgot-email">Email</label>
                            <input type="email" id="forgot-email" name="email" required>
                        </div>
                        <button type="submit" class="btn-primary">Kirim Kode OTP</button>
                    </form>
                    <div style="text-align: center; margin-top: 20px;">
                        <button onclick="showLogin()" style="background: none; border: none; color: #0f766e; cursor: pointer; font-weight: 600;">← Kembali ke Login</button>
                    </div>
                </div>

                <!-- OTP Verification Form -->
                <div id="otp-verification" class="form-section">
                    <div class="form-header">
                        <h2>Verifikasi OTP</h2>
                        <p>Masukkan 6 digit kode yang dikirim ke email Anda</p>
                    </div>
                    <form onsubmit="handleOTPVerification(event)">
                        <div class="otp-inputs">
                            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 0)">
                            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 1)">
                            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 2)">
                            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 3)">
                            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 4)">
                            <input type="text" class="otp-input" maxlength="1" oninput="moveToNext(this, 5)">
                        </div>
                        <div class="resend-otp">
                            <p>Tidak menerima kode? <button onclick="resendOTP()">Kirim Ulang</button></p>
                        </div>
                        <button type="submit" class="btn-primary">Verifikasi</button>
                    </form>
                </div>

                <!-- Reset Password Form -->
                <div id="reset-password" class="form-section">
                    <div class="form-header">
                        <h2>Password Baru</h2>
                        <p>Buat password baru untuk akun Anda</p>
                    </div>
                    <form onsubmit="handleResetPassword(event)">
                        <div class="input-group">
                            <label for="new-password">Password Baru</label>
                            <input type="password" id="new-password" name="new-password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('new-password')">👁️</button>
                        </div>
                        <div class="input-group">
                            <label for="confirm-new-password">Konfirmasi Password Baru</label>
                            <input type="password" id="confirm-new-password" name="confirm-new-password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirm-new-password')">👁️</button>
                        </div>
                        <button type="submit" class="btn-primary">Ubah Password</button>
                    </form>
                </div>

                <div class="divider">
                    <span>atau masuk dengan</span>
                </div>

                <div class="social-buttons">
                    <button class="social-btn google" onclick="socialLogin('google')" title="Login dengan Google">
                        <span>G</span>
                    </button>
                    <button class="social-btn facebook" onclick="socialLogin('facebook')" title="Login dengan Facebook">
                        <span>f</span>
                    </button>
                    <button class="social-btn instagram" onclick="socialLogin('instagram')" title="Login dengan Instagram">
                        <span>📷</span>
                    </button>
                    <button class="social-btn twitter" onclick="socialLogin('twitter')" title="Login dengan Twitter">
                        <span>🐦</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected section and activate tab
            document.getElementById(tab).classList.add('active');
            event.target.classList.add('active');
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                button.textContent = '🙈';
            } else {
                input.type = 'password';
                button.textContent = '👁️';
            }
        }

        function showForgotPassword() {
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('forgot-password').classList.add('active');
        }

        function showLogin() {
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('login').classList.add('active');
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector('.tab-btn').classList.add('active');
        }

        function showSuccessMessage(messageElementId, message) {
            const messageElement = document.getElementById(messageElementId);
            messageElement.textContent = message;
            messageElement.style.display = 'block';
            
            // Hide message after 3 seconds
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 3000);
        }

        function handleLogin(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const username = formData.get('username');
            const password = formData.get('password');
            
            // Validasi sederhana (bisa diganti dengan validasi ke server)
            if (username && password) {
                // Redirect ke index.php setelah login berhasil
                window.location.href = 'index.php';
            } else {
                alert('Mohon lengkapi semua field!');
            }
        }

        function handleRegister(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const name = formData.get('name');
            const email = formData.get('email');
            const username = formData.get('username');
            const password = formData.get('password');
            const confirmPassword = formData.get('confirm-password');
            
            // Validasi password
            if (password !== confirmPassword) {
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }
            
            // Validasi semua field terisi
            if (!name || !email || !username || !password) {
                alert('Mohon lengkapi semua field!');
                return;
            }
            
            // Simulasi registrasi berhasil
            showSuccessMessage('register-success-message', 'Registrasi berhasil! Silakan login dengan akun baru Anda.');
            
            // Reset form
            event.target.reset();
            
            // Pindah ke tab login setelah 2 detik
            setTimeout(() => {
                switchTabManually('login');
            }, 2000);
        }

        function switchTabManually(tab) {
            // Hide all sections
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected section and activate tab
            document.getElementById(tab).classList.add('active');
            
            // Activate the correct tab button
            if (tab === 'login') {
                document.querySelector('.tab-btn').classList.add('active');
            } else if (tab === 'register') {
                document.querySelectorAll('.tab-btn')[1].classList.add('active');
            }
        }

        function handleForgotPassword(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const email = formData.get('email');
            
            // Simulasi kirim OTP
            alert(`Kode OTP telah dikirim ke ${email}`);
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('otp-verification').classList.add('active');
        }

        function handleOTPVerification(event) {
            event.preventDefault();
            const otpInputs = document.querySelectorAll('.otp-input');
            const otp = Array.from(otpInputs).map(input => input.value).join('');
            
            if (otp.length !== 6) {
                alert('Silakan masukkan 6 digit kode OTP!');
                return;
            }
            
            // Simulasi verifikasi OTP
            alert('OTP berhasil diverifikasi!');
            document.querySelectorAll('.form-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('reset-password').classList.add('active');
        }

        function handleResetPassword(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const newPassword = formData.get('new-password');
            const confirmNewPassword = formData.get('confirm-new-password');
            
            if (newPassword !== confirmNewPassword) {
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }
            
            // Simulasi reset password
            alert('Password berhasil diubah! Silakan login dengan password baru.');
            showLogin();
        }

        function moveToNext(current, index) {
            if (current.value.length === 1 && index < 5) {
                document.querySelectorAll('.otp-input')[index + 1].focus();
            }
        }

        function resendOTP() {
            alert('Kode OTP baru telah dikirim!');
        }

        function socialLogin(platform) {
            alert(`Login dengan ${platform} akan tersedia segera!`);
            // Di sini Anda bisa menambahkan integrasi dengan OAuth dari platform yang dipilih
        }
    </script>
</body>
</html>