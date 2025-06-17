<?php
session_start();
include_once "../koneksi.php";

if (isset($_POST['highlight_id'])) {
    $highlight_id = intval($_POST['highlight_id']);
    // Reset semua highlight ke 0
    $reset = mysqli_query($koneksi, "UPDATE berita SET highlight = 0");
    // Set highlight pada id yang dipilih
    $set = mysqli_query($koneksi, "UPDATE berita SET highlight = 1 WHERE id_berita = $highlight_id");
    if ($set) {
        header("Location: Beasiswa.php?highlight=success");
        exit;
    } else {
        header("Location: Beasiswa.php?highlight=fail");
        exit;
    }
} else {
    header("Location: Beasiswa.php?highlight=none");
    exit;
}
?>
