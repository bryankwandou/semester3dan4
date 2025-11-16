<?php
require_once 'auth.php';
require_once 'config.php';

// Ambil ID resep dari URL
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipe_id <= 0) {
    header("Location: index.php");
    exit();
}

// Query untuk mengambil detail resep beserta informasi pembuat
$query = "SELECT r.*, u.nama as user_name, u.email as user_email 
          FROM recipes r 
          LEFT JOIN users u ON r.user_id = u.id 
          WHERE r.id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika resep tidak ditemukan
if (!$recipe) {
    header("Location: index.php");
    exit();
}

// Cek apakah resep sudah difavoritkan (jika user login)
$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $favorite_query = "SELECT id FROM favorites WHERE user_id = ? AND recipe_id = ?";
    $favorite_stmt = $pdo->prepare($favorite_query);
    $favorite_stmt->execute([$_SESSION['user_id'], $recipe_id]);
    $is_favorite = $favorite_stmt->fetch() ? true : false;
}

// Decode JSON data
$bahan = json_decode($recipe['bahan'], true) ?: [];
$jumlah = json_decode($recipe['jumlah'], true) ?: [];
$langkah = json_decode($recipe['langkah'], true) ?: [];

// Tentukan gambar yang akan ditampilkan
$image_src = 'img/bg-img/default-recipe.jpg';
if (!empty($recipe['foto_path']) && file_exists($recipe['foto_path'])) {
    $image_src = $recipe['foto_path'];
}

