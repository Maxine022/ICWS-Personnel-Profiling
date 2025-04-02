<?php
session_start();

// Handle form submission and save to JSON
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newEmployee = [
        "Emp No" => $_POST["Emp No"] ?? '',
        "full_name" => $_POST["full_name"] ?? '',
        "position" => $_POST["position"] ?? '',
        "division" => $_POST["division"] ?? '',
        "plantilla_number" => $_POST["plantilla_number"] ?? '',
        "contact_number" => $_POST["contact_number"] ?? '',
        "salary_grade" => $_POST["salary_grade"] ?? '',
        "step" => $_POST["step"] ?? '',
        "level" => $_POST["level"] ?? '',
        "aca_pera" => $_POST["aca_pera"] ?? '',
        "monthly_salary" => $_POST["monthly_salary"] ?? ''
    ];

    $file = 'regulars.json';
    $existingData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $existingData[] = $newEmployee;
    file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));

    header("Location: manage_regEmp.php");
    exit();
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
          <label class="form-label">Emp No</label>
          <input type="text" class="form-control" name="Emp No" required>
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
          <input type="text" class="form-control" name="plantilla_number">
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number">
        </div>
        <div class="col-md-2">
          <label class="form-label">Salary Grade</label>
          <input type="text" class="form-control" name="salary_grade">
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
          <input type="text" class="form-control" name="aca_pera">
        </div>
        <div class="col-md-6">
          <label class="form-label">Monthly Salary</label>
          <input type="text" class="form-control" name="monthly_salary">
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
