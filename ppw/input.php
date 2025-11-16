<?php
include "koneksi.php";

// Function to generate simple captcha
function generateCaptcha() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['captcha_answer'] = $num1 + $num2;
    return "$num1 + $num2 = ?";
}

session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pendaftaran Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            overflow: hidden;
        }
        
        .header-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-floating > .form-control {
            height: calc(3.5rem + 2px);
            border-radius: 15px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
        }
        
        .form-floating > .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
            transform: translateY(-2px);
        }
        
        .form-floating > label {
            color: #6b7280;
            font-weight: 500;
        }
        
        .btn-custom {
            border-radius: 15px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .table-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        
        .table-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 20px;
        }
        
        .table > tbody > tr > td {
            vertical-align: middle;
            border-color: #f3f4f6;
        }
        
        .alert-custom {
            border-radius: 15px;
            border: none;
            padding: 20px;
            margin: 20px 0;
        }
        
        .captcha-box {
            background: #f8fafc;
            border: 2px dashed var(--primary-color);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }
        
        .skill-item {
            background: #f8fafc;
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        .skill-item:hover {
            border-color: var(--primary-color);
            background: rgba(79, 70, 229, 0.05);
        }
        
        .progress-indicator {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background: var(--primary-color);
            transition: width 0.3s ease;
            z-index: 9999;
        }
        
        @media (max-width: 768px) {
            .form-section {
                padding: 20px;
            }
            .skills-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="progress-indicator" id="progressBar"></div>
    
    <div class="container">
        <div class="main-container animate__animated animate__fadeInUp">
            <!-- Header Section -->
            <div class="header-section">
                <h1 class="mb-3"><i class="fas fa-users me-3"></i>Sistem Pendaftaran Anggota</h1>
                <p class="mb-0">Silakan lengkapi formulir pendaftaran dengan data yang akurat</p>
            </div>
            
            <!-- Form Section -->
            <div class="form-section">
                <form id="memberForm" method="post" action="" novalidate>
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-12 mb-4">
                            <h4 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Informasi Pribadi</h4>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required minlength="3" maxlength="50">
                                <label for="nama"><i class="fas fa-user me-2"></i>Nama Lengkap</label>
                                <div class="invalid-feedback">
                                    Nama lengkap harus diisi minimal 3 karakter
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="kota" name="kota" placeholder="Kota Asal" required minlength="3" maxlength="30">
                                <label for="kota"><i class="fas fa-map-marker-alt me-2"></i>Kota Asal</label>
                                <div class="invalid-feedback">
                                    Kota asal harus diisi minimal 3 karakter
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Alamat Email</label>
                                <div class="invalid-feedback">
                                    Masukkan alamat email yang valid
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon" required pattern="[0-9]{10,13}">
                                <label for="telepon"><i class="fas fa-phone me-2"></i>Nomor Telepon</label>
                                <div class="invalid-feedback">
                                    Masukkan nomor telepon yang valid (10-13 digit)
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                <label for="tanggal_lahir"><i class="fas fa-calendar me-2"></i>Tanggal Lahir</label>
                                <div class="invalid-feedback">
                                    Tanggal lahir harus diisi
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-primary fw-bold"><i class="fas fa-venus-mars me-2"></i>Jenis Kelamin</label>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jk" id="pria" value="Pria" required>
                                    <label class="form-check-label" for="pria">
                                        <i class="fas fa-mars me-1"></i>Pria
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jk" id="wanita" value="Wanita" required>
                                    <label class="form-check-label" for="wanita">
                                        <i class="fas fa-venus me-1"></i>Wanita
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Education & Skills -->
                        <div class="col-12 mb-4 mt-4">
                            <h4 class="text-primary mb-3"><i class="fas fa-graduation-cap me-2"></i>Pendidikan & Keahlian</h4>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="pendidikan" name="pendidikan" required>
                                    <option value="">-- Pilih Tingkat Pendidikan --</option>
                                    <option value="SMA/SMK">SMA/SMK</option>
                                    <option value="D3">Diploma 3 (D3)</option>
                                    <option value="S1">Sarjana (S1)</option>
                                    <option value="S2">Magister (S2)</option>
                                    <option value="S3">Doktor (S3)</option>
                                </select>
                                <label for="pendidikan"><i class="fas fa-graduation-cap me-2"></i>Tingkat Pendidikan</label>
                                <div class="invalid-feedback">
                                    Pilih tingkat pendidikan
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Jurusan" required>
                                <label for="jurusan"><i class="fas fa-book me-2"></i>Jurusan/Bidang Studi</label>
                                <div class="invalid-feedback">
                                    Jurusan harus diisi
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label class="form-label text-primary fw-bold mb-3"><i class="fas fa-tools me-2"></i>Keahlian Teknis</label>
                            <div class="skills-grid">
                                <div class="skill-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian[]" value="Web Development" id="web_dev">
                                        <label class="form-check-label fw-bold" for="web_dev">
                                            <i class="fas fa-code me-2"></i>Web Development
                                        </label>
                                        <small class="text-muted d-block">HTML, CSS, JavaScript, PHP</small>
                                    </div>
                                </div>
                                <div class="skill-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian[]" value="Mobile Development" id="mobile_dev">
                                        <label class="form-check-label fw-bold" for="mobile_dev">
                                            <i class="fas fa-mobile-alt me-2"></i>Mobile Development
                                        </label>
                                        <small class="text-muted d-block">Android, iOS, React Native</small>
                                    </div>
                                </div>
                                <div class="skill-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian[]" value="Database Management" id="database">
                                        <label class="form-check-label fw-bold" for="database">
                                            <i class="fas fa-database me-2"></i>Database Management
                                        </label>
                                        <small class="text-muted d-block">MySQL, PostgreSQL, MongoDB</small>
                                    </div>
                                </div>
                                <div class="skill-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian[]" value="Network Administration" id="networking">
                                        <label class="form-check-label fw-bold" for="networking">
                                            <i class="fas fa-network-wired me-2"></i>Network Administration
                                        </label>
                                        <small class="text-muted d-block">Cisco, Mikrotik, Security</small>
                                    </div>
                                </div>
                                <div class="skill-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian[]" value="Data Science" id="data_science">
                                        <label class="form-check-label fw-bold" for="data_science">
                                            <i class="fas fa-chart-line me-2"></i>Data Science
                                        </label>
                                        <small class="text-muted d-block">Python, R, Machine Learning</small>
                                    </div>
                                </div>
                                <div class="skill-item">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="keahlian[]" value="UI/UX Design" id="uiux">
                                        <label class="form-check-label fw-bold" for="uiux">
                                            <i class="fas fa-paint-brush me-2"></i>UI/UX Design
                                        </label>
                                        <small class="text-muted d-block">Figma, Adobe XD, Sketch</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="pengalaman_kerja" name="pengalaman_kerja" required>
                                    <option value="">-- Pilih Pengalaman Kerja --</option>
                                    <option value="Fresh Graduate">Fresh Graduate</option>
                                    <option value="< 1 Tahun">Kurang dari 1 Tahun</option>
                                    <option value="1-3 Tahun">1-3 Tahun</option>
                                    <option value="3-5 Tahun">3-5 Tahun</option>
                                    <option value="> 5 Tahun">Lebih dari 5 Tahun</option>
                                </select>
                                <label for="pengalaman_kerja"><i class="fas fa-briefcase me-2"></i>Pengalaman Kerja</label>
                                <div class="invalid-feedback">
                                    Pilih pengalaman kerja
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select" id="level_keahlian" name="level_keahlian" required>
                                    <option value="">-- Pilih Level Keahlian --</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                                <label for="level_keahlian"><i class="fas fa-star me-2"></i>Level Keahlian</label>
                                <div class="invalid-feedback">
                                    Pilih level keahlian
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" id="deskripsi_pengalaman" name="deskripsi_pengalaman" 
                                         style="height: 120px; resize: none;" placeholder="Deskripsi Pengalaman" required minlength="20"></textarea>
                                <label for="deskripsi_pengalaman"><i class="fas fa-file-alt me-2"></i>Deskripsi Pengalaman & Proyek</label>
                                <div class="invalid-feedback">
                                    Deskripsi pengalaman minimal 20 karakter
                                </div>
                            </div>
                        </div>
                        
                        <!-- Security Verification -->
                        <div class="col-12 mb-4 mt-4">
                            <h4 class="text-primary mb-3"><i class="fas fa-shield-alt me-2"></i>Verifikasi Keamanan</h4>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="captcha-box">
                                <i class="fas fa-robot mb-2"></i><br>
                                Verifikasi: <?= generateCaptcha() ?>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="captcha" name="captcha" placeholder="Jawaban" required>
                                <label for="captcha"><i class="fas fa-calculator me-2"></i>Jawaban Verifikasi</label>
                                <div class="invalid-feedback">
                                    Jawaban verifikasi harus diisi
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="agreement" id="agreement" required>
                                <label class="form-check-label" for="agreement">
                                    Saya menyetujui <a href="#" class="text-primary">syarat dan ketentuan</a> yang berlaku
                                </label>
                                <div class="invalid-feedback">
                                    Anda harus menyetujui syarat dan ketentuan
                                </div>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="col-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary btn-custom btn-lg me-3">
                                <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-custom btn-lg">
                                <i class="fas fa-redo me-2"></i>Reset Form
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Alert Messages -->
        <?php
        if (isset($_POST['submit'])) {
            // Check if database connection exists
            if (!isset($conn) || $conn->connect_error) {
                echo '<div class="alert alert-danger alert-custom animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error!</strong> Koneksi database gagal. Silakan coba lagi nanti.
                      </div>';
            } else {
                // Captcha verification
                if (!isset($_POST['captcha']) || $_POST['captcha'] != $_SESSION['captcha_answer']) {
                    echo '<div class="alert alert-danger alert-custom animate__animated animate__shakeX">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Error!</strong> Verifikasi captcha salah. Silakan coba lagi.
                          </div>';
                } else {
                    // Process form data
                    $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
                    $kota = mysqli_real_escape_string($conn, trim($_POST['kota']));
                    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
                    $telepon = mysqli_real_escape_string($conn, trim($_POST['telepon']));
                    $tanggal_lahir = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
                    $jk = mysqli_real_escape_string($conn, $_POST['jk']);
                    $pendidikan = mysqli_real_escape_string($conn, $_POST['pendidikan']);
                    $jurusan = mysqli_real_escape_string($conn, trim($_POST['jurusan']));
                    $pengalaman_kerja = mysqli_real_escape_string($conn, $_POST['pengalaman_kerja']);
                    $level_keahlian = mysqli_real_escape_string($conn, $_POST['level_keahlian']);
                    $deskripsi_pengalaman = mysqli_real_escape_string($conn, trim($_POST['deskripsi_pengalaman']));
                    
                    // Process skills
                    $keahlian = "";
                    if (isset($_POST['keahlian']) && is_array($_POST['keahlian'])) {
                        $keahlian = implode(", ", array_map(function($skill) use ($conn) {
                            return mysqli_real_escape_string($conn, $skill);
                        }, $_POST['keahlian']));
                    }
                    
                    // Check if email already exists
                    $check_email = "SELECT id FROM tabel_user WHERE email = '$email'";
                    $result_check = $conn->query($check_email);
                    
                    // FIXED: Check if query was successful before accessing num_rows
                    if ($result_check === false) {
                        echo '<div class="alert alert-danger alert-custom animate__animated animate__shakeX">
                                <i class="fas fa-times-circle me-2"></i>
                                <strong>Error!</strong> Terjadi kesalahan database: ' . $conn->error . '
                              </div>';
                    } elseif ($result_check->num_rows > 0) {
                        echo '<div class="alert alert-warning alert-custom animate__animated animate__shakeX">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Peringatan!</strong> Email sudah terdaftar. Gunakan email lain.
                              </div>';
                    } else {
                        $sql = "INSERT INTO tabel_user (nama, kota, email, telepon, tanggal_lahir, jenis_kelamin, 
                                pendidikan, jurusan, keahlian, pengalaman_kerja, level_keahlian, deskripsi_pengalaman, tanggal_daftar) 
                                VALUES ('$nama', '$kota', '$email', '$telepon', '$tanggal_lahir', '$jk', 
                                '$pendidikan', '$jurusan', '$keahlian', '$pengalaman_kerja', '$level_keahlian', '$deskripsi_pengalaman', NOW())";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success alert-custom animate__animated animate__bounceIn">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Berhasil!</strong> Data anggota berhasil didaftarkan.
                                  </div>';
                        } else {
                            echo '<div class="alert alert-danger alert-custom animate__animated animate__shakeX">
                                    <i class="fas fa-times-circle me-2"></i>
                                    <strong>Gagal!</strong> Terjadi kesalahan: ' . $conn->error . '
                                  </div>';
                        }
                    }
                }
            }
        }
        
        // Handle delete
        if (isset($_GET['hapus']) && isset($_GET['id'])) {
            if (!isset($conn) || $conn->connect_error) {
                echo '<div class="alert alert-danger alert-custom animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Error!</strong> Koneksi database gagal.
                      </div>';
            } else {
                $id = mysqli_real_escape_string($conn, $_GET['id']);
                $querydelete = "DELETE FROM tabel_user WHERE id='$id'";
                
                if ($conn->query($querydelete) === TRUE) {
                    echo '<div class="alert alert-success alert-custom animate__animated animate__bounceIn">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Berhasil!</strong> Data anggota berhasil dihapus.
                          </div>';
                } else {
                    echo '<div class="alert alert-danger alert-custom animate__animated animate__shakeX">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Gagal!</strong> Data anggota gagal dihapus: ' . $conn->error . '
                          </div>';
                }
            }
        }
        ?>
        
        <!-- Data Table -->
        <div class="table-container animate__animated animate__fadeInUp">
            <div class="table-header">
                <h3 class="mb-0"><i class="fas fa-table me-2"></i>Daftar Anggota Terdaftar</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>ID</th>
                            <th><i class="fas fa-user me-1"></i>Nama</th>
                            <th><i class="fas fa-map-marker-alt me-1"></i>Kota</th>
                            <th><i class="fas fa-envelope me-1"></i>Email</th>
                            <th><i class="fas fa-phone me-1"></i>Telepon</th>
                            <th><i class="fas fa-venus-mars me-1"></i>Gender</th>
                            <th><i class="fas fa-graduation-cap me-1"></i>Pendidikan</th>
                            <th><i class="fas fa-tools me-1"></i>Keahlian</th>
                            <th><i class="fas fa-star me-1"></i>Level</th>
                            <th><i class="fas fa-calendar me-1"></i>Tgl Daftar</th>
                            <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // FIXED: Check database connection before querying
                        if (!isset($conn) || $conn->connect_error) {
                            echo '<tr><td colspan="11" class="text-center text-danger py-4">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3 d-block"></i>
                                    Error koneksi database
                                  </td></tr>';
                        } else {
                            $sql_select = "SELECT * FROM tabel_user ORDER BY tanggal_daftar DESC";
                            $result_select = $conn->query($sql_select);
                            
                            // FIXED: Check if query was successful before accessing num_rows
                            if ($result_select === false) {
                                echo '<tr><td colspan="11" class="text-center text-danger py-4">
                                        <i class="fas fa-exclamation-triangle fa-3x mb-3 d-block"></i>
                                        Error dalam mengambil data: ' . $conn->error . '
                                      </td></tr>';
                            } elseif ($result_select->num_rows > 0) {
                                $no = 1;
                                while ($row = $result_select->fetch_assoc()) {
                                    echo '<tr class="animate__animated animate__fadeInLeft" style="animation-delay: ' . ($no * 0.1) . 's">';
                                    echo '<td><span class="badge bg-primary">' . $no . '</span></td>';
                                    echo '<td><strong>' . htmlspecialchars($row['nama']) . '</strong></td>';
                                    echo '<td><i class="fas fa-map-marker-alt text-muted me-1"></i>' . htmlspecialchars($row['kota']) . '</td>';
                                    echo '<td><i class="fas fa-envelope text-muted me-1"></i>' . htmlspecialchars($row['email']) . '</td>';
                                    echo '<td><i class="fas fa-phone text-muted me-1"></i>' . htmlspecialchars($row['telepon']) . '</td>';
                                    echo '<td>';
                                    if ($row['jenis_kelamin'] == 'Pria') {
                                        echo '<span class="badge bg-info"><i class="fas fa-mars me-1"></i>Pria</span>';
                                    } else {
                                        echo '<span class="badge bg-pink"><i class="fas fa-venus me-1"></i>Wanita</span>';
                                    }
                                    echo '</td>';
                                    echo '<td><span class="badge bg-success">' . htmlspecialchars($row['pendidikan']) . '</span></td>';
                                    echo '<td><small>' . htmlspecialchars($row['keahlian']) . '</small></td>';
                                    echo '<td><span class="badge bg-warning text-dark">' . htmlspecialchars($row['level_keahlian']) . '</span></td>';
                                    echo '<td><small>' . date('d/m/Y', strtotime($row['tanggal_daftar'])) . '</small></td>';
                                    echo '<td>';
                                    echo '<div class="btn-group btn-group-sm">';
                                    echo '<button class="btn btn-outline-info btn-sm" onclick="viewDetail(' . $row['id'] . ')" title="Lihat Detail">';
                                    echo '<i class="fas fa-eye"></i>';
                                    echo '</button>';
                                    echo '<button class="btn btn-outline-warning btn-sm" onclick="editData(' . $row['id'] . ')" title="Edit">';
                                    echo '<i class="fas fa-edit"></i>';
                                    echo '</button>';
                                    echo '<a href="?hapus=true&id=' . $row['id'] . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data ini?\')" title="Hapus">';
                                    echo '<i class="fas fa-trash"></i>';
                                    echo '</a>';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
                                    $no++;
                                }
                            } else {
                                echo '<tr><td colspan="11" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        <h5>Belum ada data anggota</h5>
                                        <p>Silakan daftarkan anggota pertama menggunakan formulir di atas</p>
                                      </td></tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-circle me-2"></i>Detail Anggota</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        
        // Progress indicator
        window.addEventListener('scroll', function() {
            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            var scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var progress = (scrollTop / scrollHeight) * 100;
            document.getElementById('progressBar').style.width = progress + '%';
        });
        
        // Form auto-save (using variables instead of localStorage)
        let formData = {};
        
        function saveFormData() {
            const form = document.getElementById('memberForm');
            const formDataObj = new FormData(form);
            formData = {};
            
            for (let [key, value] of formDataObj.entries()) {
                if (formData[key]) {
                    if (Array.isArray(formData[key])) {
                        formData[key].push(value);
                    } else {
                        formData[key] = [formData[key], value];
                    }
                } else {
                    formData[key] = value;
                }
            }
        }
        
        function loadFormData() {
            if (Object.keys(formData).length > 0) {
                for (let key in formData) {
                    const element = document.querySelector(`[name="${key}"]`);
                    if (element) {
                        if (element.type === 'checkbox' || element.type === 'radio') {
                            if (Array.isArray(formData[key])) {
                                formData[key].forEach(value => {
                                    const specificElement = document.querySelector(`[name="${key}"][value="${value}"]`);
                                    if (specificElement) specificElement.checked = true;
                                });
                            } else {
                                const specificElement = document.querySelector(`[name="${key}"][value="${formData[key]}"]`);
                                if (specificElement) specificElement.checked = true;
                            }
                        } else {
                            element.value = formData[key];
                        }
                    }
                }
            }
        }
        
        // Auto-save form data on input
        document.addEventListener('DOMContentLoaded', function() {
            loadFormData();
            
            const form = document.getElementById('memberForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                input.addEventListener('input', saveFormData);
                input.addEventListener('change', saveFormData);
            });
        });
        
        // Real-time form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('memberForm');
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });
            
            function validateField(field) {
                const isValid = field.checkValidity();
                
                if (isValid) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                } else {
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            }
        });
        
        // Email validation
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.setCustomValidity('Format email tidak valid');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Phone validation
        document.getElementById('telepon').addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length < 10 || this.value.length > 13) {
                this.setCustomValidity('Nomor telepon harus 10-13 digit');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Date validation (minimum age 17)
        document.getElementById('tanggal_lahir').addEventListener('change', function() {
            const birthDate = new Date(this.value);
            const today = new Date();
            const age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 17) {
                this.setCustomValidity('Usia minimal 17 tahun');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Skills validation (at least one skill required)
        document.addEventListener('DOMContentLoaded', function() {
            const skillCheckboxes = document.querySelectorAll('input[name="keahlian[]"]');
            
            function validateSkills() {
                const checkedSkills = document.querySelectorAll('input[name="keahlian[]"]:checked');
                const isValid = checkedSkills.length > 0;
                
                skillCheckboxes.forEach(checkbox => {
                    if (isValid) {
                        checkbox.setCustomValidity('');
                    } else {
                        checkbox.setCustomValidity('Pilih minimal satu keahlian');
                    }
                });
            }
            
            skillCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', validateSkills);
            });
        });
        
        // View detail function
        function viewDetail(id) {
            // This would typically fetch data via AJAX
            // For now, we'll show a placeholder
            const detailContent = document.getElementById('detailContent');
            detailContent.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat detail anggota...</p>
                </div>
            `;
            
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
            
            // Simulate loading data
            setTimeout(() => {
                detailContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Informasi Pribadi</h6>
                            <p><strong>ID:</strong> ${id}</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Statistik</h6>
                            <p><strong>Member sejak:</strong> ${new Date().getFullYear()}</p>
                            <p><strong>Last Update:</strong> ${new Date().toLocaleDateString()}</p>
                        </div>
                    </div>
                `;
            }, 1000);
        }
        
        // Edit function placeholder
        function editData(id) {
            alert('Fitur edit akan segera tersedia. ID: ' + id);
        }
        
        // Form submission with loading state
        document.getElementById('memberForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            
            // Re-enable button after form submission (in case of validation errors)
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }, 3000);
        });
        
        // Smooth scroll for alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            if (alerts.length > 0) {
                alerts[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 500);
                }, 5000);
            });
        });
        
        // Character counter for textarea
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('deskripsi_pengalaman');
            const minLength = 20;
            
            // Create counter element
            const counter = document.createElement('small');
            counter.className = 'text-muted float-end mt-1';
            textarea.parentNode.appendChild(counter);
            
            function updateCounter() {
                const currentLength = textarea.value.length;
                counter.textContent = `${currentLength} karakter (minimal ${minLength})`;
                
                if (currentLength < minLength) {
                    counter.className = 'text-danger float-end mt-1';
                } else {
                    counter.className = 'text-success float-end mt-1';
                }
            }
            
            textarea.addEventListener('input', updateCounter);
            updateCounter(); // Initial call
        });
    </script>
</body>
</html>