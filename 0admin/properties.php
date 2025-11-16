<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Cari Properti - NNGProperty Indonesia Official Website</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="E:\bootstrap html project\EstateAgency\Property\ico.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    .filter-section {
      background: #f8f9fa;
      padding: 30px 0;
      margin-bottom: 40px;
    }
    .filter-card {
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .property-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
    }
    .location-badge {
      background: linear-gradient(45deg, #2c5aa0, #1e4080);
      color: white;
      font-size: 0.8rem;
      padding: 4px 8px;
      border-radius: 15px;
      margin-bottom: 8px;
      display: inline-block;
    }
    .property-card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .property-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    .property-image {
      height: 250px;
      object-fit: cover;
      width: 100%;
    }
    .price-tag {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(0,0,0,0.8);
      color: white;
      padding: 8px 15px;
      border-radius: 20px;
      font-weight: bold;
    }
    .property-features {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
      margin-top: 15px;
    }
    .feature-item {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }
    .feature-item i {
      color: #2c5aa0;
      margin-right: 8px;
      width: 20px;
    }
    .section-title {
      text-align: center;
      margin-bottom: 50px;
    }
    .section-title h2 {
      color: #2c5aa0;
      font-weight: bold;
      margin-bottom: 15px;
    }
    .btn-primary {
      background: linear-gradient(45deg, #2c5aa0, #1e4080);
      border: none;
      border-radius: 25px;
      padding: 12px 30px;
      font-weight: bold;
    }
    .btn-outline-primary {
      border: 2px solid #2c5aa0;
      color: #2c5aa0;
      border-radius: 25px;
      padding: 10px 25px;
      font-weight: bold;
    }
    .btn-outline-primary:hover {
      background: #2c5aa0;
      color: white;
    }
  </style>
</head>

<body class="properties-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <h1 class="sitename">NNG<span>Property</span></h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Beranda</a></li>
          <li><a href="about.html">Tentang Kami</a></li>
          <li><a href="properties.html" class="active">Cari Properti</a></li>
          <li><a href="agents.html">Agen Kami</a></li>
          <li><a href="contact.html">Hubungi Kami</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>Properti di Makassar & Sekitarnya</h1>
              <p class="mb-0">Temukan hunian impian Anda di kota Makassar dan wilayah sekitarnya. Kami menyediakan berbagai pilihan properti berkualitas dengan lokasi strategis dan harga terjangkau.</p>
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Properties</li>
          </ol>
        </div>
      </nav>
    </div>

    <!-- Filter Section -->
    <section class="filter-section">
      <div class="container">
        <div class="filter-card">
          <div class="row">
            <div class="col-md-3">
              <label class="form-label">Lokasi</label>
              <select class="form-select">
                <option>Semua Lokasi</option>
                <option>Makassar Pusat</option>
                <option>Panakkukang</option>
                <option>Tamalate</option>
                <option>Rappocini</option>
                <option>Gowa</option>
                <option>Maros</option>
                <option>Takalar</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Tipe</label>
              <select class="form-select">
                <option>Semua Tipe</option>
                <option>Dijual</option>
                <option>Disewa</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label">Harga Min</label>
              <input type="number" class="form-control" placeholder="Rp 0">
            </div>
            <div class="col-md-2">
              <label class="form-label">Harga Max</label>
              <input type="number" class="form-control" placeholder="Rp 5M">
            </div>
            <div class="col-md-2">
              <label class="form-label">Kamar Tidur</label>
              <select class="form-select">
                <option>Semua</option>
                <option>1+</option>
                <option>2+</option>
                <option>3+</option>
                <option>4+</option>
              </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
              <button class="btn btn-primary w-100">Cari</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Properties Section -->
    <section id="real-estate" class="real-estate section">
      <div class="container">
        
        <!-- Premium Properties -->
        <div class="section-title">
          <h2>Properti Premium</h2>
          <p>Pilihan terbaik untuk investasi dan hunian mewah</p>
        </div>

        <div class="property-grid mb-5">
          
          <!-- Property 1 -->
          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop" alt="Rumah Mewah Panakkukang" class="property-image">
                <div class="price-tag">Rp 3.2M</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Panakkukang</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Rumah Mewah Panakkukang Mas</a></h5>
                <p class="text-muted small">Jl. Boulevard Panakkukang, Makassar</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 500m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 350m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>5 Kamar Tidur, 4 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-car-front"></i>
                    <span>Garasi 2 Mobil</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 2 -->
          <div class="col" data-aos="fade-up" data-aos-delay="200">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=250&fit=crop" alt="Villa Modern Gowa" class="property-image">
                <div class="price-tag">Rp 2.8M</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Gowa</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Villa Modern Samata</a></h5>
                <p class="text-muted small">Jl. Hertasning, Samata, Gowa</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 400m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 280m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>4 Kamar Tidur, 3 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-swimming"></i>
                    <span>Kolam Renang Pribadi</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 3 -->
          <div class="col" data-aos="fade-up" data-aos-delay="300">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=400&h=250&fit=crop" alt="Townhouse Tamalate" class="property-image">
                <div class="price-tag">Rp 1.8M</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Tamalate</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Townhouse Exclusive BTP</a></h5>
                <p class="text-muted small">Jl. BTP Raya, Tamalate, Makassar</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 200m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 180m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>3 Kamar Tidur, 3 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Security 24 Jam</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Residential Properties -->
        <div class="section-title">
          <h2>Hunian Keluarga</h2>
          <p>Rumah nyaman untuk keluarga bahagia</p>
        </div>

        <div class="property-grid mb-5">

          <!-- Property 4 -->
          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=400&h=250&fit=crop" alt="Perumahan Antang" class="property-image">
                <div class="price-tag">Rp 850Jt</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Manggala</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Rumah Cluster Antang Raya</a></h5>
                <p class="text-muted small">Perumahan Green Garden, Antang</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 150m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 120m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>3 Kamar Tidur, 2 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-tree"></i>
                    <span>Taman & Carport</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 5 -->
          <div class="col" data-aos="fade-up" data-aos-delay="200">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=400&h=250&fit=crop" alt="Rumah Rappocini" class="property-image">
                <div class="price-tag">Rp 1.2M</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Rappocini</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Rumah Minimalis Rappocini</a></h5>
                <p class="text-muted small">Jl. Rappocini Raya, Makassar</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 180m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 140m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>3 Kamar Tidur, 2 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Dekat Mall & Sekolah</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 6 -->
          <div class="col" data-aos="fade-up" data-aos-delay="300">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=400&h=250&fit=crop" alt="Perumahan Maros" class="property-image">
                <div class="price-tag">Rp 650Jt</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Maros</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Rumah Keluarga Maros Baru</a></h5>
                <p class="text-muted small">Perumahan Maros Indah, Maros</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 200m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 110m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>3 Kamar Tidur, 2 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-currency-dollar"></i>
                    <span>Harga Terjangkau</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Rental Properties -->
        <div class="section-title">
          <h2>Properti Sewa</h2>
          <p>Sewa rumah dan apartemen dengan harga kompetitif</p>
        </div>

        <div class="property-grid mb-5">

          <!-- Property 7 -->
          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=400&h=250&fit=crop" alt="Apartment Trans Studio" class="property-image">
                <div class="price-tag">Rp 8Jt/bulan</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Makassar Pusat</div>
                <span class="sale-rent" style="color: #007bff; font-weight: bold;">Disewa</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Apartemen Trans Studio</a></h5>
                <p class="text-muted small">Trans Studio Mall, Makassar</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas: 45m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>Studio + 1 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-wifi"></i>
                    <span>Fully Furnished + WiFi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-building"></i>
                    <span>Akses Langsung Mall</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 8 -->
          <div class="col" data-aos="fade-up" data-aos-delay="200">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=400&h=250&fit=crop" alt="Rumah Sewa Tamalate" class="property-image">
                <div class="price-tag">Rp 15Jt/bulan</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Tamalate</div>
                <span class="sale-rent" style="color: #007bff; font-weight: bold;">Disewa</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Rumah Furnished BTP</a></h5>
                <p class="text-muted small">Jl. BTP Blok C, Tamalate</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Tanah: 150m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-house"></i>
                    <span>Luas Bangunan: 120m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>3 Kamar Tidur, 2 Kamar Mandi</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-car-front"></i>
                    <span>Carport + Taman</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 9 -->
          <div class="col" data-aos="fade-up" data-aos-delay="300">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&h=250&fit=crop" alt="Kost Premium" class="property-image">
                <div class="price-tag">Rp 1.5Jt/bulan</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Panakkukang</div>
                <span class="sale-rent" style="color: #007bff; font-weight: bold;">Disewa</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Kost Premium Panakkukang</a></h5>
                <p class="text-muted small">Jl. Pengayoman, Panakkukang</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas Kamar: 20m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-door-open"></i>
                    <span>Kamar Mandi Dalam</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-wifi"></i>
                    <span>AC + WiFi + Laundry</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Security & CCTV</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Commercial Properties -->
        <div class="section-title">
          <h2>Properti Komersial</h2>
          <p>Investasi properti untuk bisnis dan usaha</p>
        </div>

        <div class="property-grid mb-5">

          <!-- Property 10 -->
          <div class="col" data-aos="fade-up" data-aos-delay="100">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600607688969-a5bfcd646154?w=400&h=250&fit=crop" alt="Ruko Somba Opu" class="property-image">
                <div class="price-tag">Rp 2.5M</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Makassar Pusat</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Ruko Strategis Somba Opu</a></h5>
                <p class="text-muted small">Jl. Somba Opu, Makassar</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas: 4x15m (3 Lantai)</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-shop"></i>
                    <span>Cocok untuk Toko/Kantor</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Jalan Protokol</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-car-front"></i>
                    <span>Parkir Luas</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 11 -->
          <div class="col" data-aos="fade-up" data-aos-delay="200">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600047509358-9dc75507daeb?w=400&h=250&fit=crop" alt="Gedung Kantor" class="property-image">
                <div class="price-tag">Rp 45Jt/bulan</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Panakkukang</div>
                <span class="sale-rent" style="color: #007bff; font-weight: bold;">Disewa</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Gedung Kantor Panakkukang</a></h5>
                <p class="text-muted small">Jl. Urip Sumoharjo, Panakkukang</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas: 500m² (4 Lantai)</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-building"></i>
                    <span>Gedung Perkantoran</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-elevator"></i>
                    <span>Lift + AC Central</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Security 24 Jam</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Property 12 -->
          <div class="col" data-aos="fade-up" data-aos-delay="300">
            <div class="card property-card">
              <div class="position-relative">
                <img src="https://images.unsplash.com/photo-1600607688960-67cd62d1de4e?w=400&h=250&fit=crop" alt="Tanah Kavling" class="property-image">
                <div class="price-tag">Rp 1.8M</div>
              </div>
              <div class="card-body">
                <div class="location-badge">Takalar</div>
                <span class="sale-rent" style="color: #28a745; font-weight: bold;">Dijual</span>
                <h5><a href="property-single.html" class="stretched-link text-decoration-none">Tanah Kavling Takalar</a></h5>
                <p class="text-muted small">Jl. Poros Takalar, Takalar</p>
                <div class="property-features">
                  <div class="feature-item">
                    <i class="bi bi-rulers"></i>
                    <span>Luas: 1000m²</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-map"></i>
                    <span>Sertifikat SHM</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-road"></i>
                    <span>Jalan Poros Utama</span>
                  </div>
                  <div class="feature-item">
                    <i class="bi bi-graph-up"></i>
                    <span>Investasi Menguntungkan</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Call to Action -->
        <div class="text-center" data-aos="fade-up">
          <p class="mb-4">Tidak menemukan properti yang Anda cari?</p>
          <div class="d-flex justify-content-center gap-3">
            <a href="contact.html" class="btn btn-primary">Hubungi Kami</a>
            <a href="#" class="btn btn-outline-primary">Konsultasi Gratis</a>
          </div>
        </div>

      </div>
    </section>

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">NNGProperty</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Urip Sumoharjo No. 123</p>
            <p>Makassar, Sulawesi Selatan 90231</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62 411 123 4567</span></p>
            <p><strong>Email:</strong> <span>info@nngproperty.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-whatsapp"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Menu Utama</h4>
          <ul>
            <li><a href="index.html">Beranda</a></li>
            <li><a href="about.html">Tentang Kami</a></li>
            <li><a href="properties.html">Cari Properti</a></li>
            <li><a href="agents.html">Agen Kami</a></li>
            <li><a href="contact.html">Hubungi Kami</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Layanan</h4>
          <ul>
            <li><a href="#">Jual Properti</a></li>
            <li><a href="#">Beli Properti</a></li>
            <li><a href="#">Sewa Properti</a></li>
            <li><a href="#">Konsultasi</a></li>
            <li><a href="#">Investasi</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Lokasi</h4>
          <ul>
            <li><a href="#">Makassar</a></li>
            <li><a href="#">Gowa</a></li>
            <li><a href="#">Maros</a></li>
            <li><a href="#">Takalar</a></li>
            <li><a href="#">Pangkep</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Bantuan</h4>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Syarat & Ketentuan</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Panduan</a></li>
            <li><a href="#">Dukungan Teknis</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">NNGProperty</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="#">NNGProperty Team</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>
</html>

              