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

// Handle search functionality
$search_query = '';
$recipes = [];

if (isset($_GET['search'])) {
    $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    // Build SQL query with search conditions - only for kue
    $sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
            FROM recipes WHERE kategori = 'kue'";
    $params = [];
    
    if (!empty($search_query)) {
        $sql .= " AND (nama_resep LIKE :search OR 
                      JSON_UNQUOTE(JSON_EXTRACT(bahan, '$[*]')) LIKE :search2)";
        $params[':search'] = '%' . $search_query . '%';
        $params[':search2'] = '%' . $search_query . '%';
    }
    
    $sql .= " ORDER BY created_at DESC LIMIT 24";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Default query - show kue recipes
    $sql = "SELECT id, nama_resep, kategori, waktu_masak, porsi, foto_path, filename 
            FROM recipes 
            WHERE kategori = 'kue'
            ORDER BY created_at DESC 
            LIMIT 12";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>SajianNusantara - Resep Masakan Indonesia | Kue</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">

    <!-- Simple Search Styles -->
    <style>
        /* Search Section Styles - Improved */
        .search-section {
            background: #D62828;
            padding: 30px 0;
            margin: 20px 150px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
            flex-wrap: nowrap;
            max-width: 800px;
            margin: 0 auto;
        }

        .search-input {
            padding: 18px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            flex: 2;
            min-width: 350px;
            max-width: 500px;
        }

        .search-select {
            padding: 0px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            flex: 1;
            min-width: 150px;
            max-width: 200px;
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }

        .search-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 18px 30px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            white-space: nowrap;
            flex-shrink: 0;
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

        /* Media Queries untuk responsivitas */
        @media (max-width: 992px) {
            .search-section {
                margin: 20px 50px;
            }
            
            .search-form {
                max-width: 90%;
                gap: 8px;
            }
            
            .search-input {
                min-width: 280px;
                max-width: 350px;
            }
            
            .search-select {
                min-width: 140px;
                max-width: 170px;
            }
            
            .search-btn {
                padding: 16px 20px;
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            .search-section {
                margin: 20px 20px;
            }
            
            .search-form {
                flex-wrap: wrap;
                justify-content: stretch;
                gap: 10px;
            }
            
            .search-input {
                flex: 1 1 100%;
                min-width: unset;
                max-width: unset;
                margin-bottom: 0;
            }
            
            .search-select {
                flex: 1 1 auto;
                min-width: 120px;
                margin-bottom: 0;
            }
            
            .search-btn {
                flex: 0 0 auto;
                min-width: 80px;
            }
        }

        @media (max-width: 480px) {
            .search-section {
                padding: 20px 0;
                margin: 10px;
            }
            
            .search-form {
                padding: 0 15px;
            }
            
            .search-input,
            .search-select,
            .search-btn {
                font-size: 14px;
                padding: 12px;
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

    <!-- Search Wrapper -->
    <div class="search-wrapper">
        <!-- Close Btn -->
        <div class="close-btn"><i class="fa fa-times" aria-hidden="true"></i></div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="#" method="post">
                        <input type="search" name="search" placeholder="Masukkan nama resep...">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
            </div>
        </div>
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
                        <a class="nav-brand" href="index.php"><img src="img/core-img/S.jpg" width = '100' height ='100' alt=""></a>

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
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="makanan.php">Makanan Utama</a></li>
                                    <li><a href="minuman.php">Minuman</a></li>
                                    <li class="active"><a href="kue.php">Kue</a></li>
                                    <li><a href="cemilan.php">Cemilan</a></li>
                                    <li><a href="akun.php">Akun Saya</a></li>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <li><a href="process.php?logout=1">Logout</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- Hero Carousel - Only show if no search -->
    <?php if (empty($search_query)): ?>
    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/klepon.jpg);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/dadargulung1.jpg);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Hero Slide -->
            <div class="single-hero-slide bg-img" style="background-image: url(img/bg-img/kuepukis.jpg);">
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12 col-md-9 col-lg-7 col-xl-6">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Hero Area End ##### -->
    <?php endif; ?>

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="search-form" method="GET" action="kue.php">
                        <input type="text" 
                               class="search-input" 
                               name="search" 
                               placeholder="Cari resep kue atau bahan kue..." 
                               value="<?php echo htmlspecialchars($search_query); ?>">
                        
                        <select name="category" class="search-select" disabled>
                            <option value="kue" selected>Kue</option>
                        </select>
                        
                        <button type="submit" class="search-btn">Cari</button>
                        
                        <?php if (!empty($search_query)): ?>
                            <a href="kue.php" class="search-btn" style="background: #6c757d; text-decoration: none;">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ##### Best Receipe Area Start ##### -->
    <section class="best-receipe-area" style="padding: 20px 0px">
        <div class="container">
            <?php if (!empty($search_query)): ?>
                <div class="search-results-info">
                    <h4>Hasil pencarian "<?php echo htmlspecialchars($search_query); ?>" dalam kategori Kue</h4>
                    <p>Ditemukan <?php echo count($recipes); ?> resep
                        <a href="kue.php" class="clear-search">✕ Hapus Filter</a>
                    </p>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <div class="section-heading">
                            <h3>Kumpulan Resep Kue</h3>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php if (!empty($recipes)): ?>
                    <?php foreach ($recipes as $recipe): ?>
                        <!-- Single Best Receipe Area -->
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <?php 
                                // Determine image source
                                $image_src = '';
                                if (!empty($recipe['foto_path']) && file_exists($recipe['foto_path'])) {
                                    $image_src = $recipe['foto_path'];
                                } elseif (!empty($recipe['filename']) && file_exists('uploads/' . $recipe['filename'])) {
                                    $image_src = 'uploads/' . $recipe['filename'];
                                } else {
                                    $image_src = getDefaultImage($recipe['kategori']);
                                }
                                ?>
                                <img src="<?php echo htmlspecialchars($image_src); ?>" alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- No recipes found -->
                    <div class="col-12">
                        <div class="text-center" style="padding: 50px 0;">
                            <?php if (!empty($search_query)): ?>
                                <h4>Tidak ada resep kue ditemukan</h4>
                                <p>Coba gunakan kata kunci lain untuk pencarian resep kue.</p>
                                <a href="kue.php" class="btn btn-primary">Lihat Semua Resep Kue</a>
                            <?php else: ?>
                                <h4>Tidak ada resep kue ditemukan</h4>
                                <p>Belum ada resep kue yang tersedia</p>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="buat_resep.php" class="btn btn-primary">Tambah Resep</a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Load More Button (Optional) -->
            <?php if (count($recipes) >= 12 && empty($search_query)): ?>
                <div class="row">
                    <div class="col-12 text-center" style="margin-top: 30px;">
                        <a href="semua-resep.php?kategori=kue" class="btn btn-outline-primary">Lihat Lebih Banyak Resep Kue</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- ##### Best Receipe Area End ##### -->

    <!-- ##### Follow Us Instagram Area Start ##### -->
    <div class="follow-us-instagram">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>Tentang Kami</h5>
                    <p>SajianNusantara adalah platform resep masakan khas Indonesia yang menyajikan ragam hidangan autentik dari Sabang hingga Merauke. Kami menghadirkan resep-resep pilihan yang mudah diikuti, cocok untuk pemula maupun pecinta kuliner Nusantara.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Follow Us Instagram Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100 d-flex flex-wrap align-items-center justify-content-between">
                    <div class="footer-logo">
                        <a href="index.php"><img style ="height: 50px; width: 50px;"src="img/core-img/s.jpg" alt=""></a>
                    </div>
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> SajianNusantara</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

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
        });
    </script>
</body>

</html>