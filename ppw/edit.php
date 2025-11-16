<?php
include "koneksi.php";
$id = $_GET['id'];
$sql_select = "SELECT * FROM tabel_user WHERE id='$id'";
$query_select = $conn->query($sql_select);
$info = $query_select->fetch_assoc()
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <title>Bootstrap Form</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initialscale=1">
 <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<div class="container">
<h2>Edit Data Anggota</h2>
<form class="form-horizontal" method="post"
action="edit.php">
 <input type='hidden' name='id' id='id'
value='<?=$id?>'>
<div class="form-group">
 <label class="control-label col-sm-2"
for="nama">Nama:</label>
 <div class="col-sm-4">
 <input type="text" class="form-control"
id="nama" placeholder="Masukkan Nama" name="nama"
value="<?=$info['nama']?>">
 </div>
<label class="control-label col-sm-2"
for="nama">Kota:</label>
 <div class="col-sm-4">
 <input type="text" class="form-control"
id="kota" placeholder="Masukkan Kota" name="kota"
value="<?=$info['kota']?>">
 </div>
 </div>
 <div class="form-group text-left">
 <label class="control-label col-sm-2"
for="email">Email:</label>
 <div class="col-sm-10">
 <input type="email" class="form-control"
id="email" placeholder="Masukkan Email" name="email"
value="<?=$info['email']?>">
 </div>
 </div>
 <div class="form-group">
 <label class="control-label col-sm-2"
for="jk">Jenis Kelamin:</label>
 <div class="col-sm-10">
 <label class="radio-inline" ><input
type="radio" id="jk" name="jk" value="Pria" <?php if
($info['jenis_kelamin'] == "Pria") echo "checked"; ?>> Pria</label>
<label class="radio-inline"><input
type="radio" id="jk" name="jk" value="Wanita" <?php if
($info['jenis_kelamin'] == "Wanita") echo "checked"; ?>>
Wanita</label>
 </div>
 </div>
<div class="form-group">
 <label class="control-label col-sm-2"
for="pendidikan">Pendidikan:</label>
 <div class="col-sm-10">
 <select class="form-control"
id="pendidikan" name="pendidikan">
<option value='-' <?php if
($info['pendidikan'] == "-") echo "selected"; ?>>--Masukkan
Pendidikan--</option>
<option value='S1' <?php if
($info['pendidikan'] == "S1") echo "selected"; ?>>S1</option>
<option value='S2' <?php if
($info['pendidikan'] == "S2") echo "selected"; ?>>S2</option>
<option value='S3' <?php if
($info['pendidikan'] == "S3") echo "selected"; ?>>S3</option>
<option value='lainnya' <?php
if ($info['pendidikan'] == "lainnya") echo "selected";
?>>Lainnya</option>
</select>
 </div>
 </div>
<div class="form-group">
 <label class="control-label col-sm-2"
for="ahli">Keahlian:</label>
 <div class="col-sm-10">
 <label class="checkbox-inline" ><input
type='checkbox' name='ahli1' value='Programming' id="ahli" <?php if
(ereg("Programming", $info['keahlian'])) echo "checked"; ?>>
Programming</label>
<label class="checkbox-inline"
><input type='checkbox' name='ahli2' value='Networking' id="ahli"
<?php if (ereg("Networking", $info['keahlian'])) echo "checked"; ?>>
Networking</label>
<label class="checkbox-inline"
><input type='checkbox' name='ahli3' value='Database' id="ahli"
<?php if (ereg("Database", $info['keahlian'])) echo "checked"; ?>>
Database</label>
<label class="checkbox-inline"
><input type='checkbox' name='ahli4' value='System' id="ahli" <?php
if (ereg("System", $info['keahlian'])) echo "checked"; ?>>
System</label>
 </div>
 </div>
<div class="form-group">
 <label class="control-label col-sm-2"
for="pengalaman">Pengalaman:</label>
 <div class="col-sm-10">
 <textarea class="form-control" rows="5"
style="resize: none" id="pengalaman"
name="pengalaman"><?=$info['pengalaman']?></textarea>
 </div>
 </div>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn
btn-success" name="edit">Edit</button>
<button type="reset" class="btn
btn-warning">Reset</button>
</div>
</div>
 </div>
</form>
<div class="col-sm-10 col-sm-offset-1">
<?php
if (isset($_POST['edit']))
{
$id = $_POST['id'];
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
$queryedit = "UPDATE tabel_user SET
nama='$nama', kota='$kota', email='$email', jenis_kelamin='$jk',
pendidikan='$pendidikan', keahlian='$keahlian',
pengalaman='$pengalaman' WHERE id='$id'";
if ($conn->query($queryedit) === TRUE)
{
?>
<div class="alert alert-success alertdismissable">
<a href="#" class="close" datadismiss="alert" aria-label="close">&times;</a>
<strong>Success!</strong> Data
Anggota Berhasil Diedit. Klik <a href="input.php">disini</a> untuk
Input Data Baru.
</div>
<?php
}
else
{
?>
<div class="alert alert-ddanger alertdismissable">
<a href="#" class="close" datadismiss="alert" aria-label="close">&times;</a>
<strong>Failed!</strong> Data
Anggota Gagal Diedit.
</div>
<?php
}
}
?>
</div>
</div>
</body>
</html>