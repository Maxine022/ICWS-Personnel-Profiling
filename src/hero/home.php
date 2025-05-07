<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include_once __DIR__ . '/../../backend/db.php';

// Check database connection
if ($conn->connect_error) {
    die("<div class='alert alert-danger'>Database connection failed: {$conn->connect_error}</div>");
}

// Initialize counts
$regularCount = 0;
$jobOrderCount = 0;
$contractCount = 0;
$internCount = 0;

// Fetch personnel data
$sql = "SELECT emp_type FROM personnel";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        switch ($row['emp_type']) {
            case 'Regular': $regularCount++; break;
            case 'Job Order': $jobOrderCount++; break;
            case 'Contract': $contractCount++; break;
        }
    }
} else {
    die("Error executing personnel query: " . $conn->error);
}

// Fetch intern count
$internSql = "SELECT COUNT(intern_id) AS intern_count FROM intern";
$internResult = $conn->query($internSql);

if ($internResult) {
    $internRow = $internResult->fetch_assoc();
    $internCount = (int)$internRow['intern_count'];
} else {
    die("Error executing intern query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
        body { font-family: Arial; }
        .content { padding: 30px; }
        .card {
            border: none;
            color: white;
            position: relative;
            overflow: hidden;
            height: 120px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .card i {
            font-size: 50px;
            position: absolute;
            top: 25px;
            left: 15px;
        }
        .card .text-start {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
        }
        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 25px;
            background: rgba(0, 0, 0, 0.2);
        }
        .breadcrumb-link {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s ease;
        }
        .breadcrumb-link:hover {
            color: #007bff;
            text-decoration: underline;
        }
        .view-link {
            color: #0d6efd;
            text-decoration: none;
            transition: color 0.2s ease, text-decoration 0.2s ease;
        }
        .view-link:hover {
            color: #0a58ca;
            text-decoration: underline;
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
    <?php include 'sidebar.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="content" id="content">
        <!-- Header and Breadcrumb -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h4 class="mb-0" style="font-weight: bold;">Dashboard</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>

        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card bg-info p-4">
                    <i class="fas fa-users"></i>
                    <div class="text-start ms-5">
                        <h5 class="m-0">Regular Employees</h5>
                        <h3 class="m-0 fw-bold"><?php echo $regularCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success p-4">
                    <i class="fas fa-briefcase"></i>
                    <div class="text-start ms-0">
                        <h5 class="m-0">Job Orders</h5>
                        <h3 class="m-0 fw-bold"><?php echo $jobOrderCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning p-4">
                    <i class="fas fa-file-contract"></i>
                    <div class="text-start ms-5">
                        <h5 class="m-0">Contract Employees</h5>
                        <h3 class="m-0 fw-bold"><?php echo $contractCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger p-4">
                    <i class="fas fa-user-graduate"></i>
                    <div class="text-start ms-0">
                        <h5 class="m-0">Interns</h5>
                        <h3 class="m-0 fw-bold"><?php echo $internCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
        </div>
        <hr/>
    </div>
</body>
</html>
