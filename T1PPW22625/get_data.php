<?php
include "koneksi.php";

// Set header untuk JSON response
header('Content-Type: application/json');

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $sql = "SELECT * FROM anggota WHERE no = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response = array(
                'success' => true,
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'email' => $data['email'],
                'pesan' => $data['pesan']
            );
        } else {
            $response = array('success' => false, 'message' => 'Data tidak ditemukan');
        }
        
        $stmt->close();
    } else {
        $response = array('success' => false, 'message' => 'Query error: ' . $conn->error);
    }
} else {
    $response = array('success' => false, 'message' => 'ID tidak valid');
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
$conn->close();
?>