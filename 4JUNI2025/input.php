<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <title>Bootstrap Form</title>
 <meta charset="utf-8">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 <meta name="viewport" content="width=device-width, initialscale=1">
 <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<div class="container">
<h2>Input Data Anggota</h2>
<form class="form-horizontal" method="post"
action="input.php">
 <div class="form-group">
 <label class="control-label col-sm-2"
for="nama">Nama:</label>
 <div class="col-sm-4">
 <input type="text" class="form-control"
id="nama" placeholder="Masukkan Nama" name="nama">
 </div>
<label class="control-label col-sm-2"
for="nama">Kota:</label>
 <div class="col-sm-4">
 <input type="text" class="form-control"
id="kota" placeholder="Masukkan Kota" name="kota">
 </div>
 </div>
 <div class="form-group text-left">
 <label class="control-label col-sm-2"
for="email">Email:</label>
 <div class="col-sm-10">
 <input type="email" class="form-control"
id="email" placeholder="Masukkan Email" name="email">
 </div>
 </div>
 <div class="form-group">
 <label class="control-label col-sm-2"
for="jk">Jenis Kelamin:</label>
 <div class="col-sm-10">
 <label class="radio-inline" ><input
type="radio" id="jk" name="jk" value="Pria"> Pria</label>
<label class="radio-inline"><input
type="radio" id="jk" name="jk" value="Wanita"> Wanita</label>
 </div>
 </div>
<div class="form-group">
 <label class="control-label col-sm-2"
for="pendidikan">Pendidikan:</label>
 <div class="col-sm-10">
 <select class="form-control"
id="pendidikan" name="pendidikan">
<option value='-'>--Masukkan
Pendidikan--</option>
<option value='S1'>S1</option>
<option value='S2'>S2</option>
<option value='S3'>S3</option>
<option
value='lainnya'>Lainnya</option>
</select>
 </div>
 </div>
<div class="form-group">
 <label class="control-label col-sm-2"
for="ahli">Keahlian:</label>
 <div class="col-sm-10">
 <label class="checkbox-inline" ><input
type='checkbox' name='ahli1' value='Programming' id="ahli">
Programming</label>
<label class="checkbox-inline"
><input type='checkbox' name='ahli2' value='Networking' id="ahli">
Networking</label>
<label class="checkbox-inline"
><input type='checkbox' name='ahli3' value='Database' id="ahli">
Database</label>
<label class="checkbox-inline"
><input type='checkbox' name='ahli4' value='System' id="ahli">
System</label>
 </div>
 </div>
<div class="form-group">
 <label class="control-label col-sm-2"
for="pengalaman">Pengalaman:</label>
 <div class="col-sm-10">
 <textarea class="form-control" rows="5"
style="resize: none" id="pengalaman" name="pengalaman"></textarea>
 </div>
 </div>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn
btn-success" name="submit">Submit</button>
<button type="reset" class="btn
btn-warning">Reset</button>
</div>
</div>
 </div>
</form>
<div class="col-sm-10 col-sm-offset-1">






<?php
if (isset($_POST['submit'])) {
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $kota = isset($_POST['kota']) ? $_POST['kota'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $jk = isset($_POST['jk']) ? $_POST['jk'] : '';
    $pendidikan = isset($_POST['pendidikan']) ? $_POST['pendidikan'] : '';
    $pengalaman = isset($_POST['pengalaman']) ? $_POST['pengalaman'] : '';

    $keahlian = "";
    for ($i = 1; $i <= 4; $i++) {
        if (isset($_POST['ahli' . $i]) && !empty($_POST['ahli' . $i])) {
            $keahlian .= $_POST['ahli' . $i] . ", ";
        }
    }

    // Potong koma terakhir jika ada
    $keahlian = rtrim($keahlian, ", ");

    $queryinsert = mysqli_query($conn, "INSERT INTO tabel_user VALUES (
        '',
        '$nama',
        '$kota',
        '$email',
        '$jk',
        '$pendidikan',
        '$keahlian',
        '$pengalaman'
    )");

    if ($queryinsert) {
        echo '<div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Data Anggota Berhasil Diinput.
        </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Failed!</strong> Data Anggota Gagal Diinput.
        </div>';
    }
}

?>










</div>
<div class="table-responsive col-sm-10 col-sm-offset-1">
<h2>List Data Anggota</h2>
<table class="table table-striped ">
<thead>
<tr>
<th>ID</th>
<th>Nama</th>
<th>Kota</th>
<th>Email</th>
<th>Jenis Kelamin</th>
<th>Pendidikan</th>
<th>Keahlian</th>
<th>Pengalaman</th>
</tr>
</thead>
<tbody>





<?php
$queryanggota = mysqli_query($conn, "SELECT * FROM tabel_user ORDER BY id");

if (!$queryanggota) {
    echo "<tr><td colspan='8' class='danger'>Query Gagal: " . mysqli_error($conn) . "</td></tr>";
} else {
    $jumanggota = mysqli_num_rows($queryanggota);

    if ($jumanggota == 0) {
        echo "<tr><td colspan='8' class='danger'>Data Anggota Masih Kosong</td></tr>";
    } else {
        while ($anggota = mysqli_fetch_array($queryanggota)) {
            echo "<tr>
                    <td>{$anggota['id']}</td>
                    <td>{$anggota['nama']}</td>
                    <td>{$anggota['kota']}</td>
                    <td>{$anggota['email']}</td>
                    <td>{$anggota['jenis_kelamin']}</td>
                    <td>{$anggota['pendidikan']}</td>
                    <td>{$anggota['keahlian']}</td>
                    <td>{$anggota['pengalaman']}</td>
                  </tr>";
        }
    }
}

?>
</tbody>
</table>
</div>
</div>
</body>
</html>