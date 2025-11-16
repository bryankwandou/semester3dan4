<?php
/**
 * File Debug untuk Testing Koneksi dan Troubleshooting
 */

echo "<h2>Debug Information</h2>";

// Test 1: Cek koneksi database
echo "<h3>1. Test Koneksi Database</h3>";
try {
    include "koneksi.php";
    echo "✅ Koneksi database berhasil<br>";
    echo "Database: " . $conn->get_server_info() . "<br>";
} catch (Exception $e) {
    echo "❌ Koneksi database gagal: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Cek tabel anggota
echo "<h3>2. Test Tabel Anggota</h3>";
$result = $conn->query("SHOW TABLES LIKE 'anggota'");
if ($result->num_rows > 0) {
    echo "✅ Tabel anggota ditemukan<br>";
} else {
    echo "❌ Tabel anggota tidak ditemukan<br>";
}

// Test 3: Cek struktur tabel
echo "<h3>3. Struktur Tabel</h3>";
$result = $conn->query("DESCRIBE anggota");
if ($result) {
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . ($value ? $value : 'NULL') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

// Test 4: Cek data dalam tabel
echo "<h3>4. Data Dalam Tabel</h3>";
$result = $conn->query("SELECT COUNT(*) as total FROM anggota");
if ($result) {
    $row = $result->fetch_assoc();
    echo "Total data: " . $row['total'] . " record<br>";
    
    if ($row['total'] > 0) {
        echo "<h4>Sample Data:</h4>";
        $sample = $conn->query("SELECT * FROM anggota LIMIT 3");
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>No</th><th>Nama</th><th>Jenis Kelamin</th><th>Email</th><th>Pesan</th></tr>";
        while ($data = $sample->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $data['no'] . "</td>";
            echo "<td>" . $data['nama'] . "</td>";
            echo "<td>" . $data['jenis_kelamin'] . "</td>";
            echo "<td>" . $data['email'] . "</td>";
            echo "<td>" . substr($data['pesan'], 0, 50) . "...</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Test 5: Cek file-file yang diperlukan
echo "<h3>5. File Dependencies</h3>";
$files = [
    'koneksi.php',
    'proses.php',
    'get_data.php',
    'update_data.php',
    'delete_data.php',
    'view_complete.php',
    'jquery-1.11.1.js'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ $file<br>";
    } else {
        echo "❌ $file (tidak ditemukan)<br>";
    }
}

// Test 6: PHP Configuration
echo "<h3>6. PHP Configuration</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "MySQL Extension: " . (extension_loaded('mysqli') ? '✅ Loaded' : '❌ Not loaded') . "<br>";
echo "JSON Extension: " . (extension_loaded('json') ? '✅ Loaded' : '❌ Not loaded') . "<br>";

// Test 7: Test AJAX endpoints
echo "<h3>7. Test AJAX Endpoints</h3>";
echo "<button onclick='testGetData()'>Test Get Data</button> ";
echo "<button onclick='testInsert()'>Test Insert</button> ";
echo "<button onclick='testUpdate()'>Test Update</button> ";
echo "<button onclick='testDelete()'>Test Delete</button><br><br>";
echo "<div id='test-result'></div>";

?>

<script src="jquery-1.11.1.js"></script>
<script>
function testGetData() {
    $.ajax({
        type: "POST",
        url: "get_data.php",
        data: "id=1",
        success: function(response) {
            $("#test-result").html("<strong>Get Data Response:</strong><br><pre>" + response + "</pre>");
        },
        error: function(xhr, status, error) {
            $("#test-result").html("<strong>Get Data Error:</strong><br>" + error);
        }
    });
}

function testInsert() {
    $.ajax({
        type: "POST",
        url: "proses.php",
        data: "btnkirim=Kirim&txtnama=Test User&jenis=L&txtemail=test" + Date.now() + "@test.com&txtpesan=Test message",
        success: function(response) {
            $("#test-result").html("<strong>Insert Response:</strong><br>" + response);
        },
        error: function(xhr, status, error) {
            $("#test-result").html("<strong>Insert Error:</strong><br>" + error);
        }
    });
}

function testUpdate() {
    $.ajax({
        type: "POST",
        url: "update_data.php",
        data: "id=1&txtnama=Updated User&jenis=L&txtemail=updated@test.com&txtpesan=Updated message",
        success: function(response) {
            $("#test-result").html("<strong>Update Response:</strong><br>" + response);
        },
        error: function(xhr, status, error) {
            $("#test-result").html("<strong>Update Error:</strong><br>" + error);
        }
    });
}

function testDelete() {
    if (confirm("This will delete a test record. Continue?")) {
        $.ajax({
            type: "POST",
            url: "delete_data.php",
            data: "id=999", // ID yang tidak ada
            success: function(response) {
                $("#test-result").html("<strong>Delete Response:</strong><br>" + response);
            },
            error: function(xhr, status, error) {
                $("#test-result").html("<strong>Delete Error:</strong><br>" + error);
            }
        });
    }
}
</script>

<?php
$conn->close();
?>