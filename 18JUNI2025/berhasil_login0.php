<?php 
session_start(); 

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {  
    header("Location: index.php");  
    exit(); 
}

// Fungsi untuk mendapatkan waktu login terakhir
function getLastLoginTime() {
    return isset($_SESSION['login_time']) ? $_SESSION['login_time'] : date('Y-m-d H:i:s');
}

// Fungsi untuk menghitung durasi session
function getSessionDuration() {
    if (isset($_SESSION['login_time'])) {
        $loginTime = strtotime($_SESSION['login_time']);
        $currentTime = time();
        $duration = $currentTime - $loginTime;
        
        $hours = floor($duration / 3600);
        $minutes = floor(($duration % 3600) / 60);
        $seconds = $duration % 60;
        
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }
    return "00:00:00";
}

// Simulasi data user (dalam aplikasi nyata, ambil dari database)
$userData = [
    'email' => isset($_SESSION['email']) ? $_SESSION['email'] : 'user@example.com',
    'role' => isset($_SESSION['role']) ? $_SESSION['role'] : 'User',
    'last_login' => getLastLoginTime(),
    'session_duration' => getSessionDuration(),
    'profile_picture' => 'https://via.placeholder.com/80x80/007bff/ffffff?text=' . substr($_SESSION['username'], 0, 1)
];

// Menu navigasi berdasarkan role
$menuItems = [
    'User' => [
        ['icon' => 'fa-home', 'title' => 'Dashboard', 'url' => '#dashboard'],
        ['icon' => 'fa-user', 'title' => 'Profile', 'url' => '#profile'],
        ['icon' => 'fa-cog', 'title' => 'Settings', 'url' => '#settings']
    ],
    'Admin' => [
        ['icon' => 'fa-home', 'title' => 'Dashboard', 'url' => '#dashboard'],
        ['icon' => 'fa-users', 'title' => 'Users', 'url' => '#users'],
        ['icon' => 'fa-chart-bar', 'title' => 'Analytics', 'url' => '#analytics'],
        ['icon' => 'fa-cog', 'title' => 'Settings', 'url' => '#settings']
    ]
];

$currentMenu = isset($menuItems[$userData['role']]) ? $menuItems[$userData['role']] : $menuItems['User'];

// Statistik dashboard (simulasi)
$stats = [
    ['icon' => 'fa-users', 'title' => 'Total Users', 'value' => '1,234', 'color' => 'primary'],
    ['icon' => 'fa-shopping-cart', 'title' => 'Orders', 'value' => '567', 'color' => 'success'],
    ['icon' => 'fa-dollar-sign', 'title' => 'Revenue', 'value' => '$12,345', 'color' => 'warning'],
    ['icon' => 'fa-chart-line', 'title' => 'Growth', 'value' => '23%', 'color' => 'info']
];

