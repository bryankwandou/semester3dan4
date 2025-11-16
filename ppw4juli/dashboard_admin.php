<?php 
session_start();
require_once 'config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin.php");
    exit();
}

// Ambil pesan dari session
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

// Hapus pesan setelah digunakan
unset($_SESSION['success']);
unset($_SESSION['errors']);

// Handle delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_recipe'])) {
        $recipe_id = (int)$_POST['recipe_id'];
        
        try {
            // Hapus foto jika ada
            $stmt = $pdo->prepare("SELECT foto_path FROM recipes WHERE id = ?");
            $stmt->execute([$recipe_id]);
            $recipe = $stmt->fetch();
            
            if ($recipe && $recipe['foto_path'] && file_exists($recipe['foto_path'])) {
                unlink($recipe['foto_path']);
            }
            
            // Hapus resep
            $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
            $stmt->execute([$recipe_id]);
            
            $_SESSION['success'] = "Resep berhasil dihapus!";
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Gagal menghapus resep: " . $e->getMessage()];
        }
        
        header("Location: dashboard_admin.php");
        exit();
    }
    
    if (isset($_POST['delete_user'])) {
        $user_id = (int)$_POST['user_id'];
        
        try {
            // Hapus user (favorites dan recipes akan terhapus otomatis karena CASCADE)
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            
            $_SESSION['success'] = "User berhasil dihapus!";
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Gagal menghapus user: " . $e->getMessage()];
        }
        
        header("Location: dashboard_admin.php");
        exit();
    }
    
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: admin.php");
        exit();
    }
}

// Ambil statistik
try {
    $stats = [];
    
    // Total resep
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM recipes");
    $stats['total_recipes'] = $stmt->fetch()['total'];
    
    // Total users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $stats['total_users'] = $stmt->fetch()['total'];
    
    // Total favorites
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM favorites");
    $stats['total_favorites'] = $stmt->fetch()['total'];
    
    // Resep per kategori
    $stmt = $pdo->query("SELECT kategori, COUNT(*) as total FROM recipes GROUP BY kategori");
    $categories = $stmt->fetchAll();
    
} catch (Exception $e) {
    $errors[] = "Gagal mengambil statistik: " . $e->getMessage();
}

// Ambil semua resep dengan data user
try {
    $stmt = $pdo->query("
        SELECT r.*, 
               u.nama as user_name, 
               u.email as user_email
        FROM recipes r 
        LEFT JOIN users u ON r.user_id = u.id 
        ORDER BY r.created_at DESC
    ");
    $recipes = $stmt->fetchAll();
} catch (Exception $e) {
    $errors[] = "Gagal mengambil data resep: " . $e->getMessage();
    $recipes = [];
}

// Ambil semua users dengan perhitungan yang benar
try {
    $stmt = $pdo->query("
        SELECT u.*, 
               COALESCE(r.recipe_count, 0) as recipe_count,
               COALESCE(f.favorite_count, 0) as favorite_count
        FROM users u 
        LEFT JOIN (
            SELECT user_id, COUNT(*) as recipe_count 
            FROM recipes 
            GROUP BY user_id
        ) r ON u.id = r.user_id
        LEFT JOIN (
            SELECT user_id, COUNT(*) as favorite_count 
            FROM favorites 
            GROUP BY user_id
        ) f ON u.id = f.user_id
        ORDER BY u.created_at DESC
    ");
    $users = $stmt->fetchAll();
} catch (Exception $e) {
    $errors[] = "Gagal mengambil data user: " . $e->getMessage();
    $users = [];
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
    <title>SajianNusantara - Dashboard Admin</title>
    
    <!-- Favicon -->
    <link rel="icon" href="img/core-img/s.jpg">
    
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Custom Admin Styles -->
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
        .admin-header {
            background:  #D62828;
            color: white;
            padding: 20px 0;
        }
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #f96d38;
        }
        .stats-label {
            color: #666;
            margin-top: 5px;
        }
        .admin-table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .admin-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .admin-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
        }
        .admin-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }
        .admin-table tr:hover {
            background: #f8f9fa;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .recipe-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        .category-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }
        .badge-makanan_utama { background: #e3f2fd; color: #1976d2; }
        .badge-minuman { background: #f3e5f5; color: #7b1fa2; }
        .badge-kue { background: #fff3e0; color: #f57c00; }
        .badge-cemilan { background: #e8f5e8; color: #388e3c; }
        .section-title {
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #f96d38;
            color: #333;
        }
        /* Style untuk link nama resep */
        .recipe-name-link {
            color: #f96d38;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .recipe-name-link:hover {
            color: #D62828;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Admin Header -->
    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 style="color: white;">Dashboard Admin</h2>
                    <p style="color: white;" class="mb-0">Selamat datang, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <a href="index.php" class="btn btn-light mr-2">Lihat Website</a>
                    <form method="post" style="display: inline;">
                        <button name="logout" class="btn btn-outline-light" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 30px; margin-bottom: 50px;">
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

        <!-- Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $stats['total_recipes']; ?></div>
                    <div class="stats-label">Total Resep</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $stats['total_users']; ?></div>
                    <div class="stats-label">Total Users</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo $stats['total_favorites']; ?></div>
                    <div class="stats-label">Total Favorites</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number"><?php echo count($categories); ?></div>
                    <div class="stats-label">Kategori</div>
                </div>
            </div>
        </div>

        <!-- Recipes Management -->
        <h3 class="section-title">Manajemen Resep</h3>
        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Resep</th>
                        <th>Kategori</th>
                        <th>Pembuat</th>
                        <th>Waktu Masak</th>
                        <th>Porsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recipes)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada resep</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recipes as $recipe): ?>
                            <tr>
                                <td>
                                    <?php if ($recipe['foto_path'] && file_exists($recipe['foto_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($recipe['foto_path']); ?>" class="recipe-image" alt="">
                                    <?php else: ?>
                                        <div class="recipe-image" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; color: #666;">
                                            No Image
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="detail_resep.php?id=<?php echo $recipe['id']; ?>" class="recipe-name-link">
                                        <?php echo htmlspecialchars($recipe['nama_resep']); ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="category-badge badge-<?php echo $recipe['kategori']; ?>">
                                        <?php echo ucfirst(str_replace('_', ' ', $recipe['kategori'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($recipe['user_name']): ?>
                                        <?php echo htmlspecialchars($recipe['user_name']); ?><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($recipe['user_email']); ?></small>
                                    <?php else: ?>
                                        <em>User dihapus</em>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $recipe['waktu_masak']; ?> menit</td>
                                <td><?php echo $recipe['porsi']; ?> porsi</td>
                                <td><?php echo date('d/m/Y H:i', strtotime($recipe['created_at'])); ?></td>
                                <td>
                                    <form method="post" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                                        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                                        <button name="delete_recipe" class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Users Management -->
        <h3 class="section-title">Manajemen User</h3>
        <div class="admin-table">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Total Resep Dibuat</th>
                        <th>Total Resep Difavoritkan</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada user</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['nama']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                        <?php echo $user['recipe_count']; ?> resep
                                    </span>
                                </td>
                                <td>
                                    <span class="badge" style="background: #fff3e0; color: #f57c00; padding: 4px 8px; border-radius: 12px; font-size: 12px;">
                                        <?php echo $user['favorite_count']; ?> favorit
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <form method="post" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus user ini? Semua resep dan favoritnya akan ikut terhapus.');">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button name="delete_user" class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ##### All Javascript Files ##### -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/popper.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/plugins.js"></script>
    <script src="js/active.js"></script>
</body>

</html>