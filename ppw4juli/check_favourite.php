<?php
require_once 'auth.php';
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: akun.php");
    exit();
}

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['is_favorite' => false]);
    exit();
}

$recipe_id = isset($_GET['recipe_id']) ? (int)$_GET['recipe_id'] : 0;

if ($recipe_id <= 0) {
    echo json_encode(['is_favorite' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $query = "SELECT id FROM favorites WHERE user_id = ? AND recipe_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $recipe_id]);
    
    $is_favorite = $stmt->fetch() ? true : false;
    
    echo json_encode(['is_favorite' => $is_favorite]);
    
} catch (PDOException $e) {
    echo json_encode(['is_favorite' => false]);
}
?>