<?php
$host = "localhost";
$db_user = "root";
$password = ""; 
$db_name = "web_jurusan"; 

$koneksi = new mysqli($host, $db_user, $password, $db_name);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
