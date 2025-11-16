<!-- /*
* Template Name: Property
* Template Author: Untree.co
* Template URI: https://untree.co/
* License: https://creativecommons.org/licenses/by/3.0/
*/ -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Untree.co" />
    <link rel="shortcut icon" href="E:\bootstrap html project\EstateAgency\Property\nngp.ico"/>

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap5" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="fonts/icomoon/style.css" />
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css" />

    <link rel="stylesheet" href="css/tiny-slider.css" />
    <link rel="stylesheet" href="css/aos.css" />
    <link rel="stylesheet" href="css/style.css" />

    <title>
      Hubungi Kami &mdash; NNGProperty
    </title>
  </head>
  <body>
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close">
          <span class="icofont-close js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>

    <nav class="site-nav">
      <div class="container">
        <div class="menu-bg-wrap">
          <div class="site-navigation">
            <a href="index.php" class="logo m-0 float-start">Property</a>

            <ul
              class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end"
            >
              <li><a href="index.php">Home</a></li>
              <li class="has-children">
                <a href="properties.php">Properties</a>
                <ul class="dropdown">
                  <li><a href="#">Beli Properti</a></li>
                      <li><a href="#">Sewa Properti</a></li>
                      <li><a href="#">Ajukan KPR Rumah</a></li>
            
                  </li>
                </ul>
              </li>
              <li><a href="services.php">Layanan Kami</a></li>
              <li><a href="about.php">Tentang Kami</a></li>
              <li class="active"><a href="contact.php">Hubungi Kami Sekarang</a></li>
            </ul>

            <a
              href="#"
              class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
              data-toggle="collapse"
              data-target="#main-navbar"
            >
              <span></span>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <div
      class="hero page-inner overlay"
      style="background-image: url('images/hero_bg_1.jpg')"
    >
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-9 text-center mt-5">
            <h1 class="heading" data-aos="fade-up">Contact Us</h1>

            <nav
              aria-label="breadcrumb"
              data-aos="fade-up"
              data-aos-delay="200"
            >
              <ol class="breadcrumb text-center justify-content-center">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li
                  class="breadcrumb-item active text-white-50"
                  aria-current="page"
                >
                  Contact
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>








    


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Location</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --dark-color: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }

        .map-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .map-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
        }

        .map-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 2.5rem;
        }

        .map-header p {
            opacity: 0.9;
            font-size: 1.1rem;
            margin: 0;
        }

        #map {
            height: 500px;
            width: 100%;
        }

        .controls-section {
            padding: 30px;
            background: #f8f9fa;
        }

        .control-group {
            margin-bottom: 25px;
        }

        .control-group h5 {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-group .btn {
            padding: 12px 20px;
            font-weight: 500;
            border-radius: 10px;
            margin: 0 5px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .btn-view {
            background: #e9ecef;
            color: var(--dark-color);
            border-color: #e9ecef;
        }

        .btn-view:hover, .btn-view.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-transport {
            background: #e9ecef;
            color: var(--dark-color);
            border-color: #e9ecef;
        }

        .btn-transport:hover, .btn-transport.active {
            background: var(--success-color);
            color: white;
            border-color: var(--success-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .action-buttons .btn {
            padding: 15px 25px;
            font-weight: 600;
            border-radius: 12px;
            margin: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.4);
        }

        .status-indicator {
            padding: 15px 20px;
            border-radius: 12px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-loading {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c2c7;
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #856404;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .route-info {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            display: none;
        }

        .route-info.show {
            display: block;
            animation: slideInUp 0.5s ease;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .route-info h5 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .route-details p {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .route-details strong {
            color: var(--dark-color);
        }

        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .info-card h4 {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .info-card p {
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .contact-info {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.1);
            padding: 10px 15px;
            border-radius: 25px;
            backdrop-filter: blur(10px);
        }

        @media (max-width: 768px) {
            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .btn-group .btn {
                flex: 1;
                min-width: 120px;
                margin: 2px;
            }
            
            .action-buttons {
                text-align: center;
            }
            
            .action-buttons .btn {
                width: 100%;
                margin: 5px 0;
            }
            
            .map-header h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Info Card -->
        <div class="info-card" data-aos="fade-up">
            <h4><i class="fas fa-building"></i> Pusat Konferensi Downtown</h4>
            <p><i class="fas fa-map-marker-alt"></i> 123 Conference St, Jakarta Pusat 10013</p>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+62 21 1234-5678</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@conference.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                    <span>www.conference.com</span>
                </div>
            </div>
        </div>

        <!-- Map Container -->
        <div class="map-container" data-aos="fade-up" data-aos-delay="100">
            <div class="map-header">
                <h2><i class="fas fa-map-marked-alt"></i> Lokasi Kami</h2>
                <p>Temukan rute terbaik menuju lokasi acara Anda</p>
            </div>

            <!-- Status Indicator -->
            <div class="controls-section">
                <div id="statusIndicator" class="status-indicator status-success">
                    <i class="fas fa-check-circle"></i>
                    Peta siap digunakan
                </div>

                <!-- Map View Controls -->
                <div class="control-group">
                    <h5><i class="fas fa-eye"></i> Tampilan Peta</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-view active" id="roadmapBtn" onclick="changeMapType('roadmap')">
                            <i class="fas fa-road"></i> Jalan
                        </button>
                        <button type="button" class="btn btn-view" id="satelliteBtn" onclick="changeMapType('satellite')">
                            <i class="fas fa-satellite"></i> Satelit
                        </button>
                        <button type="button" class="btn btn-view" id="hybridBtn" onclick="changeMapType('hybrid')">
                            <i class="fas fa-layer-group"></i> Hibrida
                        </button>
                        <button type="button" class="btn btn-view" id="terrainBtn" onclick="changeMapType('terrain')">
                            <i class="fas fa-mountain"></i> Terrain
                        </button>
                    </div>
                </div>

                <!-- Transport Mode Controls -->
                <div class="control-group">
                    <h5><i class="fas fa-route"></i> Mode Transportasi</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-transport active" id="drivingBtn" onclick="changeTransportMode('DRIVING')">
                            <i class="fas fa-car"></i> Mobil
                        </button>
                        <button type="button" class="btn btn-transport" id="motorcycleBtn" onclick="changeTransportMode('TWO_WHEELER')">
                            <i class="fas fa-motorcycle"></i> Motor
                        </button>
                        <button type="button" class="btn btn-transport" id="walkingBtn" onclick="changeTransportMode('WALKING')">
                            <i class="fas fa-walking"></i> Jalan
                        </button>
                        <button type="button" class="btn btn-transport" id="transitBtn" onclick="changeTransportMode('TRANSIT')">
                            <i class="fas fa-bus"></i> Transit
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons text-center">
                    <button class="btn btn-primary btn-lg" onclick="getCurrentLocation()">
                        <i class="fas fa-location-arrow"></i> Dapatkan Lokasi Saya
                    </button>
                    <button class="btn btn-success btn-lg" onclick="getDirections()">
                        <i class="fas fa-directions"></i> Petunjuk Arah
                    </button>
                    <button class="btn btn-danger btn-lg" onclick="clearRoute()">
                        <i class="fas fa-times"></i> Bersihkan Rute
                    </button>
                </div>
            </div>

            <!-- Google Maps -->
            <div id="map"></div>

            <!-- Route Information -->
            <div id="routeInfo" class="route-info">
                <h5><i class="fas fa-info-circle"></i> Informasi Rute</h5>
                <div id="routeDetails" class="route-details"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Global variables
        let map;
        let directionsService;
        let directionsRenderer;
        let currentMapType = 'roadmap';
        let currentTransportMode = 'DRIVING';
        let userLocation = null;
        
        // Destination coordinates (Jakarta - Monas area as example)
        const destination = {
            lat: -6.1751,
            lng: 106.8650
        };

        // Initialize Google Maps
        function initMap() {
            // Create map
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: destination,
                mapTypeId: currentMapType,
                styles: [
                    {
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{ visibility: "on" }]
                    }
                ],
                mapTypeControl: false,
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true
            });

            // Initialize directions service and renderer
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                draggable: true,
                panel: document.getElementById('routeDetails')
            });
            directionsRenderer.setMap(map);

            // Add destination marker
            const destinationMarker = new google.maps.Marker({
                position: destination,
                map: map,
                title: 'Pusat Konferensi Downtown',
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#667eea" stroke="white" stroke-width="3"/>
                            <text x="20" y="26" text-anchor="middle" fill="white" font-size="16" font-weight="bold">📍</text>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(40, 40)
                },
                animation: google.maps.Animation.BOUNCE
            });

            // Add info window to destination marker
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="padding: 15px; max-width: 300px; font-family: 'Segoe UI', sans-serif;">
                        <h6 style="margin: 0 0 15px 0; color: #333; font-weight: 700;">
                            <i class="fas fa-building" style="color: #667eea;"></i>
                            Pusat Konferensi Downtown
                        </h6>
                        <p style="margin: 8px 0; color: #666; font-size: 14px;">
                            <i class="fas fa-map-marker-alt" style="color: #dc3545; width: 15px;"></i>
                            123 Conference St, Jakarta Pusat 10013
                        </p>
                        <p style="margin: 8px 0; color: #666; font-size: 14px;">
                            <i class="fas fa-phone" style="color: #28a745; width: 15px;"></i>
                            +62 21 1234-5678
                        </p>
                        <p style="margin: 8px 0; color: #666; font-size: 14px;">
                            <i class="fas fa-envelope" style="color: #ffc107; width: 15px;"></i>
                            info@conference.com
                        </p>
                        <div style="margin-top: 15px; text-align: center;">
                            <button onclick="getDirections()" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; padding: 8px 16px; border-radius: 8px; font-size: 13px; cursor: pointer;">
                                <i class="fas fa-directions"></i> Petunjuk Arah
                            </button>
                        </div>
                    </div>
                `
            });

            destinationMarker.addListener('click', () => {
                infoWindow.open(map, destinationMarker);
            });

            updateStatus('Peta siap digunakan', 'success');
        }

        // Change map type
        function changeMapType(type) {
            currentMapType = type;
            map.setMapTypeId(type);
            
            // Update active button
            document.querySelectorAll('.btn-view').forEach(btn => btn.classList.remove('active'));
            document.getElementById(type + 'Btn').classList.add('active');
            
            const typeNames = {
                'roadmap': 'Jalan',
                'satellite': 'Satelit',
                'hybrid': 'Hibrida',
                'terrain': 'Terrain'
            };
            
            updateStatus(`Beralih ke tampilan ${typeNames[type]}`, 'success');
        }

        // Change transport mode
        function changeTransportMode(mode) {
            currentTransportMode = mode;
            
            // Update active button
            document.querySelectorAll('.btn-transport').forEach(btn => btn.classList.remove('active'));
            
            const buttonMap = {
                'DRIVING': 'drivingBtn',
                'TWO_WHEELER': 'motorcycleBtn', 
                'WALKING': 'walkingBtn',
                'TRANSIT': 'transitBtn'
            };
            
            document.getElementById(buttonMap[mode]).classList.add('active');
            
            // If route is already shown, recalculate with new mode
            if (userLocation) {
                calculateAndDisplayRoute(userLocation, destination);
            }
            
            const modeNames = {
                'DRIVING': 'Mobil',
                'TWO_WHEELER': 'Motor',
                'WALKING': 'Jalan Kaki',
                'TRANSIT': 'Transportasi Umum'
            };
            
            updateStatus(`Mode transportasi: ${modeNames[mode]}`, 'success');
        }

        // Get current user location
        function getCurrentLocation() {
            updateStatus('Mendapatkan lokasi Anda...', 'loading');
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        
                        // Add user location marker
                        if (window.userMarker) {
                            window.userMarker.setMap(null);
                        }
                        
                        window.userMarker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: 'Lokasi Anda',
                            icon: {
                                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                    <svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="15" cy="15" r="12" fill="#28a745" stroke="white" stroke-width="3"/>
                                        <circle cx="15" cy="15" r="4" fill="white"/>
                                    </svg>
                                `),
                                scaledSize: new google.maps.Size(30, 30)
                            }
                        });
                        
                        // Center map to show both locations
                        const bounds = new google.maps.LatLngBounds();
                        bounds.extend(userLocation);
                        bounds.extend(destination);
                        map.fitBounds(bounds);
                        
                        updateStatus('Lokasi ditemukan!', 'success');
                    },
                    (error) => {
                        let errorMessage = 'Tidak dapat mendapatkan lokasi: ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Izin ditolak';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Posisi tidak tersedia';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Permintaan timeout';
                                break;
                        }
                        updateStatus(errorMessage, 'error');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 600000
                    }
                );
            } else {
                updateStatus('Geolocation tidak didukung', 'error');
            }
        }

        // Get directions
        function getDirections() {
            if (!userLocation) {
                getCurrentLocation();
                setTimeout(() => {
                    if (userLocation) {
                        calculateAndDisplayRoute(userLocation, destination);
                    }
                }, 2000);
            } else {
                calculateAndDisplayRoute(userLocation, destination);
            }
        }

        // Calculate and display route
        function calculateAndDisplayRoute(origin, destination) {
            updateStatus('Menghitung rute...', 'loading');
            
            const request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode[currentTransportMode],
                avoidHighways: false,
                avoidTolls: false,
                optimizeWaypoints: true
            };

            directionsService.route(request, (result, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(result);
                    
                    // Show route information
                    const route = result.routes[0];
                    const leg = route.legs[0];
                    
                    document.getElementById('routeInfo').classList.add('show');
                    document.getElementById('routeDetails').innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-route"></i> Jarak:</strong> ${leg.distance.text}</p>
                                <p><strong><i class="fas fa-clock"></i> Waktu:</strong> ${leg.duration.text}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-map-marker-alt"></i> Dari:</strong> ${leg.start_address}</p>
                                <p><strong><i class="fas fa-flag-checkered"></i> Ke:</strong> ${leg.end_address}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-center">
                            <button class="btn btn-primary btn-sm" onclick="openInGoogleMaps()">
                                <i class="fas fa-external-link-alt"></i>
                                Buka di Google Maps
                            </button>
                            <button class="btn btn-success btn-sm" onclick="shareRoute()">
                                <i class="fas fa-share"></i>
                                Bagikan Rute
                            </button>
                        </div>
                    `;
                    
                    updateStatus(`Rute dihitung: ${leg.distance.text}, ${leg.duration.text}`, 'success');
                } else {
                    updateStatus('Tidak dapat menghitung rute: ' + status, 'error');
                }
            });
        }

        // Clear route
        function clearRoute() {
            directionsRenderer.setDirections({routes: []});
            document.getElementById('routeInfo').classList.remove('show');
            
            // Remove user marker
            if (window.userMarker) {
                window.userMarker.setMap(null);
            }
            
            userLocation = null;
            
            // Reset map view
            map.setCenter(destination);
            map.setZoom(15);
            
            updateStatus('Rute dibersihkan', 'success');
        }

        // Open in Google Maps app
        function openInGoogleMaps() {
            if (userLocation) {
                const url = `https://www.google.com/maps/dir/${userLocation.lat},${userLocation.lng}/${destination.lat},${destination.lng}/@${destination.lat},${destination.lng},15z/data=!3m1!4b1!4m2!4m1!3e${getGoogleMapsTravelMode()}`;
                window.open(url, '_blank');
            } else {
                const url = `https://www.google.com/maps/search/?api=1&query=${destination.lat},${destination.lng}`;
                window.open(url, '_blank');
            }
        }

        // Get Google Maps travel mode code
        function getGoogleMapsTravelMode() {
            const modes = {
                'DRIVING': '0',
                'TWO_WHEELER': '0',
                'WALKING': '2',
                'TRANSIT': '3'
            };
            return modes[currentTransportMode] || '0';
        }

        // Share route
        function shareRoute() {
            if (navigator.share && userLocation) {
                navigator.share({
                    title: 'Rute ke Pusat Konferensi Downtown',
                    text: 'Lihat rute yang saya temukan!',
                    url: `https://www.google.com/maps/dir/${userLocation.lat},${userLocation.lng}/${destination.lat},${destination.lng}`
                });
            } else {
                // Fallback to copying to clipboard
                const url = userLocation ? 
                    `https://www.google.com/maps/dir/${userLocation.lat},${userLocation.lng}/${destination.lat},${destination.lng}` :
                    `https://www.google.com/maps/search/?api=1&query=${destination.lat},${destination.lng}`;
                
                navigator.clipboard.writeText(url).then(() => {
                    updateStatus('Link rute disalin ke clipboard!', 'success');
                }).catch(() => {
                    updateStatus('Tidak dapat menyalin link rute', 'error');
                });
            }
        }

        // Update status indicator
        function updateStatus(message, type) {
            const indicator = document.getElementById('statusIndicator');
            const icons = {
                'loading': '<div class="loading-spinner"></div>',
                'success': '<i class="fas fa-check-circle"></i>',
                'error': '<i class="fas fa-exclamation-triangle"></i>'
            };
            
            indicator.className = `status-indicator status-${type}`;
            indicator.innerHTML = `${icons[type]} ${message}`;
            
            // Auto-hide after 5 seconds for non-loading states
            if (type !== 'loading') {
                setTimeout(() => {
                    if (indicator.classList.contains(`status-${type}`)) {
                        indicator.className = 'status-indicator status-success';
                        indicator.innerHTML = '<i class="fas fa-check-circle"></i> Peta siap digunakan';
                    }
                }, 5000);
            }
        }
    </script>
    
    <!-- Google Maps API - Replace YOUR_API_KEY with your actual API key -->
    <script async defer 
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap&libraries=geometry">
    </script>
