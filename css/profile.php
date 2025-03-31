<?php
// Sample user data
$user = [
    'name' => 'John Ryan Dela Cruz',
    'email' => 'johnryan.delacruz@gmail.com',
    'location' => 'Iligan City',
    'phone' => '09123456789',
    'details' => [
        'Affiliation' => 'College Graduate',
        'Status' => 'Active',
        'Sex' => 'Male',
        'Civil Status' => 'Married',
        'Citizenship' => 'Filipino',
        'Birthdate' => '2025-02-17',
        'Birthplace' => 'Unknown',
        'Religion' => 'Unknown',
        'Permanent Address' => 'Iligan City'
    ]
];

$adminData = [
    'employee_number' => '2025-0001',
    'position' => 'Engineer IV',
    'division' => 'Admin'
];

$serviceRecords = [
    ['start' => '2020-01-01', 'end' => '2022-12-31', 'position' => 'Engineer IV', 'division' => 'Admin'],
    ['start' => '2018-06-15', 'end' => '2019-12-31', 'position' => 'Senior Developer', 'division' => 'IT'],
    ['start' => '2015-03-10', 'end' => '2018-06-14', 'position' => 'Software Developer', 'division' => 'IT']
];

// Pagination settings
$recordsPerPage = 2; // Change this to set how many records per page
$totalRecords = count($serviceRecords);
$totalPages = ceil($totalRecords / $recordsPerPage);

// Get current page from URL
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages)); 

// Calculate offset
$offset = ($currentPage - 1) * $recordsPerPage;

// Slice the records array for pagination
$pagedRecords = array_slice($serviceRecords, $offset, $recordsPerPage);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .header {
            background: #2C3E50;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #2C3E50;
            position: fixed;
            top: 0;
            left: -250px;
            padding-top: 60px;
            color: white;
            transition: left 0.3s ease-in-out;
        }
        .sidebar.show {
            left: 0;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #007BFF;
        }
        .sidebar h3 {
            margin-top: 10px; 
        }
        .toggle-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            margin-right: 15px;
        }
        .content {
            margin-left: 0;
            padding: 80px 20px 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        .content.shifted {
            margin-left: 250px; /* Fixed missing 'px' */
        }
        .profile-card, .details-card {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ddd;
            display: block;
            margin: 0 auto;
        }
        .btn-container {
            text-align: right;
        }
        @media (max-width: 768px) {
            .content.shifted {
                margin-left: 0;
            }
        }
        .pagination .page-link {
            background-color: #FEFEFE; 
            color: black; 
            border: 1px solid 000000; 
        }

        .pagination .page-link:hover {
            background-color: #0056b3; 
            color: white;
        }

        .pagination .active .page-link {
            background-color: #0056b3; 
            border-color: #000000;
            color: white;
        }
        .pagination-container {
            margin-top: 50px; 
        }
    </style>
</head>
<body>
        
    <div class="header">
        <button class="toggle-btn" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        <h3 class="m-0">Profile Dashboard</h3>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="d-flex align-items-center ps-3" style="margin-top: 10px;">
        <img src="/assets/logo.png" alt="ICWS Logo" width="40" height="40" class="me-2">
        <h3 class="m-0 fw-bold" style="padding-top: 5px;">ICWS</h3>
    </div>
        <hr>
        <div class="d-flex align-items-center justify-content-start mb-3 ps-3">
            <img src="/assets/profile.jpg" class="rounded-circle" alt="User Profile" width="40" height="40">
            <p class="m-0 ms-2"><?php echo $user['name']; ?></p>
        </div>
        <hr>
        <a href="#"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#"><i class="fas fa-user"></i> Profile</a>
        <a href="#"><i class="fas fa-tasks"></i> Manage</a>
        <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container mt-4">
            <div class="row">
                <!-- Sidebar Profile Info -->
                <div class="col-md-3">
                    <div class="card profile-card text-center">
                        <img src="/assets/profile.jpg" class="profile-img" alt="User Profile">
                        <h5 class="mt-2"><?php echo $user['name']; ?></h5>
                        <p class="text-muted"><i><?php echo $user['email']; ?></i></p>
                        <hr>
                        <p>
                            <i class="fas fa-map-marker-alt"></i> Iligan City  &nbsp;|&nbsp; 
                            <i class="fas fa-phone"></i> 09123456789
                        </p>
                    </div>

                    <!-- Personal Details Box -->
                    <div class="card details-card mt-3">
                        <h6 class="fw-bold" style= "font-size: 18px;">Personal Details</h6>
                        <hr> <!-- Line after the heading -->
                        <?php foreach ($user['details'] as $key => $value) { ?>
                            <p><strong><?php echo $key; ?>:</strong> <?php echo $value; ?></p>
                        <?php } ?>
                    </div>
                    </div>

                <!-- Admin Data and Service Records -->
                <div class="col-md-9">
                    <div class="card p-3 profile-card">
                        <div class="btn-container">
                            <button class="btn btn-success">Update</button>
                            <button class="btn btn-warning">Print</button>
                        </div>
                        <h5 class="fw-bold mt-3">Admin Data</h5>
                        <p><strong>Employee Number:</strong> <?php echo $adminData['employee_number']; ?></p>
                        <p><strong>Position:</strong> <?php echo $adminData['position']; ?></p>
                        <p><strong>Division:</strong> <?php echo $adminData['division']; ?></p>

                        <hr>

                        <h5 class="fw-bold">Service Record</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Starting Date</th>
                                    <th>Ending Date</th>
                                    <th>Position</th>
                                    <th>Division</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($serviceRecords as $record) { ?>
                                    <tr>
                                        <td><?php echo $record['start']; ?></td>
                                        <td><?php echo $record['end']; ?></td>
                                        <td><?php echo $record['position']; ?></td>
                                        <td><?php echo $record['division']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <nav class="pagination-container">
                        <ul class="pagination pagination-sm justify-content-center">
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link prev-next" href="?page=<?php echo $currentPage - 1; ?>">« Prev</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link prev-next" href="?page=<?php echo $currentPage + 1; ?>">Next »</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    </div>
                </body>
                </html>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        document.querySelector(".sidebar").classList.toggle("show");
        document.querySelector(".content").classList.toggle("shifted");
    }
    </script>
</body>
</html>