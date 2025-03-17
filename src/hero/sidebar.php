<?php
session_start();
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

    <div class="d-flex align-items-center justify-content-start mb-3 ps-3 sidebar-divider">
        <img src="/assets/profile.jpg" class="rounded-circle" alt="User Profile" width="40" height="40">
        <p class="m-0 ms-2"><?php echo $user['name']; ?></p>
    </div>

    <hr class="sidebar-divider">
    
    <a href="#"><i class="fas fa-home"></i> Dashboard</a>
    <a href="#"><i class="fas fa-user"></i> Profile</a>
    <a href="#"><i class="fas fa-users"></i> Personnel</a>
    
    <a href="#" id="manageToggle" class="manage-toggle">
        <i class="fas fa-chevron-right" id="chevron"></i>
        <i class="fas fa-tasks"></i> Manage Personnel
    </a>

    <div class="dropdown-container" id="manageDropdown">
        <a href="#"><i class="far fa-circle bullet-icon"></i> Regular Employee</a>
        <a href="#"><i class="far fa-circle bullet-icon"></i> Job Order</a>
        <a href="#"><i class="far fa-circle bullet-icon"></i> Contract of Service</a>
    </div>
    
    <a href="#"><i class="fas fa-users"></i>Intern</a>
    <a href="#"><i class="fas fa-users"></i> COC</a>
    
    <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var manageToggle = document.getElementById("manageToggle");
    var manageDropdown = document.getElementById("manageDropdown");
    var chevron = document.getElementById("chevron");

    manageToggle.addEventListener("click", function (event) {
        event.preventDefault(); // Prevents default link behavior

        // Toggle the dropdown
        if (manageDropdown.style.display === "block") {
            manageDropdown.style.display = "none";
            chevron.classList.remove("rotate");
        } else {
            manageDropdown.style.display = "block";
            chevron.classList.add("rotate");
        }
    });
});
</script>

