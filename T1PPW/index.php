<!DOCTYPE html>
<html>
<head>
  <title>CRUD AJAX PHP</title>
  <script src="assets/jquery.js"></script>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    input, textarea { width: 100%; }
    .btn { padding: 5px 10px; cursor: pointer; }
  </style>
</head>
<body>

<h2>Form Pendaftaran</h2>
<form id="formData">
  <input type="hidden" id="no" name="no">
  <label>Nama:</label><br>
  <input type="text" id="nama" name="nama"><br>
  <label>Jenis Kelamin:</label><br>
  <input type="radio" name="jenis_kelamin" value="L" checked> Laki-laki
  <input type="radio" name="jenis_kelamin" value="P"> Perempuan<br>
  <label>Email:</label><br>
  <input type="email" id="email" name="email"><br>
  <label>Pesan:</label><br>
  <textarea id="pesan" name="pesan"></textarea><br><br>
  <button type="submit" class="btn">Simpan</button>
  <button type="reset" class="btn">Reset</button>
</form>

<h2>Data Anggota</h2>
<div id="tabelData"></div>

<script>
function loadData() {
  $.post("crud.php", { action: "view" }, function(data) {
    $("#tabelData").html(data);
  });
}

$("#formData").on("submit", function(e) {
  e.preventDefault();
  const formData = $(this).serialize() + "&action=save";
  $.post("crud.php", formData, function(response) {
    alert(response);
    $("#formData")[0].reset();
    loadData();
  });
});

function editData(no) {
  $.post("crud.php", { action: "get", no: no }, function(data) {
    const obj = JSON.parse(data);
    $("#no").val(obj.no);
    $("#nama").val(obj.nama);
    $("input[name='jenis_kelamin'][value='" + obj.jenis_kelamin + "']").prop("checked", true);
    $("#email").val(obj.email);
    $("#pesan").val(obj.pesan);
  });
}

function deleteData(no) {
  if (confirm("Hapus data ini?")) {
    $.post("crud.php", { action: "delete", no: no }, function(response) {
      alert(response);
      loadData();
    });
  }
}

$(document).ready(function() {
  loadData();
});
</script>

</body>
</html>
