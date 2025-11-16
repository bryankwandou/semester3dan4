<?php
include "koneksi.php";

// Set header untuk JSON response
header('Content-Type: application/json');

// Handle different actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'add':
            addData();
            break;
        case 'view':
            viewData();
            break;
        case 'get':
            getData();
            break;
        case 'update':
            updateData();
            break;
        case 'delete':
            deleteData();
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Action tidak valid']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Action tidak ditemukan']);
}

function addData() {
    global $conn;
    
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
    
    // Validasi input
    if (empty($nama) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Nama dan Email harus diisi']);
        return;
    }
    
    // Check if email already exists
    $check_email = "SELECT no FROM anggota WHERE email = '$email'";
    $result_check = $conn->query($check_email);
    
    if ($result_check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email sudah terdaftar']);
        return;
    }
    
    $insertdb = "INSERT INTO anggota (nama, jenis_kelamin, email, pesan) VALUES ('$nama', '$jenis', '$email', '$pesan')";
    
    if ($conn->query($insertdb) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil ditambahkan']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan data: ' . $conn->error]);
    }
}

function viewData() {
    global $conn;
    
    $sql_select = "SELECT * FROM anggota ORDER BY no DESC";
    $result_select = $conn->query($sql_select);
    
    if ($result_select->num_rows > 0) {
        echo "<table class='data-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>No.</th>";
        echo "<th>Nama</th>";
        echo "<th>Jenis Kelamin</th>";
        echo "<th>Email</th>";
        echo "<th>Pesan</th>";
        echo "<th>Aksi</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        while ($anggota = $result_select->fetch_assoc()) {
            $jenis_kelamin_text = ($anggota['jenis_kelamin'] == 'L') ? '👨 Laki-laki' : '👩 Perempuan';
            
            echo "<tr>";
            echo "<td>" . $anggota['no'] . "</td>";
            echo "<td>" . htmlspecialchars($anggota['nama']) . "</td>";
            echo "<td>" . $jenis_kelamin_text . "</td>";
            echo "<td>" . htmlspecialchars($anggota['email']) . "</td>";
            echo "<td>" . htmlspecialchars(substr($anggota['pesan'], 0, 50)) . (strlen($anggota['pesan']) > 50 ? '...' : '') . "</td>";
            echo "<td>";
            echo "<button onclick='editData(" . $anggota['no'] . ")' class='btn btn-warning btn-sm' style='margin-right: 5px;'>✏️ Edit</button>";
            echo "<button onclick='deleteData(" . $anggota['no'] . ", \"" . htmlspecialchars($anggota['nama']) . "\")' class='btn btn-danger btn-sm'>🗑️ Hapus</button>";
            echo "</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
        
        echo "<div style='margin-top: 15px; padding: 10px; background: #e9ecef; border-radius: 5px; text-align: center;'>";
        echo "<small><strong>📊 Total Data: " . $result_select->num_rows . " anggota</strong></small>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-info' style='text-align: center; padding: 40px;'>";
        echo "📭 <strong>Belum ada data anggota.</strong><br>";
        echo "<small>Silakan tambahkan anggota baru menggunakan form di samping.</small>";
        echo "</div>";
    }
}

function getData() {
    global $conn;
    
    $id = (int)$_POST['id'];
    
    $sql_select = "SELECT * FROM anggota WHERE no = $id";
    $result_select = $conn->query($sql_select);
    
    if ($result_select->num_rows > 0) {
        $data = $result_select->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }
}

function updateData() {
    global $conn;
    
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);
    
    // Validasi input
    if (empty($nama) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Nama dan Email harus diisi']);
        return;
    }
    
    // Check if email already exists (exclude current record)
    $check_email = "SELECT no FROM anggota WHERE email = '$email' AND no != $id";
    $result_check = $conn->query($check_email);
    
    if ($result_check->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email sudah digunakan oleh anggota lain']);
        return;
    }
    
    $updatedb = "UPDATE anggota SET nama = '$nama', jenis_kelamin = '$jenis', email = '$email', pesan = '$pesan' WHERE no = $id";
    
    if ($conn->query($updatedb) === TRUE) {
        if ($conn->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada perubahan data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data: ' . $conn->error]);
    }
}

function deleteData() {
    global $conn;
    
    $id = (int)$_POST['id'];
    
    // Check if data exists
    $check_data = "SELECT nama FROM anggota WHERE no = $id";
    $result_check = $conn->query($check_data);
    
    if ($result_check->num_rows == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        return;
    }
    
    $deletedb = "DELETE FROM anggota WHERE no = $id";
    
    if ($conn->query($deletedb) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Data berhasil dihapus']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data: ' . $conn->error]);
    }
}
?>