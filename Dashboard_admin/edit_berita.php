<?php
session_start();
include_once "../koneksi.php";

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM berita WHERE id_berita = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Berita - Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    .card-header {
      background: linear-gradient(45deg, #56021f, #8a0b2e);
      color: white;
      border-radius: 15px 15px 0 0 !important;
      padding: 1.2rem;
      font-weight: 600;
    }
    .form-control:focus {
      border-color: #56021f;
      box-shadow: 0 0 0 0.2rem rgba(86, 2, 31, 0.15);
    }
    .img-preview {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .img-preview:hover {
      transform: scale(1.02);
    }
    label {
      font-weight: 500;
      color: #56021f;
      margin-bottom: 0.5rem;
    }
    .form-group {
      margin-bottom: 1.5rem;
    }
    .custom-file-label {
      border-radius: 8px;
      padding: 0.8rem 1rem;
    }
    .custom-file-label::after {
      border-radius: 0 8px 8px 0;
      padding: 0.8rem 1rem;
    }
    .btn {
      padding: 0.8rem 1.5rem;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .btn-warning {
      background: linear-gradient(45deg, #ffc107, #ff9800);
      border: none;
      color: #fff;
    }
    .btn-warning:hover {
      background: linear-gradient(45deg, #ff9800, #ffc107);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 152, 0, 0.2);
    }
    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      border: none;
    }
    .btn-secondary:hover {
      background: linear-gradient(45deg, #495057, #6c757d);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
    }
    #isi {
      min-height: 300px;
      line-height: 1.6;
      white-space: pre-wrap;
    }
    .breadcrumb {
      background: transparent;
      padding: 0;
      margin-bottom: 1.5rem;
    }
    .breadcrumb-item a {
      color: #56021f;
      text-decoration: none;
    }
    .breadcrumb-item.active {
      color: #6c757d;
    }
    .invalid-feedback {
      font-size: 0.875rem;
      color: #dc3545;
    }
  </style>
</head>
<body>
  <?php
    include "./Header.php";
    include "sidebar.php";
  ?>

  <div id="main">
    <div class="container-fluid mt-4">
      <div class="row">
        <div class="col-md-12 mb-4">
          <h2><i class="fas fa-edit mr-2"></i>Edit Berita</h2>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="admin.php">Home</a></li>
              <li class="breadcrumb-item"><a href="admin.php">Berita</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <i class="fas fa-newspaper mr-2"></i>Form Edit Berita
        </div>
        <div class="card-body">
          <form action="proses_edit_berita.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_berita']) ?>">
            
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="judul"><i class="fas fa-heading mr-1"></i>Judul Berita</label>
                  <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($data['judul']) ?>" required>
                </div>

                <div class="form-group">
                  <label for="isi"><i class="fas fa-align-left mr-1"></i>Isi Berita</label>
                  <textarea class="form-control" id="isi" name="isi" rows="10" required style="white-space: pre-wrap;"><?= htmlspecialchars($data['isi']) ?></textarea>
                </div>

                <div class="form-group">
                  <label for="kategori"><i class="fas fa-tag mr-1"></i>Kategori</label>
                  <select class="form-control" id="kategori" name="kategori" required onchange="toggleCustomKategori()">
                    <option value="">Pilih Kategori</option>
                    <option value="Berita" <?= $data['kategori'] == 'Berita' ? 'selected' : '' ?>>Berita</option>
                    <option value="Pengumuman" <?= $data['kategori'] == 'Pengumuman' ? 'selected' : '' ?>>Pengumuman</option>
                    <option value="Event" <?= $data['kategori'] == 'Event' ? 'selected' : '' ?>>Event</option>
                    <option value="Olahraga" <?= $data['kategori'] == 'Olahraga' ? 'selected' : '' ?>>Olahraga</option>
                    <option value="Akademik" <?= $data['kategori'] == 'Akademik' ? 'selected' : '' ?>>Akademik</option>
                    <option value="Bootcamp" <?= $data['kategori'] == 'Bootcamp' ? 'selected' : '' ?>>Bootcamp</option>
                    <option value="Seminar" <?= $data['kategori'] == 'Seminar' ? 'selected' : '' ?>>Seminar</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </div>

                <div class="form-group" id="customKategoriGroup" style="display: none;">
                  <label for="customKategori"><i class="fas fa-plus-circle mr-1"></i>Kategori Lainnya</label>
                  <input type="text" class="form-control" id="customKategori" name="customKategori" placeholder="Masukkan kategori lainnya">
                </div>

                <div class="form-group">
                  <label for="tanggal"><i class="fas fa-calendar-alt mr-1"></i>Tanggal Berita</label>
                  <input type="datetime-local" id="tanggal" name="tanggal" class="form-control" required value="<?= date('Y-m-d\TH:i', strtotime($data['tanggal'])) ?>">
                  <div class="invalid-feedback">Tanggal berita harus diisi.</div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label><i class="fas fa-image mr-1"></i>Gambar Saat Ini</label>
                  <div class="mb-3">
                    <img src="../uploads/<?= htmlspecialchars($data['gambar']) ?>" alt="Gambar berita" class="img-preview img-fluid">
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
    });

    // Function to toggle custom kategori input
    function toggleCustomKategori() {
      var kategoriSelect = document.getElementById('kategori');
      var customKategoriGroup = document.getElementById('customKategoriGroup');
      var customKategoriInput = document.getElementById('customKategori');
      
      if (kategoriSelect.value === 'Lainnya') {
        customKategoriGroup.style.display = 'block';
        customKategoriInput.required = true;
      } else {
        customKategoriGroup.style.display = 'none';
        customKategoriInput.required = false;
      }
    }

    // Check on page load if "Lainnya" is selected
    document.addEventListener('DOMContentLoaded', function() {
      var kategoriSelect = document.getElementById('kategori');
      if (kategoriSelect.value === 'Lainnya') {
        toggleCustomKategori();
      }
    });
  </script>
</body>
</html>