</body>
</html>






























  




















    <style>
        .form-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }
        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 20px 0;
        }
        .section-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 30px 0 20px 0;
            font-weight: 600;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .table-section {
            background: #f8f9fa;
            padding: 60px 0;
        }
        .nav-tabs .nav-link.active {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
        }
        .nav-tabs .nav-link {
            border: 2px solid #dee2e6;
            margin-right: 5px;
            border-radius: 10px 10px 0 0;
        }
        .required {
            color: #dc3545;
        }
        .file-upload-area {
            border: 2px dashed #667eea;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload-area:hover {
            background: #f8f9ff;
            border-color: #5a67d8;
        }
        .upload-icon {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 15px;
        }
        .alert-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }
    </style>
</head>

<body>
    <div class="form-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-container" data-aos="fade-up">
                        <div class="text-center mb-4">
                            <h1 class="display-4 text-primary">🏠 Sistem Formulir Properti</h1>
                            <p class="lead text-muted">Formulir Lengkap Transaksi Jual Beli Properti</p>
                        </div>

                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs mb-4" id="propertyTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="seller-tab" data-bs-toggle="tab" data-bs-target="#seller" type="button">
                                    📋 Formulir Penjual
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="buyer-tab" data-bs-toggle="tab" data-bs-target="#buyer" type="button">
                                    🏡 Formulir Pembeli
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="property-tab" data-bs-toggle="tab" data-bs-target="#property" type="button">
                                    📊 Data Properti
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="propertyTabContent">
                            <!-- Seller Form -->
                            <div class="tab-pane fade show active" id="seller" role="tabpanel">
                                <form id="sellerForm" onsubmit="handleSubmit(event, 'seller')">
                                    <div class="section-header">
                                        <i class="fas fa-user-tie me-2"></i>📄 2. Identitas Pihak yang Terlibat - A. Data Penjual Properti
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                            <input type="text" name="seller_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor KTP <span class="required">*</span></label>
                                            <input type="text" name="seller_ktp" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alamat Tinggal Sesuai KTP <span class="required">*</span></label>
                                            <textarea name="seller_address_ktp" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alamat Domisili Saat Ini</label>
                                            <textarea name="seller_current_address" class="form-control" rows="2"></textarea>
                                            <small class="text-muted">Kosongkan jika sama dengan alamat KTP</small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                                            <input type="tel" name="seller_phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email <span class="required">*</span></label>
                                            <input type="email" name="seller_email" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Status Kepemilikan Properti <span class="required">*</span></label>
                                            <select name="seller_ownership_status" class="form-control" required>
                                                <option value="">Pilih Status Kepemilikan</option>
                                                <option value="pribadi">Pribadi</option>
                                                <option value="warisan">Warisan</option>
                                                <option value="hibah">Hibah</option>
                                                <option value="surat_kuasa">Surat Kuasa Jual</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-money-bill-wave me-2"></i>💰 4. Detail Transaksi - A. Harga Penawaran
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga Total (Rp) <span class="required">*</span></label>
                                            <input type="number" name="seller_price" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Bisa Nego?</label>
                                            <select name="seller_negotiable" class="form-control">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Sudah Termasuk Pajak & Biaya Notaris?</label>
                                            <select name="seller_include_tax" class="form-control">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-question-circle me-2"></i>📑 5. Pertanyaan Teknis dan Legalitas - A. Kepada Penjual
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apakah properti bebas sengketa hukum?</label>
                                            <select name="seller_dispute_free" class="form-control">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apakah sedang dijaminkan ke bank?</label>
                                            <select name="seller_bank_collateral" class="form-control">
                                                <option value="tidak">Tidak</option>
                                                <option value="ya">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apakah ada ahli waris yang belum menyetujui?</label>
                                            <select name="seller_heir_approval" class="form-control">
                                                <option value="tidak">Tidak Ada</option>
                                                <option value="ada">Ada</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apakah bangunan memiliki IMB resmi?</label>
                                            <select name="seller_has_imb" class="form-control">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Simpan Data Penjual
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Buyer Form -->
                            <div class="tab-pane fade" id="buyer" role="tabpanel">
                                <form id="buyerForm" onsubmit="handleSubmit(event, 'buyer')">
                                    <div class="section-header">
                                        <i class="fas fa-user me-2"></i>📄 2. Identitas Pihak yang Terlibat - B. Data Pembeli Properti
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                                            <input type="text" name="buyer_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor KTP <span class="required">*</span></label>
                                            <input type="text" name="buyer_ktp" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alamat Sesuai KTP <span class="required">*</span></label>
                                            <textarea name="buyer_address_ktp" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alamat Domisili Saat Ini</label>
                                            <textarea name="buyer_current_address" class="form-control" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Pekerjaan <span class="required">*</span></label>
                                            <input type="text" name="buyer_job" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nama Perusahaan</label>
                                            <input type="text" name="buyer_company" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor Telepon <span class="required">*</span></label>
                                            <input type="tel" name="buyer_phone" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email <span class="required">*</span></label>
                                            <input type="email" name="buyer_email" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Status Pernikahan <span class="required">*</span></label>
                                            <select name="buyer_marital_status" class="form-control" required>
                                                <option value="">Pilih Status</option>
                                                <option value="belum_menikah">Belum Menikah</option>
                                                <option value="menikah">Menikah</option>
                                                <option value="cerai">Cerai</option>
                                                <option value="duda_janda">Duda/Janda</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-calculator me-2"></i>💰 4. Detail Transaksi - B. Harga Pengajuan Pembelian
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Harga Yang Diajukan (Rp) <span class="required">*</span></label>
                                            <input type="number" name="buyer_offer_price" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Skema Pembayaran <span class="required">*</span></label>
                                            <select name="buyer_payment_scheme" class="form-control" required>
                                                <option value="">Pilih Skema</option>
                                                <option value="tunai_keras">Tunai Keras</option>
                                                <option value="bertahap">Bertahap</option>
                                                <option value="kpr">KPR</option>
                                                <option value="cicil_developer">Cicil Developer</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Uang Tanda Jadi (Rp)</label>
                                            <input type="number" name="buyer_down_payment" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Termin Pembayaran (Bulan)</label>
                                            <input type="number" name="buyer_payment_term" class="form-control">
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-clipboard-check me-2"></i>📑 5. Pertanyaan Teknis dan Legalitas - B. Kepada Pembeli
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apakah memiliki sumber dana yang jelas?</label>
                                            <select name="buyer_clear_funds" class="form-control">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Apakah siap membayar uang tanda jadi?</label>
                                            <select name="buyer_ready_down_payment" class="form-control">
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Jika KPR: Bank Mana?</label>
                                            <input type="text" name="buyer_kpr_bank" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Proses KPR Sampai Tahap?</label>
                                            <select name="buyer_kpr_stage" class="form-control">
                                                <option value="">Belum KPR</option>
                                                <option value="pengajuan">Pengajuan</option>
                                                <option value="proses">Proses</option>
                                                <option value="approved">Approved</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Simpan Data Pembeli
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Property Form -->
                            <div class="tab-pane fade" id="property" role="tabpanel">
                                <form id="propertyForm" onsubmit="handleSubmit(event, 'property')">
                                    <div class="section-header">
                                        <i class="fas fa-home me-2"></i>🏡 3. Data Properti
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Alamat Lengkap Properti <span class="required">*</span></label>
                                            <textarea name="property_address" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Luas Tanah (m²) <span class="required">*</span></label>
                                            <input type="number" name="property_land_area" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Luas Bangunan (m²) <span class="required">*</span></label>
                                            <input type="number" name="property_building_area" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Sertifikat Tanah <span class="required">*</span></label>
                                            <select name="property_certificate_type" class="form-control" required>
                                                <option value="">Pilih Jenis Sertifikat</option>
                                                <option value="shm">SHM (Sertifikat Hak Milik)</option>
                                                <option value="hgb">HGB (Hak Guna Bangunan)</option>
                                                <option value="girik">Girik</option>
                                                <option value="petok_d">Petok D</option>
                                                <option value="ajb">AJB (Akta Jual Beli)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nomor Sertifikat <span class="required">*</span></label>
                                            <input type="text" name="property_certificate_number" class="form-control" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Atas Nama Siapa di Sertifikat <span class="required">*</span></label>
                                            <input type="text" name="property_certificate_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">IMB - Nomor</label>
                                            <input type="text" name="property_imb_number" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">IMB - Tahun</label>
                                            <input type="number" name="property_imb_year" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PBB Status</label>
                                            <select name="property_pbb_status" class="form-control">
                                                <option value="lunas">Lunas</option>
                                                <option value="belum_lunas">Belum Lunas</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Kondisi Bangunan</label>
                                            <select name="property_condition" class="form-control">
                                                <option value="baru">Baru</option>
                                                <option value="renovasi">Renovasi</option>
                                                <option value="siap_huni">Siap Huni</option>
                                                <option value="rusak">Rusak</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Legalitas Pendukung Lain (SLF, SIPPT, dll)</label>
                                            <textarea name="property_other_legality" class="form-control" rows="2" placeholder="Sebutkan legalitas pendukung lainnya jika ada"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-upload me-2"></i>📄 6. Lampiran yang Wajib Disiapkan
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Upload Dokumen Properti</label>
                                            <div class="file-upload-area" onclick="document.getElementById('propertyFiles').click()">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <h5>Klik untuk Upload Dokumen</h5>
                                                <p class="text-muted">Sertifikat, IMB, PBB, Foto Properti (Max 10MB per file)</p>
                                                <input type="file" id="propertyFiles" name="property_files" multiple accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                            </div>
                                            <div id="fileList" class="mt-3"></div>
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-sticky-note me-2"></i>📌 8. Catatan Tambahan
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Catatan Khusus</label>
                                            <textarea name="property_notes" class="form-control" rows="4" placeholder="Tambahkan catatan khusus seperti properti warisan, dalam sengketa, cicilan developer, rencana renovasi, dll"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-header">
                                        <i class="fas fa-signature me-2"></i>🖊️ 7. Pernyataan & Tanda Tangan
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="property_data_truth" id="dataTruth" required>
                                                <label class="form-check-label" for="dataTruth">
                                                    Saya menyatakan bahwa semua data yang diisi adalah benar dan dapat dipertanggungjawabkan secara hukum
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="property_transaction_ready" id="transactionReady" required>
                                                <label class="form-check-label" for="transactionReady">
                                                    Saya menyatakan kesanggupan untuk melakukan transaksi sesuai dengan ketentuan yang berlaku
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-save me-2"></i>Simpan Data Properti
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Management Section -->
    <div class="table-section">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h2 class="text-center mb-5">📊 Data Management Properti</h2>
                    
                    <!-- Filter Controls -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <input type="text" id="searchInput" class="form-control" placeholder="🔍 Cari berdasarkan nama, email, atau alamat...">
                        </div>
                        <div class="col-md-4">
                            <select id="filterType" class="form-control">
                                <option value="">Semua Data</option>
                                <option value="seller">Data Penjual</option>
                                <option value="buyer">Data Pembeli</option>
                                <option value="property">Data Properti</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success me-2" onclick="exportToCSV()">
                                <i class="fas fa-download"></i> Export CSV
                            </button>
                            <button class="btn btn-info me-2" onclick="exportToMySQL()">
                                <i class="fas fa-database"></i> Export MySQL
                            </button>
                            <button class="btn btn-danger" onclick="clearAllData()">
                                <i class="fas fa-trash"></i> Clear All
                            </button>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tipe</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBody">
                                <!-- Data akan dimuncul di sini -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">📋 Total Penjual</h5>
                                    <h3 id="totalSellers">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">🏡 Total Pembeli</h5>
                                    <h3 id="totalBuyers">0</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">🏠 Total Properti</h5>
                                    <h3 id="totalProperties">0</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    <div id="successAlert" class="alert alert-success alert-floating" style="display: none;">
        <i class="fas fa-check-circle me-2"></i>
        <span id="alertMessage">Data berhasil disimpan!</span>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init();

        // Data storage
        let propertyData = {
            sellers: JSON.parse(localStorage.getItem('sellers') || '[]'),
            buyers: JSON.parse(localStorage.getItem('buyers') || '[]'),
            properties: JSON.parse(localStorage.getItem('properties') || '[]')
        };

        // Form submission handler
        function handleSubmit(event, type) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const data = {};
            
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }
            
            data.id = Date.now();
            data.timestamp = new Date().toISOString();
            
            propertyData[type + 's'].push(data);
            localStorage.setItem(type + 's', JSON.stringify(propertyData[type + 's']));
            
            showAlert(`Data ${type === 'seller' ? 'penjual' : type === 'buyer' ? 'pembeli' : 'properti'} berhasil disimpan!`);
            form.reset();
            
            updateTable();
            updateStatistics();
        }

        // Show alert
        function showAlert(message) {
            const alert = document.getElementById('successAlert');
            document.getElementById('alertMessage').textContent = message;
            alert.style.display = 'block';
            
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }

        // Update table
        function updateTable() {
            const tbody = document.getElementById('dataTableBody');
            tbody.innerHTML = '';
            
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filterType = document.getElementById('filterType').value;
            
            let allData = [];
            
            if (!filterType || filterType === 'seller') {
                allData = allData.concat(propertyData.sellers.map(item => ({...item, type: 'seller'})));
            }
            if (!filterType || filterType === 'buyer') {
                allData = allData.concat(propertyData.buyers.map(item => ({...item, type: 'buyer'})));
            }
            if (!filterType || filterType === 'property') {
                allData = allData.concat(propertyData.properties.map(item => ({...item, type: 'property'})));
            }
            
            // Filter data
            if (searchTerm) {
                allData = allData.filter(item => {
                    const name = getName(item);
                    const email = getEmail(item);
                    const address = getAddress(item);
                    return name.toLowerCase().includes(searchTerm) ||
                           email.toLowerCase().includes(searchTerm) ||
                           address.toLowerCase().includes(searchTerm);
                });
            }
            
            // Sort by timestamp (newest first)
            allData.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
            
            allData.forEach(item => {
                const row = tbody.insertRow();
                row.innerHTML = `
                    <td>${item.id}</td>
                    <td><span class="badge bg-${getTypeBadge(item.type)}">${getTypeLabel(item.type)}</span></td>
                    <td>${getName(item)}</td>
                    <td>${getEmail(item)}</td>
                    <td>${getPhone(item)}</td>
                    <td>${formatDate(item.timestamp)}</td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="viewDetails(${item.id}, '${item.type}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteItem(${item.id}, '${item.type}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
            });
        }

        // Helper functions
        function getName(item) {
            return item.seller_name || item.buyer_name || item.property_certificate_name || '-';
        }

        function getEmail(item) {
            return item.seller_email || item.buyer_email || '-';
        }

        function getPhone(item) {
            return item.seller_phone || item.buyer_phone || '-';
        }

        function getAddress(item) {
            return item.seller_address_ktp || item.buyer_address_ktp || item.property_address || '-';
        }

        function getTypeBadge(type) {
            const badges = {
                'seller': 'primary',
                'buyer': 'success',
                'property': 'info'
            };
            return badges[type] || 'secondary';
        }

        function getTypeLabel(type) {
            const labels = {
                'seller': 'Penjual',
                'buyer': 'Pembeli',
                'property': 'Properti'
            };
            return labels[type] || type;
        }

        function formatDate(timestamp) {
            return new Date(timestamp).toLocaleDateString('id-ID');
        }

        // Update statistics
        function updateStatistics() {
            document.getElementById('totalSellers').textContent = propertyData.sellers.length;
            document.getElementById('totalBuyers').textContent = propertyData.buyers.length;
            document.getElementById('totalProperties').textContent = propertyData.properties.length;
        }

        // Delete item
        function deleteItem(id, type) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const arrayName = type + 's';
                propertyData[arrayName] = propertyData[arrayName].filter(item => item.id !== id);
                localStorage.setItem(arrayName, JSON.stringify(propertyData[arrayName]));
                
                showAlert('Data berhasil dihapus!');
                updateTable();
                updateStatistics();
            }
        }

        // View details
        function viewDetails(id, type) {
            const arrayName = type + 's';
            const item = propertyData[arrayName].find(item => item.id === id);
            
            if (item) {
                let details = `<h4>Detail ${getTypeLabel(type)}</h4><hr>`;
                
                Object.keys(item).forEach(key => {
                    if (key !== 'id' && key !== 'timestamp') {
                        const label = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        details += `<strong>${label}:</strong> ${item[key] || '-'}<br>`;
                    }
                });
                
                details += `<hr><small>Dibuat: ${formatDate(item.timestamp)}</small>`;
                
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.innerHTML = `
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">${details}</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(modal);
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
                
                modal.addEventListener('hidden.bs.modal', () => {
                    document.body.removeChild(modal);
                });
            }
        }

        // Export to CSV
        function exportToCSV() {
            let csv = 'ID,Tipe,Nama,Email,Telepon,Tanggal\n';
            
            const allData = [
                ...propertyData.sellers.map(item => ({...item, type: 'seller'})),
                ...propertyData.buyers.map(item => ({...item, type: 'buyer'})),
                ...propertyData.properties.map(item => ({...item, type: 'property'}))
            ];
            
            allData.forEach(item => {
                csv += `${item.id},${getTypeLabel(item.type)},"${getName(item)}","${getEmail(item)}","${getPhone(item)}",${formatDate(item.timestamp)}\n`;
            });
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `property_data_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
            window.URL.revokeObjectURL(url);
            
            showAlert('Data berhasil diekspor ke CSV!');
        }

        // Export to MySQL
        function exportToMySQL() {
            let sql = '-- Property Management System Export\n';
            sql += '-- Generated on: ' + new Date().toISOString() + '\n\n';
            
            // Create tables
            sql += `CREATE TABLE IF NOT EXISTS sellers (
                id BIGINT PRIMARY KEY,
                seller_name VARCHAR(255),
                seller_ktp VARCHAR(50),
                seller_address_ktp TEXT,
                seller_current_address TEXT,
                seller_phone VARCHAR(20),
                seller_email VARCHAR(100),
                seller_ownership_status VARCHAR(50),
                seller_price DECIMAL(15,2),
                seller_negotiable ENUM('ya','tidak'),
                seller_include_tax ENUM('ya','tidak'),
                seller_dispute_free ENUM('ya','tidak'),
                seller_bank_collateral ENUM('ya','tidak'),
                seller_heir_approval ENUM('tidak','ada'),
                seller_has_imb ENUM('ya','tidak'),
                timestamp DATETIME
            );\n\n`;
            
            sql += `CREATE TABLE IF NOT EXISTS buyers (
                id BIGINT PRIMARY KEY,
                buyer_name VARCHAR(255),
                buyer_ktp VARCHAR(50),
                buyer_address_ktp TEXT,
                buyer_current_address TEXT,
                buyer_job VARCHAR(100),
                buyer_company VARCHAR(100),
                buyer_phone VARCHAR(20),
                buyer_email VARCHAR(100),
                buyer_marital_status VARCHAR(50),
                buyer_offer_price DECIMAL(15,2),
                buyer_payment_scheme VARCHAR(50),
                buyer_down_payment DECIMAL(15,2),
                buyer_payment_term INT,
                buyer_clear_funds ENUM('ya','tidak'),
                buyer_ready_down_payment ENUM('ya','tidak'),
                buyer_kpr_bank VARCHAR(100),
                buyer_kpr_stage VARCHAR(50),
                timestamp DATETIME
            );\n\n`;
            
            sql += `CREATE TABLE IF NOT EXISTS properties (
                id BIGINT PRIMARY KEY,
                property_address TEXT,
                property_land_area INT,
                property_building_area INT,
                property_certificate_type VARCHAR(50),
                property_certificate_number VARCHAR(100),
                property_certificate_name VARCHAR(255),
                property_imb_number VARCHAR(100),
                property_imb_year INT,
                property_pbb_status ENUM('lunas','belum_lunas'),
                property_condition VARCHAR(50),
                property_other_legality TEXT,
                property_notes TEXT,
                property_data_truth BOOLEAN,
                property_transaction_ready BOOLEAN,
                timestamp DATETIME
            );\n\n`;
            
            // Insert data
            if (propertyData.sellers.length > 0) {
                sql += 'INSERT INTO sellers VALUES\n';
                propertyData.sellers.forEach((item, index) => {
                    sql += `(${item.id}, '${escapeSQL(item.seller_name || '')}', '${escapeSQL(item.seller_ktp || '')}', '${escapeSQL(item.seller_address_ktp || '')}', '${escapeSQL(item.seller_current_address || '')}', '${escapeSQL(item.seller_phone || '')}', '${escapeSQL(item.seller_email || '')}', '${escapeSQL(item.seller_ownership_status || '')}', ${item.seller_price || 0}, '${item.seller_negotiable || 'tidak'}', '${item.seller_include_tax || 'tidak'}', '${item.seller_dispute_free || 'ya'}', '${item.seller_bank_collateral || 'tidak'}', '${item.seller_heir_approval || 'tidak'}', '${item.seller_has_imb || 'tidak'}', '${item.timestamp}')`;
                    sql += index < propertyData.sellers.length - 1 ? ',\n' : ';\n\n';
                });
            }
            
            if (propertyData.buyers.length > 0) {
                sql += 'INSERT INTO buyers VALUES\n';
                propertyData.buyers.forEach((item, index) => {
                    sql += `(${item.id}, '${escapeSQL(item.buyer_name || '')}', '${escapeSQL(item.buyer_ktp || '')}', '${escapeSQL(item.buyer_address_ktp || '')}', '${escapeSQL(item.buyer_current_address || '')}', '${escapeSQL(item.buyer_job || '')}', '${escapeSQL(item.buyer_company || '')}', '${escapeSQL(item.buyer_phone || '')}', '${escapeSQL(item.buyer_email || '')}', '${escapeSQL(item.buyer_marital_status || '')}', ${item.buyer_offer_price || 0}, '${escapeSQL(item.buyer_payment_scheme || '')}', ${item.buyer_down_payment || 0}, ${item.buyer_payment_term || 0}, '${item.buyer_clear_funds || 'ya'}', '${item.buyer_ready_down_payment || 'ya'}', '${escapeSQL(item.buyer_kpr_bank || '')}', '${escapeSQL(item.buyer_kpr_stage || '')}', '${item.timestamp}')`;
                    sql += index < propertyData.buyers.length - 1 ? ',\n' : ';\n\n';
                });
            }
            
            if (propertyData.properties.length > 0) {
                sql += 'INSERT INTO properties VALUES\n';
                propertyData.properties.forEach((item, index) => {
                    sql += `(${item.id}, '${escapeSQL(item.property_address || '')}', ${item.property_land_area || 0}, ${item.property_building_area || 0}, '${escapeSQL(item.property_certificate_type || '')}', '${escapeSQL(item.property_certificate_number || '')}', '${escapeSQL(item.property_certificate_name || '')}', '${escapeSQL(item.property_imb_number || '')}', ${item.property_imb_year || 0}, '${item.property_pbb_status || 'lunas'}', '${escapeSQL(item.property_condition || '')}', '${escapeSQL(item.property_other_legality || '')}', '${escapeSQL(item.property_notes || '')}', ${item.property_data_truth ? 1 : 0}, ${item.property_transaction_ready ? 1 : 0}, '${item.timestamp}')`;
                    sql += index < propertyData.properties.length - 1 ? ',\n' : ';\n\n';
                });
            }
            
            const blob = new Blob([sql], { type: 'text/sql' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `property_database_${new Date().toISOString().split('T')[0]}.sql`;
            a.click();
            window.URL.revokeObjectURL(url);
            
            showAlert('Database berhasil diekspor ke MySQL!');
        }

        function escapeSQL(str) {
            return str.replace(/'/g, "''");
        }

        // Clear all data
        function clearAllData() {
            if (confirm('Apakah Anda yakin ingin menghapus SEMUA data? Tindakan ini tidak dapat dibatalkan!')) {
                localStorage.clear();
                propertyData = { sellers: [], buyers: [], properties: [] };
                updateTable();
                updateStatistics();
                showAlert('Semua data berhasil dihapus!');
            }
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', updateTable);
        document.getElementById('filterType').addEventListener('change', updateTable);

        // File upload handler
        document.getElementById('propertyFiles').addEventListener('change', function(e) {
            const fileList = document.getElementById('fileList');
            fileList.innerHTML = '';
            
            Array.from(e.target.files).forEach(file => {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'alert alert-info d-flex justify-content-between align-items-center';
                fileDiv.innerHTML = `
                    <span><i class="fas fa-file me-2"></i>${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                fileList.appendChild(fileDiv);
            });
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTable();
            updateStatistics();
        });
    </script>
