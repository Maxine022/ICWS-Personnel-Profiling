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
        width: calc(100% - 250px);
        height: 60px;
        background: #fff;
        border-bottom: 1px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1rem;
        z-index: 1000;
        transition: left 0.3s ease, width 0.3s ease;
    }
        .content.expanded {
            margin-left: 0;
        }
        /* when body gets this class, shrink the sidebar & expand navbar */
        body.sidebar-closed .navbar-custom {
            left: 0;
            width: 100%;
        }
        .admin-info { display: flex; align-items: center; gap: .5rem; }
        .admin-info .dropdown-toggle { cursor: pointer; }

        /* sidebar.css or in your <head> */
        .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh;
        background: #2C3E50;
        transition: transform 0.3s ease;
        z-index: 999;
        }
        body.sidebar-closed .sidebar {
        transform: translateX(-250px);
        }

        /* content area: pushed right by 250px when sidebar is open */
        #content {
        margin-left: 250px;
        transition: margin-left 0.3s ease;
        padding: 1.5rem;
        margin-top: 50px
        }
        body.sidebar-closed #content {
        margin-left: 0;
        }

    </style>
</head>
<body>

<!-- Navbar -->
<div id="navbar" class="navbar-custom">
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
                <li><a class="dropdown-item" href="http://localhost/ICWS-Personnel-Profiling/backend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
  // toggle sidebar by adding/removing a class on <body>
  document.getElementById('toggleSidebar')
    .addEventListener('click', () => {
      document.body.classList.toggle('sidebar-closed');
    });
</script>

</body>
</html>