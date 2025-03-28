<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["full_name"];
    $contactNumber = $_POST["contact_number"];
    $school = $_POST["school"];
    $courseProgram = $_POST["course_program"];
    $numberOfHours = $_POST["number_of_hours"];
    $internshipStart = $_POST["internship_start"];
    $internshipEnd = $_POST["internship_end"];
    $division = $_POST["division"];
    $supervisor = $_POST["supervisor"];

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Intern</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 220px;
      background-color: #2c3e50;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      padding-top: 1rem;
      color: #fff;
    }
    .sidebar .logo {
      text-align: center;
      font-weight: bold;
      font-size: 20px;
      padding: 10px 0;
    }
    .sidebar .profile {
      text-align: center;
      font-size: 14px;
      margin-bottom: 1rem;
      color: #dcdcdc;
    }
    .sidebar .nav-link {
      color: #dcdcdc;
      padding: 10px 20px;
      display: block;
      text-decoration: none;
    }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #0d6efd;
      color: #fff;
      border-radius: 5px;
    }
    .main {
      margin-left: 220px;
      padding: 2rem;
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

<!-- Sidebar -->
<div class="sidebar">
  <div class="logo">ICWS</div>
  <div class="profile">
    <img src="https://via.placeholder.com/60" class="rounded-circle mb-2" alt="Profile"><br>
    John Ryan Dela Cruz
  </div>
  <a href="#" class="nav-link">Dashboard</a>
  <a href="#" class="nav-link">Profile</a>
  <a href="#" class="nav-link">Personnel</a>
  <a href="#" class="nav-link ms-3">Regular</a>
  <a href="#" class="nav-link ms-3">Job Order</a>
  <a href="#" class="nav-link ms-3">Contract of Service</a>
  <a href="#" class="nav-link active ms-3">Intern</a>
  <a href="#" class="nav-link">Logout</a>
</div>

<!-- Main Content -->
<div class="main">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-semibold">Update Intern Information</h5>
    <div class="breadcrumb-custom text-end">
      <a href="#" class="breadcrumb-link">Home</a>
      <span class="mx-1">/</span>
      <a href="#" class="breadcrumb-link">Manage</a>
      <span class="mx-1">/</span>
      <span class="text-dark">Update Intern Information</span>
    </div>
  </div>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">Intern information has been successfully saved!</div>
  <?php endif; ?>

  <div class="form-wrapper">
    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" placeholder="Enter your Full Name" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number" placeholder="Enter Contact Number">
        </div>

        <div class="col-md-12">
          <label class="form-label">School</label>
          <input type="text" class="form-control" name="school" placeholder="Enter School Name">
        </div>

        <div class="col-md-6">
          <label class="form-label">Course/Program</label>
          <input type="text" class="form-control" name="course_program" placeholder="Enter Course or Program">
        </div>
        <div class="col-md-6">
          <label class="form-label">Number of Hours</label>
          <input type="text" class="form-control" name="number_of_hours" placeholder="Enter Number of Hours">
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
          <input type="text" class="form-control" name="supervisor" placeholder="Enter Name">
        </div>

        <div class="col-md-12 d-flex mt-5 gap-4">
          <button type="submit" class="btn btn-success px-4">Save Changes</button>
          <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>