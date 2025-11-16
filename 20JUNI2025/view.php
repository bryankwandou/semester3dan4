<table border='1' cellspacing='0' cellpadding='5'>
<tr>
<th>No.</th>
<th>Nama</th>
<th>Jenis Kelamin</th>
<th>Email</th>
<th>Pesan</th>
</tr>
<?php
include "koneksi.php";
$sql_select = "SELECT * FROM anggota";
$result_select = $conn->query($sql_select);
while ($anggota = $result_select->fetch_assoc()) {
?>
<tr>
<td><?=$anggota['no']?></td>
<td><?=$anggota['nama']?></td>
<td><?=$anggota['jenis_kelamin']?></td>
<td><?=$anggota['email']?></td>
<td><?=$anggota['pesan']?></td>
</tr>
<?php
}
?>
</table>