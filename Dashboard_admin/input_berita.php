<?php
// Contoh hanya form UI input berita, proses simpan dilakukan di 'proses_input_berita.php'
session_start();
$id_admin_user = $_SESSION['id_user'] ?? 1; // fallback default id jika tidak login
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berita - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #56021f;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        .form-control:focus {
            border-color: #56021f;
            box-shadow: 0 0 0 0.2rem rgba(86, 2, 31, 0.25);
        }
        label {
            font-weight: 500;
            color: #56021f;
        }
    </style>
</head>
<body>
    <?php
        include "./Header.php";
        include "./sidebar.php";
    ?>

    <div id="main">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h2><i class="fas fa-plus-circle mr-2"></i>Tambah Berita</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="admin.php">Berita</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-newspaper mr-2"></i>Form Tambah Berita
                </div>
                <div class="card-body">
                    <form action="proses_input_berita.php" method="POST" enctype="multipart/form-data" id="beritaForm" class="needs-validation" novalidate>
                        <input type="hidden" name="id_admin_user" value="<?= htmlspecialchars($id_admin_user) ?>">

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="judul"><i class="fas fa-heading mr-1"></i>Judul Berita</label>
                                    <input type="text" id="judul" name="judul" class="form-control" required minlength="5" maxlength="150">
                                    <div class="invalid-feedback">Judul berita harus diisi (min. 5 karakter)</div>
                                </div>

                                <div class="form-group">
                                    <label for="kategori"><i class="fas fa-tag mr-1"></i>Kategori</label>
                                    <input type="text" id="kategori" name="kategori" class="form-control" required minlength="3">
                                    <div class="invalid-feedback">Kategori harus diisi (min. 3 karakter)</div>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal"><i class="fas fa-calendar-alt mr-1"></i>Tanggal Berita</label>
                                    <input type="datetime-local" id="tanggal" name="tanggal" class="form-control" required>
                                    <div class="invalid-feedback">Tanggal berita harus diisi.</div>
                                </div>

                                <div class="form-group">
                                    <label for="isi"><i class="fas fa-align-left mr-1"></i>Isi Berita</label>
                                    <textarea id="isi" name="isi" class="form-control" rows="10" required minlength="20"></textarea>
                                    <div class="invalid-feedback">Isi berita harus diisi (min. 20 karakter)</div>
                                </div>

                                <div class="form-group">
                                    <label for="penulis"><i class="fas fa-user mr-1"></i>Penulis</label>
                                    <input type="text" id="penulis" name="penulis" class="form-control" required minlength="3">
                                    <div class="invalid-feedback">Nama penulis harus diisi (min. 3 karakter)</div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gambar"><i class="fas fa-image mr-1"></i>Upload Gambar</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*" required>
                                        <label class="custom-file-label" for="gambar">Pilih gambar...</label>
                                    </div>
                                    <div id="image-preview" class="mt-3 d-none">
                                        <img src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Simpan Berita</button>
                            <a href="admin.php" class="btn btn-secondary ml-2"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        // Update file input label with filename
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            
            // Show image preview
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').removeClass('d-none');
                    $('#image-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                
                // Loop over them and prevent submission
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
        
        // Custom validation for file input
        document.getElementById('gambar').addEventListener('change', function() {
            const fileInput = this;
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (fileInput.files.length > 0) {
                const fileSize = fileInput.files[0].size;
                
                if (fileSize > maxSize) {
                    fileInput.setCustomValidity('Ukuran file maksimal 2MB');
                } else {
                    fileInput.setCustomValidity('');
                }
            }
        });
    </script>
</body>
</html>