// Convert waktu masak ke format yang lebih readable
$waktu_display = $recipe['waktu_masak'] > 0 ? $recipe['waktu_masak'] . ' menit' : 'Tidak ditentukan';
?>
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>SajianNusantara - Resep Masakan Indonesia | <?php echo htmlspecialchars($recipe['kategori']); ?> | <?php echo htmlspecialchars($recipe['nama_resep']); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">

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
                                    <li><a href="akun.php">Akun</a></li>
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

        <!-- Recipe Image Slider -->
        <div class="hero-area">
            <div class="row">
                <div class="col-12">
                    <div class="receipe-slider owl-carousel">
                        <img src="<?php echo htmlspecialchars($image_src); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipe Content Area -->
        <div class="receipe-content-area">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="receipe-headline my-5">
                            <h2 style="margin-bottom: -45px;"><?php echo htmlspecialchars($recipe['nama_resep']); ?></h2>
                            <div class="receipe-ratings text-left my-5">
                                <div class="receipe-duration">
                                    <h6 style="font-size: 20px;">Waktu Memasak <?php echo htmlspecialchars($waktu_display); ?></h6>
                                    <h6 style="font-size: 20px;">Porsi <?php echo htmlspecialchars($recipe['porsi']); ?> Orang</h6>
                                    <?php if (!empty($recipe['user_name'])): ?>
                                    <div class="recipe-author mt-3">
                                        <h6 style="font-size: 16px; color: #666;">
                                            Dibuat oleh: <?php echo htmlspecialchars($recipe['user_name']); ?>
                                            <?php if (!empty($recipe['user_email'])): ?>
                                                <span class="text-muted">(<?php echo htmlspecialchars($recipe['user_email']); ?>)</span>
                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-8">
                        <!-- Preparation Steps -->
                        <?php if (!empty($langkah)): ?>
                            <?php foreach ($langkah as $index => $step): ?>
                                <div class="single-preparation-step d-flex">
                                    <h4 style="font-size: 20px;"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>.</h4>
                                    <p style="font-size: 20px;"><?php echo nl2br(htmlspecialchars($step)); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="single-preparation-step d-flex">
                                <h4 style="font-size: 20px;">01.</h4>
                                <p style="font-size: 20px;">Langkah-langkah memasak belum ditambahkan.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Ingredients -->
                    <div class="col-12 col-lg-4">
                        <div class="ingredients">
                            <h4>Ingredients</h4>

                            <?php if (!empty($bahan) && !empty($jumlah)): ?>
                                <?php 
                                $max_items = max(count($bahan), count($jumlah));
                                for ($i = 0; $i < $max_items; $i++): 
                                    $ingredient = isset($bahan[$i]) ? $bahan[$i] : '';
                                    $amount = isset($jumlah[$i]) ? $jumlah[$i] : '';
                                    
                                    if (!empty($ingredient)):
                                ?>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $i + 1; ?>">
                                        <label style="font-size: 20px;" class="custom-control-label" for="customCheck<?php echo $i + 1; ?>">
                                            <?php if (!empty($amount)): ?>
                                                <?php echo htmlspecialchars($amount); ?> 
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($ingredient); ?>
                                        </label>
                                    </div>
                                <?php 
                                    endif;
                                endfor; 
                                ?>
                            <?php else: ?>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label style="font-size: 20px;" class="custom-control-label" for="customCheck1">Daftar bahan belum ditambahkan</label>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Save Recipe Section -->
                <div class="container">
                    <div class="col-12">
                        <div class="save-recipe-area text-center d-flex justify-content-center align-items-center" style="min-height: 200px;">
                            <div class="save-recipe-content">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <h4 style="font-size: 24px;" class="mb-3">Suka dengan resep ini?</h4>
                                    <p style="font-size: 20px;" class="mb-4">Simpan resep ini ke koleksi favorit Anda untuk dimasak nanti!</p>
                                    <button id="favoriteBtn" class="btn delicious-btn mx-auto" type="button" onclick="toggleFavorite()" data-recipe-id="<?php echo $recipe_id; ?>">
                                        <i class="fa fa-heart mr-2" id="favoriteIcon"></i>
                                        <span id="favoriteText"></span>
                                    </button>
                                <?php else: ?>
                                    <h4 style="font-size: 24px;" class="mb-3">Suka dengan resep ini?</h4>
                                    <p style="font-size: 20px;" class="mb-4">Login untuk menyimpan resep ini ke koleksi favorit Anda!</p>
                                    <a href="login.php" class="btn delicious-btn mx-auto">
                                        <i class="fa fa-sign-in mr-2"></i>Login Sekarang
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ##### Follow Us Instagram Area Start ##### -->
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

    <!-- ##### All Javascript Files ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
    
    <script>
        let isFavorite = <?php echo json_encode($is_favorite); ?>;
        const recipeId = <?php echo $recipe_id; ?>;
        
        // Update tampilan button berdasarkan status favorit
        function updateFavoriteButton() {
            const icon = document.getElementById('favoriteIcon');
            const text = document.getElementById('favoriteText');
            const button = document.getElementById('favoriteBtn');
            
            if (isFavorite) {
                icon.style.color = '#ff6b6b';
                text.textContent = 'Hapus dari Favorit';
                button.classList.add('btn-favorite-active');
            } else {
                icon.style.color = '#999';
                text.textContent = 'Simpan ke Favorit';
                button.classList.remove('btn-favorite-active');
            }
        }
        
        // Toggle status favorit
        function toggleFavorite() {
            const button = document.getElementById('favoriteBtn');
            button.disabled = true;
            
            $.ajax({
                url: 'save_favorite.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    recipe_id: recipeId,
                    action: isFavorite ? 'remove' : 'add'
                }),
                success: function(response) {
                    if (response.success) {
                        isFavorite = !isFavorite;
                        updateFavoriteButton();
                        showMessage(response.message, 'success');
                    } else {
                        showMessage(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        showMessage('Anda harus login terlebih dahulu', 'error');
                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 2000);
                    } else {
                        showMessage('Terjadi kesalahan saat menyimpan favorit', 'error');
                    }
                },
                complete: function() {
                    button.disabled = false;
                }
            });
        }
        
        function showMessage(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show position-fixed" role="alert" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            `;
            
            $('body').append(alertHtml);
            
            // Auto hide after 3 seconds
            setTimeout(function() {
                $('.alert').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 3000);
        }
        
        // Initialize button state when page loads
        $(document).ready(function() {
            <?php if (isset($_SESSION['user_id'])): ?>
                updateFavoriteButton();
            <?php endif; ?>
        });
    </script>
    
    <style>
        .btn-favorite-active {
            background-color: #ff6b6b !important;
            border-color: #ff6b6b !important;
        }
        
        .btn-favorite-active:hover {
            background-color: #ff5252 !important;
            border-color: #ff5252 !important;
        }
        
        #favoriteBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</body>
</html>