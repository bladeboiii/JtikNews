<?php
include 'koneksi.php';
$conn = $koneksi;

$single_beasiswa = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql_single = "SELECT * FROM beasiswa WHERE id_beasiswa = ?";
    $stmt = $conn->prepare($sql_single);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_single = $stmt->get_result();
    if ($result_single && $result_single->num_rows > 0) {
        $single_beasiswa = $result_single->fetch_assoc();
    }
    $stmt->close();
}

$sql_all = "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC";
$result_all = $conn->query($sql_all);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beasiswa - Jurusan TIK</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

  <style>
    body { font-family: "Segoe UI", sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
    .navbar { background-color: #56021f; }
    .navbar .navbar-brand, .navbar .nav-link { color: white; }
    .navbar .nav-link:hover { color: #ffc107; }
    .nav-link.active { font-weight: bold; color: #ffc107 !important; }
    
    /* Header section with pattern overlay */
    header { 
      background: url('img/bg_header_beasiswa.jpg');
      background-size: cover;
      background-position: center;
      color: white; 
      padding: 80px 0; 
      text-align: center;
      position: relative;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      margin-bottom: 30px;
    }
    
    /* Semi-transparent overlay */
    header:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(to right, rgba(86, 2, 31, 0.8), rgba(138, 5, 54, 0.7));
      z-index: 1;
    }
    
    header .container-fluid {
      position: relative;
      z-index: 2;
    }
    
    header h1 {
      font-weight: 800;
      letter-spacing: 1px;
      margin-bottom: 20px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
      animation: fadeInDown 1s ease-out;
    }
    
    header p {
      font-size: 1.25rem;
      max-width: 700px;
      margin: 0 auto;
      opacity: 0.9;
      animation: fadeInUp 1s ease-out;
    }
    
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    section { padding: 60px 0; }
    .container-fluid { padding-left: 5%; padding-right: 5%; }
    
    /* Balanced container for content sections */
    .balanced-container {
      max-width: 1600px;
      margin-left: auto;
      margin-right: auto;
      padding-left: 10px;
      padding-right: 10px;
      width: 100%;
    }
    
    /* Single Beasiswa Styles */
    .beasiswa-header {
      position: relative;
      padding: 80px 0;
      margin-bottom: 40px;
      background-size: cover;
      background-position: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .beasiswa-header:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(86, 2, 31, 0.85);
      z-index: 1;
    }
    
    .beasiswa-header .container-fluid {
      position: relative;
      z-index: 2;
    }
    
    .beasiswa-image {
      max-height: 300px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    
    .beasiswa-image:hover {
      transform: scale(1.02);
    }
    
    .beasiswa-title {
      color: #56021f;
      font-weight: 600;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 2px solid #56021f;
      letter-spacing: 0.5px;
    }
    
    .back-button {
      background: linear-gradient(45deg, #56021f, #8a0b2e);
      color: white !important;
      border: none;
      padding: 0.8rem 1.5rem;
      border-radius: 8px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
    }
    
    .back-button:hover {
      background: linear-gradient(45deg, #8a0b2e, #56021f);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(86, 2, 31, 0.2);
      color: white !important;
      text-decoration: none;
    }
    
    .requirements-card {
      background-color: #fff;
      border-left: 4px solid #56021f;
      border-radius: 8px;
      padding: 25px;
      margin-bottom: 25px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    
    .requirements-card h4 {
      color: #56021f;
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    .apply-button {
      background-color: #ffc107;
      color: #fff;
      border: none;
      padding: 12px 36px;
      border-radius: 50px;
      font-size: 1.15rem;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    
    .apply-button:hover {
      background-color: #e0a800;
      color: #fff;
      transform: translateY(-2px);
    }
    
    /* Program badges style */
    .program-badges {
      display: flex;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    
    .program-badge {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 13px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .badge-s1 { background-color: #28a745; }
    .badge-sma { background-color: #007bff; }
    .badge-smp { background-color: #6610f2; }
    .badge-sd { background-color: #dc3545; }
    .badge-ma { background-color: #fd7e14; }
    .badge-d3 { background-color: #fd7e14; }
    .badge-d4 { background-color: #e83e8c; }
    .badge-s2 { background-color: #20c997; }
    .badge-s3 { background-color: #6f42c1; }
    
    .beasiswa-meta {
      background-color: #f8f9fa;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 3px 15px rgba(0,0,0,0.05);
      border-left: 3px solid #56021f;
    }
    
    .beasiswa-meta-item {
      margin-bottom: 12px;
    }
    
    .beasiswa-meta-item:last-child {
      margin-bottom: 0;
    }
    
    .meta-label {
      font-size: 13px;
      color: #6c757d;
      display: block;
      margin-bottom: 3px;
    }
    
    .meta-value {
      font-size: 15px;
      font-weight: 600;
      color: #212529;
    }
    
    .deadline-value {
      color: #dc3545;
    }
    
    /* Info card in detail view */
    .info-card {
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      border: none;
    }
    
    .info-card .card-header {
      background-color: #56021f;
      color: white;
      padding: 15px 20px;
      font-weight: 600;
      font-size: 18px;
      border-bottom: none;
    }
    
    .info-card .card-body {
      padding: 20px;
    }
    
    .info-section {
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid #f0f0f0;
    }
    
    .info-section:last-child {
      margin-bottom: 0;
      padding-bottom: 0;
      border-bottom: none;
    }
    
    .info-section-title {
      font-size: 15px;
      font-weight: 500;
      color: #6c757d;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }
    
    .info-section-title i {
      margin-right: 8px;
      color: #56021f;
    }
    
    .info-section-content {
      font-size: 16px;
      font-weight: 600;
      color: #212529;
    }
    
    .info-section-date {
      display: flex;
      justify-content: space-between;
    }
    
    .date-item {
      flex: 1;
    }
    
    .date-label {
      font-size: 13px;
      color: #6c757d;
      margin-bottom: 5px;
    }
    
    .date-value {
      font-size: 15px;
      font-weight: 600;
    }
    
    .deadline-value {
      color: #dc3545;
    }
    
    .badge-status {
      font-size: 14px;
      padding: 5px 12px;
      border-radius: 20px;
    }
    
    .info-footer {
      display: flex;
      align-items: center;
      color: #6c757d;
      font-size: 14px;
      margin-top: 10px;
    }
    
    .info-footer i {
      margin-right: 8px;
      color: #56021f;
    }
    
    /* Card beasiswa in list view */
    .beasiswa-list-item {
      background-color: #fff;
      border-radius: 12px !important;
      border: none !important;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      margin-bottom: 25px;
      transition: all 0.25s ease;
      height: 100%;
      position: relative;
    }
    
    .beasiswa-list-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(86, 2, 31, 0.12);
    }
    
    .beasiswa-list-item .card-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      height: 100%;
    }
    
    .beasiswa-list-item .card-title {
      color: #56021f;
      font-weight: 700;
      margin-bottom: 15px;
      font-size: 1.1rem;
      line-height: 1.3;
      height: auto;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }
    
    .beasiswa-list-item .img-container {
      height: 180px;
      overflow: hidden;
      position: relative;
    }
    
    .beasiswa-list-item .img-container::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 30%;
      background: linear-gradient(to top, rgba(0,0,0,0.5), rgba(0,0,0,0));
      pointer-events: none;
    }
    
    .beasiswa-list-item .img-container img {
      object-fit: cover;
      width: 100%;
      height: 100%;
      transition: transform 0.5s ease;
    }
    
    .beasiswa-list-item:hover .img-container img {
      transform: scale(1.05);
    }
    
    /* Location display */
    .location-display {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      color: #666;
      font-size: 14px;
    }
    
    .location-display i {
      color: #dc3545;
      margin-right: 8px;
    }
    
    /* Date display */
    .date-container {
      display: flex;
      margin-bottom: 15px;
      position: relative;
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 10px;
    }
    
    .date-container::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 3px;
      background-color: #56021f;
      border-radius: 3px;
    }
    
    .date-info {
      padding-left: 12px;
      width: 100%;
    }
    
    .date-row {
      display: flex;
      justify-content: space-between;
    }
    
    .date-label {
      font-size: 12px;
      color: #6c757d;
      margin-bottom: 4px;
    }
    
    .date-value {
      font-size: 14px;
      font-weight: 600;
    }
    
    .deadline-value {
      color: #dc3545;
    }
    
    /* Description truncate */
    .card-text-container {
      flex-grow: 1;
      margin-bottom: 15px;
    }
    
    .card-text {
      font-size: 14px;
      line-height: 1.5;
      height: 42px;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      color: #666;
    }
    
    /* Bottom buttons */
    .buttons-container {
      display: block !important;
      margin-top: 16px !important;
      padding-top: 10px !important;
      z-index: 1000 !important;
      position: relative !important;
    }
    
    .btn-read-more {
      display: inline-flex !important;
      visibility: visible !important;
      opacity: 1 !important;
    }
    
    .buttons-container .btn {
      flex: 1;
      white-space: nowrap;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px 12px;
      font-size: 14px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .buttons-container .btn i {
      margin-right: 5px;
    }
    
    .buttons-container .btn-warning {
      background: linear-gradient(45deg, #ffc107, #ff9800);
      border: none;
      color: #fff;
    }
    
    .buttons-container .btn-warning:hover {
      background: linear-gradient(45deg, #ff9800, #ffc107);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 152, 0, 0.2);
    }
    
    .buttons-container .btn-danger {
      background: linear-gradient(45deg, #dc3545, #c82333);
      border: none;
      color: #fff;
    }
    
    .buttons-container .btn-danger:hover {
      background: linear-gradient(45deg, #c82333, #dc3545);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
    }
    
    /* Card content adjustments */
    .beasiswa-content {
      padding: 0 3px;
    }
    
    .location-icon {
      color: #dc3545;
      margin-right: 5px;
    }
    
    .location-text {
      color: #666;
      font-size: 14px;
    }
    
    /* Section title with underline */
    .section-title {
      position: relative;
      color: #212529;
      font-weight: 700;
      margin-bottom: 30px;
      padding-bottom: 12px;
      display: inline-block;
    }
    
    .section-title:after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background-color: #56021f;
    }
    
    @media (max-width: 768px) {
      .beasiswa-header {
        padding: 50px 0;
      }
      .beasiswa-list-meta {
        flex-direction: column;
        gap: 10px;
      }
      header {
        padding: 50px 0;
      }
      header h1 {
        font-size: 2rem;
      }
      header p {
        font-size: 1rem;
      }
      .apply-button {
        width: 100%;
      }
      .beasiswa-list-item .card-title {
        height: auto;
        -webkit-line-clamp: 3;
      }
      .beasiswa-list-item .img-container {
        height: 140px;
      }
    }
    
    @media (max-width: 576px) {
      .container-fluid { padding-left: 3%; padding-right: 3%; }
      .beasiswa-list-item .card-body {
        padding: 15px;
      }
      .btn-beasiswa-action {
        padding: 8px 16px;
        font-size: 14px;
      }
      .buttons-container {
        flex-direction: column;
        gap: 10px;
      }
      .beasiswa-list-item .card-text {
        height: auto;
        -webkit-line-clamp: 2;
      }
    }
    
    /* Additional alignment styles */
    .row.g-4 {
      justify-content: space-between;
    }
    
    .col {
      display: flex;
    }
    
    .beasiswa-list-item {
      width: 100%;
    }
    
    @media (min-width: 992px) {
      .row.balanced-container.mx-auto {
        max-width: 1320px;
      }
    }

    .btn,
    .btn-detail,
    .btn-register,
    .apply-button,
    .back-button {
      color: #fff !important;
    }

    .btn-read-more {
      background-color: #ffc107;
      color: #fff;
      border: none;
      padding: 8px 18px;
      border-radius: 50px;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      text-decoration: none;
    }
    .btn-read-more:hover {
      background-color: #e0a800;
      color: #fff;
      transform: translateY(-2px);
    }

    .btn-outline-danger.back-button {
      color: #c62828 !important;
      border-color: #c62828 !important;
      background-color: transparent !important;
      font-weight: 600;
      font-size: 1.15rem;
      padding: 10px 32px;
    }
    .btn-outline-danger.back-button:hover,
    .btn-outline-danger.back-button:focus {
      background-color: #c62828 !important;
      color: #fff !important;
      border-color: #c62828 !important;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<?php if ($single_beasiswa): ?>
  <!-- Single Beasiswa View -->
  <div class="beasiswa-header" style="background-image: url('img/bg_header_beasiswa.jpg');">
    <div class="container-fluid text-center">
      <h1 class="display-5 fw-bold text-white">Detail Beasiswa</h1>
      <p class="lead text-white">Informasi lengkap mengenai beasiswa yang tersedia</p>
    </div>
  </div>

   <section>
    <div class="container-fluid">
      <div class="row balanced-container mx-auto">
        <div class="col-12">
          <a href="beasiswa.php" class="back-button mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Beasiswa
          </a>
        </div>
        
        <div class="col-md-8">
          <h2 class="beasiswa-title"><?= htmlspecialchars($single_beasiswa['nama_beasiswa']) ?></h2>
          
          <div class="mb-4">
            <h4 class="section-title">Deskripsi</h4>
            <p class="text-muted"><?= nl2br(htmlspecialchars($single_beasiswa['deskripsi'])) ?></p>
          </div>
          
          <div class="requirements-card">
            <h4><i class="bi bi-check-circle-fill me-2 text-danger"></i>Persyaratan</h4>
            <p class="text-muted"><?= nl2br(htmlspecialchars($single_beasiswa['syarat'])) ?></p>
          </div>
          
          <a href="<?= htmlspecialchars($single_beasiswa['link_pendaftaran']) ?>" class="btn btn-detail btn-read-more mt-3" target="_blank">
            <i class="bi bi-box-arrow-up-right" style="font-size:1.2em;"></i> Daftar Sekarang
          </a>
        </div>
        
        <div class="col-md-4">
          <img src="uploads/<?= htmlspecialchars($single_beasiswa['gambar']) ?>" alt="<?= htmlspecialchars($single_beasiswa['nama_beasiswa']) ?>" class="img-fluid beasiswa-image mb-4">
          
          <div class="info-card">
            <div class="card-header">
              <i class="bi bi-info-circle me-2"></i>Informasi Beasiswa
            </div>
            <div class="card-body">
              <?php
              // Array of program levels for badge display
              $program_levels = [
                ['code' => 's1', 'name' => 'S1'],
                ['code' => 'sma', 'name' => 'SMA'],
                ['code' => 'smp', 'name' => 'SMP'],
                ['code' => 'sd', 'name' => 'SD'],
                ['code' => 's2', 'name' => 'S2'],
                ['code' => 's3', 'name' => 'S3'],
                ['code' => 'd3', 'name' => 'D3'],
                ['code' => 'd4', 'name' => 'D4'],
                ['code' => 'ma', 'name' => 'MA']
              ];
              
              // Get jenjang value from database if it exists
              $jenjang_array = [];
              if (!empty($single_beasiswa['jenjang'])) {
                $jenjang_array = explode(',', $single_beasiswa['jenjang']);
              }
              
              if (!empty($jenjang_array)): 
              ?>
              <div class="info-section">
                <div class="info-section-title">
                  <i class="bi bi-mortarboard-fill"></i>Jenjang Pendidikan:
                </div>
                <div class="program-badges">
                  <?php foreach ($jenjang_array as $jenjang): ?>
                    <?php 
                      $badge_code = strtolower($jenjang);
                      if (in_array($badge_code, array_column($program_levels, 'code'))) {
                        echo '<div class="program-badge badge-' . $badge_code . '">' . $jenjang . '</div>';
                      }
                    ?>
                  <?php endforeach; ?>
                </div>
              </div>
              <?php endif; ?>
              
              <?php if (!empty($single_beasiswa['lokasi'])): ?>
              <div class="info-section">
                <div class="info-section-title">
                  <i class="bi bi-geo-alt-fill"></i>Lokasi:
                </div>
                <div class="info-section-content">
                  <?= htmlspecialchars($single_beasiswa['lokasi']) ?>
                </div>
              </div>
              <?php endif; ?>
              
              <?php if (!empty($single_beasiswa['tanggal_mulai']) || !empty($single_beasiswa['deadline'])): ?>
              <div class="info-section">
                <div class="info-section-date">
                  <?php if (!empty($single_beasiswa['tanggal_mulai'])): ?>
                  <div class="date-item">
                    <div class="date-label">Mulai:</div>
                    <div class="date-value"><?= date('d M Y', strtotime($single_beasiswa['tanggal_mulai'])) ?></div>
                  </div>
                  <?php endif; ?>
                  
                  <?php if (!empty($single_beasiswa['deadline'])): ?>
                  <div class="date-item">
                    <div class="date-label">Deadline:</div>
                    <div class="date-value deadline-date"><?= date('d M Y', strtotime($single_beasiswa['deadline'])) ?></div>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
              <?php endif; ?>
              
              <div class="info-section">
                <div class="info-section-title">
                  <i class="bi bi-bookmark-fill"></i>Kategori:
                </div>
                <div class="info-section-content">
                  Beasiswa Pendidikan
                </div>
              </div>
              
              <div class="info-section">
                <div class="info-section-title">
                  <i class="bi bi-building"></i>Penyelenggara:
                </div>
                <div class="info-section-content">
                  Jurusan TIK
                </div>
              </div>
              
              <div class="info-section">
                <div class="info-section-title">
                  <i class="bi bi-calendar-check"></i>Status:
                </div>
                <div class="info-section-content">
                  <span class="badge bg-success badge-status">Aktif</span>
                </div>
              </div>
              
              <div class="info-footer">
                <i class="bi bi-info-circle"></i> Untuk informasi lebih lanjut hubungi admin Jurusan TIK
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php else: ?>
  <!-- All Beasiswa List View -->
  <!-- Header Section -->
  <header>
    <div class="container-fluid">
      <h1 class="display-5 fw-bold">Informasi Beasiswa</h1>
      <p class="lead">Dapatkan informasi beasiswa terbaru untuk mendukung studimu di Jurusan TIK</p>
    </div>
  </header>

  <!-- Konten Beasiswa -->
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h3 class="section-title">Beasiswa Aktif</h3>
          <div class="mb-4">
            <a href="index.php" class="back-button">
              <i class="bi bi-arrow-left"></i> Kembali ke Beranda
            </a>
          </div>
          
          <?php if ($result_all && $result_all->num_rows > 0): ?>
          <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 balanced-container mx-auto">
        <?php 
              // Program levels for badge display
              $program_levels = [
                ['code' => 's1', 'name' => 'S1'],
                ['code' => 'sma', 'name' => 'SMA'],
                ['code' => 'smp', 'name' => 'SMP'],
                ['code' => 'sd', 'name' => 'SD'],
                ['code' => 's2', 'name' => 'S2'],
                ['code' => 's3', 'name' => 'S3'],
                ['code' => 'd3', 'name' => 'D3'],
                ['code' => 'd4', 'name' => 'D4'],
                ['code' => 'ma', 'name' => 'MA']
              ];
              
              while($row = $result_all->fetch_assoc()):
                // Get jenjang value from database if it exists
                $jenjang_array = [];
                if (!empty($row['jenjang'])) {
                  $jenjang_array = explode(',', $row['jenjang']);
                }
                
                // Get location from database or use default
                $location = isset($row['lokasi']) && !empty($row['lokasi']) 
                    ? $row['lokasi'] 
                    : 'Indonesia';
                
                // Format dates
                $start_date = !empty($row['tanggal_mulai']) 
                    ? date('d M Y', strtotime($row['tanggal_mulai'])) 
                    : '';
                    
                $deadline_date = !empty($row['deadline']) 
                    ? date('d M Y', strtotime($row['deadline'])) 
                    : '';
              ?>
              <div class="col">
                <div class="beasiswa-list-item">
                  <a href="beasiswa.php?id=<?= $row['id_beasiswa'] ?>" class="text-decoration-none">
                    <div class="img-container">
                      <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="Beasiswa Image">
                    </div>
                  </a>
                  <div class="card-body d-flex flex-column">
                    <a href="beasiswa.php?id=<?= $row['id_beasiswa'] ?>" class="text-decoration-none">
                      <h5 class="card-title"><?= htmlspecialchars($row['nama_beasiswa']) ?></h5>
                    </a>
                    
                    <?php if (!empty($jenjang_array)): ?>
                    <div class="program-badges mb-3">
                      <?php foreach ($jenjang_array as $jenjang): ?>
                        <?php 
                          $badge_code = strtolower($jenjang);
                          if (in_array($badge_code, array_column($program_levels, 'code'))) {
                            echo '<div class="program-badge badge-' . $badge_code . '">' . $jenjang . '</div>';
                          }
                        ?>
                      <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($location)): ?>
                    <div class="location-display">
                      <i class="bi bi-geo-alt-fill"></i>
                      <span><?= htmlspecialchars($location) ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($start_date) || !empty($deadline_date)): ?>
                    <div class="date-container">
                      <div class="date-info">
                        <div class="date-row">
                          <?php if (!empty($start_date)): ?>
                          <div>
                            <div class="date-label">Mulai:</div>
                            <div class="date-value"><?= $start_date ?></div>
                          </div>
                          <?php endif; ?>
                          
                          <?php if (!empty($deadline_date)): ?>
                          <div>
                            <div class="date-label">Deadline:</div>
                            <div class="date-value deadline-value"><?= $deadline_date ?></div>
                          </div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="card-text-container">
                      <p class="card-text"><?= substr(htmlspecialchars($row['deskripsi']), 0, 80) ?>...</p>
                    </div>
                    <div class="buttons-container">
                      <a href="beasiswa.php?id=<?= $row['id_beasiswa'] ?>" class="btn btn-detail btn-read-more">
                        <i class="bi bi-info-circle"></i> Selengkapnya
                      </a>
                      <?php if (!empty($row['link_pendaftaran'])): ?>
                      <a href="<?= htmlspecialchars($row['link_pendaftaran']) ?>" class="btn btn-danger btn-sm d-inline-flex align-items-center" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Daftar
                      </a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php endwhile; ?>
            </div>
          <?php elseif ($result_all): ?>
              <div class="alert alert-info p-4 text-center">
                <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                <p class="fs-5 mb-0">Tidak ada data beasiswa saat ini.</p>
              </div>
          <?php else: ?>
              <div class="alert alert-danger p-4 text-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                <p class="fs-5 mb-0">Terjadi kesalahan saat mengambil data.</p>
              </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>

<!-- footer  -->
<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Inisialisasi semua dropdown Bootstrap
  document.addEventListener('DOMContentLoaded', function() {
    // Pastikan Bootstrap telah dimuat
    if (typeof bootstrap !== 'undefined') {
      // Inisialisasi semua dropdown
      var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
      dropdownElementList.forEach(function(dropdownToggleEl) {
        new bootstrap.Dropdown(dropdownToggleEl);
      });
    }
  });
</script>
</body>
</html>
