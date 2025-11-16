<?php
include "koneksi.php";

// Set header untuk JSON response
header('Content-Type: application/json');

// Function untuk membersihkan input
function cleanInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Function untuk response JSON
function jsonResponse($status, $message, $data = null) {
    return json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
}

// Cek action yang diminta
$action = isset($_POST['action']) ? $_POST['action'] : '';

switch($action) {
    case 'insert':
        // Insert data baru
        $nama = cleanInput($_POST['nama']);
        $jenis = cleanInput($_POST['jenis']);
        $email = cleanInput($_POST['email']);
        $pesan = cleanInput($_POST['pesan']);
        
        // Validasi input
        if(empty($nama) || empty($email)) {
            echo jsonResponse('error', 'Nama dan Email harus diisi!');
            exit;
        }
        
        // Cek email sudah ada atau belum
        $check_email = "SELECT email FROM anggota WHERE email = '$email'";
        $result_check = $conn->query($check_email);
        
        if($result_check->num_rows > 0) {
            echo jsonResponse('error', 'Email sudah terdaftar!');
            exit;
        }
        
        $sql_insert = "INSERT INTO anggota (nama, jenis_kelamin, email, pesan) VALUES ('$nama', '$jenis', '$email', '$pesan')";
        
        if($conn->query($sql_insert) === TRUE) {
            echo jsonResponse('success', 'Data berhasil ditambahkan!');
        } else {
            echo jsonResponse('error', 'Gagal menambahkan data: ' . $conn->error);
        }
        break;
        
    case 'view':
        // Tampilkan data
        echo '<div class="card">
                <div class="card-header">
                    <h2>📊 Data Anggota</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Pesan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>';
        
        $sql_select = "SELECT * FROM anggota ORDER BY no DESC";
        $result_select = $conn->query($sql_select);
        
        if($result_select->num_rows > 0) {
            $no = 1;
            while($anggota = $result_select->fetch_assoc()) {
                $jenis_kelamin = ($anggota['jenis_kelamin'] == 'L') ? '👨 Pria' : '👩 Wanita';
                $pesan_short = (strlen($anggota['pesan']) > 50) ? substr($anggota['pesan'], 0, 50) . '...' : $anggota['pesan'];
                
                echo '<tr>
                        <td>' . $no++ . '</td>
                        <td>' . htmlspecialchars($anggota['nama']) . '</td>
                        <td>' . $jenis_kelamin . '</td>
                        <td>' . htmlspecialchars($anggota['email']) . '</td>
                        <td>' . htmlspecialchars($pesan_short) . '</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="openEditModal(' . $anggota['no'] . ', \'' . addslashes($anggota['nama']) . '\', \'' . $anggota['jenis_kelamin'] . '\', \'' . addslashes($anggota['email']) . '\', \'' . addslashes($anggota['pesan']) . '\')">
                                ✏️ Edit
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="deleteData(' . $anggota['no'] . ', \'' . addslashes($anggota['nama']) . '\')">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>';
            }
        } else {
            echo '<tr>
                    <td colspan="6" style="text-align:center; padding:40px;">
                        <div style="color:#9ca3af;">
                            📝 Belum ada data anggota
                        </div>
                    </td>
                  </tr>';
        }
        
        echo '          </tbody>
                        </table>
                    </div>
                </div>
            </div>';
        break;
        
    case 'update':
        // Update data
        $id = cleanInput($_POST['id']);
        $nama = cleanInput($_POST['nama']);
        $jenis = cleanInput($_POST['jenis']);
        $email = cleanInput($_POST['email']);
        $pesan = cleanInput($_POST['pesan']);
        
        // Validasi input
        if(empty($nama) || empty($email)) {
            echo jsonResponse('error', 'Nama dan Email harus diisi!');
            exit;
        }
        
        // Cek apakah email sudah digunakan oleh anggota lain
        $check_email = "SELECT no FROM anggota WHERE email = '$email' AND no != '$id'";
        $result_check = $conn->query($check_email);
        
        if($result_check->num_rows > 0) {
            echo jsonResponse('error', 'Email sudah digunakan oleh anggota lain!');
            exit;
        }
        
        $sql_update = "UPDATE anggota SET 
                       nama = '$nama', 
                       jenis_kelamin = '$jenis', 
                       email = '$email', 
                       pesan = '$pesan' 
                       WHERE no = '$id'";
        
        if($conn->query($sql_update) === TRUE) {
            if($conn->affected_rows > 0) {
                echo jsonResponse('success', 'Data berhasil diupdate!');
            } else {
                echo jsonResponse('error', 'Tidak ada perubahan data atau data tidak ditemukan!');
            }
        } else {
            echo jsonResponse('error', 'Gagal mengupdate data: ' . $conn->error);
        }
        break;
        
    case 'delete':
        // Delete data
        $id = cleanInput($_POST['id']);
        
        // Cek apakah data ada
        $check_data = "SELECT nama FROM anggota WHERE no = '$id'";
        $result_check = $conn->query($check_data);
        
        if($result_check->num_rows == 0) {
            echo jsonResponse('error', 'Data tidak ditemukan!');
            exit;
        }
        
        $sql_delete = "DELETE FROM anggota WHERE no = '$id'";
        
        if($conn->query($sql_delete) === TRUE) {
            echo jsonResponse('success', 'Data berhasil dihapus!');
        } else {
            echo jsonResponse('error', 'Gagal menghapus data: ' . $conn->error);
        }
        break;
        
    case 'get_detail':
        // Get detail data untuk edit
        $id = cleanInput($_POST['id']);
        
        $sql_detail = "SELECT * FROM anggota WHERE no = '$id'";
        $result_detail = $conn->query($sql_detail);
        
        if($result_detail->num_rows > 0) {
            $data = $result_detail->fetch_assoc();
            echo jsonResponse('success', 'Data ditemukan', $data);
        } else {
            echo jsonResponse('error', 'Data tidak ditemukan!');
        }
        break;
        
    default:
        echo jsonResponse('error', 'Action tidak valid!');
        break;
}

// Tutup koneksi
$conn->close();
?>