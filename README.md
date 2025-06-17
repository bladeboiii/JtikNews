# Sistem Informasi Mahasiswa, Berita, dan Beasiswa

Proyek ini adalah sebuah sistem informasi berbasis web yang dirancang untuk mengelola data mahasiswa, berita, dan beasiswa. Sistem ini memungkinkan admin untuk mengelola data dengan mudah melalui antarmuka berbasis web, serta menyediakan informasi yang relevan kepada pengguna.

## Struktur Proyek

Berikut adalah struktur direktori proyek ini:

### Penjelasan Folder dan File

- **admin/**: Berisi file untuk autentikasi admin, seperti `login.php` dan `hash.php`.
- **Dashboard_admin/**: Berisi file untuk halaman dashboard admin, termasuk pengelolaan data mahasiswa, beasiswa, berita, dan fitur lainnya.
- **css/**: Berisi file CSS untuk styling halaman.
- **img/**: Berisi gambar-gambar yang digunakan dalam proyek.
- **uploads/**: Folder untuk menyimpan file yang diunggah, seperti gambar beasiswa atau berita.
- **koneksi.php**: File untuk mengatur koneksi ke database.
- **index.php**: Halaman utama dari sistem.
- **search.php**: File untuk fitur pencarian.

## Fitur Utama

1. **Manajemen Mahasiswa**

   - Tambah, edit, dan hapus data mahasiswa.
   - Menampilkan informasi mahasiswa secara terstruktur.

2. **Manajemen Beasiswa**

   - Tambah, edit, dan hapus data beasiswa.
   - Unggah gambar untuk setiap

3. **Manajemen Berita**

   - Tambah, edit, dan hapus berita.
   - Fitur untuk menyorot berita tertentu.

4. **Autentikasi Admin**

   - Login untuk admin dengan validasi.

5. **Pencarian**
   - Fitur pencarian untuk mempermudah pengguna menemukan informasi.

## Cara Menjalankan Proyek

1. **Persiapan**

   - Pastikan Anda memiliki server lokal seperti XAMPP atau WAMP.
   - Buat database dan impor file SQL yang sesuai (jika ada).

2. **Konfigurasi**

   - Perbarui file `koneksi.php` dengan kredensial database Anda:
     ```php
     $koneksi = new mysqli("localhost", "username", "password", "nama_database");
     ```

3. **Menjalankan**
   - Letakkan folder proyek di direktori `htdocs` (untuk XAMPP).
   - Akses proyek melalui browser, misalnya: `http://localhost/nama_proyek`.

## Penjelasan File Utama

### `edit_beasiswa.php`

File ini digunakan untuk mengedit data beasiswa yang sudah ada. Berikut adalah langkah-langkah kerja file ini:

1. **Mengambil Data Beasiswa**

   - Mengambil data beasiswa berdasarkan `id` yang diterima melalui parameter `GET`.
   - Query SQL:
     ```sql
     SELECT * FROM beasiswa WHERE id_beasiswa=$id
     ```

2. **Proses Pengeditan**

   - Jika form dikirimkan melalui metode `POST`, data yang diinputkan akan diperbarui ke database.
   - Jika ada file gambar yang diunggah, file tersebut akan disimpan di folder [uploads](http://_vscodecontentref_/7) dan nama file akan diperbarui di database.

3. **Validasi dan Redirect**
   - Jika query berhasil, pengguna akan diarahkan kembali ke halaman [Beasiswa.php](http://_vscodecontentref_/8).
   - Jika gagal, pesan error akan ditampilkan.

### Contoh Kode Utama

```php
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
```
