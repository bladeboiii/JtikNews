<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color: #56021f;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="img/JTIK.png" alt="Logo JTIK" width="50" height="50" class="me-2" />
      <div class="d-flex flex-column">
        <span class="brand-title" style="font-size: 1rem; font-weight: 600; transition:color 0.2s; cursor:pointer;">TIK NEWS</span>
        <span style="font-size: 0.85rem">Politeknik Negeri Ujung Pandang</span>
      </div>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'berita.php' ? 'active' : '' ?>" href="berita.php">Berita</a></li>
        <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'beasiswa.php' ? 'active' : '' ?>" href="beasiswa.php">Beasiswa</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownProdi" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Program Studi
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownProdi">
            <li><a class="dropdown-item" href="https://tmj.poliupg.ac.id" target="_blank">Teknik Multimedia & Jaringan</a></li>
            <li><a class="dropdown-item" href="https://tkj.poliupg.ac.id" target="_blank">Teknik Komputer & Jaringan</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="admin/login.php">Login</a></li>
      </ul>
      <!-- Search Icon in Navbar -->
      <div class="navbar-search ms-lg-3 mt-2 mt-lg-0 position-relative d-inline-block">
        <button id="searchToggle" class="btn btn-warning text-white d-flex align-items-center justify-content-center" type="button" style="border-radius: 30px; width: 40px; height: 40px;">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </div>
  </div>
</nav>

<!-- Floating Search Box -->
<div id="searchOverlay" class="search-overlay">
  <form id="searchForm" class="search-form-modern" method="get" action="search.php" role="search" autocomplete="off">
    <input class="form-control" type="search" name="q" placeholder="Cari berita atau beasiswa..." aria-label="Search" autofocus>
    <button class="btn btn-warning text-white" type="submit"><i class="bi bi-search"></i></button>
    <button type="button" class="btn-close" id="closeSearch" aria-label="Close"></button>
  </form>
</div>

<style>
/* Style for dropdown menus */
.dropdown-menu {
  background-color: #fff;
  border: none;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  padding: 8px 0;
  margin-top: 0.5rem;
  display: none;
}

.dropdown-menu.show {
  display: block !important;
  z-index: 1001;
  position: absolute;
  left: auto;
  right: 0;
  top: 100%;
  min-width: 10rem;
}

.dropdown-item {
  padding: 8px 16px;
  color: #212529;
  font-weight: 500;
  transition: all 0.2s ease;
}

.dropdown-item:hover, .dropdown-item:focus {
  background-color: #f8f9fa;
  color: #56021f;
}

.nav-item.dropdown {
  position: relative;
}

.dropdown-toggle::after {
  display: inline-block;
  margin-left: 0.255em;
  vertical-align: 0.255em;
  content: "";
  border-top: 0.3em solid;
  border-right: 0.3em solid transparent;
  border-bottom: 0;
  border-left: 0.3em solid transparent;
}

.brand-title:hover {
  color: #ffc107 !important;
  cursor: pointer;
}

.navbar-search {
  position: relative;
}
.search-form-popup {
  display: none;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  min-width: 250px;
  background: #fff;
  border-radius: 30px;
  box-shadow: 0 4px 24px rgba(86,2,31,0.10);
  padding: 4px 8px;
  z-index: 9999;
}
@media (min-width: 992px) {
  .search-form-popup {
    top: 0;
    left: 100%;
    transform: translate(0, 0);
    margin-left: 10px;
  }
}

.search-overlay {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(30, 0, 20, 0.25);
  z-index: 2000;
  align-items: flex-start;
  justify-content: center;
  animation: fadeIn 0.2s;
}
.search-overlay.active {
  display: flex;
}
.search-form-modern {
  margin-top: 7vh;
  background: #fff;
  border-radius: 32px;
  box-shadow: 0 8px 32px rgba(86,2,31,0.18);
  padding: 12px 24px 12px 18px;
  display: flex;
  align-items: center;
  min-width: 320px;
  max-width: 90vw;
  width: 420px;
  position: relative;
  animation: slideDown 0.2s;
}
.search-form-modern input.form-control {
  border: none;
  outline: none;
  box-shadow: none;
  font-size: 1.1rem;
  background: transparent;
  flex: 1;
}
.search-form-modern input.form-control:focus {
  box-shadow: none;
}
.search-form-modern .btn-warning {
  border-radius: 50%;
  margin-left: 8px;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.search-form-modern .btn-close {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  font-size: 1.3rem;
  opacity: 0.7;
  z-index: 2;
}
@media (max-width: 600px) {
  .search-form-modern {
    width: 95vw;
    min-width: 0;
    padding: 10px 10px 10px 14px;
  }
}
@keyframes fadeIn {
  from { opacity: 0; }
  to   { opacity: 1; }
}
@keyframes slideDown {
  from { transform: translateY(-30px); opacity: 0; }
  to   { transform: translateY(0); opacity: 1; }
}
</style>

<script>
// Pastikan dropdown berfungsi dengan baik
document.addEventListener('DOMContentLoaded', function() {
  // Implementasi manual dropdown yang pasti berjalan
  var dropdownToggle = document.getElementById('dropdownProdi');
  var dropdownMenu = document.querySelector('.dropdown-menu');
  
  if (dropdownToggle && dropdownMenu) {
    // Manual click handler untuk dropdown menu
    dropdownToggle.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      // Toggle show class pada dropdown menu
      if (dropdownMenu.classList.contains('show')) {
        dropdownMenu.classList.remove('show');
      } else {
        dropdownMenu.classList.add('show');
      }
    });
    
    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function(e) {
      if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.classList.remove('show');
      }
    });
  }
  
  // Kalau Bootstrap tersedia, tetap inisialisasi dengan cara normal
  if (typeof bootstrap !== 'undefined') {
    setTimeout(function() {
      var dropdownElementList = document.querySelectorAll('.dropdown-toggle');
      dropdownElementList.forEach(function(element) {
        var dropdown = new bootstrap.Dropdown(element);
      });
    }, 100);
  }

  var searchToggle = document.getElementById('searchToggle');
  var searchOverlay = document.getElementById('searchOverlay');
  var searchForm = document.getElementById('searchForm');
  var closeSearch = document.getElementById('closeSearch');
  var searchInput = searchForm ? searchForm.querySelector('input[name="q"]') : null;

  function showSearchBox() {
    searchOverlay.classList.add('active');
    setTimeout(function() {
      searchInput && searchInput.focus();
    }, 100);
  }
  function hideSearchBox() {
    searchOverlay.classList.remove('active');
    if (searchInput) searchInput.value = '';
  }

  if (searchToggle && searchOverlay && searchForm) {
    searchToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      showSearchBox();
    });
    closeSearch.addEventListener('click', function(e) {
      hideSearchBox();
    });
    // Hide on click outside form
    searchOverlay.addEventListener('click', function(e) {
      if (e.target === searchOverlay) hideSearchBox();
    });
    // Hide on ESC
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') hideSearchBox();
    });
    // Prevent form click from closing overlay
    searchForm.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  }
});
</script>