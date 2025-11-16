<?php
require_once 'auth.php';

// Database connection
$host = 'localhost';
$dbname = 'sajian_nusantara';
$username = 'root'; // sesuaikan dengan username database Anda
$password = ''; // sesuaikan dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get random recipes for carousel (only when not searching)
$carousel_recipes = [];
if (!isset($_GET['search']) && !isset($_GET['category'])) {
    $carousel_sql = "SELECT id, nama_resep, foto_path, filename 
                     FROM recipes 
                     WHERE (foto_path IS NOT NULL AND foto_path != '') 
                        OR (filename IS NOT NULL AND filename != '')
                     ORDER BY RAND() 
                     LIMIT 5";
    $carousel_stmt = $pdo->prepare($carousel_sql);
    $carousel_stmt->execute();
    $carousel_recipes = $carousel_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get favorite recipes (most favorited)
$favorite_recipes = [];
if (!isset($_GET['search']) && !isset($_GET['category'])) {
    $favorite_sql = "SELECT r.id, r.nama_resep, r.kategori, r.waktu_masak, r.porsi, 
                            r.foto_path, r.filename, COUNT(f.id) as favorite_count
                     FROM recipes r 
                     LEFT JOIN favorites f ON r.id = f.recipe_id 
                     GROUP BY r.id 
                     HAVING favorite_count > 0
                     ORDER BY favorite_count DESC, r.created_at DESC 
                     LIMIT 6";
    $favorite_stmt = $pdo->prepare($favorite_sql);
    $favorite_stmt->execute();
    $favorite_recipes = $favorite_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get latest recipes by category
$makanan_recipes = [];
$minuman_recipes = [];
$kue_recipes = [];
$cemilan_recipes = [];

if (!isset($_GET['search']) && !isset($_GET['category'])) {
    // Makanan Utama (terbaru)
    $makanan_sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
                    FROM recipes 
                    WHERE kategori = 'makanan_utama' 
                    ORDER BY created_at DESC 
                    LIMIT 3";
    $makanan_stmt = $pdo->prepare($makanan_sql);
    $makanan_stmt->execute();
    $makanan_recipes = $makanan_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Minuman (terbaru)
    $minuman_sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
                    FROM recipes 
                    WHERE kategori = 'minuman' 
                    ORDER BY created_at DESC 
                    LIMIT 3";
    $minuman_stmt = $pdo->prepare($minuman_sql);
    $minuman_stmt->execute();
    $minuman_recipes = $minuman_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Kue (terbaru)
    $kue_sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
                FROM recipes 
                WHERE kategori = 'kue' 
                ORDER BY created_at DESC 
                LIMIT 3";
    $kue_stmt = $pdo->prepare($kue_sql);
    $kue_stmt->execute();
    $kue_recipes = $kue_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cemilan (terbaru)
    $cemilan_sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
                    FROM recipes 
                    WHERE kategori = 'cemilan' 
                    ORDER BY created_at DESC 
                    LIMIT 3";
    $cemilan_stmt = $pdo->prepare($cemilan_sql);
    $cemilan_stmt->execute();
    $cemilan_recipes = $cemilan_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle search functionality
$search_query = '';
$category_filter = '';
$recipes = [];

if (isset($_GET['search']) || isset($_GET['category'])) {
    $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
    $category_filter = isset($_GET['category']) ? $_GET['category'] : '';
    
    // Build SQL query with search conditions
    $sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
            FROM recipes WHERE 1=1";
    $params = [];
    
    if (!empty($search_query)) {
        $sql .= " AND (nama_resep LIKE :search OR 
                      JSON_UNQUOTE(JSON_EXTRACT(bahan, '$[*]')) LIKE :search2)";
        $params[':search'] = '%' . $search_query . '%';
        $params[':search2'] = '%' . $search_query . '%';
    }
    
    if (!empty($category_filter)) {
        $sql .= " AND kategori = :category";
        $params[':category'] = $category_filter;
    }
    
    $sql .= " ORDER BY created_at DESC LIMIT 24";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Default query - show latest recipes
    $sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
            FROM recipes 
            ORDER BY created_at DESC 
            LIMIT 12";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get recipe image - sama seperti favorit.php
function getRecipeImage($recipe) {
    if (!empty($recipe['foto_path']) && file_exists($recipe['foto_path'])) {
        return $recipe['foto_path'];
    } elseif (!empty($recipe['filename']) && file_exists('uploads/' . $recipe['filename'])) {
        return 'uploads/' . $recipe['filename'];
    } else {
        return getDefaultImage($recipe['kategori'] ?? 'makanan_utama');
    }
}

// Function to get default image based on category
function getDefaultImage($kategori) {
    $default_images = [
        'makanan_utama' => 'img/bg-img/default-makanan.jpg',
        'minuman' => 'img/bg-img/default-minuman.jpg',
        'kue' => 'img/bg-img/default-kue.jpg',
        'cemilan' => 'img/bg-img/default-cemilan.jpg'
    ];
    return isset($default_images[$kategori]) ? $default_images[$kategori] : 'img/bg-img/default-recipe.jpg';
}

// Function to format category name
function formatCategory($kategori) {
    $categories = [
        'makanan_utama' => 'Makanan Utama',
        'minuman' => 'Minuman',
        'kue' => 'Kue',
        'cemilan' => 'Cemilan'
    ];
    return isset($categories[$kategori]) ? $categories[$kategori] : ucfirst($kategori);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>SajianNusantara - Resep Masakan Indonesia | Home</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">

    <!-- Font Awesome for search icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">

    <!-- Search and Carousel Styles -->
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

        /* Search Section Styles - Mobile fallback */
        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 100%;
            margin: 0 auto;
            padding: 0 20px;
        }

        .search-input {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            flex: 1;
            min-width: 200px;
        }

        .search-select {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            flex: 0 0 auto;
            min-width: 120px;
        }

        .search-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            white-space: nowrap;
        }

        .search-btn:hover {
            background: #0056b3;
        }

        .search-results-info {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #e9ecef;
            border-radius: 5px;
        }

        .clear-search {
            color: #dc3545;
            text-decoration: none;
            margin-left: 10px;
        }

        .clear-search:hover {
            text-decoration: underline;
        }

        /* Dynamic Carousel Styles */
        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-content {
            text-align: center;
            color: white;
        }

        .carousel-content h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }

        .carousel-content .btn {
            background: #D62828;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            text-shadow: none;
        }

        .carousel-content .btn:hover {
            background: #B71C1C;
            color: white;
            text-decoration: none;
        }

        @media (max-width: 992px) {
            .carousel-content h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .carousel-content h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .carousel-content h2 {
                font-size: 1.2rem;
            }
        }

        /* Section Styles */
        .section-area {
            padding: 40px 0;
        }

        .section-heading {
            margin-bottom: 30px;
        }

        .section-heading h3 {
            color: #2c3e50;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }

        .section-heading h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: #D62828;
        }

        .view-all-btn {
            text-align: right;
            margin-top: 20px;
        }

        .view-all-btn a {
            background: #f8f9fa;
            color: #D62828;
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #D62828;
            transition: all 0.3s ease;
        }

        .view-all-btn a:hover {
            background: #D62828;
            color: white;
            text-decoration: none;
        }

        /* Favorite Badge - dipindah ke dalam recipe-image-container */
        .favorite-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff6b6b;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            z-index: 5;
        }

        .single-best-receipe-area {
            position: relative;
        }

        /* Recipe image container - sama seperti favorit.php */
        .recipe-image-container {
            position: relative;
            overflow: hidden;
        }

        .recipe-fav-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .recipe-fav-btn .btn {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .recipe-fav-btn .btn:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
        }

        /* Fix image aspect ratio for all sections - sama seperti favorit.php */
        .single-best-receipe-area img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Ensure consistent card heights */
        .single-best-receipe-area {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .single-best-receipe-area .receipe-content {
            flex: 1;
            padding: 15px;
        }

        /* Section-specific styling consistency */
        .section-area .single-best-receipe-area {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .section-area .single-best-receipe-area:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .section-area .single-best-receipe-area .receipe-content h5 {
            font-size: 16px;
            line-height: 1.4;
            margin-bottom: 10px;
            height: 2.8em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .section-area .single-best-receipe-area .receipe-content a {
            text-decoration: none;
            color: #333;
        }

        .section-area .single-best-receipe-area .receipe-content a:hover h5 {
            color: #D62828;
        }

        /* Responsive image heights */
        @media (max-width: 768px) {
            .single-best-receipe-area img {
                height: 200px;
            }
        }

        @media (max-width: 480px) {
            .single-best-receipe-area img {
                height: 180px;
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
                                    <li class="active"><a href="index.php">Home</a></li>
                                    <li class="nav-search-item">
                                        <form class="nav-search-form" method="GET" action="index.php">
                                            <div class="nav-search-wrapper">
                                                <input type="text" 
                                                       class="nav-search-input" 
                                                       name="search" 
                                                       placeholder="Cari resep..." 
                                                       value="<?php echo htmlspecialchars($search_query); ?>">
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

    <!-- Dynamic Hero Carousel -->
    <?php if (empty($search_query) && empty($category_filter)): ?>
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <?php if (!empty($carousel_recipes)): ?>
                <?php foreach ($carousel_recipes as $carousel_recipe): ?>
                    <!-- Dynamic Hero Slide -->
                    <div class="single-hero-slide bg-img" style="background-image: url(<?php echo htmlspecialchars(getRecipeImage($carousel_recipe)); ?>);">
                        <div class="carousel-overlay">
                            <div class="carousel-content">
                                <a href="detail_resep.php?id=<?php echo $carousel_recipe['id']; ?>" class="btn">Lihat Resep</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default slides when no recipes with images -->
                <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/carousel1.jpg);">
                    <div class="carousel-overlay">
                        <div class="carousel-content">
                            <h2>Selamat Datang di SajianNusantara</h2>
                            <p style="margin-bottom: 20px;">Temukan resep masakan Indonesia terlezat</p>
                        </div>
                    </div>
                </div>
                <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/carousel2.jpg);">
                    <div class="carousel-overlay">
                        <div class="carousel-content">
                            <h2>Bagikan Resep Favorit Anda</h2>
                            <p style="margin-bottom: 20px;">Bergabunglah dengan komunitas pecinta kuliner</p>
                        </div>
                    </div>
                </div>
                <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/carousel3.jpg);">
                    <div class="carousel-overlay">
                        <div class="carousel-content">
                            <h2>Eksplorasi Cita Rasa Nusantara</h2>
                            <p style="margin-bottom: 20px;">Dari Sabang sampai Merauke</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="search-form" method="GET" action="index.php">
                        <input type="text" 
                               class="search-input" 
                               name="search" 
                               placeholder="Cari resep atau bahan makanan..." 
                               value="<?php echo htmlspecialchars($search_query); ?>">
                        
                        <select name="category" class="search-select">
                            <option value="">Semua Kategori</option>
                            <option value="makanan_utama" <?php echo $category_filter === 'makanan_utama' ? 'selected' : ''; ?>>Makanan Utama</option>
                            <option value="minuman" <?php echo $category_filter === 'minuman' ? 'selected' : ''; ?>>Minuman</option>
                            <option value="kue" <?php echo $category_filter === 'kue' ? 'selected' : ''; ?>>Kue</option>
                            <option value="cemilan" <?php echo $category_filter === 'cemilan' ? 'selected' : ''; ?>>Cemilan</option>
                        </select>
                        
                        <button type="submit" class="search-btn">Cari</button>
                        
                        <?php if (!empty($search_query) || !empty($category_filter)): ?>
                            <a href="index.php" class="search-btn" style="background: #6c757d; text-decoration: none;">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <?php if (empty($search_query) && empty($category_filter)): ?>

        <!-- Resep Favorit Section -->
        <?php if (!empty($favorite_recipes)): ?>
        <section class="section-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <h3><i class="fa fa-heart" style="color: #ff6b6b; margin-right: 10px;"></i>Resep Paling Disukai</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($favorite_recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <div class="recipe-image-container">
                                    <img src="<?php echo htmlspecialchars(getRecipeImage($recipe)); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                    <div class="favorite-badge">
                                        <i class="fa fa-heart"></i> <?php echo $recipe['favorite_count']; ?>
                                    </div>
                                </div>
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                    <div class="receipe-ratings-cook-time">
                                        <div class="receipe-cook-time">
                                            <span><?php echo formatCategory($recipe['kategori']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- <div class="view-all-btn">
                    <a href="favorit.php">Lihat Semua Favorit <i class="fa fa-arrow-right"></i></a>
                </div> -->
            </div>
        </section>
        <?php endif; ?>

        <!-- Makanan Utama Section -->
        <?php if (!empty($makanan_recipes)): ?>
        <section class="section-area" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <h3>Makanan Utama Terbaru</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($makanan_recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <div class="recipe-image-container">
                                    <img src="<?php echo htmlspecialchars(getRecipeImage($recipe)); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                </div>
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                    <div class="receipe-ratings-cook-time">
                                        <div class="receipe-cook-time">
                                            <span><?php echo formatCategory($recipe['kategori']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all-btn">
                    <a href="index.php?category=makanan_utama">Lihat Semua Makanan Utama <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Minuman Section -->
        <?php if (!empty($minuman_recipes)): ?>
        <section class="section-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <h3>Minuman Terbaru</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($minuman_recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <div class="recipe-image-container">
                                    <img src="<?php echo htmlspecialchars(getRecipeImage($recipe)); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                </div>
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                    <div class="receipe-ratings-cook-time">
                                        <div class="receipe-cook-time">
                                            <span><?php echo formatCategory($recipe['kategori']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all-btn">
                    <a href="index.php?category=minuman">Lihat Semua Minuman <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Kue Section -->
        <?php if (!empty($kue_recipes)): ?>
        <section class="section-area" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <h3>Kue Terbaru</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($kue_recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <div class="recipe-image-container">
                                    <img src="<?php echo htmlspecialchars(getRecipeImage($recipe)); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                </div>
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                    <div class="receipe-ratings-cook-time">
                                        <div class="receipe-cook-time">
                                            <span><?php echo formatCategory($recipe['kategori']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all-btn">
                    <a href="index.php?category=kue">Lihat Semua Kue <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Cemilan Section -->
        <?php if (!empty($cemilan_recipes)): ?>
        <section class="section-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <h3>Cemilan Terbaru</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php foreach ($cemilan_recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <div class="recipe-image-container">
                                    <img src="<?php echo htmlspecialchars(getRecipeImage($recipe)); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                </div>
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                    <div class="receipe-ratings-cook-time">
                                        <div class="receipe-cook-time">
                                            <span><?php echo formatCategory($recipe['kategori']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="view-all-btn">
                    <a href="index.php?category=cemilan">Lihat Semua Cemilan <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        </section>
        <?php endif; ?>

    <?php else: ?>
        <!-- Search Results Section -->
        <section class="best-receipe-area" style="padding: 20px 0px">
            <div class="container">
                <div class="search-results-info">
                    <h4>
                        <?php if (!empty($search_query) && !empty($category_filter)): ?>
                            Hasil pencarian "<?php echo htmlspecialchars($search_query); ?>" 
                            dalam kategori <?php echo formatCategory($category_filter); ?>
                        <?php elseif (!empty($search_query)): ?>
                            Hasil pencarian "<?php echo htmlspecialchars($search_query); ?>"
                        <?php elseif (!empty($category_filter)): ?>
                            Kategori: <?php echo formatCategory($category_filter); ?>
                        <?php endif; ?>
                    </h4>
                    <p>Ditemukan <?php echo count($recipes); ?> resep
                        <a href="index.php" class="clear-search">✕ Hapus Filter</a>
                    </p>
                </div>

                <div class="row">
                    <?php if (!empty($recipes)): ?>
                        <?php foreach ($recipes as $recipe): ?>
                            <!-- Single Best Receipe Area -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="single-best-receipe-area mb-30">
                                    <div class="recipe-image-container">
                                        <img src="<?php echo htmlspecialchars(getRecipeImage($recipe)); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                    </div>
                                    <div class="receipe-content">
                                        <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                            <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                        </a>
                                        <div class="receipe-ratings-cook-time">
                                            <div class="receipe-cook-time">
                                                <span><?php echo formatCategory($recipe['kategori']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- No recipes found -->
                        <div class="col-12">
                            <div class="text-center" style="padding: 50px 0;">
                                <h4>Tidak ada resep ditemukan</h4>
                                <p>Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                                <a href="index.php" class="btn btn-primary">Lihat Semua Resep</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
 
    <!-- <div class="follow-us-instagram">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>Tentang Kami</h5>
                    <p>SajianNusantara adalah platform komunitas resep masakan khas Indonesia yang menyajikan ragam hidangan autentik dari Sabang hingga Merauke. Kami menghadirkan resep-resep pilihan yang mudah diikuti, cocok untuk pemula maupun pecinta kuliner Nusantara. Di platform ini, siapa saja dapat berbagi resep mereka sendiri, menjelajahi kreasi kuliner pengguna lain, dan menjadi bagian dari komunitas pecinta masakan Indonesia.</p>
                </div>
            </div>
        </div>
    </div> -->

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
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
    
    <!-- Custom Search JavaScript -->
    <script>
        // Auto-submit form when category filter is changed
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            
            // Add enter key support
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.closest('form').submit();
                    }
                });
                
                // Focus on search input when page loads (if not mobile)
                if (window.innerWidth > 768) {
                    searchInput.focus();
                }
            }
        });
    </script>
</body>

</html>