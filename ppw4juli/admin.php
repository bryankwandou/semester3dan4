<?php 
session_start();
require_once 'config.php';

// Jika admin sudah login, redirect ke dashboard admin
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard_admin.php");
    exit();
}

// Ambil data dari session untuk menampilkan kembali jika ada error
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';

// Hapus data session setelah digunakan
unset($_SESSION['errors']);
unset($_SESSION['success']);

// Process login admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['admin_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $errors = [];
    
    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong";
    }
    
    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong";
    }
    
    // Hardcoded admin credentials (dalam implementasi nyata, sebaiknya disimpan di database dengan hash)
    $admin_username = "admin";
    $admin_password = "admin123"; 
    
    if (empty($errors)) {
        if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['admin_id'] = 1;
            $_SESSION['admin_username'] = $username;
            header("Location: dashboard_admin.php");
            exit();
        } else {
            $errors[] = "Username atau password salah";
        }
    }
    
    $_SESSION['errors'] = $errors;
    header("Location: admin.php");
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
    
    <!-- Title -->
    <title>SajianNusantara - Admin Login</title>
    
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">
    
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Alert Styles -->
    <style>
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
        .admin-login-container {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .admin-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        .admin-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #f96d38;
            text-decoration: none;
        }
        .back-link:hover {
            color: #333;
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
                        <a class="nav-brand" href="index.php">
                            <img src="img/core-img/s.jpg" width='100' height='100' alt="">
                        </a>

                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="makanan.php">Makanan Utama</a></li>
                                <li><a href="minuman.php">Minuman</a></li>
                                <li><a href="kue.php">Kue</a></li>
                                <li><a href="cemilan.php">Cemilan</a></li>
                                <li><a href="akun.php">Akun Saya</a></li>
                            </ul>
                        </div>
                        <!-- Nav End -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- Admin Login Area -->
    <div class="admin-login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="admin-card">
                        <a href="index.php" class="back-link">
                            <i class="fa fa-arrow-left"></i> Kembali ke Beranda
                        </a>
                        
                        <h2 class="admin-title">Admin Login</h2>
                        
                        <!-- Alert Messages -->
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success">
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul style="margin: 0; padding-left: 20px;">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form method="post">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control" name="username" 
                                       placeholder="Username Admin" required>
                            </div>
                            <div class="form-group mb-4">
                                <input type="password" class="form-control" name="password" 
                                       placeholder="Password Admin" required>
                            </div>
                            <div class="text-center">
                                <button name="admin_login" class="btn delicious-btn" type="submit" style="width: 100%;">
                                    Login Admin
                                </button>
                            </div>
                        </form>
                        
                        <!-- <div class="text-center mt-3">
                            <small class="text-muted">Default: admin / admin123</small>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer-area">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-12 h-100 d-flex flex-wrap align-items-center justify-content-between">
                    <!-- Footer Logo -->
                    <div class="footer-logo">
                        <a href="index.php"><img style="height: 50px; width: 50px;" src="img/core-img/s.jpg" alt=""></a>
                    </div>
                    <!-- Copywrite -->
                    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> SajianNusantara</p>
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
</body>

</html>