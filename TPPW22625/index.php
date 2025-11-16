<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD AJAX - Sistem Registrasi</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .content {
            display: flex;
            min-height: 500px;
        }

        .form-section {
            flex: 1;
            padding: 30px;
            background: #f8f9fa;
        }

        .data-section {
            flex: 2;
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
        }

        .radio-group input[type="radio"] {
            width: auto;
            margin-right: 8px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #4CAF50;
            color: white;
        }

        .btn-primary:hover {
            background: #45a049;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            font-weight: bold;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .form-title {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4CAF50;
        }

        .hidden {
            display: none;
        }

        #editForm {
            background: #fff3cd;
            border: 2px solid #ffc107;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            
            .btn-group {
                flex-wrap: wrap;
            }
            
            .data-table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Sistem Registrasi Anggota</h1>
            <p>CRUD dengan PHP & AJAX</p>
        </div>
        
        <div class="content">
            <!-- Form Section -->
            <div class="form-section">
                <!-- Form Edit (Hidden by default) -->
                <div id="editForm" class="hidden">
                    <h3 class="form-title">✏️ Edit Data Anggota</h3>
                    <input type="hidden" id="editId">
                    
                    <div class="form-group">
                        <label for="editNama">Nama Lengkap:</label>
                        <input type="text" id="editNama" placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div class="form-group">
                        <label>Jenis Kelamin:</label>
                        <div class="radio-group">
                            <label><input type="radio" name="editJenis" value="L"> 👨 Laki-laki</label>
                            <label><input type="radio" name="editJenis" value="P"> 👩 Perempuan</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" placeholder="contoh@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="editPesan">Pesan:</label>
                        <textarea id="editPesan" rows="3" placeholder="Tulis pesan Anda..."></textarea>
                    </div>
                    
                    <div class="btn-group">
                        <button type="button" id="btnUpdate" class="btn btn-warning">💾 Update</button>
                        <button type="button" id="btnCancelEdit" class="btn btn-secondary">❌ Batal</button>
                    </div>
                </div>

                <!-- Form Tambah -->
                <div id="addForm">
                    <h3 class="form-title">➕ Tambah Anggota Baru</h3>
                    
                    <div class="form-group">
                        <label for="txtnama">Nama Lengkap:</label>
                        <input type="text" id="txtnama" placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div class="form-group">
                        <label>Jenis Kelamin:</label>
                        <div class="radio-group">
                            <label><input type="radio" name="jenis" value="L" id="jenis1" checked> 👨 Laki-laki</label>
                            <label><input type="radio" name="jenis" value="P" id="jenis2"> 👩 Perempuan</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="txtemail">Email:</label>
                        <input type="email" id="txtemail" placeholder="contoh@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="txtpesan">Pesan:</label>
                        <textarea id="txtpesan" rows="3" placeholder="Tulis pesan Anda..."></textarea>
                    </div>
                    
                    <div class="btn-group">
                        <button type="button" id="btnkirim" class="btn btn-primary">📤 Kirim</button>
                        <button type="button" id="btnreset" class="btn btn-secondary">🔄 Reset</button>
                    </div>
                </div>
            </div>
            
            <!-- Data Section -->
            <div class="data-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 class="form-title">📊 Data Anggota</h3>
                    <button type="button" id="btnview" class="btn btn-info">🔄 Refresh Data</button>
                </div>
                
                <div id="info">
                    <div class="loading">Memuat data...</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Reset form function
        function resetForm() {
            $("#txtnama").val("");
            $("#jenis1").prop("checked", true);
            $("#txtemail").val("");
            $("#txtpesan").val("");
        }

        // Show success message
        function showAlert(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
            const icon = type === 'success' ? '✅' : '❌';
            $("#info").prepend(`<div class="alert ${alertClass}">${icon} ${message}</div>`);
            
            // Auto remove alert after 3 seconds
            setTimeout(() => {
                $(".alert").fadeOut();
            }, 3000);
        }

        // Load data when page loads
        $(document).ready(function(){
            loadData();

            // Add new data
            $("#btnkirim").click(function(){
                var nama = $("#txtnama").val();
                var jenis = $('input:radio[name=jenis]:checked').val();
                var email = $("#txtemail").val();
                var pesan = $("#txtpesan").val();

                if(nama === "" || email === "") {
                    showAlert("Nama dan Email harus diisi!", 'error');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "proses.php",
                    data: {
                        action: "add",
                        nama: nama,
                        jenis: jenis,
                        email: email,
                        pesan: pesan
                    },
                    success: function(response){
                        const result = JSON.parse(response);
                        if(result.status === 'success') {
                            showAlert(result.message);
                            resetForm();
                            loadData();
                        } else {
                            showAlert(result.message, 'error');
                        }
                    },
                    error: function(){
                        showAlert("Terjadi kesalahan. Silakan coba lagi.", 'error');
                    }
                });
            });

            // Reset form
            $("#btnreset").click(function(){
                resetForm();
            });

            // Load data
            $("#btnview").click(function(){
                loadData();
            });

            // Update data
            $("#btnUpdate").click(function(){
                var id = $("#editId").val();
                var nama = $("#editNama").val();
                var jenis = $('input:radio[name=editJenis]:checked').val();
                var email = $("#editEmail").val();
                var pesan = $("#editPesan").val();

                if(nama === "" || email === "") {
                    showAlert("Nama dan Email harus diisi!", 'error');
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "proses.php",
                    data: {
                        action: "update",
                        id: id,
                        nama: nama,
                        jenis: jenis,
                        email: email,
                        pesan: pesan
                    },
                    success: function(response){
                        const result = JSON.parse(response);
                        if(result.status === 'success') {
                            showAlert(result.message);
                            cancelEdit();
                            loadData();
                        } else {
                            showAlert(result.message, 'error');
                        }
                    },
                    error: function(){
                        showAlert("Terjadi kesalahan. Silakan coba lagi.", 'error');
                    }
                });
            });

            // Cancel edit
            $("#btnCancelEdit").click(function(){
                cancelEdit();
            });
        });

        // Load data function
        function loadData() {
            $.ajax({
                type: "POST",
                url: "proses.php",
                data: { action: "view" },
                success: function(output){
                    $("#info").html(output);
                },
                error: function(){
                    $("#info").html('<div class="alert alert-error">❌ Terjadi kesalahan saat memuat data.</div>');
                }
            });
        }

        // Edit data function
        function editData(id) {
            $.ajax({
                type: "POST",
                url: "proses.php",
                data: { 
                    action: "get",
                    id: id 
                },
                success: function(response){
                    const result = JSON.parse(response);
                    if(result.status === 'success') {
                        const data = result.data;
                        $("#editId").val(data.no);
                        $("#editNama").val(data.nama);
                        $('input:radio[name=editJenis][value=' + data.jenis_kelamin + ']').prop('checked', true);
                        $("#editEmail").val(data.email);
                        $("#editPesan").val(data.pesan);
                        
                        $("#editForm").removeClass("hidden");
                        $("#addForm").addClass("hidden");
                    } else {
                        showAlert(result.message, 'error');
                    }
                },
                error: function(){
                    showAlert("Terjadi kesalahan saat mengambil data.", 'error');
                }
            });
        }

        // Cancel edit function
        function cancelEdit() {
            $("#editForm").addClass("hidden");
            $("#addForm").removeClass("hidden");
        }

        // Delete data function
        function deleteData(id, nama) {
            if(confirm(`Apakah Anda yakin ingin menghapus data "${nama}"?`)) {
                $.ajax({
                    type: "POST",
                    url: "proses.php",
                    data: { 
                        action: "delete",
                        id: id 
                    },
                    success: function(response){
                        const result = JSON.parse(response);
                        if(result.status === 'success') {
                            showAlert(result.message);
                            loadData();
                        } else {
                            showAlert(result.message, 'error');
                        }
                    },
                    error: function(){
                        showAlert("Terjadi kesalahan saat menghapus data.", 'error');
                    }
                });
            }
        }
    </script>
</body>
</html>