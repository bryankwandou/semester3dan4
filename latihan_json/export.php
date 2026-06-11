<?php
// Set response header to text/html with UTF-8
header('Content-Type: text/html; charset=utf-8');

$host = "localhost";
$user = "root";
$pass = "";

$flights = [];
$errors = [];

// 1. Fetch from Maskapai AA
$connAA = mysqli_connect($host, $user, $pass, 'maskapai_aa');
if ($connAA) {
    $queryAA = "SELECT id_penerbangan AS ID, dari AS `from`, ke AS `to`, jam_berangkat AS depart, jam_tiba AS arrive, harga AS price FROM tabel_penerbangan";
    $resultAA = mysqli_query($connAA, $queryAA);
    if ($resultAA) {
        while ($row = mysqli_fetch_assoc($resultAA)) {
            $flights[] = [
                "ID" => $row['ID'],
                "from" => $row['from'],
                "to" => $row['to'],
                "depart" => substr($row['depart'], 0, 5), // HH:MM
                "arrive" => substr($row['arrive'], 0, 5),  // HH:MM
                "price" => (string)$row['price']
            ];
        }
    } else {
        $errors[] = "Gagal mengambil data dari Maskapai AA: " . mysqli_error($connAA);
    }
    mysqli_close($connAA);
} else {
    $errors[] = "Gagal terhubung ke database Maskapai AA: " . mysqli_connect_error();
}

// 2. Fetch from Maskapai BB
$connBB = mysqli_connect($host, $user, $pass, 'maskapai_bb');
if ($connBB) {
    $queryBB = "SELECT f.flightID AS ID, f.from AS `from`, f.to AS `to`, ft.depart, ft.arrive, ft.price 
                FROM flight f 
                JOIN flightTime ft ON f.flightID = ft.flightID";
    $resultBB = mysqli_query($connBB, $queryBB);
    if ($resultBB) {
        while ($row = mysqli_fetch_assoc($resultBB)) {
            $flights[] = [
                "ID" => $row['ID'],
                "from" => $row['from'],
                "to" => $row['to'],
                "depart" => substr($row['depart'], 0, 5), // HH:MM
                "arrive" => substr($row['arrive'], 0, 5),  // HH:MM
                "price" => (string)$row['price']
            ];
        }
    } else {
        $errors[] = "Gagal mengambil data dari Maskapai BB: " . mysqli_error($connBB);
    }
    mysqli_close($connBB);
} else {
    $errors[] = "Gagal terhubung ke database Maskapai BB: " . mysqli_connect_error();
}

// 3. Fetch from Maskapai CC
$connCC = mysqli_connect($host, $user, $pass, 'maskapai_cc');
if ($connCC) {
    $queryCC = "SELECT p.kode_penerbangan AS ID, p.dari AS `from`, p.ke AS `to`, j.berangkat AS depart, j.tiba AS arrive, j.harga AS price 
                FROM penerbangan p 
                JOIN jadwal j ON p.kode_penerbangan = j.kode_penerbangan";
    $resultCC = mysqli_query($connCC, $queryCC);
    if ($resultCC) {
        while ($row = mysqli_fetch_assoc($resultCC)) {
            $flights[] = [
                "ID" => $row['ID'],
                "from" => $row['from'],
                "to" => $row['to'],
                "depart" => substr($row['depart'], 0, 5), // HH:MM
                "arrive" => substr($row['arrive'], 0, 5),  // HH:MM
                "price" => (string)$row['price']
            ];
        }
    } else {
        $errors[] = "Gagal mengambil data dari Maskapai CC: " . mysqli_error($connCC);
    }
    mysqli_close($connCC);
} else {
    $errors[] = "Gagal terhubung ke database Maskapai CC: " . mysqli_connect_error();
}

// Format the final data structure
$outputData = [
    "flight" => $flights
];

// Write to JSON file
$jsonFilename = 'flights.json';
$jsonContent = json_encode($outputData, JSON_PRETTY_PRINT);
$writeSuccess = false;

if (empty($errors)) {
    if (file_put_contents($jsonFilename, $jsonContent) !== false) {
        $writeSuccess = true;
    } else {
        $errors[] = "Gagal menulis file JSON ke disk.";
    }
}

// Return JSON response if requested via AJAX
if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    if ($writeSuccess) {
        echo json_encode(["status" => "success", "message" => "Export berhasil!"]);
    } else {
        echo json_encode(["status" => "error", "errors" => $errors]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Penerbangan</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1>Export Flight Data</h1>
            <p>Proses integrasi data dari maskapai AA, BB, dan CC ke format JSON.</p>
        </header>

        <main class="card">
            <?php if ($writeSuccess): ?>
                <div class="alert alert-success">
                    <h3>Export Berhasil!</h3>
                    <p>Seluruh data penerbangan telah digabungkan dan disimpan ke dalam file <strong>flights.json</strong>.</p>
                </div>
                <div class="json-preview">
                    <h4>Preview JSON:</h4>
                    <pre><code><?php echo htmlspecialchars($jsonContent); ?></code></pre>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <h3>Export Gagal</h3>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="action-buttons">
                <a href="index.php" class="btn btn-primary">Lihat Jadwal Penerbangan</a>
                <a href="export.php" class="btn btn-secondary">Export Ulang</a>
            </div>
        </main>
    </div>
</body>
</html>
