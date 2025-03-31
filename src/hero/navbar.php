<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
$user = $user_id ? ['name' => 'Admin'] : ['name' => 'Guest'];
?>

<div class="navbar-custom" id="navbar">
    <div class="title">
        <button class="btn btn-sm btn-light" id="toggleSidebar" style="margin-left: 5px;">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="admin-info dropdown">
    <span class="text-muted"><?php echo $user['name']; ?></span>
    <i class="fas fa-user-circle fs-4 text-secondary"></i>
    
    <!-- Dropdown button -->
    <i class="fas fa-caret-down" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></i>
    
    <!-- Dropdown menu -->
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="/src/components/profile.php">Profile</a></li>
        <li><hr class="dropdown-divider"></li> 
        <li><a class="dropdown-item" href="/src/components/login.php">Logout</a></li>
    </ul>
</div>

</div>

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

#toggleSidebar {
    margin-left: 5px;
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
</style>