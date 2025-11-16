<?php
require_once 'auth.php';
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}
// Set content type untuk JSON response
header('Content-Type: application/json');

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Anda harus login terlebih dahulu'
    ]);
    exit();
}

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
    exit();
}

// Ambil data JSON dari request body
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['recipe_id']) || !isset($input['action'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Data tidak lengkap'
    ]);
    exit();
}

$recipe_id = (int)$input['recipe_id'];
$action = $input['action']; // 'add' atau 'remove'
$user_id = $_SESSION['user_id'];

// Validasi recipe_id
if ($recipe_id <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID resep tidak valid'
    ]);
    exit();
}

// Validasi action
if (!in_array($action, ['add', 'remove'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Aksi tidak valid'
    ]);
    exit();
}

try {
    // Cek apakah resep exists
    $recipe_check = $pdo->prepare("SELECT id FROM recipes WHERE id = ?");
    $recipe_check->execute([$recipe_id]);
    if (!$recipe_check->fetch()) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Resep tidak ditemukan'
        ]);
        exit();
    }

    if ($action === 'add') {
        // Tambah ke favorit
        // Cek apakah sudah ada di favorit
        $check_existing = $pdo->prepare("SELECT id FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $check_existing->execute([$user_id, $recipe_id]);
        
        if ($check_existing->fetch()) {
            echo json_encode([
                'success' => false,
                'message' => 'Resep sudah ada di favorit Anda'
            ]);
            exit();
        }

        // Insert ke favorites
        $insert_favorite = $pdo->prepare("INSERT INTO favorites (user_id, recipe_id) VALUES (?, ?)");
        $insert_favorite->execute([$user_id, $recipe_id]);

        echo json_encode([
            'success' => true,
            'message' => 'Resep berhasil ditambahkan ke favorit'
        ]);

    } else { // action === 'remove'
        // Hapus dari favorit
        $delete_favorite = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND recipe_id = ?");
        $delete_favorite->execute([$user_id, $recipe_id]);

        if ($delete_favorite->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Resep berhasil dihapus dari favorit'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Resep tidak ditemukan di favorit Anda'
            ]);
        }
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan database: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ]);
}
?>