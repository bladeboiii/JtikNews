<?php
session_start();
include_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get form data
  $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
  $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
  $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
  $penulis = mysqli_real_escape_string($koneksi, $_POST['penulis']);
  $id_admin_user = isset($_POST['id_admin_user']) ? (int)$_POST['id_admin_user'] : 1;
  $tanggal = date('Y-m-d H:i:s');
  
  // Handle file upload
  $gambar = '';
  if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
    $namaFile = basename($_FILES['gambar']['name']);
    $namaBaru = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $namaFile);
    $targetDir = "../uploads/";
    $targetFile = $targetDir . $namaBaru;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Validate file type
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if(in_array($fileType, $allowedTypes)) {
      if(move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
        $gambar = $namaBaru;
      }
    }
  }
  
  // Insert data into database
  $sql = "INSERT INTO berita (judul, isi, tanggal, kategori, gambar, penulis, id_admin_user) 
          VALUES ('$judul', '$isi', '$tanggal', '$kategori', '$gambar', '$penulis', $id_admin_user)";
  
  $result = mysqli_query($koneksi, $sql);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Proses Input Berita</title>
  <style>
    body { font-family: sans-serif; background: #f5f5f5; padding: 40px; }
    .box { background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-align: center; }
    .success { color: green; font-size: 18px; margin-bottom: 20px; }
    .error { color: red; font-size: 18px; margin-bottom: 20px; }
    a { text-decoration: none; color: white; background: #007BFF; padding: 10px 20px; border-radius: 5px; }
  </style>
</head>
<body>
  <div class="box">
    <?php if (isset($result) && $result): ?>
      <div class="success">Berita berhasil ditambahkan.</div>
    <?php else: ?>
      <div class="error">Gagal menambahkan berita.</div>
    <?php endif; ?>
    <a href="admin.php">Kembali ke Daftar Berita</a>
  </div>
</body>
</html>
