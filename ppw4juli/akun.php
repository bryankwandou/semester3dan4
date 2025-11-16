<?php 
session_start();
require_once 'config.php';

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Ambil data dari session untuk menampilkan kembali jika ada error
$old_data = isset($_SESSION['old_data']) ? $_SESSION['old_data'] : [];
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

// Hapus data session setelah digunakan
unset($_SESSION['old_data']);
unset($_SESSION['errors']);
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Title -->
    <title>SajianNusantara - Resep Masakan Indonesia | Daftar Akun</title>
    
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">
    
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Alert Styles -->
    <style>
        select {
            display: inline-block;
            z-index: 999;
        }
        /* Navigation Search Bar Styles */
        .nav-search-item {
            display: flex !important;
            align-items: center;
            margin: 0 20px;
        }

        .nav-search-form {
            margin: 0;
            padding: 0;
        }

        .nav-search-wrapper {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 25px;
            padding: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            min-width: 350px;
        }

        .nav-search-input {
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            flex: 2;
            background: transparent;
            outline: none;
            min-width: 150px;
        }

        .nav-search-select {
            border: none;
            padding: 8px 10px;
            font-size: 12px;
            background: transparent;
            outline: none;
            flex: 1;
            min-width: 100px;
            color: #666;
        }

        .nav-search-btn {
            background: #D62828;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-search-btn:hover {
            background: #B71C1C;
        }

        /* Mobile Navigation Search */
        @media (max-width: 992px) {
            .nav-search-wrapper {
                min-width: 280px;
                flex-direction: column;
                padding: 10px;
                gap: 8px;
            }
            
            .nav-search-input,
            .nav-search-select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background: white;
            }
            
            .nav-search-btn {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
            }
        }

        @media (max-width: 768px) {
            .nav-search-item {
                margin: 10px 0;
                width: 100%;
            }
            
            .nav-search-wrapper {
                min-width: 100%;
            }
        }

        /* Hide the separate search section when search is in nav */
        .search-section {
            display: none;
        }

        /* Show search section only on mobile */
        @media (max-width: 768px) {
            .search-section {
                display: block;
                background: #D62828;
                padding: 20px 0;
                margin: 0;
            }
            
            .nav-search-item {
                display: none !important;
            }
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }

        /* Registration specific styles */
        .registration-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .login-link {
            text-align: center;
            margin-top: 0px;
            padding: 20px;

            border-radius: 8px;
        }

        .login-link a {
            color: #D62828;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .new-footer-area {
            background-color: #333;
            color: #fff;
            padding: 40px 0;
            position: relative;
            overflow: hidden;
        }

        .new-footer-area .container {
            position: relative;
            z-index: 1;
        }

        .footer-content-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer-left,
        .footer-right {
            flex: 1;
            min-width: 300px;
        }

        .footer-left {
            text-align: left;
        }

        .footer-social-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .footer-social-links a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .footer-social-links a:hover {
            color: #D62828;
        }

        .footer-social-links img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .footer-right {
            text-align: right;
        }

        .footer-info h5 {
            color: #D62828;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .footer-info p {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .footer-info p:last-child {
            margin-bottom: 0;
            font-size: 14px;
            opacity: 0.8;
        }

        .footer-center-cut {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 2px;
            height: 200%;
            background-color: #000;
            z-index: 0;
            clip-path: none;
        }

        @media (max-width: 768px) {
            .footer-content-wrapper {
                flex-direction: column;
                text-align: center;
            }

            .footer-left,
            .footer-right {
                min-width: unset;
                width: 100%;
                text-align: center;
            }

            .footer-social-links {
                flex-direction: row;
                justify-content: center;
                margin-bottom: 20px;
            }

            .footer-center-cut {
                width: 100%;
                height: 1px;
                top: 50%;
                transform: translateY(-50%);
                background-color: #555;
            }

            .footer-info {
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .new-footer-area {
                padding: 30px 0;
            }

            .footer-social-links a {
                font-size: 16px;
            }

            .footer-info h5 {
                font-size: 18px;
            }

            .footer-info p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <i class="circle-preloader"></i>
        <img src="img/core-img/s.jpg" alt="">
    </div>

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">
        <!-- Navbar Area -->
        <div class="delicious-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="deliciousNav">

                        <!-- Logo -->
                        <a class="nav-brand" href="index.php" style="flex-shrink: 0;">
                            <img src="img/core-img/S.jpg" width="100" height="100" alt="">
                        </a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">
                            <!-- close btn -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul style="display: flex; align-items: center; gap: 20px; margin: 0; padding: 0; margin-left: 100px;">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="nav-search-item">
                                        <form class="nav-search-form" method="GET" action="index.php">
                                            <div class="nav-search-wrapper">
                                                <input type="text" 
                                                       class="nav-search-input" 
                                                       name="search" 
                                                       placeholder="Cari resep..." 
                                                       value="">
                                                <button type="submit" class="nav-search-btn">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </li>
                                    <li><a href="favorit.php">Favorit</a></li>
                                    <li class="active"><a href="akun.php">Akun</a></li>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <li><a href="process.php?logout=1">Logout</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- Alert Messages -->
    <?php if (!empty($success)): ?>
        <div class="container mt-5">
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="container mt-5">
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <div class="contact-area section-padding-0-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Daftar Akun Baru</h2>
                        <p>Bergabunglah dengan komunitas pecinta kuliner Nusantara</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="registration-container">
                        <div class="contact-form-area">
                            <form action="process.php" method="post">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <input type="text" class="form-control" name="nama" 
                                               placeholder="Nama Lengkap" 
                                               value="<?php echo isset($old_data['nama']) ? htmlspecialchars($old_data['nama']) : ''; ?>" 
                                               required>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="email" class="form-control" name="email" 
                                               placeholder="E-mail" 
                                               value="<?php echo isset($old_data['email']) ? htmlspecialchars($old_data['email']) : ''; ?>" 
                                               required>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="password" class="form-control" name="password" 
                                               placeholder="Password (minimal 6 karakter)" 
                                               minlength="6" required>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <input type="password" class="form-control" name="confirmpass" 
                                               placeholder="Konfirmasi Password" 
                                               minlength="6" required>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button name="send" class="btn delicious-btn mt-30" type="submit">Daftar Sekarang</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Login Link -->
                        <div class="login-link">
                            <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ##### Footer Area Start ##### -->
    <footer class="new-footer-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-content-wrapper">
                        <div class="footer-left">
                            <div class="footer-social-links">
                                <div class="footer-info">
                                    <h5 style="margin-top: 1.5px;">Sosial Media Kami</h5>
                                </div>
                                <a href="www.instagram.com" class="instagram-icon"><img src="img/sosmed-img/instagram-bg.png" alt="Instagram"> Instagram</a>
                                <a href="www.facebook.com" class="facebook-icon"><img src="img/sosmed-img/facebook-bg.png" alt="Facebook"> Facebook</a>
                                <a href="www.youtube.com" class="youtube-icon"><img src="img/sosmed-img/youtube-bg.png" alt="Youtube"> Youtube</a>
                                <a href="www.tiktok.com" class="youtube-icon"><img src="img/sosmed-img/tiktok-bg.png" alt="Tiktok"> Tiktok</a>
                            </div>
                        </div>
                        <div class="footer-center-cut"></div>
                        <div class="footer-right">
                            <div class="footer-info">
                                <h5>Tentang Kami</h5>
                                <p>SajianNusantara adalah platform komunitas resep masakan khas Indonesia yang menyajikan ragam hidangan autentik dari Sabang hingga Merauke. Kami menghadirkan resep-resep pilihan yang mudah diikuti, cocok untuk pemula maupun pecinta kuliner Nusantara. Di platform ini, siapa saja dapat berbagi resep mereka sendiri, menjelajahi kreasi kuliner pengguna lain, dan menjadi bagian dari komunitas pecinta masakan Indonesia.</p>
                                <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> SajianNusantara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- ##### All Javascript Files ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
    
    <!-- Password Confirmation Validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const confirmPasswordInput = document.querySelector('input[name="confirmpass"]');
            
            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', function() {
                    if (passwordInput.value !== confirmPasswordInput.value) {
                        confirmPasswordInput.setCustomValidity('Password tidak sesuai');
                    } else {
                        confirmPasswordInput.setCustomValidity('');
                    }
                });
            }
        });
    </script>
</body>

</html>