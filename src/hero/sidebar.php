<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user_id'] ?? ['name' => 'Guest'];
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
    #chevron {
        order: 1;
    }
    .rotate {
        transform: rotate(90deg);
        transition: transform 0.3s ease;
    }

</style>

<div class="sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-start mb-3 ps-3 pt-3">
        <img src="/assets/logo.png" alt="ICWS Logo" width="40" height="40" class="me-2">
        <h3 class="m-0 fw-bold">ICWS</h3>
    </div>

    <hr class="sidebar-divider">

    <div class="d-flex align-items-center justify-content-start mb-3 ps-3">
        <img src="/assets/profile.jpg" class="rounded-circle" alt="User Profile" width="40" height="40">
        <p class="m-0 ms-2"><?php echo $user['name']; ?></p>
    </div>

    <hr class="sidebar-divider">
    
    <a href="/src/index.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="/src/components/profile.php"><i class="fas fa-user"></i> Profile</a>
    <a href="/src/components/personnel_record.php"><i class="fas fa-users"></i> Personnel</a>
    
    <a href="/src/components/personnel_record.php" id="manageToggle" class="manage-toggle">
        <i class="fas fa-chevron-right" id="chevron"></i>
        <i class="fas fa-tasks"></i> Manage Personnel
    </a>

    <div class="dropdown-container" id="manageDropdown">
        <a href="/src/components/manage_regEmp.php"><i class="far fa-circle bullet-icon"></i> Regular Employee</a>
        <a href="#"><i class="far fa-circle bullet-icon"></i> Job Order</a>
        <a href="#"><i class="far fa-circle bullet-icon"></i> Contract of Service</a>
    </div>
    
    <a href="#"><i class="fas fa-users"></i>Intern</a>
    <a href="#"><i class="fas fa-users"></i> COC</a>
    
    <a href="/src/components/login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

