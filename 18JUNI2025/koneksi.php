<?php
// MySQLi Object-Oriented
// buka koneksi ke database server
// sesuaikan dengan database sendiri
$servername = "localhost"; // sesuaikan
$username = "root"; // sesuaikan
$password = ""; // sesuaikan
$database = "18JUNI2025"; // sesuaikan
// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
die("Connection failed: ".$conn->connect_error);
}
?>