<?php
session_start();
include_once "../koneksi.php";

$id = $_GET['id'];
$data = $koneksi->query("SELECT gambar FROM beasiswa WHERE id_beasiswa=$id")->fetch_assoc();
if ($data && file_exists("../uploads/" . $data['gambar'])) {
    unlink("../uploads/" . $data['gambar']);
}

$sql = "DELETE FROM beasiswa WHERE id_beasiswa=$id";
if ($koneksi->query($sql)) {
    header("Location: Beasiswa.php");
} else {
    echo "Gagal menghapus data.";
}
?>
