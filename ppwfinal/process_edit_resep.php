<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}

// Cek apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Metode request tidak valid!';
    header("Location: dashboard.php");
    exit();
}

// Cek apakah ada recipe_id
if (!isset($_POST['recipe_id']) || empty($_POST['recipe_id'])) {
    $_SESSION['error'] = 'ID resep tidak valid!';
    header("Location: dashboard.php");
    exit();
}

$recipe_id = (int)$_POST['recipe_id'];
$user_id = $_SESSION['user_id'];

// Koneksi database
require_once 'config.php';

try {
    // Verifikasi bahwa resep ada dan milik user
    $check_query = "SELECT id, foto_path, filename FROM recipes WHERE id = ? AND user_id = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$recipe_id, $user_id]);
    $existing_recipe = $check_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$existing_recipe) {
        $_SESSION['error'] = 'Resep tidak ditemukan atau Anda tidak memiliki akses untuk mengedit resep ini!';
        header("Location: dashboard.php");
        exit();
    }
    
    // Validasi input
    $nama_resep = trim($_POST['nama_resep'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $waktu_masak = (int)($_POST['waktu_masak'] ?? 0);
    $porsi = (int)($_POST['porsi'] ?? 1);
    $bahan = $_POST['bahan'] ?? [];
    $jumlah = $_POST['jumlah'] ?? [];
    $langkah = $_POST['langkah'] ?? [];
    
    // Validasi field wajib
    if (empty($nama_resep)) {
        throw new Exception('Nama resep tidak boleh kosong!');
    }
    
    if (empty($kategori) || !in_array($kategori, ['makanan_utama', 'minuman', 'kue', 'cemilan'])) {
        throw new Exception('Kategori tidak valid!');
    }
    
    if (empty($bahan) || empty($jumlah) || empty($langkah)) {
        throw new Exception('Bahan, jumlah, dan langkah memasak tidak boleh kosong!');
    }
    
    if (count($bahan) !== count($jumlah)) {
        throw new Exception('Jumlah bahan dan takaran harus sama!');
    }
    
    // Bersihkan array dari nilai kosong
    $bahan = array_filter(array_map('trim', $bahan));
    $jumlah = array_filter(array_map('trim', $jumlah));
    $langkah = array_filter(array_map('trim', $langkah));
    
    if (empty($bahan) || empty($jumlah) || empty($langkah)) {
        throw new Exception('Bahan, jumlah, dan langkah memasak tidak boleh kosong!');
    }
    
    // Validasi nilai numerik
    if ($waktu_masak < 0) {
        $waktu_masak = 0;
    }
    
    if ($porsi < 1) {
        $porsi = 1;
    }
    
    // Handle upload foto
    $foto_path = $existing_recipe['foto_path']; // Gunakan foto lama sebagai default
    $filename = $existing_recipe['filename'];
    
    if (isset($_FILES['foto_resep']) && $_FILES['foto_resep']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'img/recipe-img/';
        
        // Buat direktori jika belum ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_tmp = $_FILES['foto_resep']['tmp_name'];
        $file_name = $_FILES['foto_resep']['name'];
        $file_size = $_FILES['foto_resep']['size'];
        $file_type = $_FILES['foto_resep']['type'];
        
        // Validasi tipe file
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file_type, $allowed_types)) {
            throw new Exception('Tipe file tidak didukung! Gunakan JPEG, PNG, GIF, atau WebP.');
        }
        
        // Validasi ukuran file (maksimal 5MB)
        if ($file_size > 5 * 1024 * 1024) {
            throw new Exception('Ukuran file terlalu besar! Maksimal 5MB.');
        }
        
        // Generate nama file unik
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_filename = 'recipe_' . $user_id . '_' . time() . '_' . uniqid() . '.' . $file_extension;
        $new_foto_path = $upload_dir . $new_filename;
        
        // Upload file
        if (move_uploaded_file($file_tmp, $new_foto_path)) {
            // Hapus foto lama jika ada dan berbeda
            if (!empty($existing_recipe['foto_path']) && 
                $existing_recipe['foto_path'] !== $new_foto_path && 
                file_exists($existing_recipe['foto_path'])) {
                unlink($existing_recipe['foto_path']);
            }
            
            $foto_path = $new_foto_path;
            $filename = $new_filename;
        } else {
            throw new Exception('Gagal mengupload foto!');
        }
    }
    
    // Convert array ke JSON
    $bahan_json = json_encode($bahan, JSON_UNESCAPED_UNICODE);
    $jumlah_json = json_encode($jumlah, JSON_UNESCAPED_UNICODE);
    $langkah_json = json_encode($langkah, JSON_UNESCAPED_UNICODE);
    
    if ($bahan_json === false || $jumlah_json === false || $langkah_json === false) {
        throw new Exception('Gagal memproses data resep!');
    }
    
    // Update resep ke database
    $update_query = "UPDATE recipes SET 
                     nama_resep = ?, 
                     kategori = ?, 
                     waktu_masak = ?, 
                     porsi = ?, 
                     foto_path = ?, 
                     filename = ?, 
                     bahan = ?, 
                     jumlah = ?, 
                     langkah = ?
                     WHERE id = ? AND user_id = ?";
    
    $update_stmt = $pdo->prepare($update_query);
    $result = $update_stmt->execute([
        $nama_resep,
        $kategori,
        $waktu_masak,
        $porsi,
        $foto_path,
        $filename,
        $bahan_json,
        $jumlah_json,
        $langkah_json,
        $recipe_id,
        $user_id
    ]);
    
    if ($result && $update_stmt->rowCount() > 0) {
        $_SESSION['success'] = 'Resep berhasil diperbarui!';
        header("Location: dashboard.php");
    } else {
        // Jika tidak ada perubahan data
        $_SESSION['success'] = 'Resep berhasil diperbarui!';
        header("Location: dashboard.php");
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: edit_resep.php?id=" . $recipe_id);
} catch (PDOException $e) {
    // Log error untuk debugging
    error_log("Database Error in process_edit_resep.php: " . $e->getMessage());
    $_SESSION['error'] = 'Terjadi kesalahan database. Silakan coba lagi.';
    header("Location: edit_resep.php?id=" . $recipe_id);
}

exit();
?>