<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email = $_SESSION['email'] ?? 'Guest';
?>
<style>
/* Sidebar styles */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        background: #2C3E50;
        color: white;
        z-index: 999;
        transition: transform 0.3s ease;
    }
    .sidebar a {
        display: flex;
        align-items: center;
        color: white;
        padding: 12px 20px;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: background 0.3s;
    }
    .sidebar a:hover {
        background: #007BFF;
    }
    .sidebar a.active {
        background-color: #007BFF;
        color: white !important;
    }
    .sidebar a i {
        width: 25px;
        text-align: center;
        margin-right: 10px;
    }
    .sidebar .sidebar-divider {
        border-top: 1px solid #bbb;
        margin: 10px 0;
    }
    .sidebar .profile-section {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        font-size: 16px;
    }
    .sidebar .profile-section img {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }
    .sidebar-custom {
        width: 250px;
        position: fixed;
        top: 60px;
        left: 0;
        height: 100%;
        background-color: #343a40;
        transition: transform 0.3s ease;
        z-index: 999;
    }
    .sidebar-hidden {
        transform: translateX(-250px);
    }
    .dropdown-container {
        display: none;
        flex-direction: column;
        padding-left: 30px;
        margin-top: 5px;
    }
    .dropdown-container a {
        padding: 8px 0px;
        font-size: 14px;
        color: #dcdcdc;
        transition: color 0.3s;
    }
    .dropdown-container a:hover {
        color: white;
    }
    .manage-toggle {
        display: flex;
        padding: 12px 15px;
        text-decoration: none;
        color: white;
        white-space: nowrap;
        width: 100%;
    }
    .manage-toggle i {
        width: 20px;
        text-align: center;
    }
    .manage-toggle i:first-child {
        transition: transform 0.3s ease;
        margin-right: 10px;
    }
    #chevron {
        order: 1;
    }
    .rotate {
        transform: rotate(90deg);
        transition: transform 0.3s ease;
    }

</style>

<div id="sidebar" class="sidebar">
    <div class="d-flex align-items-center justify-content-start mb-3 ps-3 pt-3">
        <a href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php" class="text-decoration-none text-white"> <!-- Link added here -->
            <img src="../../assets/logo.png" alt="ICWS Logo" width="40" height="40" class="me-2">
            <h3 class="m-0 fw-bold">ICWS</h3>
        </a>
    </div>

    <hr class="sidebar-divider">
    
    <a href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php" class="<?php echo ($_SERVER['REQUEST_URI'] == 'hero.php') ? 'active' : ''; ?>">
        <i class="fas fa-home"></i> Dashboard
    </a>
    </a><a href="http://localhost/ICWS-Personnel-Profiling/src/components/personnel_record.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/src/components/personnel_record.php') ? 'active' : ''; ?>">
        <i class="fas fa-users"></i> Personnel
    </a>
    
    <a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_regEmp.php" id="manageToggle" class="manage-toggle">
        <i class="fas fa-chevron-right" id="chevron"></i>
        <i class="fas fa-tasks"></i> Manage Personnel
    </a>

    <div class="dropdown-container" id="manageDropdown">
        <a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_regEmp.php"
            class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'manage_regEmp.php') !== false) ? 'active' : ''; ?>">
            <i class="far fa-circle bullet-icon"></i> Regular Employee
        </a>
        <a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_jo.php"
            class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'manage_jo.php') !== false) ? 'active' : ''; ?>">
            <i class="far fa-circle bullet-icon"></i> Job Order
        </a>
        <a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_cos.php"
            class="<?php echo (strpos($_SERVER['REQUEST_URI'], 'manage_cos.php') !== false) ? 'active' : ''; ?>">
            <i class="far fa-circle bullet-icon"></i> Contract of Service
        </a>
    </div>
    
    </a><a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_intern.php" class="<?php echo ($_SERVER['REQUEST_URI'] == '/src/components/manage_intern.php') ? 'active' : ''; ?>">
        <i class="fas fa-users"></i> Internship
    </a>
    <a href="http://localhost/ICWS-Personnel-Profiling/backend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<script>
document.getElementById("toggleSidebar").addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content");
    const navbar = document.getElementById("navbar");

    if (sidebar.classList.contains("d-none")) {
        sidebar.classList.remove("d-none");
        content.classList.remove("expanded");
        navbar.style.left = "250px";
    } else {
        sidebar.classList.add("d-none");
        content.classList.add("expanded");
        navbar.style.left = "0";
    }
});

document.getElementById("manageToggle").addEventListener("click", function(event) {
    event.preventDefault();
    let dropdown = document.getElementById("manageDropdown");
    let chevron = document.getElementById("chevron");
    if (dropdown.style.display === "flex") {
        dropdown.style.display = "none";
        chevron.classList.remove("rotate");
    } else {
        dropdown.style.display = "flex";
        chevron.classList.add("rotate");
    }
});

document.addEventListener("click", function(event) {
    const dropdown = document.getElementById("manageDropdown");
    const toggle = document.getElementById("manageToggle");
    const chevron = document.getElementById("chevron");
    // Only close if dropdown is open, and click is outside both toggle and dropdown
    if (
        dropdown.style.display === "flex" &&
        !dropdown.contains(event.target) &&
        !toggle.contains(event.target)
    ) {
        dropdown.style.display = "none";
        chevron.classList.remove("rotate");
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar   = document.getElementById('sidebar');
    const content   = document.getElementById('content');
    const navbar    = document.getElementById('navbar');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('sidebar-hidden');
      content.classList.toggle('expanded');
      // if sidebar is hidden, navbar slides to 0; otherwise back to 250px
      navbar.style.left = sidebar.classList.contains('sidebar-hidden') ? '0' : '250px';
    });
  });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>