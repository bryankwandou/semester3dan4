<?php

$hostmysql = "localhost";

$username = "root";

$password = "";

$database = "penjualan";

$conn = mysqli_connect($hostmysql, $username, $password);

if (!$conn) die ("Koneksi gagal");

mysqli_select_db($conn, $database) or die ("Database tidak ditemukan");

?>