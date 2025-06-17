<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Web_jurusan";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) { die("Koneksi gagal: " . $conn->connect_error); }

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Hasil Pencarian - Jurusan TIK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css"/>
  <style>
    .navbar { background-color: #56021f !important; }
    .navbar .navbar-brand, .navbar .nav-link { color: #fff !important; }
    .navbar .nav-link:hover { color: #ffc107 !important; }
    .nav-link.active { font-weight: bold; color: #ffc107 !important; }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Hasil Pencarian: <em><?= htmlspecialchars($q) ?></em></h2>
  <?php if ($q): ?>
    <h4 class="mt-4 mb-3">Berita</h4>
    <div class="row">
      <?php
      $stmt = $conn->prepare("SELECT * FROM berita WHERE judul LIKE ? OR isi LIKE ? ORDER BY tanggal DESC");
      $like = "%$q%";
      $stmt->bind_param("ss", $like, $like);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
      ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100">
            <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
              <p class="card-text"><?= substr(strip_tags($row['isi']), 0, 100) ?>...</p>
              <a href="berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-warning btn-sm text-white">Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php endwhile; else: ?>
        <div class="col-12"><div class="alert alert-info">Tidak ada berita ditemukan.</div></div>
      <?php endif; ?>
    </div>
    <h4 class="mt-5 mb-3">Beasiswa</h4>
    <div class="row">
      <?php
      $stmt = $conn->prepare("SELECT * FROM beasiswa WHERE nama_beasiswa LIKE ? OR deskripsi LIKE ? ORDER BY id_beasiswa DESC");
      $stmt->bind_param("ss", $like, $like);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
      ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card h-100">
            <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['nama_beasiswa']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['nama_beasiswa']) ?></h5>
              <p class="card-text"><?= substr(strip_tags($row['deskripsi']), 0, 100) ?>...</p>
              <a href="beasiswa.php?id=<?= $row['id_beasiswa'] ?>" class="btn btn-warning btn-sm text-white">Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php endwhile; else: ?>
        <div class="col-12"><div class="alert alert-info">Tidak ada beasiswa ditemukan.</div></div>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">Masukkan kata kunci pencarian.</div>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
