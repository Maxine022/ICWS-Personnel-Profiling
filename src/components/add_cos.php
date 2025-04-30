<?php
include_once __DIR__ . '/../../backend/db.php';

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $Emp_No = trim($_POST["Emp_No"] ?? "");
    $full_name = trim($_POST["full_name"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $sex = trim($_POST["sex"] ?? "");
    $birthdate = trim($_POST["birthdate"] ?? "");
    $position = trim($_POST["designation"] ?? "");
    $contact_number = trim($_POST["contact_number"] ?? "");
    $salaryRate = trim($_POST["salary_rate"] ?? "");

    // Validate required fields
    if (empty($Emp_No)) $errors[] = "Employee Number is required.";
    if (empty($full_name)) $errors[] = "Full Name is required.";
    if (empty($contact_number) || !preg_match('/^\d{11}$/', $contact_number)) $errors[] = "Contact Number is required and must be 11 digits.";
    if (empty($birthdate)) $errors[] = "Birthdate is required.";
    if (empty($sex)) $errors[] = "Sex is required.";
    if (empty($position)) $errors[] = "Position is required.";
    if (empty($salaryRate) || !is_numeric($salaryRate)) $errors[] = "Salary Rate is required and must be numeric.";
    if (empty($address)) $errors[] = "Address is required.";

    // Check for duplicate Emp_No
    if (empty($errors)) {
        $check = $conn->prepare("SELECT personnel_id FROM personnel WHERE Emp_No = ?");
        $check->bind_param("s", $Emp_No);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $errors[] = "Employee Number already exists.";
        }
        $check->close();
    }

    if (empty($errors)) {
        $division = ""; // Not in form, set as empty or add to form if needed

        // Insert into personnel
        $stmt_personnel = $conn->prepare("INSERT INTO personnel (Emp_No, full_name, contact_number, birthdate, sex, position, division, address, emp_type, emp_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Contract', 'Active')");
        $stmt_personnel->bind_param("ssssssss", $Emp_No, $full_name, $contact_number, $birthdate, $sex, $position, $division, $address);

        if ($stmt_personnel->execute()) {
            $personnel_id = $conn->insert_id;

            // Insert into contract_service
            $stmt_contract = $conn->prepare("INSERT INTO contract_service (personnel_id, salaryRate) VALUES (?, ?)");
            $stmt_contract->bind_param("ii", $personnel_id, $salaryRate);

            if ($stmt_contract->execute()) {
                // Use header redirect for a smooth process and to avoid output before header
                header("Location: /src/components/manage_cos.php");
                exit();
            } else {
                $errors[] = "Error adding contract_service: " . $conn->error;
            }
            $stmt_contract->close();
        } else {
            $errors[] = "Error adding personnel: " . $conn->error;
        }
        $stmt_personnel->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Contract of Service Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<!-- Main Content -->
<div class="content" id="content">
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h5 class="mb-0 fw-bold">Add New Contract of Service Employee</h5>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/index.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/components/manage_cos.php">Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Order</li>
      </ol>
    </nav>
  </div>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">Contract of Service employee added successfully!</div>
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
          <label class="form-label">Address</label>
          <input type="text" class="form-control" name="address">
        </div>
        <div class="col-md-6">
          <label class="form-label">Sex</label>
          <select class="form-select" name="sex">
            <option value="">Please Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Birthdate</label>
          <input type="date" class="form-control" name="birthdate">
        </div>
        <div class="col-md-6">
          <label class="form-label">Position</label>
          <select class="form-select" name="designation">
            <option value="">Please Select</option>
            <option value="Field Staff">Field Staff</option>
            <option value="Office Staff">Office Staff</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number">
        </div>
        <div class="col-md-6">
          <label class="form-label">Salary Rate</label>
          <input type="text" class="form-control" name="salary_rate">
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