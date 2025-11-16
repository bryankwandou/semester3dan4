<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['error'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Resep - SajianNusantara</title>
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
        
        .form-content {
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: #666;
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
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            background-color: white;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        
        .form-group select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 45px;
            cursor: pointer;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #f8b500;
            box-shadow: 0 0 0 3px rgba(248, 181, 0, 0.1);
        }
        
        .form-group select:hover {
            border-color: #f8b500;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .ingredients-section,
        .steps-section {
            border: 2px dashed #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        .section-title {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }
        
        .ingredient-item,
        .step-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            align-items: center;
        }
        
        .ingredient-item input {
            flex: 2;
        }
        
        .ingredient-item input:last-child {
            flex: 1;
        }
        
        .step-item textarea {
            flex: 1;
            min-height: 60px;
        }
        
        .add-btn,
        .remove-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        
        .add-btn {
            background-color: #28a745;
            color: white;
        }
        
        .add-btn:hover {
            background-color: #218838;
        }
        
        .remove-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .remove-btn:hover {
            background-color: #c82333;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn-submit {
            background-color: #f8b500;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .btn-submit:hover {
            background-color: #e6a200;
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
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload input[type=file] {
            position: absolute;
            left: -9999px;
        }
        
        .file-upload-label {
            display: block;
            padding: 12px 15px;
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: #f8b500;
        }
        
        @media (max-width: 768px) {
            .form-container {
                margin: 0 15px;
                padding: 20px;
            }
            
            .ingredient-item,
            .step-item {
                flex-direction: column;
            }
            
            .form-actions {
                flex-direction: column;
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

    <!-- Form Content -->
    <section class="form-content">
        <div class="container">
            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <div class="form-header">
                    <h2>Buat Resep Baru</h2>
                    <p>Bagikan resep masakan favorit Anda dengan komunitas SajianNusantara</p>
                </div>

                <form action="process_resep.php" method="POST" enctype="multipart/form-data">
                    <!-- Informasi Dasar -->
                    <div class="form-group">
                        <label for="nama_resep">Nama Resep *</label>
                        <input type="text" id="nama_resep" name="nama_resep" required>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori *</label>
                        <select id="kategori" name="kategori" required style="position: relative; z-index: 1;">
                            <option value="">Pilih Kategori</option>
                            <option value="makanan_utama">Makanan Utama</option>
                            <option value="minuman">Minuman</option>
                            <option value="kue">Kue</option>
                            <option value="cemilan">Cemilan</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="waktu_masak">Waktu Memasak (menit)</label>
                        <input type="number" id="waktu_masak" name="waktu_masak" min="1" placeholder="30">
                    </div>

                    <div class="form-group">
                        <label for="porsi">Porsi</label>
                        <input type="number" id="porsi" name="porsi" min="1" placeholder="4">
                    </div>

                    <!-- Upload Foto -->
                    <div class="form-group">
                        <label>Foto Resep</label>
                        <div class="file-upload">
                            <input type="file" id="foto_resep" name="foto_resep" accept="image/*">
                            <label for="foto_resep" class="file-upload-label">
                                <span>📷 Klik untuk upload foto resep</span>
                            </label>
                        </div>
                    </div>

                    <!-- Bahan-bahan -->
                    <div class="ingredients-section">
                        <h3 class="section-title">Bahan-bahan *</h3>
                        <div id="ingredients-container">
                            <div class="ingredient-item">
                                <input type="text" name="bahan[]" placeholder="Nama bahan" required>
                                <input type="text" name="jumlah[]" placeholder="Jumlah" required>
                                <button type="button" class="remove-btn" onclick="removeIngredient(this)">Hapus</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addIngredient()">+ Tambah Bahan</button>
                    </div>

                    <!-- Langkah-langkah -->
                    <div class="steps-section">
                        <h3 class="section-title">Cara Memasak *</h3>
                        <div id="steps-container">
                            <div class="step-item">
                                <span style="font-weight: bold; margin-right: 10px;">1.</span>
                                <textarea name="langkah[]" placeholder="Masukkan langkah memasak..." required></textarea>
                                <button type="button" class="remove-btn" onclick="removeStep(this)">Hapus</button>
                            </div>
                        </div>
                        <button type="button" class="add-btn" onclick="addStep()">+ Tambah Langkah</button>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">Buat Resep</button>
                        <a href="dashboard.php" class="btn-cancel">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

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
        let ingredientCount = 1;
        let stepCount = 1;

        function addIngredient() {
            ingredientCount++;
            const container = document.getElementById('ingredients-container');
            const newIngredient = document.createElement('div');
            newIngredient.className = 'ingredient-item';
            newIngredient.innerHTML = `
                <input type="text" name="bahan[]" placeholder="Nama bahan" required>
                <input type="text" name="jumlah[]" placeholder="Jumlah" required>
                <button type="button" class="remove-btn" onclick="removeIngredient(this)">Hapus</button>
            `;
            container.appendChild(newIngredient);
        }

        function removeIngredient(button) {
            if (document.querySelectorAll('.ingredient-item').length > 1) {
                button.parentElement.remove();
            } else {
                alert('Minimal harus ada 1 bahan!');
            }
        }

        function addStep() {
            stepCount++;
            const container = document.getElementById('steps-container');
            const newStep = document.createElement('div');
            newStep.className = 'step-item';
            newStep.innerHTML = `
                <span style="font-weight: bold; margin-right: 10px;">${stepCount}.</span>
                <textarea name="langkah[]" placeholder="Masukkan langkah memasak..." required></textarea>
                <button type="button" class="remove-btn" onclick="removeStep(this)">Hapus</button>
            `;
            container.appendChild(newStep);
        }

        function removeStep(button) {
            if (document.querySelectorAll('.step-item').length > 1) {
                button.parentElement.remove();
                updateStepNumbers();
            } else {
                alert('Minimal harus ada 1 langkah!');
            }
        }

        function updateStepNumbers() {
            const steps = document.querySelectorAll('.step-item span');
            steps.forEach((step, index) => {
                step.textContent = `${index + 1}.`;
            });
            stepCount = steps.length;
        }

        // File upload preview
        document.getElementById('foto_resep').addEventListener('change', function(e) {
            const label = document.querySelector('.file-upload-label span');
            if (e.target.files.length > 0) {
                label.textContent = `📷 ${e.target.files[0].name}`;
            } else {
                label.textContent = '📷 Klik untuk upload foto resep';
            }
        });
    </script>
</body>
</html>