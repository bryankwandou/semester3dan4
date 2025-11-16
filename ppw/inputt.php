<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Input Data Anggota</h2>
    <form class="form-horizontal" method="post" action="input.php">
        <div class="form-group">
            <label class="control-label col-sm-2" for="nama">Nama:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama" name="nama" required>
            </div>
            <label class="control-label col-sm-2" for="kota">Kota:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="kota" placeholder="Masukkan Kota" name="kota" required>
            </div>
        </div>
        
        <div class="form-group text-left">
            <label class="control-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" placeholder="Masukkan Email" name="email" required>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="jk">Jenis Kelamin:</label>
            <div class="col-sm-10">
                <label class="radio-inline">
                    <input type="radio" name="jk" value="Pria" required> Pria
                </label>
                <label class="radio-inline">
                    <input type="radio" name="jk" value="Wanita" required> Wanita
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="pendidikan">Pendidikan:</label>
            <div class="col-sm-10">
                <select class="form-control" id="pendidikan" name="pendidikan" required>
                    <option value=''>--Masukkan Pendidikan--</option>
                    <option value='S1'>S1</option>
                    <option value='S2'>S2</option>
                    <option value='S3'>S3</option>
                    <option value='lainnya'>Lainnya</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="ahli">Keahlian:</label>
            <div class="col-sm-10">
                <label class="checkbox-inline">
                    <input type='checkbox' name='ahli1' value='Programming'> Programming
                </label>
                <label class="checkbox-inline">
                    <input type='checkbox' name='ahli2' value='Networking'> Networking
                </label>
                <label class="checkbox-inline">
                    <input type='checkbox' name='ahli3' value='Database'> Database
                </label>
                <label class="checkbox-inline">
                    <input type='checkbox' name='ahli4' value='System'> System
                </label>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="pengalaman">Pengalaman:</label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="5" style="resize: none" id="pengalaman" name="pengalaman"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success" name="submit">Submit</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </div>
    </form>

    <div class="col-sm-10 col-sm-offset-1">
        <?php
        if (isset($_POST['submit'])) {
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $kota = mysqli_real_escape_string($conn, $_POST['kota']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $jk = mysqli_real_escape_string($conn, $_POST['jk']);
            $pendidikan = mysqli_real_escape_string($conn, $_POST['pendidikan']);
            
            $keahlian = "";
            for ($i = 1; $i <= 4; $i++) {
                if (isset($_POST['ahli'.$i]) && !empty($_POST['ahli'.$i])) {
                    $ahli = mysqli_real_escape_string($conn, $_POST['ahli'.$i]);
                    $keahlian .= $ahli . ", ";
                }
            }
            $keahlian = rtrim($keahlian, ", "); // Menghapus koma terakhir
            
            $pengalaman = mysqli_real_escape_string($conn, $_POST['pengalaman']);
            
            $sql = "INSERT INTO tabel_user (nama, kota, email, jenis_kelamin, pendidikan, keahlian, pengalaman) 
                    VALUES ('$nama', '$kota', '$email', '$jk', '$pendidikan', '$keahlian', '$pengalaman')";
            
            if ($conn->query($sql) === TRUE) {
                ?>
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> Data Anggota Berhasil Diinput.
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong> Data Anggota Gagal Diinput. Error: <?php echo $conn->error; ?>
                </div>
                <?php
            }
        }

        if (isset($_GET['hapus'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $querydelete = "DELETE FROM tabel_user WHERE id='$id'";
            
            if ($conn->query($querydelete) === TRUE) {
                ?>
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> Data Anggota Berhasil Dihapus.
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong> Data Anggota Gagal Dihapus. Error: <?php echo $conn->error; ?>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <div class="table-responsive col-sm-10 col-sm-offset-1">
        <h2>List Data Anggota</h2>
        <table class="table table-striped">
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
                    <th colspan='2'><center>Action</center></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_select = "SELECT * FROM tabel_user ORDER BY nama";
                $result_select = $conn->query($sql_select);
                
                if ($result_select->num_rows === 1) {
                    ?>
                    <tr>
                        <td colspan="10" class="danger">Data Anggota Masih Kosong</td>
                    </tr>
                    <?php
                } else {
                    while ($anggota = $result_select->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($anggota['id']) ?></td>
                            <td><?= htmlspecialchars($anggota['nama']) ?></td>
                            <td><?= htmlspecialchars($anggota['kota']) ?></td>
                            <td><?= htmlspecialchars($anggota['email']) ?></td>
                            <td><?= htmlspecialchars($anggota['jenis_kelamin']) ?></td>
                            <td><?= htmlspecialchars($anggota['pendidikan']) ?></td>
                            <td><?= htmlspecialchars($anggota['keahlian']) ?></td>
                            <td><?= htmlspecialchars($anggota['pengalaman']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= htmlspecialchars($anggota['id']) ?>">
                                    <button type="button" class="btn btn-sm btn-info">Edit</button>
                                </a>
                            </td>
                            <td>
                                <a href="input.php?hapus=ok&id=<?= htmlspecialchars($anggota['id']) ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <button type="button" class="btn btn-sm btn-danger">Hapus</button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>