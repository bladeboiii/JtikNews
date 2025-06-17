<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Web_jurusan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// berita terbaru (maksimal 3)
$sql = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3";
$result = $conn->query($sql);

// beasiswa terbaru (maksimal 6 untuk slider)
$sql_beasiswa = "SELECT * FROM beasiswa ORDER BY id_beasiswa DESC LIMIT 6";
$result_beasiswa = $conn->query($sql_beasiswa);

// berita highlight (1 berita yang di-highlight)
$sql_highlight = "SELECT * FROM berita WHERE highlight = 1 LIMIT 1";
$result_highlight = $conn->query($sql_highlight);
$highlight_berita = $result_highlight && $result_highlight->num_rows > 0 ? $result_highlight->fetch_assoc() : null;

// berita terkini (skip highlight)
$sql_terkini = "SELECT * FROM berita WHERE highlight = 0 ORDER BY tanggal DESC LIMIT 3";
$result_terkini = $conn->query($sql_terkini);

// Ambil ID berita yang sudah tampil di highlight dan terkini
$exclude_ids = [];
if ($highlight_berita) {
    $exclude_ids[] = $highlight_berita['id_berita'];
}
if ($result_terkini && $result_terkini->num_rows > 0) {
    $result_terkini->data_seek(0);
    while ($row = $result_terkini->fetch_assoc()) {
        $exclude_ids[] = $row['id_berita'];
    }
}
$exclude_ids_str = implode(',', array_map('intval', $exclude_ids));
$sql_sebelumnya = "SELECT * FROM berita ".($exclude_ids_str ? "WHERE id_berita NOT IN ($exclude_ids_str)" : '')." ORDER BY tanggal DESC LIMIT 12";
$result_sebelumnya = $conn->query($sql_sebelumnya);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />  
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda - Jurusan TIK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/style.css"/>
  <style>
    body { font-family: "Segoe UI", sans-serif; margin: 0; padding: 0; }
    .hero { background: url("img/banner.jpg") center/cover no-repeat; height: 500px; display: flex; align-items: center; justify-content: center; color: white; text-shadow: 1px 1px 3px #000; }
    .hero h1 { font-size: 3rem; text-align: center; }
    .navbar { background-color: #56021f; }
    .navbar .navbar-brand, .navbar .nav-link { color: white; }
    .navbar .nav-link:hover { color: #ffc107; }
    .nav-link.active { font-weight: bold; color: #ffc107 !important; }
    .section-title { position: relative; margin-bottom: 30px; padding-bottom: 15px; font-size: 1.75rem; font-weight: 700; color: #212529; }
    .section-title:after { content: ''; position: absolute; left: 0; bottom: 0; width: 60px; height: 3px; background-color: #56021f; }
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
    
    /* Beasiswa Slider Styles */
    .beasiswa-slider {
      overflow-x: auto;
      white-space: nowrap;
      padding: 20px 0;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
      scrollbar-color: #56021f #f1f1f1;
    }
    
    .beasiswa-slider::-webkit-scrollbar {
      height: 8px;
    }
    
    .beasiswa-slider::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .beasiswa-slider::-webkit-scrollbar-thumb {
      background: #56021f;
      border-radius: 10px;
    }
    
    .beasiswa-slider::-webkit-scrollbar-thumb:hover {
      background: #450119;
    }
    
    .beasiswa-section {
      margin-bottom: 50px;
    }
    
    .beasiswa-section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      border-bottom: 1px solid #e9ecef;
      padding-bottom: 15px;
    }
    
    .beasiswa-section-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: #212529;
      margin-bottom: 0;
      position: relative;
    }
    
    .beasiswa-section-title::after {
      content: '';
      position: absolute;
      bottom: -16px;
      left: 0;
      width: 50px;
      height: 3px;
      background-color: #56021f;
    }
    
    .nav-controls {
      display: flex;
      gap: 10px;
    }
    
    .nav-button {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #6c757d;
      background-color: #e9ecef;
      border: 1px solid #dee2e6;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .nav-button:hover {
      background-color: #dee2e6;
      color: #495057;
    }
    
    .nav-button i {
      font-size: 16px;
    }
    
    .beasiswa-card {
      display: inline-block;
      width: 300px;
      min-width: 300px;
      max-width: 300px;
      margin-right: 15px;
      white-space: normal;
      vertical-align: top;
      height: 210px;
    }
    
    .beasiswa-card:last-child {
      margin-right: 0;
    }
    
    /* New Card Style matching the image reference */
    .beasiswa-item {
      background-color: #ebf3ff;
      border-radius: 16px;
      overflow: hidden;
      height: 100%;
      position: relative;
      transition: transform 0.3s;
      padding: 16px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border: 1px solid rgba(0,0,0,0.05);
      display: flex;
      flex-direction: column;
      width: 100%;
      min-height: 100%;
    }
    
    .beasiswa-item .img-container {
      height: 30px;
      overflow: hidden;
      position: relative;
      border-radius: 10px;
      margin-bottom: 8px;
    }
    
    .beasiswa-item:hover {
      transform: translateY(-5px);
    }
    
    /* Multiple badges container */
    .program-badges {
      display: flex;
      gap: 5px;
      margin-bottom: 10px;
    }
    
    /* New badge style - multiple round badges at top */
    .program-badge {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 12px;
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
    
    .beasiswa-info {
      padding-top: 5px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    
    .beasiswa-info h5 {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 8px;
      color: #212529;
      line-height: 1.4;
    }
    
    .location-tag {
      font-size: 14px;
      color: #6c757d;
      margin-bottom: 15px;
      display: block;
    }
    
    .date-info {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: auto;
    }
    
    .date-item {
      display: flex;
      flex-direction: column;
    }
    
    .date-label {
      font-size: 13px;
      color: #6c757d;
      margin-bottom: 2px;
    }
    
    .date-value {
      font-size: 14px;
      font-weight: 600;
      color: #212529;
    }
    
    .deadline-value {
      color: #dc3545;
    }
    
    .bookmark-btn {
      position: absolute;
      right: 15px;
      top: 15px;
      background: none;
      border: none;
      color: #6c757d;
      font-size: 18px;
      cursor: pointer;
      z-index: 2;
    }
    
    .left-content {
      max-width: 300px;
      padding-right: 15px;
    }
    
    .left-content h3 {
      font-size: 1.75rem;
      font-weight: 700;
      color: #212529;
      margin-bottom: 15px;
    }
    
    .left-content p {
      color: #212529;
      font-size: 15px;
      line-height: 1.6;
      margin-bottom: 0;
    }
    
    @media (max-width: 767px) {
      .navbar .navbar-brand { font-size: 0.9rem; }
      .carousel-img { height: 50vh; }
      .carousel-caption h1 { font-size: 1.75rem; }
      .carousel-caption p { font-size: 1rem; }
      .beasiswa-card { width: 280px; }
      .left-content { display: none; }
    }
    
    @media (max-width: 576px) {
      .container-fluid { padding-left: 3%; padding-right: 3%; }
      .beasiswa-card { width: 260px; }
    }
    
    /* Berita Terbaru styling */
    .news-card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease;
    }
    
    .news-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .news-card .card-body {
      padding: 21px;
    }
    
    .news-image {
      height: 200px;
      object-fit: cover;
      width: 100%;
    }
    
    .news-date {
      font-size: 13px;
      color: #6c757d;
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }
    
    .news-date i {
      margin-right: 5px;
      color: #56021f;
    }
    
    .news-title {
      font-weight: 700;
      color: #56021f;
      margin-bottom: 11px;
      line-height: 1.4;
      font-size: 18px;
    }
    
    .news-excerpt {
      color: #666;
      margin-bottom: 16px;
      font-size: 14px;
      line-height: 1.6;
    }
    
    .btn-read-more {
      background-color: #ffc107;
      color: #fff;
      border: none;
      padding: 6px 14px;
      border-radius: 50px;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-read-more:hover {
      background-color: #e0a800;
      color: #fff;
      transform: translateY(-2px);
    }
    
    /* Sidebar styling */
    .sidebar-wrapper {
      padding-right: 0;
      position: relative;
      height: 100%;
    }
    
    .sidebar-fixed {
      position: sticky;
      top: 20px;
      width: 100%;
      max-width: 350px;
      margin-left: auto;
      margin-right: 0;
      transition: all 0.3s ease;
      height: fit-content; /* Ensures the container only takes the space it needs */
      z-index: 10; /* Ensures the sidebar appears above other content when scrolling */
      display: block;
    }
    
    .sidebar-card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
      background-color: #fff; /* Ensures the card has a solid background */
    }
    
    .sidebar-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .sidebar-card .card-header {
      background-color: #56021f;
      color: white;
      padding: 15px;
      font-weight: 600;
      text-align: center;
      letter-spacing: 1px;
    }
    
    .sidebar-card .card-body {
      padding: 15px;
    }
    
    .profile-video {
      height: 200px;
      width: 100%;
      border-bottom: 1px solid #f5f5f5;
    }
    
    .contact-info p {
      margin-bottom: 12px;
      font-size: 14px;
      display: flex;
      align-items: center;
      color: #495057;
      transition: all 0.2s ease;
    }
    
    .contact-info p:hover {
      color: #56021f;
    }
    
    .contact-info i {
      color: #56021f;
      margin-right: 12px;
      font-size: 18px;
      width: 20px;
      text-align: center;
    }
    
    /* Additional alignment styles */
    .row.g-5 {
      justify-content: space-between;
      margin: 0 -1.5rem;
    }
    
    .row.g-5 .col {
      display: flex;
      padding: 0 1.5rem;
      margin-bottom: 1.5rem;
    }
    
    .row.g-4 {
      justify-content: space-between;
    }
    
    .col {
      display: flex;
    }
    
    .news-card, .beasiswa-item {
      width: 100%;
    }
    
    /* Even more balanced layout for news section */
    @media (min-width: 992px) {
      .col-lg-8.pe-lg-4 {
        padding-right: 30px !important;
      }
    }
    
    @media (max-width: 991.98px) {
      .highlight-flex-row {
        flex-direction: column !important;
      }
      .highlight-img-col, .highlight-text-col {
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
      }
      .highlight-img-col img {
        max-height: 220px !important;
        object-fit: cover !important;
      }
      .highlight-text-col {
        padding: 1.5rem !important;
      }
    }
    @media (max-width: 575.98px) {
      .highlight-text-col h2 {
        font-size: 1.2rem !important;
      }
      .highlight-text-col p, .highlight-text-col .text-muted {
        font-size: 0.98rem !important;
      }
      .beasiswa-card {
        min-width: 95vw;
        max-width: 95vw;
        width: 95vw;
        height: 210px;
      }
      .beasiswa-item .img-container {
        height: 20px;
      }
    }
    .carousel-img-overlay {
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      top: 0;
      z-index: 2;
      pointer-events: none;
      /* Gradasi putih natural, semi transparan, tanpa garis tegas */
      background: linear-gradient(
        to top,
        rgba(255,255,255,0.5) 0%,
        rgba(255,255,255,0.35) 25%,
        rgba(255,255,255,0.15) 60%,
        rgba(255,255,255,0.0) 100%
      );
    }
    .carousel-item {
      position: relative;
    }
    .btn-outline-danger.back-button {
      color: #c62828 !important; /* Merah tua, bisa disesuaikan */
      border-color: #c62828 !important;
      background-color: transparent !important;
    }
    
    .btn-outline-danger.back-button:hover,
    .btn-outline-danger.back-button:focus {
      background-color: #c62828 !important;
      color: #fff !important;
      border-color: #c62828 !important;
    }
    .apply-button {
      background-color: #ffc107;
      color: #fff;
      border: none;
      padding: 16px 40px;
      border-radius: 50px;
      font-size: 1.25rem;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      gap: 10px;
    }
    .apply-button:hover {
      background-color: #e0a800;
      color: #fff;
      transform: translateY(-2px);
    }
    .btn-outline-warning.daftar-outline-button {
      color: #ffc107 !important;
      border-color: #ffc107 !important;
      background-color: transparent !important;
      font-weight: 600;
      font-size: 1.15rem;
      padding: 12px 40px;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      transition: all 0.3s;
    }
    .btn-outline-warning.daftar-outline-button:hover,
    .btn-outline-warning.daftar-outline-button:focus {
      background-color: #ffc107 !important;
      color: #fff !important;
      border-color: #ffc107 !important;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <?php include 'navbar.php'; ?>

<!-- Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/bg_corousel_1.jpg" class="d-block w-100 carousel-img" alt="Slide 1">
      <div class="carousel-img-overlay"></div>
      <div class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-5 fw-bold text-white">Selamat Datang di TIK News</h1>
        <p class="lead text-light">Menjadi pusat berita unggulan seputar Teknik Informatika dan Komputer.</p>
        <a href="berita.php" class="btn btn-warning mt-3">Lihat Berita Terbaru</a>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/programstudi.jpg" class="d-block w-100 carousel-img" alt="Slide 2">
      <div class="carousel-img-overlay"></div>
      <div class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-5 fw-bold text-white">Program Studi Unggulan</h1>
        <p class="lead text-light">Teknik Komputer & Jaringan dan Teknik Multimedia & Jaringan.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="img/bg_header_beasiswa.jpg" class="d-block w-100 carousel-img" alt="Slide 3">
      <div class="carousel-img-overlay"></div>
      <div class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center">
        <h1 class="display-5 fw-bold text-white">Beasiswa Mahasiswa</h1>
        <p class="lead text-light">Raih peluang beasiswa dan ikuti kegiatan inspiratif.</p>
        <a href="beasiswa.php" class="btn btn-warning mt-3">Cek Beasiswa</a>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Sebelumnya</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Selanjutnya</span>
  </button>
</div>

<!-- Highlight Berita -->
<?php if ($highlight_berita): ?>
<section class="py-4">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4 d-flex highlight-flex-row flex-md-row flex-column" style="background:linear-gradient(90deg,#fff 60%,#fbe9e7 100%);">
          <div class="highlight-img-col col-md-5 p-0 d-flex align-items-stretch">
            <img src="uploads/<?= htmlspecialchars($highlight_berita['gambar']) ?>" alt="<?= htmlspecialchars($highlight_berita['judul']) ?>" class="img-fluid w-100 h-100 object-fit-cover" style="min-height:220px; max-height:320px; object-fit:cover;">
          </div>
          <div class="highlight-text-col col-md-7 p-4 d-flex flex-column justify-content-center">
            <span class="badge bg-danger mb-2" style="width:max-content;">Highlight</span>
            <h2 class="fw-bold mb-2" style="color:#c62828; font-size:2rem;"> <?= htmlspecialchars($highlight_berita['judul']) ?> </h2>
            <div class="text-muted mb-2" style="font-size:0.98rem;">
              <i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($highlight_berita['tanggal'])) ?>
              <?php if (!empty($highlight_berita['penulis'])): ?> &bull; <?= htmlspecialchars($highlight_berita['penulis']) ?><?php endif; ?>
            </div>
            <p class="mb-3" style="font-size:1.08rem; color:#333;">
              <?= substr(strip_tags($highlight_berita['isi']),0,180) ?>...
            </p>
            <a href="berita.php?id=<?= $highlight_berita['id_berita'] ?>" class="btn btn-danger px-4 py-2 mt-auto" style="border-radius:30px; font-weight:500;">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- Berita Terkini -->
  <section class="py-5">
    <div class="container-fluid">
      <div class="text-center mb-5">
      <h2 class="fw-bold">Berita Terkini</h2>
        <p>Temukan informasi terbaru mengenai berita, beasiswa, dan kegiatan di jurusan TIK.</p>
      </div>
    <div class="row g-5 justify-content-center">
      <?php if ($result_terkini && $result_terkini->num_rows > 0): ?>
        <?php $result_terkini->data_seek(0); while ($row = $result_terkini->fetch_assoc()): ?>
          <div class="col-md-4 col-12 mb-4">
            <div class="news-card h-100">
              <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="news-image" alt="Berita"/>
              <div class="card-body">
                <div class="news-date">
                  <i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($row['tanggal'])) ?>
                </div>
                <h5 class="news-title"> <?= htmlspecialchars($row['judul']) ?> </h5>
                <div class="berita-body berita-list">
                  <?= strip_tags(
                    strlen($row['isi']) > 120 ? substr($row['isi'], 0, 120) . '...' : $row['isi']
                  ) ?>
                </div>
                <a href="berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-sm btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right me-1"></i></a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info">Tidak ada berita terbaru.</div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
      
      <!-- Beasiswa Section -->
<section class="py-5">
  <div class="container-fluid">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Beasiswa yang sedang dibuka</h2>
      <p>Dapatkan beasiswa impian kamu, akses kelas dan event untuk persiapan mendaftar beasiswa</p>
        </div>
        
        <div class="row">
          <?php if ($result_beasiswa && $result_beasiswa->num_rows > 0): ?>
            <div class="col-lg-3 col-md-4 d-none d-md-block">
              <div class="left-content">
                <h3>Akses Ratusan Program Beasiswa</h3>
                <p>Dapatkan beasiswa impian kamu, akses kelas dan event untuk persiapan mendaftar beasiswa</p>
              </div>
            </div>
            <div class="col-lg-9 col-md-8 col-sm-12">
              <div class="beasiswa-slider" id="beasiswaSlider">
                <?php 
                // Array of possible program levels and associated badges
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
                
                $i = 0;
                while ($row_beasiswa = $result_beasiswa->fetch_assoc()): 
                  // Get jenjang value from database if it exists
                  $jenjang_array = [];
                  if (!empty($row_beasiswa['jenjang'])) {
                    $jenjang_array = explode(',', $row_beasiswa['jenjang']);
                  } else {
                    // Fallback to random badges if jenjang is not in the database
                    $random_program_keys = array_rand($program_levels, min(3, count($program_levels)));
                    if (!is_array($random_program_keys)) {
                      $random_program_keys = [$random_program_keys];
                    }
                    foreach ($random_program_keys as $key) {
                      $jenjang_array[] = $program_levels[$key]['name'];
                    }
                  }
                  
                  // Get location from database or use default
                  $location = isset($row_beasiswa['lokasi']) && !empty($row_beasiswa['lokasi']) 
                      ? $row_beasiswa['lokasi'] 
                      : 'Indonesia';
                  
                  // Format start date from database or generate random
                  if (isset($row_beasiswa['tanggal_mulai']) && !empty($row_beasiswa['tanggal_mulai'])) {
                    $start_date = date('d M Y', strtotime($row_beasiswa['tanggal_mulai']));
                  } else {
                    $day = rand(1, 28);
                    $month = rand(1, 12);
                    $start_date = sprintf('%02d', $day) . ' ' . date('M', mktime(0, 0, 0, $month, 10)) . ' 2025';
                  }
                  
                  // Format deadline from database or generate random
                  if (isset($row_beasiswa['deadline']) && !empty($row_beasiswa['deadline'])) {
                    $deadline_date = date('d M Y', strtotime($row_beasiswa['deadline']));
                  } else {
                    $deadline_day = rand(1, 28);
                    $deadline_month = rand(1, 12);
                    $deadline_date = sprintf('%02d', $deadline_day) . ' ' . date('M', mktime(0, 0, 0, $deadline_month, 10)) . ' 2025';
                  }
                  
                  $i++;
                ?>
                  <div class="beasiswa-card">
                    <div class="beasiswa-item">
                      <!-- Multiple badge display -->
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
                      
                      <button class="bookmark-btn"><i class="bi bi-bookmark"></i></button>
                      
                      <div class="beasiswa-info">
                        <h5><?= htmlspecialchars($row_beasiswa['nama_beasiswa']) ?></h5>
                        <span class="location-tag"><?= $location ?></span>
                        
                        <div class="date-info">
                          <div class="date-item">
                            <span class="date-label">Mulai:</span>
                            <span class="date-value"><?= $start_date ?></span>
                          </div>
                          
                          <div class="date-item">
                            <span class="date-label">Deadline:</span>
                            <span class="date-value deadline-value"><?= $deadline_date ?></span>
                          </div>
                        </div>
                      </div>
                      
                      <a href="beasiswa.php?id=<?= $row_beasiswa['id_beasiswa'] ?>" class="stretched-link"></a>
                    </div>
                  </div>
                <?php endwhile; ?>
              </div>
            </div>
            
            <div class="col-12 text-end mt-3">
              <a href="beasiswa.php" class="btn btn-warning btn-sm text-white">Lihat Semua Beasiswa <i class="bi bi-arrow-right"></i></a>
            </div>
          <?php else: ?>
            <div class="col-12">
              <div class="alert alert-info">Tidak ada data beasiswa terbaru.</div>
            </div>
          <?php endif; ?>
        </div>
  </div>
</section>

<!-- Berita Sebelumnya -->
<section class="py-5">
  <div class="container-fluid">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Berita Sebelumnya</h2>
      <p>Kumpulan berita yang tidak masuk ke highlight atau berita terkini.</p>
    </div>
    <div class="row g-5 justify-content-center">
      <?php if ($result_sebelumnya && $result_sebelumnya->num_rows > 0): ?>
        <?php while ($row = $result_sebelumnya->fetch_assoc()): ?>
          <div class="col-md-4 col-12 mb-4">
            <div class="news-card h-100">
              <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="news-image" alt="Berita"/>
              <div class="card-body">
                <div class="news-date">
                  <i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($row['tanggal'])) ?>
                </div>
                <h5 class="news-title"> <?= htmlspecialchars($row['judul']) ?> </h5>
                <div class="berita-body berita-list">
                  <?= strip_tags(
                    strlen($row['isi']) > 120 ? substr($row['isi'], 0, 120) . '...' : $row['isi']
                  ) ?>
                </div>
                <a href="berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-sm btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right me-1"></i></a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info">Tidak ada berita sebelumnya.</div>
        </div>
      <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Berita & Profil -->
  <section class="py-5 bg-light">
    <div class="container-fluid">
      <div class="row balanced-container mx-auto">
        <!-- Berita -->
        <div class="col-lg-8 mb-4 pe-lg-4">
        <h3 class="section-title">Berita Lainnya</h3>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col">
                  <div class="news-card">
                    <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" class="news-image" alt="Berita"/>
                    <div class="card-body">
                      <div class="news-date">
                        <i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($row['tanggal'])) ?>
                      </div>
                      <h5 class="news-title"><?= htmlspecialchars($row['judul']) ?></h5>
                    <div class="berita-body berita-list">
                      <?= strip_tags(
                        strlen($row['isi']) > 120 ? substr($row['isi'], 0, 120) . '...' : $row['isi']
                      ) ?>
                    </div>
                      <a href="berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-sm btn-read-more">Baca Selengkapnya <i class="bi bi-arrow-right me-1"></i></a>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="col-12">
                <p>Tidak ada berita yang tersedia.</p>
              </div>
            <?php endif; ?>
          </div>
          <div class="mt-4 text-end">
            <a href="berita.php" class="btn btn-warning btn-sm text-white">Lihat Semua Berita <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <!-- Profil & Kontak -->
        <div class="col-lg-4 sidebar-wrapper">
          <aside class="sidebar-fixed">
            <div class="sidebar-card" id="profil-jurusan">
              <div class="card-header">PROFIL JURUSAN</div>
              <div class="card-body p-0">
                <div class="profile-video">
                  <iframe src="https://www.youtube.com/embed/JFL8ZGR_1Rk" title="Profil Jurusan" allowfullscreen style="width:100%; height:100%; border:0;"></iframe>
                </div>
              </div>
            </div>
            <div class="sidebar-card" id="kontak-jurusan">
              <div class="card-header">CONTACT US</div>
              <div class="card-body contact-info">
                <p><i class="bi bi-building"></i>Jurusan Teknik Informatika dan Komputer</p>
                <p><i class="bi bi-geo-alt"></i>Politeknik Negeri Ujung Pandang</p>
                <p><i class="bi bi-map"></i>Jl. Perintis Kemerdekaan KM.10, Makassar</p>
                <p class="mb-0"><i class="bi bi-mailbox"></i>90245, Sulawesi Selatan</p>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </div>
  </section>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Enhanced carousel functionality
    const carousel = document.getElementById('heroCarousel');
    if (carousel) {
      const carouselInstance = new bootstrap.Carousel(carousel, {
        interval: 7000, // Slightly longer interval for better user experience
        pause: 'hover' // Pause on hover
      });
      
      // Fix for captions being hidden during slide transitions
      carousel.addEventListener('slide.bs.carousel', function(event) {
        // Get the next slide
        const nextSlide = event.relatedTarget;
        
        // Make sure the next slide's caption elements are immediately visible
        if (nextSlide) {
          const caption = nextSlide.querySelector('.carousel-caption');
          if (caption) {
            caption.style.visibility = 'visible';
          }
        }
      });
      
      // Fix for caption animations
      carousel.addEventListener('slid.bs.carousel', function(event) {
        // This event fires after the slide transition is complete
        const activeSlide = event.relatedTarget;
        
        // Reset animation on the active slide for proper animation
        if (activeSlide) {
          const h1 = activeSlide.querySelector('.carousel-caption h1');
          const p = activeSlide.querySelector('.carousel-caption p');
          const btn = activeSlide.querySelector('.carousel-caption .btn');
          
          // Reset and force reflow to restart animation
          if (h1) {
            h1.style.animation = 'none';
            h1.offsetHeight; // Force reflow
            h1.style.animation = '';
          }
          
          if (p) {
            p.style.animation = 'none';
            p.offsetHeight; // Force reflow
            p.style.animation = '';
          }
          
          if (btn) {
            btn.style.animation = 'none';
            btn.offsetHeight; // Force reflow
            btn.style.animation = '';
          }
        }
      });
    }
    
    // Inisialisasi dropdown menu
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownElementList.forEach(function(dropdownToggleEl) {
      new bootstrap.Dropdown(dropdownToggleEl);
    });
    
    // Beasiswa slider auto-scroll and navigation
    const sliderElement = document.getElementById('beasiswaSlider');
    const prevButton = document.getElementById('prevBeasiswa');
    const nextButton = document.getElementById('nextBeasiswa');
    
    if (sliderElement && prevButton && nextButton) {
      // Amount to scroll on each button click - width of one card + margin
      const scrollAmount = 335;
      let autoScrollInterval;
      
      // Manual navigation buttons
      prevButton.addEventListener('click', function() {
        clearInterval(autoScrollInterval); // Stop auto-scroll when user interacts
        sliderElement.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        startAutoScroll(); // Restart after manual navigation
      });
      
      nextButton.addEventListener('click', function() {
        clearInterval(autoScrollInterval); // Stop auto-scroll when user interacts
        sliderElement.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        startAutoScroll(); // Restart after manual navigation
      });
      
      // Auto-scroll function
      function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
          // Check if we've reached the end, scroll back to start if needed
          if (sliderElement.scrollLeft >= (sliderElement.scrollWidth - sliderElement.clientWidth)) {
            sliderElement.scrollTo({ left: 0, behavior: 'smooth' });
          } else {
            sliderElement.scrollBy({ left: scrollAmount, behavior: 'smooth' });
          }
        }, 5000); // Auto-scroll every 5 seconds
      }
      
      // Start auto-scrolling when page loads
      startAutoScroll();
      
      // Pause auto-scroll when user hovers over slider
      sliderElement.addEventListener('mouseenter', () => {
        clearInterval(autoScrollInterval);
      });
      
      // Resume auto-scroll when user leaves slider
      sliderElement.addEventListener('mouseleave', () => {
        startAutoScroll();
      });
      
      // Enable bookmark functionality
      const bookmarkButtons = document.querySelectorAll('.bookmark-btn');
      bookmarkButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          const icon = this.querySelector('i');
          if (icon.classList.contains('bi-bookmark')) {
            icon.classList.remove('bi-bookmark');
            icon.classList.add('bi-bookmark-fill');
            icon.style.color = '#2a5885';
          } else {
            icon.classList.remove('bi-bookmark-fill');
            icon.classList.add('bi-bookmark');
            icon.style.color = '#6c757d';
          }
        });
      });
    }
  });
</script>
</body>
</html>
