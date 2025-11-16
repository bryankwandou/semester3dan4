<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <meta name="description" content="NNGProperty - Miliki Properti Impian Anda" />
    <meta name="keywords" content="property, real estate, rumah, investasi" />
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary-color: #28a745;
            --secondary-color: #218838;
            --dark-color: #333;
            --light-color: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Work Sans', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
        }

        /* Login Area */
        .login-area {
            position: absolute;
            top: 10px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 15px;
            border-radius: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .login-area a {
            color: var(--dark-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin: 0 8px;
            padding: 6px 12px;
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .login-area a:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .login-area .login-btn {
            background: var(--primary-color);
            color: white !important;
        }
        
        .login-area .login-btn:hover {
            background: var(--secondary-color);
        }

        /* Navigation */
        .site-nav {
            position: relative;
            padding: 20px 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .site-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .site-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .site-menu li {
            margin: 0 15px;
            position: relative;
        }

        .site-menu a {
            color: var(--dark-color);
            text-decoration: none;
            font-weight: 500;
            padding: 10px 0;
            transition: color 0.3s ease;
        }

        .site-menu a:hover {
            color: var(--primary-color);
        }

        .site-menu .active a {
            color: var(--primary-color);
        }

        .dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            list-style: none;
            padding: 10px 0;
        }

        .has-children:hover .dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown a {
            padding: 8px 20px;
            display: block;
            color: var(--dark-color);
        }

        .dropdown a:hover {
            background: var(--light-color);
            color: var(--primary-color);
        }

        .burger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .burger span {
            width: 25px;
            height: 3px;
            background: var(--dark-color);
            margin: 3px 0;
            transition: 0.3s;
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-slide .img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .hero-slide .img.active {
            opacity: 1;
        }

        .hero-slide .img::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .hero .container {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .form-search {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            padding: 5px;
            backdrop-filter: blur(10px);
        }

        .form-search input {
            border: none;
            background: transparent;
            color: var(--dark-color);
        }

        .form-search input::placeholder {
            color: #666;
        }

        .form-search .btn {
            background: var(--primary-color);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
        }

        /* Property Slider */
        .property-slider-wrap {
            position: relative;
            overflow: hidden;
        }

        .property-slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .property-item {
            min-width: 350px;
            margin: 0 15px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .property-item:hover {
            transform: translateY(-5px);
        }

        .property-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .property-content {
            padding: 20px;
        }

        .price {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .controls {
            text-align: center;
            margin-top: 20px;
        }

        .controls span {
            display: inline-block;
            margin: 0 10px;
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .controls span:hover {
            background: var(--secondary-color);
        }

        /* Features */
        .features-1 {
            padding: 80px 0;
            background: var(--light-color);
        }

        .box-feature {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .box-feature:hover {
            transform: translateY(-10px);
        }

        .box-feature span {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: block;
        }

        /* Testimonials */
        .testimonial-slider-wrap {
            position: relative;
            overflow: hidden;
        }

        .testimonial-slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .testimonial {
            min-width: 400px;
            margin: 0 15px;
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .testimonial img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .rate {
            margin: 20px 0;
        }

        .rate span {
            color: #ffc107;
            font-size: 20px;
            margin: 0 2px;
        }

        /* Footer */
        .site-footer {
            background: var(--dark-color);
            color: white;
            padding: 60px 0 20px;
        }

        .site-footer h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        

        .site-footer a {
            color: #ccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .site-footer a:hover {
            color: var(--primary-color);
        }

        .social a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .social a:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-area {
                position: relative;
                top: 0;
                right: 0;
                margin: 10px;
                text-align: center;
                width: calc(100% - 20px);
            }

            .site-menu {
                display: none;
            }

            .burger {
                display: flex;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .property-item {
                min-width: 280px;
            }

            .testimonial {
                min-width: 300px;
            }

            .form-search {
                flex-direction: column;
                border-radius: 15px;
            }

            .form-search input {
                margin-bottom: 10px;
                border-radius: 10px;
            }

            .form-search .btn {
                border-radius: 10px;
            }
        }
    </style>
    
    <title>Beranda &mdash; NNGProperty</title>
</head>
<body>
    <!-- Login Area -->
    <div class="login-area">
        <div class="container">
            <a href="login.php">Daftar</a>
            <a href="login.php" class="login-btn">Masuk</a>
        </div>
    </div>


 <!-- Navigation -->
    <nav class="site-nav">
        <div class="container">
            <div class="site-navigation">
                <a href="#" class="logo">NNGProperty</a>
                
                <ul class="site-menu">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li class="has-children">
                        <a href="properties.php">Properties</a>
                        <ul class="dropdown">
                            <li><a href="beli-properti.php">Beli Properti</a></li>
                            <li><a href="sewa-properti.php">Sewa Properti</a></li>
                            <li><a href="kpr-rumah.php">Ajukan KPR Rumah</a></li>
                        </ul>
                    </li>
                    <li><a href="services.php">Layanan Kami</a></li>
                    <li><a href="about.php">Tentang Kami</a></li>
                    <li><a href="contact.php">Hubungi Kami</a></li>
                </ul>
                
                <div class="burger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-slide">
            <div class="img active" style="background-image: url('https://images.unsplash.com/photo-1605146769289-440113cc3d00?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')"></div>
            <div class="img" style="background-image: url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2073&q=80')"></div>
            <div class="img" style="background-image: url('https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9 text-center">
                    <h1 class="heading" data-aos="fade-up">Miliki Properti Impian Anda Hari Ini</h1>
                    <form class="form-search d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <input type="text" class="form-control px-4" placeholder="Masukkan Lokasi Properti (Contoh: Makassar)" />
                        <button type="submit" class="btn btn-primary">search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="section py-5">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="font-weight-bold text-primary">Properti yang Sedang Populer</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="#" class="btn btn-primary">Lihat Semua Properti</a>
                </div>
            </div>
            
            <div class="property-slider-wrap">
                <div class="property-slider" id="propertySlider">
                    <div class="property-item">
                        <img src="https://images.unsplash.com/photo-1605146769289-440113cc3d00?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Property 1" />
                        <div class="property-content">
                            <div class="price mb-2">Rp 1.2 Miliar</div>
                            <div>
                                <span class="d-block mb-2 text-muted">Summarecon Mutiara Makassar</span>
                                <span class="d-block mb-3 fw-bold">Makassar</span>
                                <div class="specs d-flex mb-4">
                                    <span class="me-3">🛏️ 3 Kamar Tidur</span>
                                    <span>🚿 2 Kamar Mandi</span>
                                </div>
                                <a href="#" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>

                    <div class="property-item">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Property 2" />
                        <div class="property-content">
                            <div class="price mb-2">Rp 890 Juta</div>
                            <div>
                                <span class="d-block mb-2 text-muted">Perumahan Elit Jakarta</span>
                                <span class="d-block mb-3 fw-bold">Jakarta</span>
                                <div class="specs d-flex mb-4">
                                    <span class="me-3">🛏️ 2 Kamar Tidur</span>
                                    <span>🚿 2 Kamar Mandi</span>
                                </div>
                                <a href="#" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>

                    <div class="property-item">
                        <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Property 3" />
                        <div class="property-content">
                            <div class="price mb-2">Rp 1.5 Miliar</div>
                            <div>
                                <span class="d-block mb-2 text-muted">Villa Mewah Bandung</span>
                                <span class="d-block mb-3 fw-bold">Bandung</span>
                                <div class="specs d-flex mb-4">
                                    <span class="me-3">🛏️ 4 Kamar Tidur</span>
                                    <span>🚿 3 Kamar Mandi</span>
                                </div>
                                <a href="#" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="controls">
                    <span onclick="prevProperty()">← Sebelumnya</span>
                    <span onclick="nextProperty()">Selanjutnya →</span>
                </div>
            </div>
        </div>
    </div>

    <section class="features-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="box-feature">
                        <span>🏠</span>
                        <h3>Properti Terpilih</h3>
                        <p>Koleksi properti terbaik dengan kualitas tinggi dan harga kompetitif untuk investasi masa depan Anda.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="box-feature">
                        <span>🏢</span>
                        <h3>Properti Komersial</h3>
                        <p>Berbagai pilihan properti komersial strategis untuk mengembangkan bisnis Anda.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="box-feature">
                        <span>👥</span>
                        <h3>Agen Profesional</h3>
                        <p>Tim agen berpengalaman siap membantu Anda menemukan properti impian dengan pelayanan terbaik.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="box-feature">
                        <span>💰</span>
                        <h3>Harga Terjangkau</h3>
                        <p>Dapatkan properti berkualitas dengan harga yang sesuai budget dan sistem pembayaran fleksibel.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-6">
                    <h2 class="font-weight-bold text-primary">Testimoni Pelanggan</h2>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="controls">
                        <span onclick="prevTestimonial()">← Sebelumnya</span>
                        <span onclick="nextTestimonial()">Selanjutnya →</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-slider-wrap">
                <div class="testimonial-slider" id="testimonialSlider">
                    <div class="testimonial">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Rizky" class="rounded-circle mb-4" />
                        <div class="rate">
                            <span>⭐⭐⭐⭐⭐</span>
                        </div>
                        <h5 class="text-primary mb-3">Rizky A. — Jakarta</h5>
                        <blockquote>
                            <p>"Saya sangat puas dengan layanan NNGProperty. Proses beli rumah jadi lebih mudah dan cepat. Timnya profesional dan komunikatif!"</p>
                        </blockquote>
                        <p class="text-muted">Karyawan Swasta</p>
                    </div>

                    <div class="testimonial">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Budi" class="rounded-circle mb-4" />
                        <div class="rate">
                            <span>⭐⭐⭐⭐⭐</span>
                        </div>
                        <h5 class="text-primary mb-3">Budi S. — Bandung</h5>
                        <blockquote>
                            <p>"Dari awal survei sampai akad, semuanya berjalan lancar. Terima kasih NNGProperty sudah bantu wujudkan rumah impian saya!"</p>
                        </blockquote>
                        <p class="text-muted">Entrepreneur</p>
                    </div>

                    <div class="testimonial">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80" alt="Clara" class="rounded-circle mb-4" />
                        <div class="rate">
                            <span>⭐⭐⭐⭐⭐</span>
                        </div>
                        <h5 class="text-primary mb-3">Clara H. — Yogyakarta</h5>
                        <blockquote>
                            <p>"Saya suka karena prosesnya transparan dan timnya ramah. Saya merasa tenang dan aman selama proses transaksi."</p>
                        </blockquote>
                        <p class="text-muted">Designer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3>Kontak Kami</h3>
                    <p>Jl. Raya Makassar No. 123<br>Makassar, Sulawesi Selatan</p>
                    <p>📞 +62 411 123 4567<br>📧 info@nngproperty.com</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h3>Layanan</h3>
                    <ul class="list-unstyled">
                        <li><a href="#">Jual Beli Properti</a></li>
                        <li><a href="#">Sewa Properti</a></li>
                        <li><a href="#">Konsultasi KPR</a></li>
                        <li><a href="#">Investasi Properti</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h3>Ikuti Kami</h3>
                    <div class="social">
                        <a href="#">📘</a>
                        <a href="#">📷</a>
                        <a href="#">🐦</a>
                        <a href="#">💼</a>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p>&copy; 2024 NNGProperty. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Hero Slideshow
        let currentHeroSlide = 0;
        const heroSlides = document.querySelectorAll('.hero-slide .img');
        
        function showHeroSlide(index) {
            heroSlides.forEach(slide => slide.classList.remove('active'));
            heroSlides[index].classList.add('active');
        }
        
        function nextHeroSlide() {
            currentHeroSlide = (currentHeroSlide + 1) % heroSlides.length;
            showHeroSlide(currentHeroSlide);
        }
        
        setInterval(nextHeroSlide, 5000);

        // Property Slider
        let currentPropertyIndex = 0;
        const propertySlider = document.getElementById('propertySlider');
        const propertyItems = document.querySelectorAll('.property-item');
        
        function updatePropertySlider() {
            const itemWidth = propertyItems[0].offsetWidth + 30;
            const maxIndex = propertyItems.length - Math.floor(propertySlider.parentElement.offsetWidth / itemWidth);
            currentPropertyIndex = Math.max(0, Math.min(currentPropertyIndex, maxIndex));
            propertySlider.style.transform = `translateX(-${currentPropertyIndex * itemWidth}px)`;
        }
        
        function nextProperty() {
            currentPropertyIndex++;
            updatePropertySlider();
        }
        
        function prevProperty() {
            currentPropertyIndex--;
            updatePropertySlider();
        }
        
        // Testimonial Slider
        let currentTestimonialIndex = 0;
        const testimonialSlider = document.getElementById('testimonialSlider');
        const testimonialItems = document.querySelectorAll('.testimonial');
        
        function updateTestimonialSlider() {
            const itemWidth = testimonialItems[0].offsetWidth + 30;
            const maxIndex = testimonialItems.length - Math.floor(testimonialSlider.parentElement.offsetWidth / itemWidth);
            currentTestimonialIndex = Math.max(0, Math.min(currentTestimonialIndex, maxIndex));
            testimonialSlider.style.transform = `translateX(-${currentTestimonialIndex * itemWidth}px)`;
        }
        
        function nextTestimonial() {
            currentTestimonialIndex++;
            updateTestimonialSlider();
        }
        
        function prevTestimonial() {
            currentTestimonialIndex--;
            updateTestimonialSlider();
        }
        
        // Mobile Menu Toggle
        function toggleMenu() {
            const siteMenu = document.querySelector('.site-menu');
            const burger = document.querySelector('.burger');
            
            if (siteMenu.style.display === 'flex') {
                siteMenu.style.display = 'none';
                burger.classList.remove('active');
            } else {
                siteMenu.style.display = 'flex';
                siteMenu.style.flexDirection = 'column';
                siteMenu.style.position = 'absolute';
                siteMenu.style.top = '100%';
                siteMenu.style.left = '0';
                siteMenu.style.width = '100%';
                siteMenu.style.background = 'white';
                siteMenu.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                siteMenu.style.padding = '20px';
                burger.classList.add('active');
            }
        }
        
        // Form Search Handler
        document.querySelector('.form-search').addEventListener('submit', function(e) {
            e.preventDefault();
            const location = document.querySelector('.form-search input').value;
            if (location.trim()) {
                alert(`Mencari properti di: ${location}`);
            } else {
                alert('Silakan masukkan lokasi terlebih dahulu');
            }
        });
        
        // Responsive slider updates
        window.addEventListener('resize', function() {
            updatePropertySlider();
            updateTestimonialSlider();
        });
        
        // Initialize sliders on page load
        document.addEventListener('DOMContentLoaded', function() {
            updatePropertySlider();
            updateTestimonialSlider();
        });
        
        // Smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.site-nav');
            if (window.scrollY > 50) {
                nav.style.background = 'rgba(255, 255, 255, 0.98)';
                nav.style.boxShadow = '0 2px 20px rgba(0,0,0,0.15)';
            } else {
                nav.style.background = 'rgba(255, 255, 255, 0.95)';
                nav.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });
    </script>
</body>
</html>