<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}

// Cek apakah ada ID resep
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'ID resep tidak valid!';
    header("Location: dashboard.php");
    exit();
}

$recipe_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Koneksi database
require_once 'config.php';

try {
    // Ambil data resep untuk validasi dan mendapatkan path foto
    $query = "SELECT id, nama_resep, foto_path FROM recipes WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$recipe_id, $user_id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Jika resep tidak ditemukan atau bukan milik user
    if (!$recipe) {
        $_SESSION['error'] = 'Resep tidak ditemukan atau Anda tidak memiliki akses untuk menghapus resep ini!';
        header("Location: dashboard.php");
        exit();
    }
    
    // Jika ada konfirmasi hapus
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
        // Mulai transaksi
        $pdo->beginTransaction();
        
        try {
            // Hapus resep dari database
            $delete_query = "DELETE FROM recipes WHERE id = ? AND user_id = ?";
            $delete_stmt = $pdo->prepare($delete_query);
            $result = $delete_stmt->execute([$recipe_id, $user_id]);
            
            if ($result && $delete_stmt->rowCount() > 0) {
                // Hapus file foto jika ada
                if (!empty($recipe['foto_path']) && file_exists($recipe['foto_path'])) {
                    unlink($recipe['foto_path']);
                }
                
                // Commit transaksi
                $pdo->commit();
                
                $_SESSION['success'] = 'Resep "' . htmlspecialchars($recipe['nama_resep']) . '" berhasil dihapus!';
                header("Location: dashboard.php");
                exit();
            } else {
                throw new Exception('Gagal menghapus resep dari database!');
            }
            
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi error
            $pdo->rollback();
            throw $e;
        }
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: dashboard.php");
    exit();
} catch (PDOException $e) {
    // Log error untuk debugging
    error_log("Database Error in hapus_resep.php: " . $e->getMessage());
    $_SESSION['error'] = 'Terjadi kesalahan database. Silakan coba lagi.';
    header("Location: dashboard.php");
    exit();
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
    <title>Hapus Resep - SajianNusantara</title>

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

        /* Confirm Content Styles */
        .confirm-content {
            padding: 100px 0;
            background-color: #f8f9fa;
            min-height: 60vh;
        }
        
        .confirm-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        
        .confirm-icon {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        
        .confirm-title {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: 600;
        }
        
        .confirm-message {
            color: #666;
            margin-bottom: 10px;
            font-size: 16px;
            line-height: 1.6;
        }
        
        .recipe-name {
            color: #dc3545;
            font-weight: 600;
            font-size: 18px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }
        
        .warning-text {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 30px;
            font-weight: 500;
        }
        
        .confirm-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-delete:hover {
            background-color: #c82333;
            color: white;
        }
        
        .btn-cancel {
            background-color: #6c757d;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        
        .btn-cancel:hover {
            background-color: #5a6268;
            color: white;
        }
        
        .recipe-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .recipe-info img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }
        
        .recipe-details h4 {
            color: #333;
            margin: 0 0 5px 0;
            font-size: 18px;
        }
        
        .recipe-details p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .confirm-container {
                margin: 0 15px;
                padding: 30px 20px;
            }
            
            .confirm-actions {
                flex-direction: column;
            }
            
            .btn-delete,
            .btn-cancel {
                width: 100%;
            }
            
            .recipe-info {
                flex-direction: column;
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
    <!-- ##### Header Area End ##### -->

    <!-- Confirm Content -->
    <section class="confirm-content">
        <div class="container">
            <div class="confirm-container">
                <div class="confirm-icon">🗑️</div>
                
                <h2 class="confirm-title">Konfirmasi Penghapusan</h2>
                
                <p class="confirm-message">
                    Apakah Anda yakin ingin menghapus resep ini?
                </p>
                
                <div class="recipe-info">
                    <?php if (!empty($recipe['foto_path']) && file_exists($recipe['foto_path'])): ?>
                        <img src="<?php echo htmlspecialchars($recipe['foto_path']); ?>" alt="Foto resep">
                    <?php else: ?>
                        <div style="width: 80px; height: 80px; background-color: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 12px;">
                            No Image
                        </div>
                    <?php endif; ?>
                    
                    <div class="recipe-details">
                        <h4><?php echo htmlspecialchars($recipe['nama_resep']); ?></h4>
                    </div>
                </div>
                
                <p class="warning-text">
                    ⚠️ Peringatan: Tindakan ini tidak dapat dibatalkan!<br>
                    Semua data resep dan foto akan dihapus secara permanen.
                </p>
                
                <div class="confirm-actions">
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="confirm_delete" value="yes">
                        <button type="submit" class="btn-delete">
                            Ya, Hapus Resep
                        </button>
                    </form>
                    <a href="dashboard.php" class="btn-cancel">Batal</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ##### Follow Us Instagram Area Start ##### -->
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
            const searchInput = document.querySelector('.nav-search-input');
            
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

        // Menambahkan loading state saat tombol hapus diklik
        const deleteForm = document.querySelector('form');
        const deleteButton = document.querySelector('.btn-delete');
        
        if (deleteForm && deleteButton) {
            deleteForm.addEventListener('submit', function(e) {
                // Ubah teks tombol untuk menunjukkan proses
                deleteButton.textContent = 'Menghapus...';
                deleteButton.style.backgroundColor = '#6c757d';
                deleteButton.disabled = true;
            });
        }
    </script>
</body>
</html>