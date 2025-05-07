<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include_once __DIR__ . '/../../backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $emp_no = $_POST['emp_no'];
    $full_name = $_POST['full_name'];
    $sex = $_POST['sex'];
    $birthdate = $_POST['birthdate'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $position = $_POST['position'];
    $division = $_POST['division'];
    $salary_rate = $_POST['salary_rate'];

    // Insert into personnel table
    $stmt = $conn->prepare("
        INSERT INTO personnel (Emp_No, full_name, sex, birthdate, contact_number, address, position, division, emp_type, emp_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Contract', 'Active')
    ");
    $stmt->bind_param("ssssssss", $emp_no, $full_name, $sex, $birthdate, $contact_number, $address, $position, $division);
    $stmt->execute();

    // Get the last inserted personnel_id
    $personnel_id = $conn->insert_id;

    // Insert into contract_service table
    $stmt = $conn->prepare("
        INSERT INTO contract_service (personnel_id, salaryRate)
        VALUES (?, ?)
    ");
    $stmt->bind_param("id", $personnel_id, $salary_rate);
    $stmt->execute();

    // Redirect to manage_cos.php after successful insertion
    header("Location: http://localhost/ICWS-Personnel-Profiling/src/components/manage_cos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contract of Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
    body { font-family: Arial; }
    .content { padding: 30px; }
    .table-container { margin-top: 30px; }
    .breadcrumb-link { color: inherit; text-decoration: none; transition: color 0.2s ease; }
    .breadcrumb-link:hover { color: #007bff; text-decoration: underline; }
    .view-link { color: #0d6efd; text-decoration: none; transition: color 0.2s ease, text-decoration 0.2s ease; }
    .view-link:hover { color: #0a58ca; text-decoration: underline; }
    .search-buttons-container { margin-top: 25px; }
    .shadow-custom { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
    </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
<div class="container mt-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0 fw-bold"> Add Contract of Service Employees</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/personnel_record.php">Manage Personnel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contract of Service</li>
      </ol>
    </nav>
  </div>
    <form method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="emp_no" class="form-label">Employee Number</label>
                <input type="text" class="form-control" id="emp_no" name="emp_no" required>
            </div>
            <div class="col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="col-md-6">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-select" id="sex" name="sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
            </div>
            <div class="col-md-6">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" required>
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="col-md-6">
            <?php
                $positionFilePath = __DIR__ . '/ideas/position.php';
                if (!file_exists($positionFilePath)) {
                    die("Error: position.php file not found.");
                }
                include_once $positionFilePath;
                ?>
                <label class="form-label">Position</label>
                <select class="form-select" name="position" required>
                    <option value="">Select Position</option>
                    <?php
                    if (class_exists('Position')) {
                foreach (Position::cases() as $position) {
                    echo "<option value=\"{$position->value}\">{$position->value}</option>";
                }
                    } else {
                echo "<option value=\"\">Error: Position class not found.</option>";
                    }
            ?>
          </select>
            </div>
            <div class="col-md-6">
            <label class="form-label">Division</label>
            <select class="form-select" name="division" required>
                <option value="">Select Division</option>
                <?php
                $divisionFilePath = __DIR__ . '/ideas/division.php';
                if (!file_exists($divisionFilePath)) {
            die("Error: division.php file not found.");
                }
                include_once $divisionFilePath;
                if (class_exists('Division')) {
            foreach (Division::cases() as $division) {
                echo "<option value=\"{$division->value}\">{$division->value}</option>";
            }
                } else {
            echo "<option value=\"\">Error: Division class not found.</option>";
                }
            ?>
          </select>
            </div>
            <div class="col-md-6">
                <label for="salary_rate" class="form-label">Salary Rate</label>
                <input type="number" step="0.01" class="form-control" id="salary_rate" name="salary_rate" required>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Add Contract of Service</button>
            <a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_cos.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>