<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["full_name"];
    $address = $_POST["address"];
    $sex = $_POST["sex"];
    $birthdate = $_POST["birthdate"];
    $designation = $_POST["designation"];
    $contactNumber = $_POST["contact_number"];
    $salaryRate = $_POST["salary_rate"];
    $yearsInService = $_POST["years_in_service"];
    $contractStart = $_POST["contract_start"];
    $contractEnd = $_POST["contract_end"];
    $remarks = $_POST["remarks"];

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Contract of Service Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    
    .main {
      margin-left: 220px;
      padding: 2rem;
      background-color: #f8f9fa;
      min-height: 100vh;
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
<div class="main">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="fw-bold fs-5">Add New Contract of Service Employee</div>
    <div class="breadcrumb-custom text-end">
      <a href="#" class="breadcrumb-link">Home</a>
      <span class="mx-1">/</span>
      <a href="#" class="breadcrumb-link">Manage</a>
      <span class="mx-1">/</span>
      <span class="text-dark">Add New Contract of Service Employee</span>
    </div>
  </div>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">Contract of Service employee added successfully!</div>
  <?php endif; ?>

  <div class="form-section">
    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-12">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" required>
        </div>
        <div class="col-md-12">
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
          <label class="form-label">Designation</label>
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
        <div class="col-md-6">
          <label class="form-label">Years in Service</label>
          <input type="text" class="form-control" name="years_in_service">
        </div>
        <div class="col-md-6">
          <label class="form-label">Contract Duration - Start</label>
          <input type="date" class="form-control" name="contract_start">
        </div>
        <div class="col-md-6">
          <label class="form-label">Contract Duration - End</label>
          <input type="date" class="form-control" name="contract_end">
        </div>
        <div class="col-md-12">
          <label class="form-label">Remarks</label>
          <textarea name="remarks" rows="2" class="form-control"></textarea>
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