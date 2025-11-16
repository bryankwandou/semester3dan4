<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);

// Koneksi database
require_once 'config.php'; // Sesuaikan dengan file koneksi database Anda

// Ambil resep yang dibuat oleh user
$user_id = $_SESSION['user_id'];
$query = "SELECT id, nama_resep, kategori, foto_path, waktu_masak, porsi, created_at FROM recipes WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user_recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SajianNusantara</title>
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

        .dashboard-content {
            padding: 50px 0;
        }
        .user-info {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .quick-actions {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }
        .action-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            flex: 1;
            min-width: 250px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .action-card h4 {
            color: #333;
            margin-bottom: 15px;
        }
        .action-card p {
            color: #666;
            margin-bottom: 20px;
        }
        .action-card .icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
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
        
        /* Styling untuk section resep user */
        .user-recipes-section {
            margin-top: 50px;
        }
        .section-heading {
            margin-bottom: 30px;
        }
        .section-heading h3 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .section-heading p {
            color: #666;
            font-size: 1.1rem;
        }
        .no-recipes {
            text-align: center;
            padding: 50px;
            background: #f8f9fa;
            border-radius: 10px;
        }
        .no-recipes h4 {
            color: #666;
            margin-bottom: 15px;
        }
        .no-recipes p {
            color: #999;
            margin-bottom: 20px;
        }
        
        /* Recipe card styling - menggunakan style existing */
        .single-best-receipe-area {
            /* Mengandalkan CSS yang sudah ada di style.css */
        }
        .single-best-receipe-area img {
            /* Mengandalkan CSS yang sudah ada di style.css */
        }
        .receipe-content {
            /* Mengandalkan CSS yang sudah ada di style.css */
        }
        .receipe-content h5 {
            /* Mengandalkan CSS yang sudah ada di style.css */
        }
        .recipe-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .recipe-meta small {
            color: #666;
            font-size: 0.9rem;
        }
        .recipe-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        .btn-sm {
            padding: 5px 15px;
            font-size: 0.9rem;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-edit {
            background: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background: #218838;
            color: white;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background: #c82333;
            color: white;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .quick-actions {
                flex-direction: column;
            }
            .action-card {
                min-width: 100%;
            }
            .recipe-actions {
                flex-direction: column;
            }
            .btn-sm {
                text-align: center;
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
    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <div class="container">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <!-- User Info -->
            <div class="user-info">
                <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                <p><strong>Total Resep:</strong> <?php echo count($user_recipes); ?> resep</p>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <div class="action-card">
                    <span class="icon">❤️</span>
                    <h4>Resep Favorit</h4>
                    <p>Simpan dan kelola resep favorit Anda</p>
                    <a href="favorit.php" class="btn delicious-btn">Kelola Favorit</a>
                </div>
                
                <div class="action-card">
                    <span class="icon">👤</span>
                    <h4>Profil Saya</h4>
                    <p>Edit informasi profil dan ubah password</p>
                    <a href="edit_profil.php" class="btn delicious-btn">Edit Profil</a>
                </div>

                <div class="action-card">
                    <span class="icon">➕</span>
                    <h4>Membuat Resep</h4>
                    <p>Buat dan bagikan resep masakan favorit Anda</p>
                    <a href="buat_resep.php" class="btn delicious-btn">Buat Resep</a>
                </div>
            </div>

            <!-- User Recipes Section -->
            <div class="user-recipes-section">
                <div class="section-heading">
                    <h3>Resep Saya</h3>
                    <p>Kelola resep yang telah Anda buat</p>
                </div>

                <?php if (count($user_recipes) > 0): ?>
                    <div class="row">
                        <?php foreach ($user_recipes as $recipe): ?>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="single-best-receipe-area mb-30">
                                    <?php 
                                    // Tentukan gambar yang akan ditampilkan
                                    $image_src = 'img/bg-img/default-recipe.jpg'; // gambar default
                                    if (!empty($recipe['foto_path']) && file_exists($recipe['foto_path'])) {
                                        $image_src = $recipe['foto_path'];
                                    }
                                    ?>
                                    <img src="<?php echo htmlspecialchars($image_src); ?>" alt="">
                                    <div class="receipe-content">
                                        <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                            <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                        </a>
                                        
                                        <div class="recipe-content" style="text-align: center;">
                                            <a href="edit_resep.php?id=<?php echo $recipe['id']; ?>" class="btn-sm btn-edit">Edit</a>
                                            <a href="hapus_resep.php?id=<?php echo $recipe['id']; ?>" 
                                               class="btn-sm btn-delete" 
                                              >Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-recipes">
                        <h4>Belum ada resep</h4>
                        <p>Anda belum membuat resep apapun. Mulai berbagi resep favorit Anda!</p>
                        <a href="buat_resep.php" class="btn delicious-btn">Buat Resep Pertama</a>
                    </div>
                <?php endif; ?>
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
    // Konfirmasi hapus resep
    // function confirmDelete(recipeId, recipeName) {
    //     if (confirm('Apakah Anda yakin ingin menghapus resep "' + recipeName + '"?')) {
    //         window.location.href = 'hapus_resep.php?id=' + recipeId;
    //     }
    // }
    </script>
</body>
</html>