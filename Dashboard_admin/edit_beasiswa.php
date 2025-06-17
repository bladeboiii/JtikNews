<?php
session_start();
include_once "../koneksi.php";

$id = $_GET['id'];
$data = $koneksi->query("SELECT * FROM beasiswa WHERE id_beasiswa=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST['nama_beasiswa'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $link = $_POST['link_pendaftaran'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/" . $gambar);
        $sql = "UPDATE beasiswa SET nama_beasiswa='$nama', deskripsi='$deskripsi', syarat='$syarat', link_pendaftaran='$link', gambar='$gambar' WHERE id_beasiswa=$id";
    } else {
        $sql = "UPDATE beasiswa SET nama_beasiswa='$nama', deskripsi='$deskripsi', syarat='$syarat', link_pendaftaran='$link' WHERE id_beasiswa=$id";
    }

    if ($koneksi->query($sql)) {
        header("Location: Beasiswa.php");
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Beasiswa - Admin Dashboard</title>
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
        .img-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
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
                    <h2><i class="fas fa-edit mr-2"></i>Edit Beasiswa</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="Beasiswa.php">Beasiswa</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-award mr-2"></i>Form Edit Beasiswa
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nama_beasiswa"><i class="fas fa-heading mr-1"></i>Nama Beasiswa</label>
                                    <input type="text" id="nama_beasiswa" name="nama_beasiswa" class="form-control" value="<?= htmlspecialchars($data['nama_beasiswa']) ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="deskripsi"><i class="fas fa-align-left mr-1"></i>Deskripsi</label>
                                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="syarat"><i class="fas fa-list-check mr-1"></i>Persyaratan</label>
                                    <textarea id="syarat" name="syarat" class="form-control" rows="5" required><?= htmlspecialchars($data['syarat']) ?></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="link_pendaftaran"><i class="fas fa-link mr-1"></i>Link Pendaftaran</label>
                                    <input type="url" id="link_pendaftaran" name="link_pendaftaran" class="form-control" value="<?= htmlspecialchars($data['link_pendaftaran']) ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fas fa-image mr-1"></i>Gambar Saat Ini</label>
                                    <div class="mb-3">
                                        <img src="../uploads/<?= htmlspecialchars($data['gambar']) ?>" alt="Gambar beasiswa" class="img-preview img-fluid">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gambar" name="gambar" accept="image/*">
                                        <label class="custom-file-label" for="gambar">Pilih gambar baru...</label>
                                    </div>
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>Simpan Perubahan</button>
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
        });
    </script>
</body>
</html>
