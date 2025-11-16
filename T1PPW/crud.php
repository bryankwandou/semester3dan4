<?php
include "koneksi.php";

$action = $_POST['action'];

if ($action == "save") {
  $no     = $_POST['no'];
  $nama   = $_POST['nama'];
  $jk     = $_POST['jenis_kelamin'];
  $email  = $_POST['email'];
  $pesan  = $_POST['pesan'];

  if ($no == "") {
    $stmt = $conn->prepare("INSERT INTO anggota (nama, jenis_kelamin, email, pesan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $jk, $email, $pesan);
    echo $stmt->execute() ? "Data berhasil ditambahkan!" : "Gagal menambah data.";
  } else {
    $stmt = $conn->prepare("UPDATE anggota SET nama=?, jenis_kelamin=?, email=?, pesan=? WHERE no=?");
    $stmt->bind_param("ssssi", $nama, $jk, $email, $pesan, $no);
    echo $stmt->execute() ? "Data berhasil diupdate!" : "Gagal mengupdate data.";
  }

} elseif ($action == "view") {
  $res = $conn->query("SELECT * FROM anggota");
  echo "<table><tr><th>No</th><th>Nama</th><th>JK</th><th>Email</th><th>Pesan</th><th>Aksi</th></tr>";
  while ($row = $res->fetch_assoc()) {
    echo "<tr>
      <td>{$row['no']}</td>
      <td>{$row['nama']}</td>
      <td>{$row['jenis_kelamin']}</td>
      <td>{$row['email']}</td>
      <td>{$row['pesan']}</td>
      <td>
        <button onclick='editData({$row['no']})' class='btn'>Edit</button>
        <button onclick='deleteData({$row['no']})' class='btn'>Delete</button>
      </td>
    </tr>";
  }
  echo "</table>";

} elseif ($action == "get") {
  $no = $_POST['no'];
  $res = $conn->query("SELECT * FROM anggota WHERE no=$no");
  echo json_encode($res->fetch_assoc());

} elseif ($action == "delete") {
  $no = $_POST['no'];
  $del = $conn->query("DELETE FROM anggota WHERE no=$no");
  echo $del ? "Data berhasil dihapus!" : "Gagal menghapus data.";
}
?>
