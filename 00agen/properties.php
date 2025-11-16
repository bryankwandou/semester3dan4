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

      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="sitename">NNG<span>Property</span></h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Beranda</a></li>
          <li><a href="about.php">Tentang Kami</a></li>
          <li><a href="properties.php" class="active">Cari Properti</a></li>
          <li><a href="agents.php">Agen Kami</a></li>
          <li><a href="contact.php">Hubungi Kami</a></li>
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
                    <li><a href="index.php">Home</a></li>
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
                        <select class="form-select" id="locationFilter">
                            <option value="">Semua Lokasi</option>
                            <option value="Makassar Pusat">Makassar Pusat</option>
                            <option value="Panakkukang">Panakkukang</option>
                            <option value="Tamalate">Tamalate</option>
                            <option value="Rappocini">Rappocini</option>
                            <option value="Manggala">Manggala</option>
                            <option value="Gowa">Gowa</option>
                            <option value="Maros">Maros</option>
                            <option value="Takalar">Takalar</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tipe</label>
                        <select class="form-select" id="typeFilter">
                            <option value="">Semua Tipe</option>
                            <option value="Dijual">Dijual</option>
                            <option value="Disewa">Disewa</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Harga Min</label>
                        <input type="number" class="form-control" id="minPrice" placeholder="Rp 0">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Harga Max</label>
                        <input type="number" class="form-control" id="maxPrice" placeholder="Rp 5M">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Kamar Tidur</label>
                        <select class="form-select" id="bedroomFilter">
                            <option value="">Semua</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary w-100" onclick="filterProperties()">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Properti Terbaik - NNGProperty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .filter-section {
            background: var(--light-bg);
            padding: 2rem 0;
            margin-bottom: 3rem;
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .form-select, .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
        }

        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .property-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .property-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .property-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .price-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .location-badge {
            display: inline-block;
            background: var(--light-bg);
            color: var(--secondary-color);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .sale-rent {
            font-size: 0.9rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .property-features {
            margin-top: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .feature-item i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: var(--secondary-color);
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: var(--secondary-color);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .property-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .filter-card {
                padding: 1rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    

    <!-- Properties Section -->
    <section class="real-estate section">
        <div class="container">
            <!-- Section Title -->
            <div class="section-title">
                <h2>Properti Terbaik</h2>
                <p>Temukan properti impian Anda dengan mudah dan cepat</p>
            </div>

            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Mencari properti...</p>
            </div>

            <!-- Property Grid -->
            <div class="property-grid" id="propertyGrid">
                <!-- Properties will be loaded here -->
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="no-results" style="display: none;">
                <i class="bi bi-search" style="font-size: 3rem; color: #dee2e6;"></i>
                <h4>Tidak ada properti yang ditemukan</h4>
                <p>Silakan coba ubah kriteria pencarian Anda</p>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Property data
        const properties = [
            {
                id: 1,
                title: "Rumah Mewah Panakkukang Mas",
                location: "Panakkukang",
                type: "Dijual",
                price: 3200000000,
                bedrooms: 5,
                address: "Jl. Boulevard Panakkukang, Makassar",
                image: "https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 500m²", "Luas Bangunan: 350m²", "5 Kamar Tidur, 4 Kamar Mandi", "Garasi 2 Mobil"]
            },
            {
                id: 2,
                title: "Villa Modern Samata",
                location: "Gowa",
                type: "Dijual",
                price: 2800000000,
                bedrooms: 4,
                address: "Jl. Hertasning, Samata, Gowa",
                image: "https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 400m²", "Luas Bangunan: 280m²", "4 Kamar Tidur, 3 Kamar Mandi", "Kolam Renang Pribadi"]
            },
            {
                id: 3,
                title: "Townhouse Exclusive BTP",
                location: "Tamalate",
                type: "Dijual",
                price: 1800000000,
                bedrooms: 3,
                address: "Jl. BTP Raya, Tamalate, Makassar",
                image: "https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 200m²", "Luas Bangunan: 180m²", "3 Kamar Tidur, 3 Kamar Mandi", "Security 24 Jam"]
            },
            {
                id: 4,
                title: "Rumah Cluster Antang Raya",
                location: "Manggala",
                type: "Dijual",
                price: 850000000,
                bedrooms: 3,
                address: "Perumahan Green Garden, Antang",
                image: "https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 150m²", "Luas Bangunan: 120m²", "3 Kamar Tidur, 2 Kamar Mandi", "Taman & Carport"]
            },
            {
                id: 5,
                title: "Rumah Minimalis Rappocini",
                location: "Rappocini",
                type: "Dijual",
                price: 1200000000,
                bedrooms: 3,
                address: "Jl. Rappocini Raya, Makassar",
                image: "https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 180m²", "Luas Bangunan: 140m²", "3 Kamar Tidur, 2 Kamar Mandi", "Dekat Mall & Sekolah"]
            },
            {
                id: 6,
                title: "Rumah Keluarga Maros Baru",
                location: "Maros",
                type: "Dijual",
                price: 650000000,
                bedrooms: 3,
                address: "Perumahan Maros Indah, Maros",
                image: "https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 200m²", "Luas Bangunan: 110m²", "3 Kamar Tidur, 2 Kamar Mandi", "Harga Terjangkau"]
            },
            {
                id: 7,
                title: "Apartemen Mewah Sudirman",
                location: "Makassar Pusat",
                type: "Disewa",
                price: 15000000,
                bedrooms: 2,
                address: "Jl. Jenderal Sudirman, Makassar",
                image: "https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=400&h=250&fit=crop&auto=format",
                features: ["Luas: 80m²", "Fully Furnished", "2 Kamar Tidur, 1 Kamar Mandi", "Lantai 15, View Kota"]
            },
            {
                id: 8,
                title: "Rumah Modern Takalar",
                location: "Takalar",
                type: "Dijual",
                price: 750000000,
                bedrooms: 3,
                address: "Perumahan Takalar Residence",
                image: "https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 160m²", "Luas Bangunan: 100m²", "3 Kamar Tidur, 2 Kamar Mandi", "Dekat Pantai"]
            },
            {
                id: 9,
                title: "Rumah Sewa Panakkukang",
                location: "Panakkukang",
                type: "Disewa",
                price: 8000000,
                bedrooms: 2,
                address: "Jl. Panakkukang Mas Raya",
                image: "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 120m²", "Luas Bangunan: 90m²", "2 Kamar Tidur, 1 Kamar Mandi", "Carport 1 Mobil"]
            },
            {
                id: 10,
                title: "Rumah Strategis Gowa",
                location: "Gowa",
                type: "Dijual",
                price: 950000000,
                bedrooms: 3,
                address: "Jl. Malino, Gowa Regency",
                image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=400&h=250&fit=crop&auto=format",
                features: ["Luas Tanah: 140m²", "Luas Bangunan: 110m²", "3 Kamar Tidur, 2 Kamar Mandi", "Akses Jalan Utama"]
            }
        ];

        // Format price function
        function formatPrice(price, type) {
            const suffix = type === 'Disewa' ? '/bln' : '';
            
            if (price >= 1000000000) {
                return `Rp ${(price / 1000000000).toFixed(1)}M${suffix}`;
            } else if (price >= 1000000) {
                return `Rp ${Math.round(price / 1000000)}Jt${suffix}`;
            } else {
                return `Rp ${price.toLocaleString('id-ID')}${suffix}`;
            }
        }

        // Create property card
        function createPropertyCard(property) {
            const typeColor = property.type === 'Dijual' ? '#28a745' : '#ffc107';
            
            return `
                <div class="property-card" data-aos="fade-up">
                    <div class="position-relative">
                        <img src="${property.image}" alt="${property.title}" class="property-image">
                        <div class="price-tag">${formatPrice(property.price, property.type)}</div>
                    </div>
                    <div class="card-body p-3">
                        <div class="location-badge">${property.location}</div>
                        <span class="sale-rent" style="color: ${typeColor}; font-weight: bold;">${property.type}</span>
                        <h5 class="mt-2 mb-1">
                            <a href="#" class="text-decoration-none">${property.title}</a>
                        </h5>
                        <p class="text-muted small mb-3">${property.address}</p>
                        <div class="property-features">
                            ${property.features.map(feature => `
                                <div class="feature-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>${feature}</span>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        }

        // Filter properties
        function filterProperties() {
            const locationFilter = document.getElementById('locationFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const minPrice = parseInt(document.getElementById('minPrice').value) || 0;
            const maxPrice = parseInt(document.getElementById('maxPrice').value) || Infinity;
            const bedroomFilter = parseInt(document.getElementById('bedroomFilter').value) || 0;

            // Show loading spinner
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('propertyGrid').style.display = 'none';
            document.getElementById('noResults').style.display = 'none';

            // Simulate loading delay (remove in production)
            setTimeout(() => {
                const filteredProperties = properties.filter(property => {
                    const matchesLocation = !locationFilter || property.location === locationFilter;
                    const matchesType = !typeFilter || property.type === typeFilter;
                    const matchesMinPrice = property.price >= minPrice;
                    const matchesMaxPrice = property.price <= maxPrice;
                    const matchesBedrooms = bedroomFilter === 0 || property.bedrooms >= bedroomFilter;

                    return matchesLocation && matchesType && matchesMinPrice && matchesMaxPrice && matchesBedrooms;
                });

                renderProperties(filteredProperties);
                
                // Hide loading spinner
                document.getElementById('loadingSpinner').style.display = 'none';
                document.getElementById('propertyGrid').style.display = 'grid';
            }, 500);
        }

        // Render properties
        function renderProperties(propertiesToRender) {
            const propertyGrid = document.getElementById('propertyGrid');
            const noResults = document.getElementById('noResults');

            if (propertiesToRender.length === 0) {
                propertyGrid.innerHTML = '';
                noResults.style.display = 'block';
                return;
            }

            noResults.style.display = 'none';
            propertyGrid.innerHTML = propertiesToRender.map(property => createPropertyCard(property)).join('');
            
            // Refresh AOS
            AOS.refresh();
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Load all properties initially
            renderProperties(properties);
            
            // Add event listeners for real-time filtering
            document.getElementById('locationFilter').addEventListener('change', filterProperties);
            document.getElementById('typeFilter').addEventListener('change', filterProperties);
            document.getElementById('bedroomFilter').addEventListener('change', filterProperties);
            
            // Add debounced event listeners for price inputs
            let priceTimeout;
            document.getElementById('minPrice').addEventListener('input', function() {
                clearTimeout(priceTimeout);
                priceTimeout = setTimeout(filterProperties, 300);
            });
            
            document.getElementById('maxPrice').addEventListener('input', function() {
                clearTimeout(priceTimeout);
                priceTimeout = setTimeout(filterProperties, 300);
            });
        });
    </script>
</body>
</html>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="logo d-flex align-items-center">
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
            <li><a href="index.php">Beranda</a></li>
            <li><a href="about.php">Tentang Kami</a></li>
            <li><a href="properties.php">Cari Properti</a></li>
            <li><a href="agents.php">Agen Kami</a></li>
            <li><a href="contact.php">Hubungi Kami</a></li>
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

              