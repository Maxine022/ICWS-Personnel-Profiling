<?php
session_start();

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $fullName = $_POST["full_name"] ?? '';
    $position = $_POST["position"] ?? '';
    $division = $_POST["division"] ?? '';
    $plantillaNumber = $_POST["plantilla_number"] ?? '';
    $contactNumber = $_POST["contact_number"] ?? '';
    $salaryGrade = $_POST["salary_grade"] ?? '';
    $step = $_POST["step"] ?? '';
    $level = $_POST["level"] ?? '';
    $acaPera = $_POST["aca_pera"] ?? '';
    $monthlySalary = $_POST["monthly_salary"] ?? '';

    // For now, just simulate saving by printing values (or logging if needed)
    echo "<h2>Employee Submitted Successfully</h2>";
    echo "<ul>";
    echo "<li><strong>Full Name:</strong> $fullName</li>";
    echo "<li><strong>Position:</strong> $position</li>";
    echo "<li><strong>Division:</strong> $division</li>";
    echo "<li><strong>Plantilla No:</strong> $plantillaNumber</li>";
    echo "<li><strong>Contact Number:</strong> $contactNumber</li>";
    echo "<li><strong>Salary Grade:</strong> $salaryGrade</li>";
    echo "<li><strong>Step:</strong> $step</li>";
    echo "<li><strong>Level:</strong> $level</li>";
    echo "<li><strong>ACA Pera:</strong> $acaPera</li>";
    echo "<li><strong>Monthly Salary:</strong> $monthlySalary</li>";
    echo "</ul>";

    echo "<br><a href='add_regular_employee.php'>← Back to Form</a>";
} else {
    echo "<p>No form data submitted.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Regular Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .main {
      margin-left: 220px;
      padding: 2rem;
      background-color: #f8f9fa;
      min-height: 100vh;
    }
    .breadcrumb-custom {
      font-size: 14px;
      color: #6c757d;
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
    .breadcrumb-link:hover {
    color: #0d6efd; 
    }
    .breadcrumb-link {
    transition: color 0.3s ease;
    color: #6c757d;
    }
  </style>
</head>
<body>

<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

  <!-- Main Content -->
  <div class="main">
    <!-- Top Navigation Row with Breadcrumb aligned to the right -->
    <div class="d-flex justify-content-between align-items-center mb-3">
    <div class="fw-bold fs-5">Add New Regular Employee</div>
    <div class="breadcrumb-custom text-end">
      <a href="/src/index.php" class="text-decoration-none breadcrumb-link">Home</a>
      <span class="mx-1">/</span>
      <a href="#" class="text-decoration-none breadcrumb-link">Manage</a>
      <span class="mx-1">/</span>
      <span class="text-dark">Add New Regular Employee</span>
    </div>
  </div>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">Employee information submitted successfully!</div>
  <?php endif; ?>

  <div class="form-section">
    <form method="POST" action="">
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
