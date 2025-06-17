<?php
session_start();
include_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id       = intval($_POST['id']);
  $judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
  $isi      = mysqli_real_escape_string($koneksi, $_POST['isi']);
  $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);

  // Ambil gambar lama
  $query = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id_berita=$id");
  $dataLama = mysqli_fetch_assoc($query);
  $gambarLama = $dataLama['gambar'];

  $gambarBaru = $gambarLama;

  // Jika ada file gambar baru diupload
  if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $namaFile = basename($_FILES['gambar']['name']);
    $namaBaru = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $namaFile);
    $targetDir = "../uploads/";
    $targetFile = $targetDir . $namaBaru;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validasi jenis file
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowedTypes)) {
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        // Hapus gambar lama jika ada dan berbeda
        if (!empty($gambarLama) && file_exists("../uploads/" . $gambarLama)) {
          unlink("../uploads/" . $gambarLama);
        }
        $gambarBaru = $namaBaru;
      }
    }
  }

  // Update data ke database
  $sql = "UPDATE berita SET judul='$judul', isi='$isi', kategori='$kategori', gambar='$gambarBaru' WHERE id_berita=$id";
  $result = mysqli_query($koneksi, $sql);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Proses Edit Berita</title>
  <style>
    body { font-family: sans-serif; background: #f5f5f5; padding: 40px; }
    .box { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
    .success { color: green; font-size: 18px; margin-bottom: 20px; }
    a { text-decoration: none; color: white; background: #007BFF; padding: 10px 20px; border-radius: 5px; }
  </style>
</head>
<body>
  <div class="box">
    <?php if (isset($result) && $result): ?>
      <div class="success">Berita berhasil diperbarui.</div>
    <?php else: ?>
      <div class="success" style="color:red;">Gagal memperbarui berita.</div>
    <?php endif; ?>
    <a href="admin.php">Kembali ke Daftar Berita</a>
  </div>
</body>
</html>
