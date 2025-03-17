<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null;
$user = $user_id ? ['name' => 'Admin'] : ['name' => 'Guest'];
?>

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
