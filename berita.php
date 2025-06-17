<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Web_jurusan";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Get single news if ID is provided
$single_berita = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql_single = "SELECT * FROM berita WHERE id_berita = ?";
    $stmt = $conn->prepare($sql_single);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_single = $stmt->get_result();
    if ($result_single && $result_single->num_rows > 0) {
        $single_berita = $result_single->fetch_assoc();
    }
    $stmt->close();
}

// Get all news for the main listing
$sql = "SELECT * FROM berita ORDER BY tanggal DESC";
$result = $conn->query($sql);

// Get featured news for the carousel (latest 5 articles)
$sql_featured = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 5";
$featured_result = $conn->query($sql_featured);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Berita - Jurusan TIK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body { font-family: "Segoe UI", sans-serif; margin: 0; padding: 0; background-color: #f5f5f5; }
    .navbar { background-color: #56021f; }
    .navbar .navbar-brand, .navbar .nav-link { color: white; }
    .navbar .nav-link:hover { color: #ffc107; }
    .nav-link.active { font-weight: bold; color: #ffc107 !important; }
    
    /* Section Title Styling */
    .section-title { 
      position: relative; 
      margin-bottom: 40px; 
      padding-bottom: 15px; 
      font-weight: 700;
      color: #212529;
      display: inline-block;
    }
    
    .section-title:after { 
      content: ''; 
      position: absolute; 
      left: 0; 
      bottom: 0; 
      width: 60px; 
      height: 3px; 
      background-color: #56021f; 
    }
    
    .container-fluid { padding-left: 5%; padding-right: 5%; }
    
    /* Header section with background image overlay */
    header { 
      background: url('img/bg_header_berita.jpg');
      background-size: cover;
      background-position: center;
      color: white; 
      padding: 80px 0; 
      text-align: center;
      position: relative;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      margin-bottom: 50px;
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
    
    /* News Card Styling */
    .news-card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background-color: #fff;
    }
    
    .news-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(86, 2, 31, 0.1);
    }
    
    .news-img-container {
      position: relative;
      overflow: hidden;
      height: 200px;
    }
    
    .news-img-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .news-card:hover .news-img-container img {
      transform: scale(1.05);
    }
    
    .news-img-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
      height: 50%;
      pointer-events: none;
    }
    
    .news-content {
      padding: 20px;
    }
    
    .news-category {
      display: inline-block;
      background-color: #56021f;
      color: white;
      padding: 4px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 15px;
      letter-spacing: 0.5px;
      box-shadow: 0 2px 5px rgba(86, 2, 31, 0.2);
    }
    
    .news-title {
      font-weight: 700;
      margin-bottom: 15px;
      line-height: 1.4;
      color: #333;
      font-size: 19px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      height: 52px;
    }
    
    .news-meta {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      color: #6c757d;
      font-size: 13px;
    }
    
    .news-meta i {
      color: #56021f;
      margin-right: 5px;
    }
    
    .news-meta-item {
      margin-right: 15px;
      display: flex;
      align-items: center;
    }
    
    .news-excerpt {
      color: #6c757d;
      margin-bottom: 15px;
      line-height: 1.6;
      font-size: 14px;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      height: 67px;
    }
    
    .buttons-container {
      display: flex;
      justify-content: space-between;
      margin-top: auto;
      padding-top: 15px;
      border-top: 1px solid #f0f0f0;
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
    
    .content-wrapper {
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Single Berita Styles */
    .berita-header {
      position: relative;
      padding: 80px 0;
      margin-bottom: 40px;
      background-size: cover;
      background-position: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .berita-header:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(86, 2, 31, 0.85);
      z-index: 1;
    }
    
    .berita-header .container-fluid {
      position: relative;
      z-index: 2;
    }
    
    .berita-image {
      max-height: 400px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    
    .berita-image:hover {
      transform: scale(1.02);
    }
    
    .berita-title {
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
    
    .berita-content {
      background-color: #fff;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
    }
    
    .berita-meta {
      background-color: #f8f9fa;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 3px 15px rgba(0,0,0,0.05);
      border-left: 3px solid #56021f;
    }
    
    .berita-meta-item {
      margin-bottom: 12px;
    }
    
    .berita-meta-item:last-child {
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
    
    .berita-category {
      display: inline-block;
      background-color: #56021f;
      color: white;
      padding: 4px 12px;
      border-radius: 30px;
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 15px;
      letter-spacing: 0.5px;
      box-shadow: 0 2px 5px rgba(86, 2, 31, 0.2);
    }
    
    /* Animation keyframes */
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
    
    /* Responsive styles */
    @media (max-width: 992px) {
      .news-img-container {
        height: 180px;
      }
    }
    
    @media (max-width: 768px) {
      .news-img-container {
        height: 220px;
      }
      .news-title {
        height: auto;
        -webkit-line-clamp: 2;
      }
      .news-excerpt {
        height: auto;
        -webkit-line-clamp: 3;
      }
      .berita-image {
        max-height: 300px;
      }
      .berita-content {
        padding: 20px;
      }
    }
    
    @media (max-width: 576px) {
      .container-fluid { padding-left: 3%; padding-right: 3%; }
      .news-img-container {
        height: 180px;
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
      .news-meta {
        flex-wrap: wrap;
      }
      .news-meta-item {
        margin-bottom: 5px;
      }
    }

    .berita-body {
      max-height: none !important;
      overflow: visible !important;
      display: block !important;
      -webkit-line-clamp: unset !important;
      -webkit-box-orient: unset !important;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<?php include 'navbar.php'; ?>

<?php if ($single_berita): ?>
  <!-- Header Section mirip page berita -->
  <div class="berita-header" style="background-image: url('img/bg_header_berita.jpg');">
    <div class="container-fluid text-center">
      <h1 class="display-5 fw-bold text-white">Detail Berita</h1>
      <p class="lead text-white">Informasi lengkap mengenai berita terbaru</p>
    </div>
  </div>
  <section class="py-5" style="background: #faf6f2; min-height: 100vh;">
    <div class="container-fluid" style="padding-left:5%; padding-right:5%;">
      <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
          <a href="berita.php" class="back-button mb-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
          </a>
          <div class="card border-0 shadow-lg rounded-4 p-0 mb-4" style="overflow:hidden;">
            <div class="p-4 p-md-5">
              <h1 class="fw-bold text-center mb-3" style="color: #c62828; font-size: 2.2rem; line-height: 1.2; letter-spacing: 0.5px;">
                <?= htmlspecialchars($single_berita['judul']) ?>
              </h1>
            </div>
            <div class="p-0 d-flex align-items-center justify-content-center" style="background:#fff; min-height:220px; max-height:420px;">
              <img src="uploads/<?= htmlspecialchars($single_berita['gambar']) ?>" alt="<?= htmlspecialchars($single_berita['judul']) ?>" class="img-fluid" style="max-height:400px; width:auto; object-fit:contain; background:#fff; display:block; margin:auto;">
            </div>
            <div class="p-4 p-md-5">
              <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-2" style="font-size: 1.08rem;">
                <span class="fw-semibold text-dark"><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($single_berita['penulis']) ?></span>
                <?php if (!empty($single_berita['kategori'])): ?>
                  <span class="mx-2">&bull;</span>
                  <span class="fw-semibold px-2 py-1 rounded-pill" style="background:#ffe0b2; color: #d32f2f; text-transform: uppercase; letter-spacing: 1px; font-size:0.98rem;">
                    <?= htmlspecialchars($single_berita['kategori']) ?>
                  </span>
                <?php endif; ?>
                <span class="mx-2">&bull;</span>
                <span class="text-muted" style="font-size: 0.97rem;"><i class="bi bi-calendar-event"></i> <?= date('l, d F Y H:i', strtotime($single_berita['tanggal'])) ?> WIB</span>
              </div>
              <hr class="my-4" style="border-top:2px solid #f3e5e5;">
              <div class="berita-body px-1" style="font-size: 1.13rem; line-height: 1.85; color: #232323;">
                <?= html_entity_decode($single_berita['isi']) ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php else: ?>
  <!-- Header Section -->
  <header>
    <div class="container-fluid">
      <h1 class="display-5 fw-bold">Berita Terbaru</h1>
      <p class="lead">Dapatkan informasi terkini seputar kegiatan dan perkembangan di Jurusan TIK</p>
    </div>
  </header>

  <!-- Konten Berita dengan UI yang ditingkatkan -->
  <div class="container-fluid py-5">
    <div class="content-wrapper">
      <h2 class="section-title">Artikel & Berita</h2>
      <div class="mb-4">
        <a href="index.php" class="back-button">
          <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
      </div>
      
      <?php if ($result && $result->num_rows > 0): ?>
        <div class="row">
          <?php 
          // Reset the result pointer to the beginning
          $result->data_seek(0);
          while ($row = $result->fetch_assoc()): 
          ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="news-card">
                <div class="news-img-container">
                  <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="<?= htmlspecialchars($row['judul']) ?>">
                  <div class="news-img-overlay"></div>
                </div>
                <div class="news-content">
                  <span class="news-category"><?= htmlspecialchars($row['kategori']) ?></span>
                  <h3 class="news-title"><?= htmlspecialchars($row['judul']) ?></h3>
                  <div class="news-meta">
                    <div class="news-meta-item">
                      <i class="bi bi-calendar-event"></i>
                      <?= date('d M Y', strtotime($row['tanggal'])) ?>
                    </div>
                    <?php if(!empty($row['penulis'])): ?>
                    <div class="news-meta-item">
                      <i class="bi bi-person-circle"></i>
                      <?= htmlspecialchars($row['penulis']) ?>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div class="berita-body px-1" style="font-size: 1.13rem; line-height: 1.85; color: #232323; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.26em;">
                    <?= substr(strip_tags($row['isi']), 0, 100) ?>...
                  </div>
                  <div class="buttons-container">
                    <a href="berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-detail btn-read-more">
                      <i class="bi bi-info-circle"></i> Selengkapnya
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info p-4 text-center">
          <i class="bi bi-info-circle-fill me-2 fs-4"></i>
          <p class="fs-5 mb-0">Belum ada berita yang tersedia.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize carousel
    var newsCarousel = new bootstrap.Carousel(document.getElementById('newsCarousel'), {
      interval: 5000,
      touch: true,
      pause: 'hover'
    });
    
    // Initialize dropdown menu
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownElementList.forEach(function(dropdownToggleEl) {
      new bootstrap.Dropdown(dropdownToggleEl);
    });
  });
</script>
</body>
</html>
