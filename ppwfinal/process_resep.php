<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: buat_resep.php");
    exit();
}

// Database connection (adjust according to your config)
require_once 'config.php'; 

try {
    // Validate required fields
    $required_fields = ['nama_resep', 'kategori', 'bahan', 'jumlah', 'langkah'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Field $field wajib diisi!");
        }
    }

    // Get user information from database
    $user_info = getUserInfo($_SESSION['user_id']);
    if (!$user_info) {
        throw new Exception("User tidak ditemukan!");
    }

    // Sanitize recipe name for filename
    $nama_resep = trim($_POST['nama_resep']);
    $filename = generateSafeFilename($nama_resep);
    
    // Handle file upload
    $foto_path = '';
    if (isset($_FILES['foto_resep']) && $_FILES['foto_resep']['error'] === UPLOAD_ERR_OK) {
        $foto_path = handleFileUpload($_FILES['foto_resep'], $filename);
    }

    // Prepare recipe data
    $recipe_data = [
        'nama_resep' => $nama_resep,
        'kategori' => $_POST['kategori'],
        'waktu_masak' => (int)($_POST['waktu_masak'] ?? 0),
        'porsi' => (int)($_POST['porsi'] ?? 1),
        'foto_path' => $foto_path,
        'bahan' => array_map('trim', $_POST['bahan']),
        'jumlah' => array_map('trim', $_POST['jumlah']),
        'langkah' => array_map('trim', $_POST['langkah']),
        'user_id' => $_SESSION['user_id'],
        'filename' => $filename
    ];

    // Save to database only
    $recipe_id = saveRecipeToDatabase($recipe_data);
    
    if ($recipe_id) {
        $_SESSION['success'] = "Resep '{$nama_resep}' berhasil ditambahkan!";
        // Redirect to view recipe page with the recipe ID
        header("Location: dashboard.php");
    } else {
        throw new Exception("Gagal menyimpan resep ke database!");
    }

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: buat_resep.php");
}
exit();

function getUserInfo($user_id) {
    global $pdo; // Assuming PDO connection
    
    $sql = "SELECT nama, email FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function generateSafeFilename($nama_resep) {
    // Convert to lowercase and replace spaces/special chars
    $filename = strtolower($nama_resep);
    $filename = preg_replace('/[^a-z0-9\s]/', '', $filename);
    $filename = preg_replace('/\s+/', '_', trim($filename));
    $filename = substr($filename, 0, 50); // Limit length
    
    // Check for existing filename in database to ensure uniqueness
    global $pdo;
    $counter = 1;
    $original_filename = $filename;
    
    while (filenameExists($filename)) {
        $filename = $original_filename . '_' . $counter;
        $counter++;
    }
    
    return $filename;
}

function filenameExists($filename) {
    global $pdo;
    
    $sql = "SELECT COUNT(*) FROM recipes WHERE filename = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$filename]);
    
    return $stmt->fetchColumn() > 0;
}

function handleFileUpload($file, $filename) {
    $upload_dir = 'img/recipe-img/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Validate file type
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        throw new Exception("Tipe file tidak diizinkan! Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.");
    }
    
    // Validate file size (max 5MB)
    $max_size = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $max_size) {
        throw new Exception("Ukuran file terlalu besar! Maksimal 5MB.");
    }
    
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_filename = $filename . '.' . strtolower($file_extension);
    $upload_path = $upload_dir . $new_filename;
    
    // Ensure unique filename for uploaded image
    $counter = 1;
    while (file_exists($upload_path)) {
        $new_filename = $filename . '_' . $counter . '.' . strtolower($file_extension);
        $upload_path = $upload_dir . $new_filename;
        $counter++;
    }
    
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        return $upload_path;
    }
    
    throw new Exception("Gagal upload foto!");
}

function saveRecipeToDatabase($data) {
    global $pdo; // Assuming PDO connection
    
    try {
        $sql = "INSERT INTO recipes (nama_resep, kategori, waktu_masak, porsi, foto_path, 
                bahan, jumlah, langkah, user_id, filename, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $data['nama_resep'],
            $data['kategori'], 
            $data['waktu_masak'],
            $data['porsi'],
            $data['foto_path'],
            json_encode($data['bahan'], JSON_UNESCAPED_UNICODE),
            json_encode($data['jumlah'], JSON_UNESCAPED_UNICODE),
            json_encode($data['langkah'], JSON_UNESCAPED_UNICODE),
            $data['user_id'],
            $data['filename']
        ]);
        
        if ($result) {
            return $pdo->lastInsertId();
        }
        
        return false;
        
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        throw new Exception("Gagal menyimpan resep ke database!");
    }
}
?>