<footer class="footer-area">
  <!-- Footer main section with gradient background -->
  <div class="footer-main" style="background: linear-gradient(135deg, #560220 0%, #8a0428 100%);">
    <div class="container py-5">
      <div class="row g-4">
        <!-- About the department -->
        <div class="col-lg-4 col-md-6">
          <div class="footer-widget">
            <h4 class="widget-title position-relative pb-2 mb-4">TIK NEWS</h4>
            <div class="about-widget">
              <div class="footer-logo mb-3">
                <img src="img/JTIK.png" alt="Logo JTIK" style="max-height: 70px;">
              </div>
              <p class="mb-3">Program studi yang berfokus pada ilmu pengetahuan bidang teknologi informasi terbarukan dengan kurikulum yang selaras dengan kebutuhan industri.</p>
              <div class="social-links d-flex gap-2 mt-4">
                <a href="https://www.instagram.com/jtikpnup?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="social-link" aria-label="Instagram">
                  <i class="bi bi-instagram"></i>
                </a>
                <a href="https://youtube.com/@jtikpnup?si=M36nCbWcNoNeozQj" class="social-link" aria-label="YouTube">
                  <i class="bi bi-youtube"></i>
                </a>
                <a href="https://www.facebook.com/jtikpnup?mibextid=ZbWKwL" class="social-link" aria-label="Facebook">
                  <i class="bi bi-facebook"></i>
                </a>
                <a href="#" class="social-link" aria-label="LinkedIn">
                  <i class="bi bi-linkedin"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Program Studi -->
        <div class="col-lg-4 col-md-6">
          <div class="footer-widget">
            <h4 class="widget-title position-relative pb-2 mb-4">Program Studi</h4>
            <div class="program-widget">
              <div class="program-item d-flex align-items-center mb-3">
                <div class="program-icon me-3">
                  <i class="bi bi-pc-display"></i>
                </div>
                <div class="program-info">
                  <h6 class="mb-0">D4 - Teknik Komputer & Jaringan</h6>
                  <small>Akreditasi Unggul</small>
                </div>
              </div>
              <div class="program-item d-flex align-items-center mb-3">
                <div class="program-icon me-3">
                  <i class="bi bi-camera-video"></i>
                </div>
                <div class="program-info">
                  <h6 class="mb-0">D4 - Teknik Multimedia & Jaringan</h6>
                  <small>Akreditasi Baik Sekali</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Contact -->
        <div class="col-lg-4 col-md-12">
          <div class="footer-widget">
            <h4 class="widget-title position-relative pb-2 mb-4">Hubungi Kami</h4>
            <div class="contact-widget">
              <div class="contact-item d-flex mb-3">
                <div class="contact-icon me-3">
                  <i class="bi bi-building"></i>
                </div>
                <div class="contact-text">
                  <p class="mb-0">Jurusan Teknik Informatika dan Komputer<br>Politeknik Negeri Ujung Pandang</p>
                </div>
              </div>
              <div class="contact-item d-flex mb-3">
                <div class="contact-icon me-3">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="contact-text">
                  <p class="mb-0">Jl. Perintis Kemerdekaan KM. 10, Tamalanrea<br>Makassar, 90245, Sulawesi Selatan</p>
                </div>
              </div>
              <div class="contact-item d-flex mb-3">
                <div class="contact-icon me-3">
                  <i class="bi bi-telephone"></i>
                </div>
                <div class="contact-text">
                  <p class="mb-0">(0411) 585365 / 0811-7337-887 / 0813-4017-9194</p>
                </div>
              </div>
              <div class="contact-item d-flex">
                <div class="contact-icon me-3">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="contact-text">
                  <p class="mb-0">jtik.pnup@poliupg.ac.id</p>
                </div>
              </div>
            </div>
          </div>
        </div>  
      </div>
    </div>
  </div>
  
  <!-- Footer copyright -->
  <div class="footer-bottom py-3 text-center" style="background-color: #3d0217;">
    <div class="container">
      <p class="mb-0 text-white">
        &copy; 2025 Jurusan Teknik Informatika dan Komputer - Politeknik Negeri Ujung Pandang
      </p>
    </div>
  </div>
</footer>

<!-- Add footer specific styles -->
<style>
  .footer-area {
    color: #fff;
    font-size: 0.95rem;
  }
  
  .widget-title {
    font-size: 1.35rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
  }
  
  .widget-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background-color: #ffc107;
  }
  
  .social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 18px;
    transition: all 0.3s ease;
  }
  
  .social-link:hover {
    background-color: #ffc107;
    color: #000;
    transform: translateY(-3px);
  }
  
  .program-icon,
  .contact-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    font-size: 18px;
  }
  
  .program-item:hover .program-icon,
  .contact-item:hover .contact-icon {
    background-color: #ffc107;
    color: #000;
  }
  
  .program-item,
  .contact-item {
    transition: all 0.3s ease;
  }
  
  .program-item:hover,
  .contact-item:hover {
    transform: translateX(5px);
  }
  
  .footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .widget-title {
      font-size: 1.25rem;
    }
    
    .social-link {
      width: 34px;
      height: 34px;
      font-size: 16px;
    }
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>