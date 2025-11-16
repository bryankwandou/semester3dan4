<?php
include "koneksi.php";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Cek apakah data dengan ID tersebut ada
    $check_sql = "SELECT no FROM anggota WHERE no = ?";
    $stmt_check = $conn->prepare($check_sql);
    
    if ($stmt_check) {
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows == 0) {
            echo "Data tidak ditemukan!";
            $stmt_check->close();
            exit;
        }
        
        $stmt_check->close();
    }
    
    // Hapus data
    $sql = "DELETE FROM anggota WHERE no = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Data berhasil dihapus!";
            } else {
                echo "Gagal menghapus data!";
            }
        } else {
            echo "Gagal menghapus data: " . $conn->error;
        }
        
        $stmt->close();
    } else {
        echo "Query error: " . $conn->error;
    }
} else {
    echo "ID tidak valid!";
}

$conn->close();
?>