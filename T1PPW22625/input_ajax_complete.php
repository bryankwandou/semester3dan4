<html>
<head>
<title>Form Input AJAX - Complete CRUD</title>
<script src="jquery-1.11.1.js"></script>
<style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .btn-edit { background-color: #4CAF50; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    .btn-delete { background-color: #f44336; color: white; padding: 5px 10px; border: none; cursor: pointer; }
    .btn-edit:hover { background-color: #45a049; }
    .btn-delete:hover { background-color: #da190b; }
    #info { margin-top: 20px; padding: 10px; }
    .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>
<script>
var editMode = false;
var editId = 0;

function resetForm() {
    $("#txtnama").val("");
    $("#jenis1").prop("checked", true);
    $("#txtemail").val("");
    $("#txtpesan").val("");
    editMode = false;
    editId = 0;
    $("#btnkirim").val("Kirim");
    $("#btncancel").hide();
}

function editData(id) {
    // Ambil data untuk edit
    $.ajax({
        type: "POST",
        url: "get_data.php",
        data: "id=" + id,
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $("#txtnama").val(data.nama);
                if(data.jenis_kelamin == 'L') {
                    $("#jenis1").prop("checked", true);
                } else {
                    $("#jenis2").prop("checked", true);
                }
                $("#txtemail").val(data.email);
                $("#txtpesan").val(data.pesan);
                editMode = true;
                editId = id;
                $("#btnkirim").val("Update");
                $("#btncancel").show();
            }
        },
        error: function() {
            $("#info").html('<div class="error">Terjadi kesalahan saat mengambil data.</div>');
        }
    });
}

function deleteData(id) {
    if(confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        $.ajax({
            type: "POST",
            url: "delete_data.php",
            data: "id=" + id,
            success: function(output) {
                $("#info").html('<div class="success">' + output + '</div>');
                loadData(); // Refresh data setelah delete
            },
            error: function() {
                $("#info").html('<div class="error">Terjadi kesalahan saat menghapus data.</div>');
            }
        });
    }
}

function loadData() {
    $.ajax({
        type: "POST",
        url: "view_complete.php",
        success: function(output) {
            $("#data-table").html(output);
        },
        error: function() {
            $("#info").html('<div class="error">Terjadi kesalahan saat memuat data.</div>');
        }
    });
}

$(document).ready(function(){
    // Load data saat halaman pertama kali dibuka
    loadData();
    
    $("#btnkirim").click(function(){
        var nama = $("#txtnama").val();
        var jenis = $('input:radio[name=jenis]:checked').val();
        var email = $("#txtemail").val();
        var pesan = $("#txtpesan").val();
        
        // Validasi form
        if(nama == "" || email == "") {
            $("#info").html('<div class="error">Nama dan Email harus diisi!</div>');
            return;
        }
        
        var url = editMode ? "update_data.php" : "proses.php";
        var data = editMode ? 
            "id=" + editId + "&txtnama=" + nama + "&jenis=" + jenis + "&txtemail=" + email + "&txtpesan=" + pesan :
            "btnkirim=Kirim&txtnama=" + nama + "&jenis=" + jenis + "&txtemail=" + email + "&txtpesan=" + pesan;
        
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            success: function(output) {
                $("#info").html('<div class="success">' + output + '</div>');
                resetForm();
                loadData(); // Refresh data setelah insert/update
            },
            error: function() {
                $("#info").html('<div class="error">Terjadi kesalahan. Silahkan coba lagi.</div>');
            }
        });
    });
    
    $("#btncancel").click(function(){
        resetForm();
    });
    
    $("#btnview").click(function(){
        loadData();
    });
});
</script>
</head>

<body>
<h2>Form Input Data Anggota</h2>
<form>
<table>
<tr>
    <td>Nama</td>
    <td>:</td>
    <td><input id='txtnama' type='text' size='25' maxlength='50'></td>
</tr>
<tr>
    <td>Jenis Kelamin</td>
    <td>:</td>
    <td>
        <input type='radio' value='L' name='jenis' id='jenis1' checked>Pria
        <input type='radio' value='P' name='jenis' id='jenis2'>Wanita
    </td>
</tr>
<tr>
    <td>Email</td>
    <td>:</td>
    <td><input id='txtemail' type='email' size='35' maxlength='50'></td>
</tr>
<tr>
    <td valign='top'>Pesan</td>
    <td valign='top'>:</td>
    <td><textarea id='txtpesan' cols='41' rows='3'></textarea></td>
</tr>
<tr>
    <td colspan='3' align='right'>
        <input id='btnkirim' type='button' value='Kirim'>
        <input id='btncancel' type='button' value='Batal' style='display: none;'>
        <input id='btnview' type='button' value='Refresh Data'>
        <input type='reset' id='reset' value='Reset'>
    </td>
</tr>
</table>
</form>

<div id='info'></div>

<h3>Data Anggota</h3>
<div id='data-table'></div>

</body>
</html>