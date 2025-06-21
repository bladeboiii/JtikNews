<!-- sidebar.php -->
<?php 
  // Determine the current page to highlight active menu item
  $current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar" id="mySidebar">
  <div class="side-header text-center">
    <img src="./assets/images/logo.png" width="100" height="100" class="img-fluid"> 
    <h5 style="color:white;">Hello, Admin</h5>
  </div>

  <hr style="border:1px solid; background-color:#8a7b6d; border-color:#3B3131;">

  <a href="admin.php" class="nav-link <?= $current_page == 'admin.php' ? 'active' : '' ?>">
    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
  </a>
  <a href="berita2.php" class="nav-link <?= $current_page == 'berita.php' ? 'active' : '' ?>">
    <i class="fas fa-newspaper"></i> <span>Berita</span>
  </a>
  <a href="Beasiswa.php" class="nav-link <?= $current_page == 'Beasiswa.php' ? 'active' : '' ?>">
    <i class="fas fa-award"></i> <span>Beasiswa</span>
  </a>
  <a href="logout.php" class="nav-link">
    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
  </a>
</div>

<!-- Toggle Button for Responsive Sidebar -->
<button id="sidebarToggle" class="btn btn-warning sidebar-toggle">
  <i class="fas fa-bars"></i>
</button>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Check viewport width on load
    checkViewport();
    
    // Add toggle functionality
    document.getElementById('sidebarToggle').addEventListener('click', function() {
      document.getElementById('mySidebar').classList.toggle('collapsed');
      document.getElementById('main').classList.toggle('expanded');
      document.querySelector('.navbar').style.marginLeft = 
        document.getElementById('mySidebar').classList.contains('collapsed') ? '250px' : '60px';
    });
    
    // Check viewport on resize
    window.addEventListener('resize', checkViewport);
  });
  
  function checkViewport() {
    const sidebar = document.getElementById('mySidebar');
    const mainContent = document.getElementById('main');
    const navbar = document.querySelector('.navbar');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (window.innerWidth <= 992) {
      toggleBtn.style.display = 'block';
      
      if (!sidebar.classList.contains('collapsed') && !mainContent.classList.contains('expanded')) {
        sidebar.classList.add('mobile-view');
      }
    } else {
      toggleBtn.style.display = 'none';
      sidebar.classList.remove('mobile-view');
      sidebar.classList.remove('collapsed');
      mainContent.classList.remove('expanded');
      navbar.style.marginLeft = '250px';
    }
  }
</script>
