<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM berita WHERE id_berita = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($data['judul']) ?> - Jurusan TIK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            color: #333;
            line-height: 1.6;
        }
        .news-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .news-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .news-title {
            color: #56021f;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .news-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .news-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .news-content {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .news-category {
            display: inline-block;
            background: linear-gradient(45deg, #56021f, #8a0b2e);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
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

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(45deg, #56021f, #8a0b2e);
            color: white;
            padding: 1.2rem;
            font-weight: 600;
            border: none;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
            margin-bottom: 1.5rem;
        }
        .card-text p {
            margin-bottom: 1rem;
        }
        .card-text p:last-child {
            margin-bottom: 0;
        }
        .btn-read-more {
            background: linear-gradient(45deg, #56021f, #8a0b2e);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-read-more:hover {
            background: linear-gradient(45deg, #8a0b2e, #56021f);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(86, 2, 31, 0.2);
            color: white;
            text-decoration: none;
        }
        .collapse {
            transition: all 0.3s ease;
        }
        .collapse.show {
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 768px) {
            .news-title {
                font-size: 2rem;
            }
            .news-content {
                padding: 1.5rem;
            }
            .card-header {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <?php include "Header.php"; ?>

    <div class="news-container">
        <div class="news-header">
            <span class="news-category">
                <i class="fas fa-tag mr-1"></i><?= htmlspecialchars($data['kategori']) ?>
            </span>
            <h1 class="news-title"><?= htmlspecialchars($data['judul']) ?></h1>
            <div class="news-meta">
                <i class="fas fa-calendar-alt mr-1"></i><?= date('d F Y H:i', strtotime($data['tanggal'])) ?>
            </div>
        </div>

        <?php if (!empty($data['gambar'])): ?>
        <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" alt="<?= htmlspecialchars($data['judul']) ?>" class="news-image">
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <?= htmlspecialchars($data['judul']) ?>
            </div>
            <div class="card-body">
                <?php
                // Split content into paragraphs
                $paragraphs = explode("\n", $data['isi']);
                $preview = array_slice($paragraphs, 0, 2); // Show first 2 paragraphs as preview
                $full_content = $paragraphs;
                ?>
                
                <div class="card-text">
                    <?php foreach($preview as $paragraph): ?>
                        <p><?= htmlspecialchars($paragraph) ?></p>
                    <?php endforeach; ?>
                </div>

                <button class="btn btn-read-more" type="button" data-toggle="collapse" data-target="#beritaLengkap" aria-expanded="false" aria-controls="beritaLengkap">
                    <i class="fas fa-chevron-down"></i> Baca Selengkapnya
                </button>

                <div class="collapse mt-4" id="beritaLengkap">
                    <div class="card-text">
                        <?php foreach($full_content as $paragraph): ?>
                            <p><?= htmlspecialchars($paragraph) ?></p>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="index.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <a href="berita.php" class="back-button">
                <i class="fas fa-newspaper"></i> Lihat Semua Berita
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle button text and icon when clicked
            $('.btn-read-more').click(function() {
                var $icon = $(this).find('i');
                if ($(this).attr('aria-expanded') === 'true') {
                    $(this).html('<i class="fas fa-chevron-down"></i> Baca Selengkapnya');
                } else {
                    $(this).html('<i class="fas fa-chevron-up"></i> Tampilkan Lebih Sedikit');
                }
            });
        });
    </script>
</body>
</html> 