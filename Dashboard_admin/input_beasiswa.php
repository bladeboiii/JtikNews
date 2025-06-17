<?php
include_once "../koneksi.php";

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_beasiswa'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $link = $_POST['link_pendaftaran'];
    
    // Get education levels (jenjang pendidikan)
    $jenjang = isset($_POST['jenjang']) ? implode(',', $_POST['jenjang']) : '';
    
    // Get location and dates
    $lokasi = $_POST['lokasi'];
    $mulai = $_POST['tanggal_mulai'];
    $deadline = $_POST['deadline'];

    // upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = "../uploads/" . $gambar;

    if (move_uploaded_file($tmp, $path)) {
        $sql = "INSERT INTO beasiswa (nama_beasiswa, deskripsi, syarat, link_pendaftaran, gambar, jenjang, lokasi, tanggal_mulai, deadline) 
                VALUES ('$nama', '$deskripsi', '$syarat', '$link', '$gambar', '$jenjang', '$lokasi', '$mulai', '$deadline')";

        if ($koneksi->query($sql)) {
            header("Location: Beasiswa.php?status=sukses");
            exit();
        } else {
            echo "Gagal menyimpan data ke database: " . $koneksi->error;
        }
    } else {
        echo "Gagal mengupload gambar.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Beasiswa - Admin Dashboard</title>
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
        .jenjang-checkbox {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 10px;
        }
        .jenjang-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            color: white;
            font-weight: 600;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .badge-sd { background-color: #dc3545; }
        .badge-smp { background-color: #6610f2; }
        .badge-sma { background-color: #007bff; }
        .badge-ma { background-color: #fd7e14; }
        .badge-s1 { background-color: #28a745; }
        .badge-d3 { background-color: #fd7e14; }
        .badge-d4 { background-color: #e83e8c; }
        .badge-s2 { background-color: #20c997; }
        .badge-s3 { background-color: #6f42c1; }
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
                    <h2><i class="fas fa-plus-circle mr-2"></i>Tambah Beasiswa</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="Beasiswa.php">Beasiswa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-award mr-2"></i>Form Tambah Beasiswa
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" id="beasiswaForm">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_beasiswa"><i class="fas fa-heading mr-1"></i>Nama Beasiswa</label>
                                    <input type="text" id="nama_beasiswa" name="nama_beasiswa" class="form-control" required minlength="3" maxlength="100">
                                    <div class="invalid-feedback">Nama beasiswa harus diisi (min. 3 karakter)</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="lokasi"><i class="fas fa-map-marker-alt mr-1"></i>Lokasi</label>
                                    <input type="text" id="lokasi" name="lokasi" class="form-control" required>
                                    <div class="invalid-feedback">Lokasi beasiswa harus diisi</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_mulai"><i class="fas fa-calendar-alt mr-1"></i>Tanggal Mulai</label>
                                            <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                                            <div class="invalid-feedback">Tanggal mulai harus diisi</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="deadline"><i class="fas fa-clock mr-1"></i>Deadline</label>
                                            <input type="date" id="deadline" name="deadline" class="form-control" required>
                                            <div class="invalid-feedback">Deadline harus diisi</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="deskripsi"><i class="fas fa-align-left mr-1"></i>Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" required minlength="10"></textarea>
                                    <div class="invalid-feedback">Deskripsi harus diisi (min. 10 karakter)</div>
                                </div>
                                
                                <div class="form-group">
                                    <label><i class="fas fa-graduation-cap mr-1"></i>Jenjang Pendidikan</label>
                                    <div id="jenjang-badges" class="mb-2"></div>
                                    <div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="sd" value="SD" class="jenjang-check">
                                            <label for="sd">SD</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="smp" value="SMP" class="jenjang-check">
                                            <label for="smp">SMP</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="sma" value="SMA" class="jenjang-check">
                                            <label for="sma">SMA</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="ma" value="MA" class="jenjang-check">
                                            <label for="ma">MA</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="d3" value="D3" class="jenjang-check">
                                            <label for="d3">D3</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="d4" value="D4" class="jenjang-check">
                                            <label for="d4">D4</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="s1" value="S1" class="jenjang-check">
                                            <label for="s1">S1</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="s2" value="S2" class="jenjang-check">
                                            <label for="s2">S2</label>
                                        </div>
                                        <div class="jenjang-checkbox">
                                            <input type="checkbox" name="jenjang[]" id="s3" value="S3" class="jenjang-check">
                                            <label for="s3">S3</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="syarat"><i class="fas fa-list mr-1"></i>Persyaratan</label>
                                    <textarea id="syarat" name="syarat" class="form-control" rows="5" required minlength="10"></textarea>
                                    <div class="invalid-feedback">Persyaratan harus diisi (min. 10 karakter)</div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="link_pendaftaran"><i class="fas fa-link mr-1"></i>Link Pendaftaran</label>
                                    <input type="url" id="link_pendaftaran" name="link_pendaftaran" class="form-control" placeholder="https://example.com" required pattern="https?://.+">
                                    <div class="invalid-feedback">URL harus valid dan diawali dengan http:// atau https://</div>
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
                                    <small class="form-text text-muted mt-2">Gambar untuk cover beasiswa (max: 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Simpan Beasiswa</button>
                            <a href="Beasiswa.php" class="btn btn-secondary ml-2"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
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
        
        // Add validation to form
        document.getElementById('beasiswaForm').classList.add('needs-validation');
        
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
        
        // Create badges when checkboxes are checked
        const checkboxes = document.querySelectorAll('.jenjang-check');
        const badgesContainer = document.getElementById('jenjang-badges');
        
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', updateBadges);
        });
        
        function updateBadges() {
            badgesContainer.innerHTML = '';
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    const value = checkbox.value;
                    const badge = document.createElement('span');
                    badge.className = `jenjang-badge badge-${value.toLowerCase()}`;
                    badge.textContent = value;
                    badgesContainer.appendChild(badge);
                }
            });
        }
    </script>
</body>
</html>