</body>
</html>






















</html>
    <div class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="widget">
              <h3>Contact</h3>
              <address>43 Raymouth Rd. Baltemoer, London 3910</address>
              <ul class="list-unstyled links">
                <li><a href="tel://11234567890">+1(123)-456-7890</a></li>
                <li><a href="tel://11234567890">+1(123)-456-7890</a></li>
                <li>
                  <a href="mailto:info@mydomain.com">info@mydomain.com</a>
                </li>
              </ul>
            </div>
            <!-- /.widget -->
          </div>
          <!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <div class="widget">
              <h3>Sources</h3>
              <ul class="list-unstyled float-start links">
                <li><a href="#">About us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Vision</a></li>
                <li><a href="#">Mission</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Privacy</a></li>
              </ul>
              <ul class="list-unstyled float-start links">
                <li><a href="#">Partners</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Creative</a></li>
              </ul>
            </div>
            <!-- /.widget -->
          </div>
          <!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <div class="widget">
              <h3>Links</h3>
              <ul class="list-unstyled links">
                <li><a href="#">Our Vision</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
              </ul>

              <ul class="list-unstyled social">
                <li>
                  <a href="#"><span class="icon-instagram"></span></a>
                </li>
                <li>
                  <a href="#"><span class="icon-twitter"></span></a>
                </li>
                <li>
                  <a href="#"><span class="icon-facebook"></span></a>
                </li>
                <li>
                  <a href="#"><span class="icon-linkedin"></span></a>
                </li>
                <li>
                  <a href="#"><span class="icon-pinterest"></span></a>
                </li>
                <li>
                  <a href="#"><span class="icon-dribbble"></span></a>
                </li>
              </ul>
            </div>
            <!-- /.widget -->
          </div>
          <!-- /.col-lg-4 -->
        </div>
        <!-- /.row -->

        <div class="row mt-5">
          <div class="col-12 text-center">
            <!-- 
              **==========
              NOTE: 
              Please don't remove this copyright link unless you buy the license here https://untree.co/license/  
              **==========
            -->

            <p>
              Copyright &copy;
              <script>
                document.write(new Date().getFullYear());
              </script>
              . All Rights Reserved. &mdash; Designed with love by
              <a href="https://untree.co">Untree.co</a>
              <!-- License information: https://untree.co/license/ -->
            </p>
            <div>
              Distributed by
              <a href="https://themewagon.com/" target="_blank">themewagon</a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container -->
    </div>
    <!-- /.site-footer -->

    <!-- Preloader -->
    <div id="overlayer"></div>
    <div class="loader">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/navbar.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>
