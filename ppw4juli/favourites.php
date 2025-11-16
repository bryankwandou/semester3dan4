<?php
// session_start();
// require_once 'config.php'; // Sesuaikan dengan file koneksi database Anda

// // Cek apakah user sudah login
// // if (!isset($_SESSION['user_id'])) {
// //     header('Content-Type: application/json');
// //     echo json_encode(['success' => false, 'message' => 'User tidak login']);
// //     exit();
// // }
// if (!isset($_SESSION['user_id'])) {
//     header("Location: akun.php");
//     exit();
// }

// $user_id = $_SESSION['user_id'];
// $action = $_POST['action'] ?? $_GET['action'] ?? '';

// header('Content-Type: application/json');

// try {
//     switch ($action) {
//         case 'add':
//             // Tambah resep ke favorit
//             $recipe_name = $_POST['recipe_name'] ?? '';
//             $recipe_slug = $_POST['recipe_slug'] ?? '';
//             $recipe_image = $_POST['recipe_image'] ?? '';
//             $recipe_category = $_POST['recipe_category'] ?? '';
//             $prep_time = $_POST['prep_time'] ?? '';
//             $cook_time = $_POST['cook_time'] ?? '';
//             $servings = $_POST['servings'] ?? '';
            
//             if (empty($recipe_name) || empty($recipe_slug)) {
//                 throw new Exception('Data resep tidak lengkap');
//             }
            
//             $stmt = $pdo->prepare("INSERT INTO user_favorites (user_id, recipe_name, recipe_slug, recipe_image, recipe_category, prep_time, cook_time, servings) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
//             $result = $stmt->execute([$user_id, $recipe_name, $recipe_slug, $recipe_image, $recipe_category, $prep_time, $cook_time, $servings]);
            
//             if ($result) {
//                 echo json_encode(['success' => true, 'message' => 'Resep berhasil ditambahkan ke favorit']);
//             } else {
//                 throw new Exception('Gagal menambahkan resep ke favorit');
//             }
//             break;
            
//         case 'remove':
//             // Hapus resep dari favorit
//             $recipe_slug = $_POST['recipe_slug'] ?? $_GET['recipe_slug'] ?? '';
            
//             if (empty($recipe_slug)) {
//                 throw new Exception('Recipe slug tidak ditemukan');
//             }
            
//             $stmt = $pdo->prepare("DELETE FROM user_favorites WHERE user_id = ? AND recipe_slug = ?");
//             $result = $stmt->execute([$user_id, $recipe_slug]);
            
//             if ($result) {
//                 echo json_encode(['success' => true, 'message' => 'Resep berhasil dihapus dari favorit']);
//             } else {
//                 throw new Exception('Gagal menghapus resep dari favorit');
//             }
//             break;
            
//         case 'check':
//             // Cek apakah resep sudah ada di favorit
//             $recipe_slug = $_GET['recipe_slug'] ?? '';
            
//             if (empty($recipe_slug)) {
//                 throw new Exception('Recipe slug tidak ditemukan');
//             }
            
//             $stmt = $pdo->prepare("SELECT COUNT(*) FROM user_favorites WHERE user_id = ? AND recipe_slug = ?");
//             $stmt->execute([$user_id, $recipe_slug]);
//             $count = $stmt->fetchColumn();
            
//             echo json_encode(['success' => true, 'is_favorite' => $count > 0]);
//             break;
            
//         case 'list':
//             // Ambil daftar resep favorit user
//             $stmt = $pdo->prepare("SELECT * FROM user_favorites WHERE user_id = ? ORDER BY created_at DESC");
//             $stmt->execute([$user_id]);
//             $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
//             echo json_encode(['success' => true, 'favorites' => $favorites]);
//             break;
            
//         default:
//             throw new Exception('Action tidak valid');
//     }
    
// } catch (PDOException $e) {
//     if ($e->getCode() == 23000) { // Duplicate entry
//         echo json_encode(['success' => false, 'message' => 'Resep sudah ada di favorit']);
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
//     }
// } catch (Exception $e) {
//     echo json_encode(['success' => false, 'message' => $e->getMessage()]);
// }
?>