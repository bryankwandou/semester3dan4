<?php
echo "<h3>Hasil Penginputan Data</h3>";

$nama = $_POST['nama'] ?? '';
$kota = $_POST['kota'] ?? '';
$email = $_POST['email'] ?? '';
$jk = $_POST['jk'] ?? '-';
$pendidikan = $_POST['pendidikan'] ?? '-';
$pengalaman = $_POST['pengalaman'] ?? '';

// Cek apakah checkbox diisi atau tidak
$keahlian = [];
if (isset($_POST['ahli1'])) $keahlian[] = $_POST['ahli1'];
if (isset($_POST['ahli2'])) $keahlian[] = $_POST['ahli2'];
if (isset($_POST['ahli3'])) $keahlian[] = $_POST['ahli3'];
if (isset($_POST['ahli4'])) $keahlian[] = $_POST['ahli4'];

echo "Nama: $nama <br>";
echo "Kota: $kota <br>";
echo "Email: $email <br>";
echo "Jenis Kelamin: $jk <br>";
echo "Pendidikan: $pendidikan <br>";
echo "Keahlian: " . implode(", ", $keahlian) . "<br>";
echo "Pengalaman: <br>$pengalaman";
?>
