<?php
include "koneksi.php";
if (isset($_POST['btnkirim']))
{
$nama = $_POST['txtnama'];
$jenis = $_POST['jenis'];
$email = $_POST['txtemail'];
$pesan = $_POST['txtpesan'];
$insertdb = "INSERT INTO anggota VALUES
('','$nama','$jenis','$email','$pesan')";
if ($conn->query($insertdb) === TRUE)
{
echo "Data Berhasil Dimasukkan ke Database";
}
else
{
echo "Data Gagal Dimasukkan ke Database";
}
}
?>