# 🌐 Sistem Informasi Jurusan TIK (Mahasiswa, Berita & Beasiswa)

Proyek ini merupakan aplikasi berbasis web yang dikembangkan untuk mengelola dan menyajikan informasi seputar **berita**, **beasiswa**, dan **profil jurusan**. Aplikasi ini memiliki dua sisi: tampilan **publik** untuk pengunjung dan **dashboard admin** untuk pengelola konten.

---

## 📁 Struktur Proyek

Berikut adalah struktur direktori utama dalam proyek ini:

- `admin/` — Halaman login dan fungsi otentikasi admin (`login.php`, `hash.php`).
- `Dashboard_admin/` — Halaman dashboard untuk admin, mencakup manajemen:
  - Berita (`berita2.php`, `input_berita.php`, `edit_berita.php`, dll)
  - Beasiswa (`Beasiswa.php`, `input_beasiswa.php`, `edit_beasiswa.php`)
- `css/` — File CSS frontend (`style.css`)
- `img/` — Aset gambar statis
- `uploads/` — Folder upload gambar berita dan beasiswa
- `index.php` — Halaman utama publik
- `search.php` — Fitur pencarian berita dan beasiswa
- `koneksi.php` — Koneksi ke database
- `navbar.php`, `footer.php` — Komponen tampilan frontend

---

## ⚙️ Fitur Utama

### ✅ 1. Halaman Publik
- Beranda dengan slider berita & highlight berita
- Daftar berita dan beasiswa terbaru
- Detail berita dan beasiswa
- Tampilan responsif dan estetis

### 🔐 2. Dashboard Admin
- Login otentikasi admin
- CRUD **berita**:
  - Tambah, edit, hapus
  - Set berita sebagai *highlight*
- CRUD **beasiswa**:
  - Tambah, edit, hapus
  - Kelola tanggal mulai & deadline
- Upload gambar berita & beasiswa

### 🔎 3. Fitur Pencarian
- Cari berita atau beasiswa berdasarkan kata kunci

---

## 🛠️ Cara Menjalankan Proyek

### 1. **Setup Database**
- Import file `web_jurusan.sql` ke MySQL via phpMyAdmin
- Pastikan database name sesuai dengan yang digunakan di `koneksi.php`

### 2. **Konfigurasi Database**
Ubah isi `koneksi.php`:
```php
$host = "localhost"; // atau host dari InfinityFree
$user = "USERNAME_DATABASE";
$password = "PASSWORD_DATABASE";
$db_name = "NAMA_DATABASE";

$koneksi = new mysqli($host, $user, $password, $db_name);
````

Menjalankan Lokal
Letakkan folder ini di htdocs (jika menggunakan XAMPP).
Akses di browser: http://localhost/Website-Jurusan-TIK.

Contoh Proses: Edit Beasiswa
File: edit_beasiswa.php
Alur:
Ambil data beasiswa berdasarkan ID.
Jika form disubmit, perbarui data di database.
Jika ada gambar baru, simpan ke folder uploads dan update gambar di database.
Redirect kembali ke halaman beasiswa.
Contoh kode utama:
```php
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST['nama_beasiswa'];
    $deskripsi = $_POST['deskripsi'];
    $syarat = $_POST['syarat'];
    $link = $_POST['link_pendaftaran'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../uploads/" . $gambar);
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
```
Teknologi yang Digunakan
Teknologi	Keterangan
PHP	Bahasa utama backend
MySQL	Basis data untuk menyimpan data
HTML5, CSS3	Tampilan antarmuka
Bootstrap 5	Framework responsif modern
XAMPP/InfinityFree	Server lokal & deployment online

Keamanan
Password admin disimpan menggunakan bcrypt hash.
Input pengguna harus divalidasi untuk menghindari SQL Injection (disarankan gunakan mysqli_prepare di masa depan).
Gambar diupload dengan nama asli – sebaiknya diberi prefix atau diubah untuk keamanan lebih baik.

Kolaborasi
Fork repositori ini.
Buat branch baru: git checkout -b fitur-anda.
Lakukan perubahan dan commit: git commit -m "Fitur baru: tambah pencarian".
Push branch: git push origin fitur-anda.
Buat Pull Request ke repo utama.

Kontak
Jurusan Teknik Informatika & Komputer
Politeknik Negeri Ujung Pandang
📍 Jl. Perintis Kemerdekaan KM.10, Makassar
📧 90245, Sulawesi Selatan
📺 Profil YouTube

Dibuat untuk mendukung keterbukaan informasi dan layanan digital di lingkungan Jurusan TIK. 🚀 ```