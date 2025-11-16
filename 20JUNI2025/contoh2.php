<html>
<head>
<title>Form Input</title>
</head>
<body>
<form action='proses.php' method='post'>
<table>
<tr>
<td>Nama</td>
<td>:</td>
<td><input name='txtnama' type='text' size='25'
maxlength='50'></td>
</tr>
<tr>
<td>Jenis Kelamin</td>
<td>:</td>
<td>
<input type='radio' value='L' name='jenis'
checked>Pria
<input type='radio' value='P'
name='jenis'>Wanita
</td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input name='txtemail' type='email' size='35'
maxlength='50'></td>
</tr>
<tr>
<td valign='top'>Pesan</td>
<td valign='top'>:</td>
<td><textarea name='txtpesan' cols='41'
rows='3'></textarea></td>
</tr>
<tr>
<td colspan='3' align='right'>
<input name='btnkirim' type='submit'
value='Kirim'>
<input type='reset' value='Ulang'>
</td>
</tr>
</table>
</form>
</body>
</html>