<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../../backend/db.php';
$fullName = $_SESSION['fullName'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
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
        .content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 60px;
            transition: margin-left 0.3s ease;
        }
        .content.expanded {
            margin-left: 0;
        }
        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar-custom" id="navbar">
    <div class="title">
        <button class="btn btn-sm btn-light" id="toggleSidebar" style="margin-left: 5px;">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="navbar-actions">
        <!-- User Profile Dropdown -->
        <div class="admin-info dropdown">
            <span class="text-muted">
                <?php echo htmlspecialchars($fullName); ?>
            </span>
            <i class="fas fa-user-circle fs-4 text-secondary"></i>
            <i class="fas fa-caret-down" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="http://localhost/ICWS-Personnel-Profiling/src/components/profile.php">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="http://localhost/ICWS-Personnel-Profiling/backend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    // JavaScript to toggle the sidebar
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggleSidebar');
        const content = document.querySelector('.content');
        const navbar = document.querySelector('.navbar-custom');

        if (toggleButton && content) {
            toggleButton.addEventListener('click', function () {
                if (content.classList.contains('expanded')) {
                    content.classList.remove('expanded');
                    if (navbar) navbar.style.left = '250px';
                } else {
                    content.classList.add('expanded');
                    if (navbar) navbar.style.left = '0';
                }
            });
        }
    });
</script>
</body>
</html>