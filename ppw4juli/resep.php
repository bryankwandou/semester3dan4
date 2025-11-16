<?php
require_once 'auth.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "sajian_nusantara";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get recipe ID from URL parameter, default to a specific recipe if not provided
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// If no ID provided, try to find "Palumara Ikan Bandeng" recipe
if (!$recipe_id) {
    $stmt = $pdo->prepare("SELECT id FROM resep WHERE nama_resep LIKE '%Palumara%' OR nama_resep LIKE '%palumara%' LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $recipe_id = $result['id'];
    }
}

// If still no recipe found, show error
if (!$recipe_id) {
    die("Resep tidak ditemukan. Pastikan resep sudah ada di database.");
}

// Fetch recipe details
$stmt = $pdo->prepare("
    SELECT r.*, u.nama as nama_user 
    FROM resep r 
    LEFT JOIN users u ON r.user_id = u.id 
    WHERE r.id = ?
");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$recipe) {
    die("Resep tidak ditemukan.");
}

// Fetch ingredients
$stmt = $pdo->prepare("SELECT * FROM resep_bahan WHERE resep_id = ? ORDER BY id");
$stmt->execute([$recipe_id]);
$ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch cooking steps
$stmt = $pdo->prepare("SELECT * FROM resep_langkah WHERE resep_id = ? ORDER BY urutan");
$stmt->execute([$recipe_id]);
$steps = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>SajianNusantara - <?php echo htmlspecialchars($recipe['nama_resep']); ?></title>

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
                        <a class="nav-brand" href="index.html"><img src="img/core-img/s.jpg" width='100' height='100' alt=""></a>

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
                                    <li class="<?php echo ($recipe['kategori'] == 'makanan_utama') ? 'active' : ''; ?>"><a href="makanan.php">Makanan Utama</a></li>
                                    <li class="<?php echo ($recipe['kategori'] == 'minuman') ? 'active' : ''; ?>"><a href="minuman.php">Minuman</a></li>
                                    <li class="<?php echo ($recipe['kategori'] == 'kue') ? 'active' : ''; ?>"><a href="kue.php">Kue</a></li>
                                    <li class="<?php echo ($recipe['kategori'] == 'cemilan') ? 'active' : ''; ?>"><a href="cemilan.php">Cemilan</a></li>
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

    <!-- Receipe Content Area -->
    <div class="receipe-content-area">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="receipe-headline my-5">
                        <h2 style="margin-bottom: -45px;"><?php echo htmlspecialchars($recipe['nama_resep']); ?></h2>
                        <div class="receipe-ratings text-left my-5">
                            <div class="receipe-duration">
                                <?php if ($recipe['waktu_masak']): ?>
                                    <h6 style="font-size: 20px;">Waktu Memasak <?php echo $recipe['waktu_masak']; ?> menit</h6>
                                <?php endif; ?>
                                <?php if ($recipe['porsi']): ?>
                                    <h6 style="font-size: 20px;">Porsi <?php echo $recipe['porsi']; ?> Orang</h6>
                                <?php endif; ?>
                                <?php if ($recipe['nama_user']): ?>
                                    <h6 style="font-size: 16px; color: #777;">Oleh: <?php echo htmlspecialchars($recipe['nama_user']); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($recipe['deskripsi']): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="recipe-description">
                        <h4>Deskripsi</h4>
                        <p style="font-size: 18px;"><?php echo nl2br(htmlspecialchars($recipe['deskripsi'])); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <h4 class="mb-4">Cara Memasak</h4>
                    <?php if (!empty($steps)): ?>
                        <?php foreach ($steps as $index => $step): ?>
                            <!-- Single Preparation Step -->
                            <div class="single-preparation-step d-flex">
                                <h4 style="font-size: 20px;"><?php echo str_pad($step['urutan'], 2, '0', STR_PAD_LEFT); ?>.</h4>
                                <p style="font-size: 20px;"><?php echo nl2br(htmlspecialchars($step['langkah'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Langkah-langkah memasak belum tersedia.</p>
                    <?php endif; ?>
                </div>

                <!-- Ingredients -->
                <div class="col-12 col-lg-4">
                    <div class="ingredients">
                        <h4>Bahan-Bahan</h4>

                        <?php if (!empty($ingredients)): ?>
                            <?php foreach ($ingredients as $index => $ingredient): ?>
                                <!-- Custom Checkbox -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $index + 1; ?>">
                                    <label style="font-size: 20px;" class="custom-control-label" for="customCheck<?php echo $index + 1; ?>">
                                        <?php echo htmlspecialchars($ingredient['jumlah'] . ' ' . $ingredient['nama_bahan']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Bahan-bahan belum tersedia.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="col-12">
                    <div class="save-recipe-area text-center d-flex justify-content-center align-items-center" style="min-height: 200px;">
                        <div class="save-recipe-content">
                            <h4 style="font-size: 24px;" class="mb-3">Suka dengan resep ini?</h4>
                            <p style="font-size: 20px;" class="mb-4">Simpan resep ini ke koleksi favorit Anda untuk dimasak nanti!</p>
                            <button class="btn delicious-btn mx-auto" type="button" onclick="saveRecipe(<?php echo $recipe['id']; ?>)">
                                <i class="fa fa-heart mr-2"></i>Simpan Resep
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                    <!-- Footer Logo -->
                    <div class="footer-logo">
                        <a href="index.html"><img style="height: 50px; width: 50px;" src="img/core-img/s.jpg" alt=""></a>
                    </div>
                    <!-- Copywrite -->
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> SajianNusantara</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ##### Footer Area Start ##### -->

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

    <script>
    function saveRecipe(recipeId) {
        // You can implement AJAX call here to save recipe to user's favorites
        alert('Fitur simpan resep akan segera tersedia!');
        
        // Example AJAX implementation:
        /*
        $.ajax({
            url: 'save_recipe.php',
            method: 'POST',
            data: { recipe_id: recipeId },
            success: function(response) {
                alert('Resep berhasil disimpan!');
            },
            error: function() {
                alert('Gagal menyimpan resep. Silakan coba lagi.');
            }
        });
        */
    }
    </script>
</body>

</html>