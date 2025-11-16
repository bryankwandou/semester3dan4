<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Anggota dengan AJAX</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .card-header h2 {
            font-size: 24px;
            font-weight: 600;
        }

        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 8px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #4f46e5;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn-primary {
            background: #4f46e5;
            color: white;
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .button-group {
            text-align: right;
            margin-top: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-responsive {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        th {
            background: #f9fafb;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #f3f4f6;
        }

        tr:hover {
            background: #f9fafb;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .modal-body {
            padding: 30px;
        }

        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close:hover {
            opacity: 0.7;
        }

        #info {
            margin-top: 20px;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4f46e5;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .btn {
                padding: 10px 16px;
                font-size: 12px;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Form Input -->
        <div class="card">
            <div class="card-header">
                <h2>📝 Form Input Data Anggota</h2>
            </div>
            <div class="card-body">
                <form id="formAnggota">
                    <input type="hidden" id="editId" value="">
                    
                    <div class="form-group">
                        <label for="txtnama">Nama Lengkap:</label>
                        <input type="text" id="txtnama" class="form-control" maxlength="50" required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin:</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" value="L" name="jenis" id="jenis1" checked>
                                <label for="jenis1">👨 Pria</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" value="P" name="jenis" id="jenis2">
                                <label for="jenis2">👩 Wanita</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtemail">Email:</label>
                        <input type="email" id="txtemail" class="form-control" maxlength="50" required>
                    </div>

                    <div class="form-group">
                        <label for="txtpesan">Pesan:</label>
                        <textarea id="txtpesan" class="form-control" rows="4" placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>

                    <div class="button-group">
                        <button type="button" id="btnkirim" class="btn btn-primary">
                            💾 Simpan Data
                        </button>
                        <button type="button" id="btnupdate" class="btn btn-warning" style="display:none;">
                            ✏️ Update Data
                        </button>
                        <button type="button" id="btnview" class="btn btn-success">
                            👁️ Lihat Data
                        </button>
                        <button type="reset" id="reset" class="btn btn-secondary">
                            🔄 Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info/Result Area -->
        <div id="info"></div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h3>✏️ Edit Data Anggota</h3>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="editIdModal" value="">
                    
                    <div class="form-group">
                        <label for="editNama">Nama Lengkap:</label>
                        <input type="text" id="editNama" class="form-control" maxlength="50" required>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin:</label>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" value="L" name="editJenis" id="editJenis1">
                                <label for="editJenis1">👨 Pria</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" value="P" name="editJenis" id="editJenis2">
                                <label for="editJenis2">👩 Wanita</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="editEmail">Email:</label>
                        <input type="email" id="editEmail" class="form-control" maxlength="50" required>
                    </div>

                    <div class="form-group">
                        <label for="editPesan">Pesan:</label>
                        <textarea id="editPesan" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="button-group">
                        <button type="button" id="btnSaveEdit" class="btn btn-primary">
                            💾 Simpan Perubahan
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">
                            ❌ Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // Reset form function
            function resetForm() {
                $("#formAnggota")[0].reset();
                $("#editId").val("");
                $("#btnkirim").show();
                $("#btnupdate").hide();
                $("#jenis1").prop("checked", true);
            }

            // Show loading
            function showLoading(target) {
                $(target).html('<div class="loading"></div> Memproses...');
            }

            // Insert data
            $("#btnkirim").click(function(){
                var nama = $("#txtnama").val();
                var jenis = $('input:radio[name=jenis]:checked').val();
                var email = $("#txtemail").val();
                var pesan = $("#txtpesan").val();

                if(nama == "" || email == "") {
                    $("#info").html('<div class="alert alert-error">❌ Nama dan Email harus diisi!</div>');
                    return false;
                }

                showLoading("#info");

                $.ajax({
                    type: "POST",
                    url: "proses_crud.php",
                    data: {
                        action: "insert",
                        nama: nama,
                        jenis: jenis,
                        email: email,
                        pesan: pesan
                    },
                    success: function(response){
                        var result = JSON.parse(response);
                        if(result.status == "success") {
                            $("#info").html('<div class="alert alert-success">✅ ' + result.message + '</div>');
                            resetForm();
                            loadData(); // Auto refresh data
                        } else {
                            $("#info").html('<div class="alert alert-error">❌ ' + result.message + '</div>');
                        }
                    },
                    error: function(){
                        $("#info").html('<div class="alert alert-error">❌ Terjadi kesalahan. Silahkan coba lagi!</div>');
                    }
                });
            });

            // View data
            $("#btnview").click(function(){
                loadData();
            });

            function loadData() {
                showLoading("#info");
                
                $.ajax({
                    type: "POST",
                    url: "proses_crud.php",
                    data: { action: "view" },
                    success: function(response){
                        $("#info").html(response);
                    },
                    error: function(){
                        $("#info").html('<div class="alert alert-error">❌ Gagal memuat data!</div>');
                    }
                });
            }

            // Reset button
            $("#reset").click(function(){
                resetForm();
                $("#info").html("");
            });

            // Modal functions
            window.openEditModal = function(id, nama, jenis, email, pesan) {
                $("#editIdModal").val(id);
                $("#editNama").val(nama);
                $("#editEmail").val(email);
                $("#editPesan").val(pesan);
                
                if(jenis == 'L') {
                    $("#editJenis1").prop("checked", true);
                } else {
                    $("#editJenis2").prop("checked", true);
                }
                
                $("#editModal").show();
            };

            window.closeModal = function() {
                $("#editModal").hide();
            };

            // Close modal when clicking outside
            $(window).click(function(event) {
                if (event.target.id == "editModal") {
                    closeModal();
                }
            });

            // Close modal with X button
            $(".close").click(function() {
                closeModal();
            });

            // Save edit
            $("#btnSaveEdit").click(function(){
                var id = $("#editIdModal").val();
                var nama = $("#editNama").val();
                var jenis = $('input:radio[name=editJenis]:checked').val();
                var email = $("#editEmail").val();
                var pesan = $("#editPesan").val();

                if(nama == "" || email == "") {
                    alert("Nama dan Email harus diisi!");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "proses_crud.php",
                    data: {
                        action: "update",
                        id: id,
                        nama: nama,
                        jenis: jenis,
                        email: email,
                        pesan: pesan
                    },
                    success: function(response){
                        var result = JSON.parse(response);
                        if(result.status == "success") {
                            $("#info").html('<div class="alert alert-success">✅ ' + result.message + '</div>');
                            closeModal();
                            loadData(); // Refresh data
                        } else {
                            alert("❌ " + result.message);
                        }
                    },
                    error: function(){
                        alert("❌ Terjadi kesalahan saat update data!");
                    }
                });
            });

            // Delete function
            window.deleteData = function(id, nama) {
                if(confirm("Apakah Anda yakin ingin menghapus data '" + nama + "'?")) {
                    $.ajax({
                        type: "POST",
                        url: "proses_crud.php",
                        data: {
                            action: "delete",
                            id: id
                        },
                        success: function(response){
                            var result = JSON.parse(response);
                            if(result.status == "success") {
                                $("#info").html('<div class="alert alert-success">✅ ' + result.message + '</div>');
                                loadData(); // Refresh data
                            } else {
                                $("#info").html('<div class="alert alert-error">❌ ' + result.message + '</div>');
                            }
                        },
                        error: function(){
                            $("#info").html('<div class="alert alert-error">❌ Terjadi kesalahan saat menghapus data!</div>');
                        }
                    });
                }
            };

            // Auto load data when page ready
            loadData();
        });
    </script>
</body>
</html>