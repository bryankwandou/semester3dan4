<html>
<head>
<title>Form Input</title>
<script src="jquery-1.11.1.js"></script>
<script>
function resetForm()
{
//kalau ada tombol reset
$("#reset").click();
//kalau tidak ada, hilangkan komentar di bawah ini
/*
$("#txtnama").val("");
$("#jenis1").prop("checked", true)
$("#txtemail").val("");
$("#txtpesan").val("");
*/
}
$(document).ready(function(){
$("#btnkirim").click(function(){
 // ambil value data dari form
var nama = $("#txtnama").val();
var jenis =
$('input:radio[name=jenis]:checked').val();
var email = $("#txtemail").val();
var pesan = $("#txtpesan").val();
// kirim dengan metode POST ke proses.php
$.ajax({
type:"POST",
url:"proses.php",
data: "btnkirim=Kirim&txtnama=" + nama +
"&jenis=" + jenis + "&txtemail=" + email + "&txtpesan=" + pesan,
success: function(output){
$("#info").html(output);
resetForm();
},
error: function(){
$("#info").html("Terjadi Kesalahan.Silahkan Coba Lagi");
}
});
});
$("#btnview").click(function(){
// kirim dengan metode POST ke view.php
$.ajax({
type:"POST",
url:"view.php",
success: function(output){
$("#info").html(output);
},
error: function(){
$("#info").html("Terjadi Kesalahan.Silahkan Coba Lagi");
}
});
});
});
</script>
</head>
<body>
<form >
<table>
<tr>
<td>Nama</td>
<td>:</td>
<td><input id='txtnama' type='text' size='25'
maxlength='50'></td>
</tr>
<tr>
<td>Jenis Kelamin</td>
<td>:</td>
<td>
<input type='radio' value='L' name='jenis'
id='jenis1' checked>Pria
<input type='radio' value='P' name='jenis'
id='jenis2' >Wanita
</td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input id='txtemail' type='email' size='35'
maxlength='50'></td>
</tr>
<tr>
<td valign='top'>Pesan</td>
<td valign='top'>:</td>
<td><textarea id='txtpesan' cols='41'
rows='3'></textarea></td>
</tr>
<tr>
<td colspan='3' align='right'>
<input id='btnkirim' type='button'
value='Kirim'>
<input id='btnview' type='button'
value='Lihat'>
<input type='reset' id='reset'
value='Ulang'>
</td>
</tr>
</table>
</form>
<div id='info'></div>
</body>
</html>