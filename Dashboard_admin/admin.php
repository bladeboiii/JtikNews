<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
session_start();
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
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .btn-icon {
      border-radius: 50%;
      width: 35px;
      height: 35px;
      padding: 0;
      line-height: 35px;
      text-align: center;
      margin-right: 5px;
    }
    .table-responsive {
      border-radius: 10px;
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
    .stats-card {
      transition: all 0.3s;
    }
    .stats-card:hover {
      transform: translateY(-5px);
    }
    .bg-maroon {
      background-color: #56021f;
      color: white;
    }
    .btn-action-container {
      display: flex;
      gap: 8px;
      justify-content: center;
    }
    .btn-action-container .btn {
      font-weight: 600;
      box-shadow: 0 2px 4px rgba(0,0,0,0.07);
      border-radius: 6px;
      padding: 6px 16px;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
    }
    .btn-action-container .btn-warning {
      background-color: #ffc107;
      border: none;
      color: #fff !important;
    }
    .btn-action-container .btn-warning:hover {
      background-color: #e0a800;
      color: #fff !important;
    }
    .btn-action-container .btn-danger {
      background-color: #dc3545;
      border: none;
      color: #fff !important;
    }
    .btn-action-container .btn-danger:hover {
      background-color: #c82333;
      color: #fff !important;
    }
    .btn-action-container i {
      font-size: 16px;
    }
    .btn-warning,
    .btn-success,
    .btn-primary {
      color: #fff !important;
    }
    .chart-container {
      position: relative;
      height: 300px;
      margin: 20px 0;
    }
    .nav-tabs .nav-link {
      color: #56021f;
      font-weight: 500;
    }
    .nav-tabs .nav-link.active {
      color: #56021f;
      font-weight: 600;
      border-color: #56021f;
    }
    .tab-content {
      padding: 20px;
      background: #fff;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <?php
    include "./Header.php";
    include "sidebar.php";
  ?>

<div id="main">
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-md-12 mb-4">
        <h2><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</h2>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <?php
        // Count berita
        $count_berita = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM berita"));
        
        // Count beasiswa
        $count_beasiswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM beasiswa"));
      ?>
      <div class="col-md-4">
        <div class="card stats-card">
          <div class="card-body bg-maroon rounded">
            <div class="d-flex align-items-center">
              <div class="mr-3">
                <i class="fas fa-newspaper fa-3x"></i>
              </div>
              <div>
                <h5 class="card-title mb-0">Total Berita</h5>
                <h2 class="mt-2 mb-0"><?= $count_berita ?></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card stats-card">
          <div class="card-body bg-warning rounded text-white">
            <div class="d-flex align-items-center">
              <div class="mr-3">
                <i class="fas fa-award fa-3x"></i>
              </div>
              <div>
                <h5 class="card-title mb-0">Total Beasiswa</h5>
                <h2 class="mt-2 mb-0"><?= $count_beasiswa ?></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card stats-card">
          <div class="card-body bg-success rounded text-white">
            <div class="d-flex align-items-center">
              <div class="mr-3">
                <i class="fas fa-calendar-alt fa-3x"></i>
              </div>
              <div>
                <h5 class="card-title mb-0">Tanggal</h5>
                <h4 class="mt-2 mb-0"><?= date('d M Y') ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Charts -->
    <div class="row">
      <div class="col-md-6">
    <div class="card">
          <div class="card-header">
            <i class="fas fa-chart-bar mr-2"></i>Statistik Berita per Kategori
          </div>
          <div class="card-body">
            <div class="chart-container">
              <canvas id="beritaChart"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <i class="fas fa-chart-pie mr-2"></i>Distribusi Beasiswa
      </div>
      <div class="card-body">
            <div class="chart-container">
              <canvas id="beasiswaChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

  <script>
// Data untuk grafik berita
const beritaCtx = document.getElementById('beritaChart').getContext('2d');
const beritaChart = new Chart(beritaCtx, {
  type: 'bar',
  data: {
    labels: ['Berita', 'Pengumuman', 'Event'],
    datasets: [{
      label: 'Jumlah Berita per Kategori',
      data: [12, 19, 3],
      backgroundColor: [
        'rgba(86, 2, 31, 0.8)',
        'rgba(255, 193, 7, 0.8)',
        'rgba(40, 167, 69, 0.8)'
      ],
      borderColor: [
        'rgba(86, 2, 31, 1)',
        'rgba(255, 193, 7, 1)',
        'rgba(40, 167, 69, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// Data untuk grafik beasiswa
const beasiswaCtx = document.getElementById('beasiswaChart').getContext('2d');
const beasiswaChart = new Chart(beasiswaCtx, {
  type: 'doughnut',
  data: {
    labels: ['S1', 'S2', 'S3', 'D3', 'D4'],
    datasets: [{
      data: [30, 20, 10, 25, 15],
      backgroundColor: [
        'rgba(86, 2, 31, 0.8)',
        'rgba(255, 193, 7, 0.8)',
        'rgba(40, 167, 69, 0.8)',
        'rgba(0, 123, 255, 0.8)',
        'rgba(220, 53, 69, 0.8)'
      ],
      borderColor: [
        'rgba(86, 2, 31, 1)',
        'rgba(255, 193, 7, 1)',
        'rgba(40, 167, 69, 1)',
        'rgba(0, 123, 255, 1)',
        'rgba(220, 53, 69, 1)'
      ],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom'
      }
    }
  }
    });
  </script>
</body>
</html>
