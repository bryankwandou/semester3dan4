<?php
// MySQLi Object-Oriented
// buka koneksi ke database server
// sesuaikan dengan database sendiri
$servername = "localhost"; // sesuaikan
$username = "%"; // sesuaikan
$password = "nayrbryanGaming"; // sesuaikan
$database = "anggota"; // sesuaikan
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
die("Connection failed: ".$conn->connect_error);
}
?>