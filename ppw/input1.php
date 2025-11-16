<!DOCTYPE html>
<html lang="en">
<head>
 <title>Bootstrap Form</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initialscale=1">
 <link rel="stylesheet" href="bootstrap.min.css">
 <script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<h2>Input Data</h2>
<form class="form-horizontal" method="post"
action="input1.php">
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
<option
value='S1'>S1</option>
<option
value='S2'>S2</option>
<option
value='S3'>S3</option>
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
btn-primary" name="submit">Submit</button>
<button type="reset" class="btn
btn-danger">Reset</button>
</div>
</div>
 </div>
</form>
<?php
if (isset($_POST['submit']))
{
$nama = $_POST['nama'];
$kota = $_POST['kota'];
$email = $_POST['email'];
$jk = $_POST['jk'];
$pendidikan = $_POST['pendidikan'];
$keahlian = "";
for ($i=1;$i<=4;$i++)
{
$ahli = $_POST['ahli'.$i];
if (!empty($ahli))
$keahlian .= $ahli.", ";
}
$pengalaman = $_POST['pengalaman'];
?>
<div class="row col-sm-offset-2 col-sm-10">
<h2>Input Data</h2>
<div class="panel-group col-sm-10">
<div class="panel panel-success">
<div class="panel-heading">Hasil
Penginputan Data</div>
<div class="panel-body">
<div class="row">
<label class="control-label
col-sm-2" for="nama">Nama:</label>
<div class="col-sm-10">
<?=$nama?>
</div>
</div>
<div class="row">
<label class="control-label
col-sm-2" for="nama">Kota:</label>
<div class="col-sm-10">
<?php echo $kota; ?>
</div>
</div>
<div class="row">
<label class="control-label
col-sm-2" for="nama">Email:</label>
<div class="col-sm-10">
<?php echo $email; ?>
</div>
</div>
<div class="row">
<label class="control-label
col-sm-2" for="nama">Jenis Kelamin:</label>
<div class="col-sm-10">
<?=$jk?>
</div>
</div>
<div class="row">
<label class="control-label
col-sm-2" for="nama">Pendidikan:</label>
<div class="col-sm-10">
<?=$pendidikan?>
</div>
</div>
<div class="row">
<label class="control-label
col-sm-2" for="nama">Keahlian:</label>
<div class="col-sm-10">
<?=$keahlian?>
</div>
</div>
<div class="row">
<label class="control-label
col-sm-2" for="nama">Pengalaman:</label>
<div class="col-sm-10">
<?=$pengalaman?>
</div>
</div>
</div>
<div class="panel-footer">Belajar
PHP</div>
</div>
</div>
</div>
<?php
}
?>
</div>
</body>
</html>