// Aktivitas terbaru (simulasi)
$recentActivities = [
    ['time' => '2 menit lalu', 'action' => 'Login berhasil', 'icon' => 'fa-sign-in-alt', 'color' => 'success'],
    ['time' => '15 menit lalu', 'action' => 'Profile updated', 'icon' => 'fa-user-edit', 'color' => 'info'],
    ['time' => '1 jam lalu', 'action' => 'Password changed', 'icon' => 'fa-key', 'color' => 'warning'],
    ['time' => '2 jam lalu', 'action' => 'Data exported', 'icon' => 'fa-download', 'color' => 'primary']
];
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">  
    <title>Dashboard - Selamat Datang <?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <style>
        /* Tambahan CSS untuk fitur baru */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
            gap: 0;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
        }
        
        .main-content {
            background: #f8f9fa;
            padding: 20px;
        }
        
        .user-profile {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        
        .nav-item {
            margin: 5px 0;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 30px;
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-right: 15px;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .content-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .welcome-text h1 {
            margin: 0;
            color: #333;
        }
        
        .session-info {
            text-align: right;
            font-size: 0.9rem;
            color: #666;
        }
        
        .logout-section {
            margin-top: auto;
            padding: 20px;
        }
        
        /* Responsif */
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100vh;
                z-index: 1000;
                transition: left 0.3s ease;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head> 
<body>  
    <div class="dashboard-grid animate__animated animate__fadeIn">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-profile">
                <img src="<?php echo $userData['profile_picture']; ?>" alt="Profile" class="profile-img">
                <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                <p><?php echo htmlspecialchars($userData['email']); ?></p>
                <small><?php echo htmlspecialchars($userData['role']); ?></small>
            </div>
            
            <ul class="nav-menu">
                <?php foreach ($currentMenu as $item): ?>
                <li class="nav-item">
                    <a href="<?php echo $item['url']; ?>" class="nav-link">
                        <i class="fa <?php echo $item['icon']; ?>"></i>
                        <?php echo $item['title']; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            
            <div class="logout-section">
                <form action="logout.php" method="POST">  
                    <button type="submit" class="btn" style="width: 100%; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                        <i class="fa fa-sign-out"></i> Logout
                    </button>  
                </form>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="header-info">
                <div class="welcome-text">
                    <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                    <p>Semoga hari Anda menyenangkan</p>
                </div>
                <div class="session-info">
                    <div><strong>Login Terakhir:</strong> <?php echo $userData['last_login']; ?></div>
                    <div><strong>Durasi Session:</strong> <span id="session-timer"><?php echo $userData['session_duration']; ?></span></div>
                    <div><strong>Status:</strong> <span style="color: #28a745;">Online</span></div>
                </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <?php foreach ($stats as $stat): ?>
                <div class="stat-card animate__animated animate__fadeInUp">
                    <div class="stat-icon" style="background: 
                        <?php 
                        echo $stat['color'] == 'primary' ? '#007bff' : 
                             ($stat['color'] == 'success' ? '#28a745' : 
                             ($stat['color'] == 'warning' ? '#ffc107' : '#17a2b8')); 
                        ?>;">
                        <i class="fa <?php echo $stat['icon']; ?>" style="color: white;"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; color: #333;"><?php echo $stat['value']; ?></h3>
                        <p style="margin: 5px 0 0 0; color: #666;"><?php echo $stat['title']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Recent Activities -->
            <div class="content-section">
                <h3><i class="fa fa-clock-o"></i> Aktivitas Terbaru</h3>
                <div class="activities-list">
                    <?php foreach ($recentActivities as $activity): ?>
                    <div class="activity-item">
                        <div class="activity-icon" style="background: 
                            <?php 
                            echo $activity['color'] == 'primary' ? '#007bff' : 
                                 ($activity['color'] == 'success' ? '#28a745' : 
                                 ($activity['color'] == 'warning' ? '#ffc107' : '#17a2b8')); 
                            ?>;">
                            <i class="fa <?php echo $activity['icon']; ?>"></i>
                        </div>
                        <div>
                            <strong><?php echo $activity['action']; ?></strong>
                            <div style="font-size: 0.9rem; color: #666;"><?php echo $activity['time']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="content-section">
                <h3><i class="fa fa-bolt"></i> Quick Actions</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <button class="btn" style="background: #007bff; color: white; padding: 15px;">
                        <i class="fa fa-plus"></i> Tambah Data
                    </button>
                    <button class="btn" style="background: #28a745; color: white; padding: 15px;">
                        <i class="fa fa-download"></i> Export Data
                    </button>
                    <button class="btn" style="background: #17a2b8; color: white; padding: 15px;">
                        <i class="fa fa-chart-bar"></i> Lihat Laporan
                    </button>
                    <button class="btn" style="background: #6f42c1; color: white; padding: 15px;">
                        <i class="fa fa-cog"></i> Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Timer untuk durasi session
        function updateSessionTimer() {
            const timerElement = document.getElementById('session-timer');
            if (timerElement) {
                const currentTime = timerElement.textContent.split(':');
                let hours = parseInt(currentTime[0]);
                let minutes = parseInt(currentTime[1]);
                let seconds = parseInt(currentTime[2]);
                
                seconds++;
                if (seconds >= 60) {
                    seconds = 0;
                    minutes++;
                    if (minutes >= 60) {
                        minutes = 0;
                        hours++;
                    }
                }
                
                timerElement.textContent = 
                    String(hours).padStart(2, '0') + ':' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
            }
        }
        
        // Update timer setiap detik
        setInterval(updateSessionTimer, 1000);
        
        // Animasi hover untuk stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Mobile menu toggle (jika diperlukan)
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            if (window.innerWidth <= 768) {
                sidebar.style.left = sidebar.style.left === '0px' ? '-250px' : '0px';
            }
        }
    </script>
</body> 
</html>