<?php
session_start();

include_once __DIR__ . '/../backend/db.php';

// Fetch personnel data from the database
$personnelData = [];
$sql = "SELECT emp_type FROM personnel";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $personnelData[] = $row;
    }
}

// Initialize counts
$internCount = $regularCount = $jobOrderCount = $contractCount = 0;

if (is_array($personnelData)) {
    foreach ($personnelData as $person) {
        switch ($person['type']) {
            case 'Regular': $regularCount++; break;
            case 'Job Order': $jobOrderCount++; break;
            case 'Contract': $contractCount++; break;
        }
    }
}
?>

<?php include './hero/sidebar.php'; ?>
<?php include './hero/navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap Bundle with Popper (must be loaded before dropdowns work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="content" id="content">
        <!-- Header and Breadcrumb -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h4 class="mb-0" style="font-weight: bold;">Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
        </div>

        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card bg-info p-4">
                    <i class="fas fa-user"></i>
                    <div class="text-start ms-4">
                        <h5 class="m-0">Regular Employee</h5>
                        <h3 class="m-0 fw-bold"><?php echo $regularCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success p-4">
                    <i class="fas fa-user"></i>
                    <div class="text-start ms-4">
                        <h5 class="m-0">Job Order</h5>
                        <h3 class="m-0 fw-bold"><?php echo $jobOrderCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning p-4">
                    <i class="fas fa-user"></i>
                    <div class="text-start ms-4">
                        <h5 class="m-0">Contract of Service</h5>
                        <h3 class="m-0 fw-bold"><?php echo $contractCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger p-4">
                    <i class="fas fa-user"></i>
                    <div class="text-start ms-4">
                        <h5 class="m-0">Intern</h5>
                        <h3 class="m-0 fw-bold"><?php echo $internCount; ?></h3>
                    </div>
                    <div class="card-overlay"></div>
                </div>
            </div>
        </div>
        <hr/>
    </div>
    <?php include './hero/footer.php'; ?>
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

<style>
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
        .breadcrumb-custom {
        font-size: 14px;
        }
        .breadcrumb-link {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s ease;
        }
        .breadcrumb-link:hover {
        color: #0d6efd;
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
        .content {
            margin-left: 250px;
            padding: 20px;
            margin-top: 0px;
            transition: margin-left 0.3s ease;
        }
</style>