<?php
// File: redirect_recipe.php
// Sistem untuk mengarahkan ke file resep yang tepat

session_start();
require_once 'config.php';

// Ambil ID resep dari parameter
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipe_id <= 0) {
    header("Location: index.php");
    exit();
}

try {
    // Ambil data resep dari database
    $query = "SELECT filename, nama_resep FROM recipes WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$recipe_id]);
    $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$recipe) {
        // Resep tidak ditemukan
        $_SESSION['error'] = "Resep tidak ditemukan.";
        header("Location: index.php");
        exit();
    }
    
    // Cek apakah file generated masih ada
    $generated_file = $recipe['filename'] . '.php';
    
    if (file_exists($generated_file)) {
        // File ada, redirect ke file generated
        header("Location: " . $generated_file);
        exit();
    } else {
        // File tidak ada, coba regenerate atau gunakan fallback
        
        // Opsi 1: Coba regenerate file (jika Anda punya fungsi generateRecipeFile)
        /*
        if (regenerateRecipeFile($recipe_id)) {
            header("Location: " . $generated_file);
            exit();
        }
        */
        
        // Opsi 2: Gunakan detail_resep.php sebagai fallback
        header("Location: detail_resep.php?id=" . $recipe_id);
        exit();
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = "Terjadi kesalahan: " . $e->getMessage();
    header("Location: index.php");
    exit();
}

// Fungsi untuk regenerate file resep (opsional)
function regenerateRecipeFile($recipe_id) {
    global $pdo;
    
    try {
        // Ambil data lengkap resep
        $query = "SELECT r.*, u.nama as user_nama, u.email as user_email 
                  FROM recipes r 
                  JOIN users u ON r.user_id = u.id 
                  WHERE r.id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$recipe_id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$recipe) {
            return false;
        }
        
        // Decode JSON data
        $recipe['bahan'] = json_decode($recipe['bahan'], true);
        $recipe['jumlah'] = json_decode($recipe['jumlah'], true);
        $recipe['langkah'] = json_decode($recipe['langkah'], true);
        
        // Generate file PHP menggunakan fungsi yang sama dari process_resep.php
        $php_content = generateRecipePhpFile($recipe);
        $file_path = $recipe['filename'] . '.php';
        
        return file_put_contents($file_path, $php_content) !== false;
        
    } catch (Exception $e) {
        return false;
    }
}

// Copy fungsi generateRecipePhpFile dari process_resep.php
function generateRecipePhpFile($data) {
    // ... (copy exact function dari process_resep.php)
    // Fungsi ini sama persis dengan yang ada di process_resep.php
}
?>