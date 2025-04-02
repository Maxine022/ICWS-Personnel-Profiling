<?php
session_start();

// Handle form submission and save to JSON file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newIntern = [
        "full_name" => $_POST["full_name"],
        "contact_number" => $_POST["contact_number"],
        "school" => $_POST["school"],
        "course_program" => $_POST["course_program"],
        "number_of_hours" => $_POST["number_of_hours"],
        "internship_start" => $_POST["internship_start"],
        "internship_end" => $_POST["internship_end"],
        "division" => $_POST["division"],
        "supervisor" => $_POST["supervisor"]
    ];

    $file = 'interns.json';
    $interns = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $interns[] = $newIntern;
    file_put_contents($file, json_encode($interns, JSON_PRETTY_PRINT));

    header("Location: manage_intern.php");
    exit();
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
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
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
  <!-- Top Navigation Row with Breadcrumb aligned to the right -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-semibold">Add New Intern</h5>
    <div class="breadcrumb-custom text-end">
      <a href="#" class="breadcrumb-link">Home</a>
      <span class="mx-1">/</span>
      <a href="#" class="breadcrumb-link">Manage</a>
      <span class="mx-1">/</span>
      <span class="text-dark">Add New Intern</span>
    </div>
  </div>

  <div class="form-wrapper">
    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number">
        </div>
        <div class="col-md-12">
          <label class="form-label">School</label>
          <input type="text" class="form-control" name="school">
        </div>
        <div class="col-md-6">
          <label class="form-label">Course/Program</label>
          <input type="text" class="form-control" name="course_program">
        </div>
        <div class="col-md-6">
          <label class="form-label">Number of Hours</label>
          <input type="text" class="form-control" name="number_of_hours">
        </div>
        <div class="col-md-6">
          <label class="form-label">Internship Start Date</label>
          <input type="date" class="form-control" name="internship_start">
        </div>
        <div class="col-md-6">
          <label class="form-label">Internship End Date</label>
          <input type="date" class="form-control" name="internship_end">
        </div>
        <div class="col-md-12">
          <label class="form-label">Assigned Division</label>
          <select class="form-select" name="division">
            <option value="">Please Select</option>
            <option value="IT Division">IT Division</option>
            <option value="Finance Division">Finance Division</option>
            <option value="HR Division">HR Division</option>
          </select>
        </div>
        <div class="col-md-12">
          <label class="form-label">Supervisor Name</label>
          <input type="text" class="form-control" name="supervisor">
        </div>
        <div class="col-md-12 d-flex mt-5 gap-4">
          <button type="submit" class="btn btn-primary px-4">Submit</button>
          <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
