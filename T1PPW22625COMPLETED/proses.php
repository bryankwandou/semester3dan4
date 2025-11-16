<?php
include "koneksi.php";

if (isset($_POST['btnkirim'])) {
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
    
    // Cek apakah email sudah ada
    $check_email = "SELECT no FROM anggota WHERE email = ?";
    $stmt_check = $conn->prepare($check_email);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        echo "Email sudah terdaftar! Silakan gunakan email lain.";
        $stmt_check->close();
        exit;
    }
    
    $stmt_check->close();
    
    // Insert data menggunakan prepared statement
    $insertdb = "INSERT INTO anggota (nama, jenis_kelamin, email, pesan) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertdb);
    $stmt->bind_param("ssss", $nama, $jenis, $email, $pesan);
    
    if ($stmt->execute()) {
        echo "Data berhasil disimpan!";
    } else {
        echo "Gagal menyimpan data: " . $conn->error;
    }
    
    $stmt->close();
} else {
    echo "Request tidak valid!";
}

$conn->close();
?>