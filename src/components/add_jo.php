<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $Emp_No = $conn->real_escape_string(trim($_POST["Emp_No"]));
    $full_name = $conn->real_escape_string(trim($_POST["full_name"]));
    $contact_number = $conn->real_escape_string(trim($_POST["contact_number"]));
    $birthdate = $conn->real_escape_string(trim($_POST["birthdate"]));
    $sex = $conn->real_escape_string(trim($_POST["sex"]));
    $position = $conn->real_escape_string(trim($_POST["position"]));
    $division = $conn->real_escape_string(trim($_POST["division"]));
    $salaryRate = $conn->real_escape_string(trim($_POST["salaryRate"]));
    $address = $conn->real_escape_string(trim($_POST["address"]));

    // Validate required fields
    if (empty($Emp_No)) $errors[] = "Employee Number is required.";
    if (empty($full_name)) $errors[] = "Full Name is required.";
    if (empty($contact_number)) $errors[] = "Contact Number is required.";
    if (empty($birthdate)) $errors[] = "Birthdate is required.";
    if (empty($sex)) $errors[] = "Sex is required.";
    if (empty($position)) $errors[] = "Position is required.";
    if (empty($division)) $errors[] = "Division is required.";
    if (empty($salaryRate)) $errors[] = "Salary Rate is required.";
    if (empty($address)) $errors[] = "Address is required.";

    // If no errors, insert into the database
    if (empty($errors)) {
        // Insert into the personnel table
        $sql_personnel = "INSERT INTO personnel (Emp_No, full_name, contact_number, birthdate, sex, position, division, address, emp_type, emp_status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Job Order', 'Active')";
        $stmt_personnel = $conn->prepare($sql_personnel);
        $stmt_personnel->bind_param(
            "ssssssss",
            $Emp_No,
            $full_name,
            $contact_number,
            $birthdate,
            $sex,
            $position,
            $division,
            $address
        );

        if ($stmt_personnel->execute()) {
            // Get the last inserted personnel_id
            $personnel_id = $conn->insert_id;

            // Insert into the job_order table
            $sql_job_order = "INSERT INTO job_order (personnel_id, salaryRate) VALUES (?, ?)";
            $stmt_job_order = $conn->prepare($sql_job_order);
            $stmt_job_order->bind_param("is", $personnel_id, $salaryRate);

            if ($stmt_job_order->execute()) {
                $success = true;
                echo "<script>alert('Job Order Employee added successfully!'); window.location.href = 'http://localhost/ICWS-Personnel-Profiling/src/components/manage_jo.php';</script>";
                exit();
            } else {
                $errors[] = "Error adding salary rate to job order: " . $conn->error;
            }

            $stmt_job_order->close();
        } else {
            $errors[] = "Error adding job order employee: " . $conn->error;
        }

        $stmt_personnel->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Job Order Employee</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

  <style>
    body {
      font-family: 'Arial';
    }
    .content {
      padding: 30px;
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
    .form-section {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .btn-cancel {
      background-color: #fff;
      border: 1px solid #ced4da;
      color: #000;
    }
    .btn-cancel:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
<?php include './src/hero/sidebar.php'; ?>
<?php include './src/hero/navbar.php'; ?>

<!-- Main Content -->
<div class="content" id="content">
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h5 class="mb-0 fw-bold">Add New Job Order Employees</h5>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_jo.php">Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Order</li>
      </ol>
    </nav>
  </div>

  <!-- Display success message -->
  <?php if ($success): ?>
    <div class="alert alert-success">Job Order Employee added successfully!</div>
  <?php endif; ?>

  <!-- Display errors -->
  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $error): ?>
          <li><?= htmlspecialchars($error); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <div class="form-section">
    <form method="POST" action="">
      <div class="col-md-6">
          <label class="form-label">Emp_No</label>
          <input type="text" class="form-control" name="Emp_No" required>
        </div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number" maxlength="11" pattern="\d{11}" title="Please enter an 11-digit contact number" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Birthdate</label>
          <input type="date" class="form-control" name="birthdate" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Sex</label>
          <select name="sex" class="form-select" required>
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
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
          <label class="form-label">Salary</label>
          <input type="text" class="form-control" name="salaryRate" required>
        </div>
        <div class="col-6">
          <label class="form-label">Address</label>
          <input type="text" class="form-control" name="address" required>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4">Submit</button>
        <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
      </div>
    </form>
  </div>

</div>

</body>
</html>