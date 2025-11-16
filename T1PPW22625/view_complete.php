<?php
include "koneksi.php";
?>
<table border='1' cellspacing='0' cellpadding='5'>
<tr>
    <th>No.</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Email</th>
    <th>Pesan</th>
    <th>Aksi</th>
</tr>
<?php
$sql_select = "SELECT * FROM anggota ORDER BY no DESC";
$result_select = $conn->query($sql_select);

if ($result_select->num_rows > 0) {
    while ($anggota = $result_select->fetch_assoc()) {
        $jk = ($anggota['jenis_kelamin'] == 'L') ? 'Pria' : 'Wanita';
        ?>
        <tr>
            <td><?=$anggota['no']?></td>
            <td><?=$anggota['nama']?></td>
            <td><?=$jk?></td>
            <td><?=$anggota['email']?></td>
            <td><?=$anggota['pesan']?></td>
            <td>
                <button class="btn-edit" onclick="editData(<?=$anggota['no']?>)">Edit</button>
                <button class="btn-delete" onclick="deleteData(<?=$anggota['no']?>)">Delete</button>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td colspan="6" style="text-align: center;">Tidak ada data</td>
    </tr>
    <?php
}
?>
</table>