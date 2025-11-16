<?php
include "koneksi.php";

if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = intval($_POST['id']);
    $nama = trim($_POST['txtnama']);
    $jenis = $_POST['jenis'];
    $email = trim($_POST['txtemail']);
    $pesan = trim($_POST['txtpesan']);
    
    // Validasi data
    if (empty($nama) || empty($email)) {
        echo "Nama dan Email harus diisi!";
        exit;
    }
    
    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid!";
        exit;
    }
    
    // Cek apakah email sudah digunakan oleh data lain
    $check_email = "SELECT no FROM anggota WHERE email = ? AND no != ?";
    $stmt_check = $conn->prepare($check_email);
    
    if ($stmt_check) {
        $stmt_check->bind_param("si", $email, $id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            echo "Email sudah digunakan oleh data lain!";
            $stmt_check->close();
            exit;
        }
        
        $stmt_check->close();
    }
    
    // Update data
    $sql = "UPDATE anggota SET nama = ?, jenis_kelamin = ?, email = ?, pesan = ? WHERE no = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssssi", $nama, $jenis, $email, $pesan, $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Data berhasil diupdate!";
            } else {
                echo "Tidak ada perubahan data atau data tidak ditemukan!";
            }
        } else {
            echo "Gagal mengupdate data: " . $conn->error;
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