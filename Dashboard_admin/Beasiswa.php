<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect jika belum login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../login.php");
    exit;
}

include_once "../koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Beasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #56021f;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        .table th {
            background-color: #f8f9fa;
            color: #56021f;
        }
        .img-thumbnail {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            height: 80px;
            object-fit: cover;
        }
        .description-cell {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .bg-maroon {
            background-color: #56021f;
            color: white;
        }
        .stats-card {
            transition: all 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        /* Styling untuk tombol action */
        .btn-action-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }
        .btn-action-container .btn {
            flex: 1;
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .btn-action-container .btn i {
            margin-right: 5px;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .action-buttons .btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .action-buttons .btn i {
            margin-right: 5px;
        }
        .btn-icon {
            border-radius: 50%;
            width: 35px;
            height: 35px;
            padding: 0;
            line-height: 35px;
            text-align: center;
            margin-right: 5px;
        }
        /* Add more hover effects for buttons */
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #212529;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        
        /* Consistent button shadow effects */
        .btn {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        /* Improve the alignment in table cells */
        .table td {
            vertical-align: middle;
        }
        .table-responsive {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<?php
include "./Header.php";
include "./sidebar.php";
?>

<div id="main">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <h2><i class="fas fa-award mr-2"></i>Beasiswa</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Beasiswa</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- List Beasiswa -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-award mr-2"></i>List Beasiswa</span>
                <div>
                    <div class="input-group mr-2 d-inline-flex" style="width: 250px;">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari beasiswa...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-light" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <a href="input_beasiswa.php" class="btn btn-warning">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Beasiswa
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="beasiswaTable">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="15%">Gambar</th>
                                <th class="text-center" width="20%">Nama Beasiswa</th>
                                <th class="text-center" width="15%">Jenjang</th>
                                <th class="text-center" width="15%">Lokasi</th>
                                <th class="text-center" width="15%">Deadline</th>
                                <th class="text-center" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC");
                        if(mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                        <td class='text-center'>{$no}</td>
                                        <td class='text-center'><img src='../uploads/{$row['gambar']}' class='img-thumbnail' width='80'></td>
                                        <td>{$row['nama_beasiswa']}</td>
                                        <td>{$row['jenjang']}</td>
                                        <td>{$row['lokasi']}</td>
                                        <td class='text-center'>" . date('d M Y', strtotime($row['deadline'])) . "</td>
                                        <td class='text-center'>
                                          <div class='btn-action-container'>
                                            <a href='edit_beasiswa.php?id={$row['id_beasiswa']}' class='btn btn-warning btn-sm d-inline-flex align-items-center'>
                                              <i class='fas fa-edit me-1'></i> Edit
                                            </a>
                                            <a href=\"hapus_beasiswa.php?id={$row['id_beasiswa']}\" class=\"btn btn-danger btn-sm d-inline-flex align-items-center\" onclick=\"return confirm('Yakin ingin menghapus?')\">
                                              <i class='fas fa-trash-alt me-1'></i> Hapus
                                            </a>
                                          </div>
                                        </td>
                                      </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Tidak ada data beasiswa</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#beasiswaTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
</body>
</html>
