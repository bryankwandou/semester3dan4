<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login - NNGProperty Indonesia Official Website</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5%;
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 40px;
        }
        .nav-links {
            display: flex;
            gap: 20px;
        }
        .nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }
        .actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .actions a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }
        .btn-post {
            background-color: #fff;
            color: #3366cc;
            border: 1px solid #3366cc;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .container {
            display: flex;
            margin: 30px auto;
            max-width: 1200px;
        }
        .banner {
            flex: 1;
            background-color: #3366cc;
            color: white;
            padding: 30px;
            border-radius: 5px;
            margin-right: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            min-height: 500px;
        }
        .banner-image {
            position: absolute;
            bottom: 0;
            left: 20px;
            height: 70%;
            max-height: 350px;
        }
        .banner-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            z-index: 2;
            padding-right: 40%;
        }
        .feature-list {
            margin-top: 30px;
            z-index: 2;
            padding-left: 40%;
        }
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .feature-icon {
            background-color: #ffc107;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .feature-text {
            font-size: 16px;
            font-weight: bold;
        }
        .login-form {
            flex: 0 0 380px;
            background-color: #fff;
            padding: 25px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-title {
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .forgot-password {
            font-size: 14px;
            color: #3366cc;
            text-decoration: none;
            display: block;
            margin-bottom: 20px;
        }
        .btn-primary {
            width: 100%;
            background-color: #3366cc;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }
        .or-divider {
            text-align: center;
            margin: 20px 0;
            color: #999;
            position: relative;
        }
        .or-divider::before, .or-divider::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #ddd;
        }
        .or-divider::before {
            left: 0;
        }
        .or-divider::after {
            right: 0;
        }
        .social-login {
            margin-top: 20px;
        }
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: #333;
        }
        .social-btn img {
            width: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <img src="E:\bootstrap html project\EstateAgency\Property\nngp.ico" alt="NNGProperty Login Page">
        </div>
        <div class="nav-links">
            <a href="#">Beranda</a>
            <a href="#">Tentang Kami</a>
            <a href="#">Cari Properti</a>
            <a href="#">Agen Kami</a>
            <a href="#">Hubungi Kami</a>
        </div>
        <div class="actions">
            <button class="btn-post">Pasang Iklan</button>
            <a href="#">Akun</a>
        </div>
    </div>

    <div class="container">
        <div class="banner">
            <h1 class="banner-title">Percayakan Proses Pencarian Properti pada Kami, karena #SemuaAdaDisini</h1>
            <img src="E:\bootstrap html project\EstateAgency\Property\me.jpg" alt="Property Agent" class="banner-image">
            <div class="feature-list">
                <div class="feature-item">
                    <div class="feature-icon">🏠</div>
                    <div class="feature-text">Ragam Pilihan<br>Properti Berkualitas</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">🤝</div>
                    <div class="feature-text">Mitra Developer<br>& Agen Properti<br>Terpercaya</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📋</div>
                    <div class="feature-text">Info KPR Terlengkap,<br>Sesuai Kebutuhan</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">👆</div>
                    <div class="feature-text">Fitur Terdepan<br>dalam Menemukan<br>Rumah Impian</div>
                </div>
            </div>
        </div>

        <div class="login-form">
            <h2 class="form-title">Login/Register</h2>
            <div class="form-group">
                <label for="phone-email">Nomor Telepon atau Email</label>
                <input type="text" id="phone-email" class="form-control" placeholder="Masukan Nomor Telepon atau Email">
            </div>
            <a href="#" class="forgot-password">Lupa Password?</a>
            <button class="btn-primary">Selanjutnya</button>

            <div class="or-divider">Atau Login dengan</div>

            <div class="social-login">
                <a href="#" class="social-btn">
                    <img src="E:\bootstrap html project\EstateAgency\Property\wa.jpg" alt="WhatsApp">
                    Masuk dengan WhatsApp
                </a>
                <a href="#" class="social-btn">
                    <img src="E:\bootstrap html project\EstateAgency\Property\g.jpg" alt="Google">
                    Masuk dengan Google
                </a>
                <a href="#" class="social-btn">
                    <img src="E:\bootstrap html project\EstateAgency\Property\f.jpg" alt="Facebook">
                    Masuk dengan Facebook
                </a>
            </div>
        </div>
    </div>
</body>
</html>