<?php
session_start();

// Load personnel data from JSON file
$personnelJson = file_get_contents('personnel.json');
$personnelData = json_decode($personnelJson, true);

// Fetch user data
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id) {
    // This only works if you're connected to a MySQL database.
    // If you're not using a DB yet, just skip or comment this part.
    // $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
    // $user = mysqli_fetch_assoc($query);
    $user = ['name' => 'Admin']; 
} else {
    $user = ['name' => 'Guest'];
}

// Count personnel types
$internCount = 0;
$regularCount = 0;
$jobOrderCount = 0;
$contractCount = 0;

if (is_array($personnelData)) {
    foreach ($personnelData as $person) {
        switch ($person['type']) {
            case 'Regular Employee':
                $regularCount++;
                break;
            case 'Job Order':
                $jobOrderCount++;
                break;
            case 'Contract of Service':
                $contractCount++;
                break;
            case 'Intern':
                $internCount++;
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ICWS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar-custom {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 60px;
            background-color: #ffffff;
            color: #000;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 0 15px;
            z-index: 1000;
            transition: left 0.3s ease;
        }
        .navbar-custom .title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
        }
        .navbar-custom .admin-info {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            margin-right: 20px;
        }
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
        .sidebar.d-none {
            transform: translateX(-100%);
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
            transition: max-height 0.3s ease-in-out;
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
        .dropdown-menu {
            display: none;
            flex-direction: column;
            padding-left: 30px;
            background: none;
        }
        .dropdown-menu a {
            padding: 8px 0px;
            font-size: 14px;
        }
        .rotate {
            transform: rotate(90deg);
            transition: transform 0.3s ease;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 60px;
            transition: margin-left 0.3s ease;
        }
        .content.expanded {
            margin-left: 0;
        }
        .card {
            border: none;
            color: white;
            position: relative;
            overflow: hidden;
            height: 120px; 
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card i {
            font-size: 50px;
            position: absolute;
            top: 25px;
            left: 15px;
        }
        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 25px;
            background: rgba(0, 0, 0, 0.2);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
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
        .profile-manage-container {
            display: flex;
            justify-content: flex-start;
            gap: 20px;
            margin-top: 5px; 
        }
        .square-box {
            width: 70px;  
            height: 70px;
            background: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background 0.3s, color 0.3s;
            padding: 5px;
        }
        .square-box i {
            font-size: 24px; 
            line-height: 1;
        }
        .square-box:hover {
            background: #007BFF;
            color: white;
        }
        .square-box span {
            font-size: 12px; 
            display: block;
            margin-top: 3px;
            text-align: center;
        }
    </style>
</head>
<body>


    <!-- Sidebar -->
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
        
        <!-- Manage Personnel Dropdown -->
        <a href="#" id="manageToggle" class="manage-toggle">
            <i class="fas fa-chevron-right" id="chevron"></i>
            <i class="fas fa-tasks"></i> Manage Personnel
        </a>
        
        <div class="dropdown-container" id="manageDropdown">
            <a href="#"><i class="far fa-circle bullet-icon"></i> Regular Employee</a>
            <a href="#"><i class="far fa-circle bullet-icon"></i> Job Order</a>
            <a href="#"><i class="far fa-circle bullet-icon"></i> Contract of Service</a>
            <a href="#"><i class="far fa-circle bullet-icon"></i> Intern</a>
        </div>
        
        <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Top Navigation Bar -->
    <div class="navbar-custom" id="navbar">
        <div class="title">
            <button class="btn btn-sm btn-light" id="toggleSidebar" style="margin-left: 5px;">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="admin-info">
        <span class="text-muted"><?php echo $user['name']; ?></span>
            <i class="fas fa-user-circle fs-4 text-secondary"></i>
        </div>
    </div>

    <!-- Content -->
    <div class="content" id="content">
        <div class="header">
            <h2>Dashboard</h2>
            <div class="header-text">
                <a href="#" style="text-decoration: none; color: inherit; transition: 0.3s;" 
                   onmouseover="this.style.textDecoration='underline'; this.style.color='#007bff'"
                   onmouseout="this.style.textDecoration='none'; this.style.color='inherit'">
                   Home
                </a> / Dashboard
            </div>
        </div>

        <!-- Dashboard Cards -->
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card bg-info p-4">
                    <i class="fas fa-user"></i>
                    <div class="d-flex flex-column text-start ms-4">
                        <h5 class="m-0">Regular Employee</h5>
                        <h3 class="m-0 fw-bold"><?php echo isset($regularCount) ? $regularCount : '0'; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success p-4">
                    <i class="fas fa-user"></i>
                    <div class="d-flex flex-column text-start" style="margin-left: -50px;">
                        <h5 class="m-0">Job Order</h5>
                        <h3 class="m-0 fw-bold"><?php echo isset($jobOrderCount) ? $jobOrderCount : '0'; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning p-4">
                    <i class="fas fa-briefcase"></i>
                    <div class="d-flex flex-column text-start" style="margin-right: -40px;">
                        <h5 class="m-0">Contract of Service</h5>
                        <h3 class="m-0 fw-bold"><?php echo isset($contractCount) ? $contractCount : '0'; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger p-4">
                    <i class="fas fa-user"></i>
                    <div class="d-flex flex-column text-start" style="margin-left: -90px;">
                        <h5 class="m-0">Intern</h5>
                        <h3 class="m-0 fw-bold"><?php echo isset($internCount) ? $internCount : '0'; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
        </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="profile-manage-container">
                <div class="square-box"><i class="fas fa-user"></i><span>Profile</span></div>
                <div class="square-box"><i class="fas fa-users"></i><span>Manage</span></div>
            </div>
        </div>
    </div>
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
</body>
</html>