<?php
session_start();
include_once __DIR__ . '/../../backend/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Emp_No = $_POST["Emp_No"] ?? '';
    $full_name = $_POST["full_name"] ?? '';
    $position = $_POST["position"] ?? '';
    $division = $_POST["division"] ?? '';
    $contact_number = $_POST["contact_number"] ?? '';
    $sex = $_POST["sex"] ?? '';
    $birthdate = $_POST["birthdate"] ?? '';
    $address = $_POST["address"] ?? '';
    $plantillaNo = $_POST["plantillaNo"] ?? '';
    $acaPera = $_POST["acaPera"] ?? '';
    $salaryGrade = $_POST["salaryGrade"] ?? '';
    $step = $_POST["step"] ?? '';
    $level = $_POST["level"] ?? '';
    $monthlySalary = $_POST["monthly_salary"] ?? '';

    // Check if Emp_No already exists to prevent duplication
    $check = $conn->prepare("SELECT Emp_No FROM personnel WHERE Emp_No = ?");
    $check->bind_param("s", $Emp_No);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        echo "<script>alert('Employee number already exists.');</script>";
        exit();
    }
    $check->close();

    // Insert into personnel
    $stmt1 = $conn->prepare("INSERT INTO personnel (Emp_No, full_name, position, division, contact_number, sex, birthdate, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssssss", $Emp_No, $full_name, $position, $division, $contact_number, $sex, $birthdate, $address);

    if ($stmt1->execute()) {
        $personnel_id = $stmt1->insert_id;

        // Insert into salary
        $stmt2 = $conn->prepare("INSERT INTO salary (personnel_id, salaryGrade, step, level, monthlySalary) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("iiiss", $personnel_id, $salaryGrade, $step, $level, $monthlySalary);

        if ($stmt2->execute()) {
            $salary_id = $stmt2->insert_id;

            // Insert into reg_emp
            $stmt3 = $conn->prepare("INSERT INTO reg_emp (personnel_id, salary_id, plantillaNo, acaPera) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("iiss", $personnel_id, $salary_id, $plantillaNo, $acaPera);

            if ($stmt3->execute()) {
                header("Location: manage_regEmp.php");
                exit();
            } else {
              echo "<script>alert('Error inserting into reg_emp: " . $stmt3->error . "');</script>";
            }
            $stmt3->close();
        } else {
            echo "<script>alert('Error inserting into salary.');</script>";
        }
        $stmt2->close();
    } else {
        echo "<script>alert('Error inserting into personnel.');</script>";
    }
    $stmt1->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Regular Employee</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .breadcrumb-custom {
      font-size: 14px;
    }
    .breadcrumb-link {
      color: #6c757d;
      text-decoration: none;
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

<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-semibold mb-0">Add New Regular Employee</h5>
    <div class="breadcrumb-custom text-end">
      <a href="/src/index.php" class="breadcrumb-link">Home</a> /
      <a href="#" class="breadcrumb-link">Manage</a> /
      <span class="text-dark">Add New Regular Employee</span>
    </div>
  </div>

  <div class="form-section">
    <form method="POST" action="">
      <div class="row g-3">
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
          <label class="form-label">Position</label>
          <select class="form-select" name="position" required>
            <option value="">Select Position</option>
            <option value="HR Officer">HR Officer</option>
            <option value="Admin Assistant">Admin Assistant</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Division</label>
          <select class="form-select" name="division" required>
            <option value="">Select Division</option>
            <option value="IT Division">IT Division</option>
            <option value="HR Division">HR Division</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Plantilla Number</label>
          <input type="text" class="form-control" name="plantillaNo">
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number">
        </div>
        <div class="col-md-2">
            <label class="form-label">Sex</label>
            <select class="form-select" name="sex" required>
              <option value="">Select</option>
              <option value="M">Male</option>
              <option value="F">Female</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
          </div>

        <div class="col-md-2">
          <label class="form-label">Salary Grade</label>
          <input type="text" class="form-control" name="salaryGrade">
        </div>
        <div class="col-md-2">
          <label class="form-label">Step</label>
          <input type="text" class="form-control" name="step">
        </div>
        <div class="col-md-2">
          <label class="form-label">Level</label>
          <input type="text" class="form-control" name="level">
        </div>
        <div class="col-md-6">
          <label class="form-label">ACA Pera</label>
          <input type="text" class="form-control" name="acaPera">
        </div>
        <div class="col-md-6">
          <label class="form-label">Monthly Salary</label>
          <input type="text" class="form-control" name="monthly_salary">
        </div>

        <div class="mt-4 d-flex gap-2">
        <button type="submit" onclick="/src/components/manage_regEmp.php" class="btn btn-primary px-4">Submit</button>
        <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
      </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
