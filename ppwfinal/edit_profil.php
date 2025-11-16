<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}

// Koneksi database
require_once 'config.php';

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Ambil data user saat ini
$query = "SELECT nama, email FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    header("Location: dashboard.php");
    exit();
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    
    // Validasi input
    if (empty($nama)) {
        $error = 'Nama tidak boleh kosong.';
    } elseif (empty($email)) {
        $error = 'Email tidak boleh kosong.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        // Cek apakah email sudah digunakan oleh user lain
        $check_email = "SELECT id FROM users WHERE email = ? AND id != ?";
        $stmt_check = $pdo->prepare($check_email);
        $stmt_check->execute([$email, $user_id]);
        
        if ($stmt_check->rowCount() > 0) {
            $error = 'Email sudah digunakan oleh pengguna lain.';
        } else {
            // Jika ingin mengubah password
            if (!empty($password_lama) || !empty($password_baru) || !empty($konfirmasi_password)) {
                if (empty($password_lama)) {
                    $error = 'Password lama harus diisi untuk mengubah password.';
                } elseif (empty($password_baru)) {
                    $error = 'Password baru harus diisi.';
                } elseif (strlen($password_baru) < 6) {
                    $error = 'Password baru minimal 6 karakter.';
                } elseif ($password_baru !== $konfirmasi_password) {
                    $error = 'Konfirmasi password tidak cocok.';
                } else {
                    // Verifikasi password lama
                    $verify_query = "SELECT password FROM users WHERE id = ?";
                    $verify_stmt = $pdo->prepare($verify_query);
                    $verify_stmt->execute([$user_id]);
                    $current_password = $verify_stmt->fetchColumn();
                    
                    if (!password_verify($password_lama, $current_password)) {
                        $error = 'Password lama tidak benar.';
                    } else {
                        // Update dengan password baru
                        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
                        $update_query = "UPDATE users SET nama = ?, email = ?, password = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
                        $update_stmt = $pdo->prepare($update_query);
                        
                        if ($update_stmt->execute([$nama, $email, $hashed_password, $user_id])) {
                            // Update session data
                            $_SESSION['user_name'] = $nama;
                            $_SESSION['user_email'] = $email;
                            $_SESSION['success'] = 'Profil dan password berhasil diperbarui!';
                            header("Location: dashboard.php");
                            exit();
                        } else {
                            $error = 'Terjadi kesalahan saat memperbarui profil.';
                        }
                    }
                }
            } else {
                // Update tanpa mengubah password
                $update_query = "UPDATE users SET nama = ?, email = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
                $update_stmt = $pdo->prepare($update_query);
                
                if ($update_stmt->execute([$nama, $email, $user_id])) {
                    // Update session data
                    $_SESSION['user_name'] = $nama;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['success'] = 'Profil berhasil diperbarui!';
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = 'Terjadi kesalahan saat memperbarui profil.';
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SajianNusantara</title>
    <link rel="icon" href="img/core-img/s.jpg">
    <link rel="stylesheet" href="style.css">
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

        .edit-profile-content {
            padding: 50px 0;
        }
        .profile-form-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #f96d00;
        }
        .password-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }
        .password-section h4 {
            color: #333;
            margin-bottom: 20px;
        }
        .password-note {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin-bottom: 20px;
            border-radius: 0 5px 5px 0;
        }
        .password-note p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .btn-container {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s ease;
        }
        .btn-cancel:hover {
            background: #5a6268;
            color: white;
        }
        .delicious-btn {
            padding: 12px 30px;
            font-size: 16px;
        }
        
        @media (max-width: 768px) {
            .profile-form-container {
                margin: 0 15px;
                padding: 30px 20px;
            }
            .btn-container {
                flex-direction: column;
            }
            .btn-cancel, .delicious-btn {
                text-align: center;
                width: 100%;
            }
        }

        .new-footer-area {
    background-color: #333; /* Dark background for the footer */
    color: #fff; /* White text color */
    padding: 40px 0; /* Vertical padding */
    position: relative; /* Needed for absolute positioning of cut effect */
    overflow: hidden; /* Hide anything that goes outside */
}

.new-footer-area .container {
    position: relative;
    z-index: 1; /* Ensure content is above the cut effect */
}

.footer-content-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center; /* Vertically align items in the middle */
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
    gap: 30px; /* Space between left, center, and right sections */
}

.footer-left,
.footer-right {
    flex: 1; /* Allow these sections to grow and shrink */
    min-width: 300px; /* Minimum width before wrapping */
}

.footer-left {
    text-align: left;
}

.footer-social-links {
    display: flex;
    flex-direction: column; /* Stack social links vertically */
    gap: 15px; /* Space between social links */
}

.footer-social-links a {
    color: #fff;
    text-decoration: none;
    font-size: 18px;
    display: flex; /* Align icon and text */
    align-items: center;
    transition: color 0.3s ease;
}

.footer-social-links a:hover {
    color: #D62828; /* Highlight on hover */
}

.footer-social-links img {
    width: 24px; /* Size of social media icons */
    height: 24px;
    margin-right: 10px; /* Space between icon and text */
}

.footer-right {
    text-align: right;
}

.footer-info h5 {
    color: #D62828; /* Accent color for heading */
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

/* The "Cut in the Middle" Effect - MODIFIED to be a thin black line */
.footer-center-cut {
    position: absolute;
    top: 50%; /* Posisikan di tengah vertikal */
    left: 50%; /* Posisikan di tengah horizontal */
    transform: translate(-50%, -50%); /* Geser agar benar-benar di tengah */
    width: 2px; /* Lebar garis tipis */
    height: 200%; /* Tinggi garis, bisa disesuaikan */
    background-color: #000; /* Warna hitam untuk garis */
    z-index: 0; /* Pastikan di belakang konten */

    /* Hilangkan clip-path karena kita tidak lagi membuat bentuk kompleks */
    clip-path: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .footer-content-wrapper {
        flex-direction: column; /* Stack items vertically on smaller screens */
        text-align: center;
    }

    .footer-left,
    .footer-right {
        min-width: unset; /* Remove min-width to allow full flexibility */
        width: 100%; /* Take full width */
        text-align: center; /* Center text */
    }

    .footer-social-links {
        flex-direction: row; /* Keep social links in a row if space allows */
        justify-content: center;
        margin-bottom: 20px;
    }

    .footer-center-cut {
        width: 100%; /* Make the cut span full width */
        height: 1px; /* Make it a very thin horizontal line */
        top: 50%;
        transform: translateY(-50%);
        background-color: #555; /* A simpler divider color for mobile */
    }

    .footer-info {
        margin-top: 20px; /* Add space between social links and info on mobile */
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

    <!-- Edit Profile Content -->
    <div class="edit-profile-content">
        <div class="container">
            <div class="profile-form-container">
                <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Edit Profil</h2>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <!-- Informasi Dasar -->
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user_data['nama']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                    </div>

                    <!-- Section Ubah Password -->
                    <div class="password-section">
                        <h4>Ubah Password</h4>
                        <div class="password-note">
                            <p><strong>Opsional:</strong> Isi bagian ini hanya jika Anda ingin mengubah password. Kosongkan jika tidak ingin mengubah password.</p>
                        </div>

                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <input type="password" id="password_lama" name="password_lama" placeholder="Masukkan password lama">
                        </div>

                        <div class="form-group">
                            <label for="password_baru">Password Baru</label>
                            <input type="password" id="password_baru" name="password_baru" placeholder="Masukkan password baru (minimal 6 karakter)">
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                            <input type="password" id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi password baru">
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="btn-container">
                        <button href="dashboard.php" class="btn-cancel" style="padding: 0px 12px">Batal</button>
                        <button type="submit" class="btn delicious-btn" style="padding: 0px 12px">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
<footer class="new-footer-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-content-wrapper">
                        <div class="footer-left">
                            <div class="footer-social-links">
                                <div class="footer-info">
                                    <h5 style="margin-top: 1.5px;" >Sosial Media Kami</h5>
                                </div>
                                <a href="www.instagram.com" class="instagram-icon"><img src="img/sosmed-img/instagram-bg.png" alt="Instagram"> Instagram</a>
                                <a href="www.facebook.com" class="facebook-icon"><img src="img/sosmed-img/facebook-bg.png" alt="Facebook"> Facebook</a>
                                <a href="www.youtube.com" class="youtube-icon"><img src="img/sosmed-img/youtube-bg.png" alt="Youtube"> Youtube</a>
                                <a href="www.tiktok.com" class="youtube-icon"><img src="img/sosmed-img/tiktok-bg.png" alt="Tiktok"> Tiktok</a>
                            </div>
                        </div>
                        <div class="footer-center-cut"></div> <div class="footer-right">
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

    <!-- Scripts -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>

    <script>
        // Validasi form di client side
        document.querySelector('form').addEventListener('submit', function(e) {
            const passwordLama = document.getElementById('password_lama').value;
            const passwordBaru = document.getElementById('password_baru').value;
            const konfirmasiPassword = document.getElementById('konfirmasi_password').value;
            
            // Jika ada field password yang diisi,