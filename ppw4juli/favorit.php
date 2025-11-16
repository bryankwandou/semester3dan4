<?php
require_once 'auth.php';
require_once 'config.php';

// Redirect ke login jika user belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Pagination setup
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 9; // 9 resep per halaman (3x3 grid)
$offset = ($page - 1) * $per_page;

// Filter kategori
$kategori_filter = isset($_GET['kategori']) && !empty($_GET['kategori']) ? $_GET['kategori'] : '';
$valid_categories = ['makanan_utama', 'minuman', 'kue', 'cemilan'];

// Query untuk menghitung total resep favorit
$count_query = "SELECT COUNT(*) as total 
                FROM favorites f 
                INNER JOIN recipes r ON f.recipe_id = r.id 
                WHERE f.user_id = ?";
$count_params = [$user_id];

if ($kategori_filter && in_array($kategori_filter, $valid_categories)) {
    $count_query .= " AND r.kategori = ?";
    $count_params[] = $kategori_filter;
}

$count_stmt = $pdo->prepare($count_query);
$count_stmt->execute($count_params);
$total_recipes = $count_stmt->fetchColumn();

// Hitung total halaman
$total_pages = ceil($total_recipes / $per_page);

// Query untuk mengambil resep favorit dengan pagination
$query = "SELECT r.*, f.created_at as favorited_at, u.nama as user_name
          FROM favorites f 
          INNER JOIN recipes r ON f.recipe_id = r.id 
          LEFT JOIN users u ON r.user_id = u.id
          WHERE f.user_id = ?";
$params = [$user_id];

if ($kategori_filter && in_array($kategori_filter, $valid_categories)) {
    $query .= " AND r.kategori = ?";
    $params[] = $kategori_filter;
}

$query .= " ORDER BY f.created_at DESC LIMIT " . (int)$per_page . " OFFSET " . (int)$offset;

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$favorite_recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Function untuk menentukan gambar resep
function getRecipeImage($foto_path) {
    if (!empty($foto_path) && file_exists($foto_path)) {
        return $foto_path;
    }
    return 'img/bg-img/default-recipe.jpg';
}

// Function untuk format kategori
function formatKategori($kategori) {
    $kategori_map = [
        'makanan_utama' => 'Makanan Utama',
        'minuman' => 'Minuman',
        'kue' => 'Kue',
        'cemilan' => 'Cemilan'
    ];
    return isset($kategori_map[$kategori]) ? $kategori_map[$kategori] : ucfirst($kategori);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>SajianNusantara - Resep Favorit Saya</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">

    <!-- Core Stylesheet -->
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
                                    <li class="active"><a href="favorit.php">Favorit</a></li>
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

    <!-- ##### Breadcrumb Area Start ##### -->
    <!-- <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Resep Favorit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div> -->
    <!-- ##### Breadcrumb Area End ##### -->

    <!-- ##### Recipe Area Start ##### -->
    <section class="receipe-area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h3><i class="fa fa-heart text-danger"></i> Resep Favorit Saya</h3>
                        <p>Koleksi resep pilihan yang telah Anda simpan</p>
                    </div>
                </div>
            </div>

            <!-- Filter Categories -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="filter-nav text-center">
                        <div class="nav nav-pills" id="filter-nav" role="tablist">
                            <a class="nav-item nav-link <?php echo empty($kategori_filter) ? 'active' : ''; ?>" 
                               href="favorit.php">Semua (<?php echo $total_recipes; ?>)</a>
                            
                            <?php foreach ($valid_categories as $category): ?>
                                <?php
                                // Count recipes per category
                                $cat_count_query = "SELECT COUNT(*) FROM favorites f 
                                                   INNER JOIN recipes r ON f.recipe_id = r.id 
                                                   WHERE f.user_id = ? AND r.kategori = ?";
                                $cat_count_stmt = $pdo->prepare($cat_count_query);
                                $cat_count_stmt->execute([$user_id, $category]);
                                $cat_count = $cat_count_stmt->fetchColumn();
                                ?>
                                <a class="nav-item nav-link <?php echo $kategori_filter === $category ? 'active' : ''; ?>" 
                                   href="favorit.php?kategori=<?php echo $category; ?>">
                                    <?php echo formatKategori($category); ?> (<?php echo $cat_count; ?>)
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php if (empty($favorite_recipes)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fa fa-heart-o" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                            <h4>Belum Ada Resep Favorit</h4>
                            <?php if ($kategori_filter): ?>
                                <p>Anda belum menyimpan resep <?php echo formatKategori($kategori_filter); ?> ke favorit.</p>
                                <a href="favorit.php" class="btn delicious-btn mt-3">Lihat Semua Favorit</a>
                            <?php else: ?>
                                <p>Mulai jelajahi resep dan simpan yang Anda sukai!</p>
                                <a href="index.php" class="btn delicious-btn mt-3">Jelajahi Resep</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($favorite_recipes as $recipe): ?>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-best-receipe-area mb-30">
                                <div class="recipe-image-container">
                                    <img src="<?php echo htmlspecialchars(getRecipeImage($recipe['foto_path'])); ?>" 
                                         alt="<?php echo htmlspecialchars($recipe['nama_resep']); ?>">
                                    <div class="recipe-fav-btn">
                                        <button class="btn btn-sm" onclick="removeFavorite(<?php echo $recipe['id']; ?>)" 
                                                title="Hapus dari favorit">
                                            <i class="fa fa-heart text-danger"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="receipe-content">
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>">
                                        <h5><?php echo htmlspecialchars($recipe['nama_resep']); ?></h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                        <div class="col-12">
                            <div class="pagination-area text-center mt-4">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page - 1; ?><?php echo $kategori_filter ? '&kategori=' . $kategori_filter : ''; ?>">
                                                    <i class="fa fa-angle-left"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?><?php echo $kategori_filter ? '&kategori=' . $kategori_filter : ''; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo $page + 1; ?><?php echo $kategori_filter ? '&kategori=' . $kategori_filter : ''; ?>">
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- ##### Recipe Area End ##### -->

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

    <!-- ##### Footer Area Start ##### -->
    <!-- <footer class="footer-area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100 d-flex flex-wrap align-items-center justify-content-between">
                    <div class="footer-logo">
                        <a href="index.php"><img style="height: 50px; width: 50px;" src="img/core-img/s.jpg" alt=""></a>
                    </div>
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> SajianNusantara</p>
                </div>
            </div>
        </div>
    </footer> -->

    <!-- ##### All Javascript Files ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>

    <script>
        // Function untuk menghapus resep dari favorit
        function removeFavorite(recipeId) {
            if (confirm('Apakah Anda yakin ingin menghapus resep ini dari favorit?')) {
                $.ajax({
                    url: 'save_favorite.php',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        recipe_id: recipeId,
                        action: 'remove'
                    }),
                    success: function(response) {
                        if (response.success) {
                            showMessage(response.message, 'success');
                            // Reload halaman setelah 1 detik
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            showMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        showMessage('Terjadi kesalahan saat menghapus favorit', 'error');
                    }
                });
            }
        }

        // Function untuk menampilkan pesan
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
    </script>

    <style>
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

        .filter-nav .nav-link {
            border: 1px solid #ddd;
            color: #666;
            margin: 0 5px;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .filter-nav .nav-link.active,
        .filter-nav .nav-link:hover {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
            color: white;
        }

        .pagination .page-link {
            color: #666;
            border: 1px solid #ddd;
            padding: 8px 12px;
        }

        .pagination .page-item.active .page-link {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
            color: white;
        }
    </style>
</body>
</html>