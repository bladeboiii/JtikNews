<?php
session_start();
include_once "../koneksi.php";

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $query = mysqli_query($koneksi, "DELETE FROM berita WHERE id_berita = $id");

  if ($query) {
    header("Location: admin.php");
    exit;
  } else {
    echo "Gagal menghapus data.";
  }
} else {
  echo "ID tidak ditemukan.";
}
?>
