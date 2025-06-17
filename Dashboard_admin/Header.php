<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-dark px-5" style="background-color:#56021f;">
    <a class="navbar-brand ml-5 d-flex align-items-center">
        <img src="./assets/images/JTIK.png" width="60" height="60" class="mr-2" alt="Logo">
        <div>
            <span class="text-white font-weight-bold" style="font-size: 20px;">TEKNIK INFORMATIKA DAN KOMPUTER</span><br>
            <span class="text-white" style="font-size: 0.85rem;">Politeknik Negeri Ujung Pandang</span>
        </div>
    </a>

    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>

    <div class="user-profile">
        <?php if(isset($_SESSION['admin_logged_in'])): ?>
            <a href="logout.php" class="nav-icon" title="Logout">
                <i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline-block ml-1">Logout</span>
            </a>
        <?php else: ?>
            <a href="../index.php" class="nav-icon" title="Homepage">
                <i class="fas fa-home"></i>
            </a>
        <?php endif; ?>
    </div>
</nav>

<!-- CSS tambahan -->
<style>
    .nav-icon {
        text-decoration: none;
        margin-right: 20px;
        font-size: 20px;
        color: #fff;
        transition: color 0.3s ease;
    }

    .nav-icon:hover {
        color: #ffc107;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .navbar-brand div {
        text-align: left;
    }

    .navbar-brand span {
        font-family: 'Segoe UI', sans-serif;
        letter-spacing: 1px;
    }
    
    @media (max-width: 992px) {
        .navbar-brand div span:first-child {
            font-size: 16px !important;
        }
        
        .navbar-brand img {
            width: 40px;
            height: 40px;
        }
    }
    
    @media (max-width: 768px) {
        .navbar-brand div {
            display: none;
        }
    }
</style>
