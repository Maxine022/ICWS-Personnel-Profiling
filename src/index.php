<?php
session_start();

// Load personnel data
$personnelJson = file_get_contents('personnel.json');
$personnelData = json_decode($personnelJson, true);

// Initialize counts
$internCount = $regularCount = $jobOrderCount = $contractCount = 0;

if (is_array($personnelData)) {
    foreach ($personnelData as $person) {
        switch ($person['type']) {
            case 'Regular Employee': $regularCount++; break;
            case 'Job Order': $jobOrderCount++; break;
            case 'Contract of Service': $contractCount++; break;
            case 'Intern': $internCount++; break;
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <?php include './hero/sidebar.php'; ?>
    <?php include './hero/navbar.php'; ?>

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
                    <i class="fas fa-briefcase"></i>
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

        <div class="row mt-4">
        <div class="col-md-3">
            <div class="profile-manage-container">
                <div class="square-box"><i class="fas fa-user"></i><span>Profile</span></div>
                <div class="square-box"><i class="fas fa-users"></i><span>Manage</span></div>
            </div>
        </div>
    </div>
    </div>

    <?php include './hero/footer.php'; ?>

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
