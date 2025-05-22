<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include_once __DIR__ . '/../../backend/db.php'; // Include database connection

// Define variables to store error messages
$errors = [];
$successMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $requiredFields = ["fullName", "hoursNo", "startDate", "endDate", "division", "supervisorName"];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . " is required.";
        }
    }

    // If no errors, proceed to check for duplicates
    if (empty($errors)) {
        // Prepare data
        $fullName = $conn->real_escape_string($_POST["fullName"]);
        $contactNo = $conn->real_escape_string($_POST["contactNo"]);
        $school = $conn->real_escape_string($_POST["school"]);
        $course = $conn->real_escape_string($_POST["course"]);
        $hoursNo = (int)$_POST["hoursNo"];
        $startDate = $conn->real_escape_string($_POST["startDate"]);
        $endDate = $conn->real_escape_string($_POST["endDate"]);
        $division = $conn->real_escape_string($_POST["division"]);
        $supervisorName = $conn->real_escape_string($_POST["supervisorName"]);

        if (empty($errors)) {
            // Insert into database
            $sql = "INSERT INTO intern (fullName, contactNo, school, course, hoursNo, startDate, endDate, division, supervisorName, createdAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssissss", $fullName, $contactNo, $school, $course, $hoursNo, $startDate, $endDate, $division, $supervisorName);

            if ($stmt->execute()) {
                header("Location: http://localhost/ICWS-Personnel-Profiling/src/components/manage_intern.php");
                exit;
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Intern</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
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
    .form-label {
      font-weight: 500;
    }
    .btn-cancel {
      background-color: #fff;
      border: 1px solid #ced4da;
      color: #000;
    }
    .btn-cancel:hover {
      background-color: #f1f1f1;
    }
    .form-wrapper {
      background-color: #ffffff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-semibold">Add New Intern</h5>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/personnel_record.php">Manage Intern</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Intern</li>
      </ol>
    </nav>
  </div>

  <div class="form-wrapper">
    <!-- Display success message -->
    <?php if (!empty($successMessage)): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($successMessage); ?>
      </div>
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

    <form method="POST" action="">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="fullName" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Contact Number</label>
        <input type="text" class="form-control" name="contactNo"  
              maxlength="11" pattern="\d{11}" 
              title="Contact number must be exactly 11 digits" 
              onkeypress="return isNumberKey(event)">
      </div>
      <div class="col-md-12">
        <label class="form-label">School</label>
        <input type="text" class="form-control" name="school" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Course/Program</label>
        <input type="text" class="form-control" name="course" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Number of Hours</label>
        <input type="number" class="form-control" name="hoursNo" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Internship Start Date</label>
        <input type="date" class="form-control" name="startDate" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Internship End Date</label>
        <input type="date" class="form-control" name="endDate" required>
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
        <label class="form-label">Supervisor Name</label>
        <input type="text" class="form-control" name="supervisorName" required>
      </div>
  
      <div class="col-md-12 d-flex mt-5 gap-4">
        <button type="submit" onclick="http://localhost/ICWS-Personnel-Profiling/src/components/manage_intern.php" class="btn btn-primary px-4">Submit</button>
        <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
      </div>  
    </form>

  </div>
</div>
</body>
</html>