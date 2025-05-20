<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

// Initialize variables
$errors = [];
$success = false;
$intern = null;

// Fetch the intern's data based on the ID passed in the query string
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["intern_id"])) {
    $intern_id = intval($_GET["intern_id"]);

    if ($intern_id > 0) {
        $sql = "SELECT * FROM intern WHERE intern_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $intern_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $intern = $result->fetch_assoc();
            } else {
                $errors[] = "Intern not found.";
            }
        } else {
            $errors[] = "Error fetching intern data: " . $conn->error;
        }
        $stmt->close();
    } else {
        $errors[] = "Invalid intern ID.";
    }
}

// Handle form submission for updating the intern's data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["intern_id"])) {
    $intern_id = intval($_POST["intern_id"]);
    $fullName = $conn->real_escape_string($_POST["full_name"]);
    $contactNumber = $conn->real_escape_string($_POST["contact_number"]);
    $school = $conn->real_escape_string($_POST["school"]);
    $courseProgram = $conn->real_escape_string($_POST["course_program"]);
    $numberOfHours = intval($_POST["number_of_hours"]);
    $internshipStart = $conn->real_escape_string($_POST["internship_start"]);
    $internshipEnd = $conn->real_escape_string($_POST["internship_end"]);
    $division = $conn->real_escape_string($_POST["division"]);
    $supervisor = $conn->real_escape_string($_POST["supervisor"]);

    // Validate required fields
    if (empty($fullName) || empty($numberOfHours) || empty($internshipStart) || empty($internshipEnd) || empty($division) || empty($supervisor)) {
        $errors[] = "All fields are required.";
    }

    if (empty($errors)) {
        $sql = "UPDATE intern SET fullName = ?, contactNo = ?, school = ?, course = ?, hoursNo = ?, startDate = ?, endDate = ?, division = ?, supervisorName = ? WHERE intern_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssissssi", $fullName, $contactNumber, $school, $courseProgram, $numberOfHours, $internshipStart, $internshipEnd, $division, $supervisor, $intern_id);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Error updating intern data: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Intern</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
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
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-semibold">Edit Intern Information</h5>
  </div>

  <!-- Display success message -->
  <?php if ($success): ?>
    <div class="alert alert-success">
      Intern information has been successfully updated! 
      <a href="http://192.168.1.26/ICWS-Personnel-Profiling/src/components/manage_intern.php" class="alert-link">Go to Manage Interns</a>.
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

  <?php if ($intern): ?>
    <div class="form-wrapper">
      <form method="POST" action="">
        <input type="hidden" name="intern_id" value="<?= htmlspecialchars($intern['intern_id']) ?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($intern['fullName']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" name="contact_number" value="<?= htmlspecialchars($intern['contactNo']) ?>" 
              maxlength="10" pattern="\d{10}" title="Contact number must be exactly 10 digits" onkeypress="return isNumberKey(event)">
          </div>
          <div class="col-md-12">
            <label class="form-label">School</label>
            <select class="form-select" name="school">
                <option value="">Select School</option>
                <?php
                    $collegeFilePath = __DIR__ . '/ideas/course.php';
                    if (!file_exists($collegeFilePath)) {
                        die("Error: course.php file not found.");
                    }
                    include_once $collegeFilePath;
                    if (class_exists('College')) {
                        foreach (College::cases() as $college) {
                            $selected = ($intern['school'] === $college->value) ? 'selected' : '';
                            echo "<option value=\"{$college->value}\" $selected>{$college->value}</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error: College class not found.</option>";
                    }
                ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Course/Program</label>
            <select class="form-select" name="course_program">
                <option value="">Select Course</option>
                <?php
                    if (class_exists('CollegeCourse')) {
                        foreach (CollegeCourse::cases() as $course) {
                            $selected = ($intern['course'] === $course->value) ? 'selected' : '';
                            echo "<option value=\"{$course->value}\" $selected>{$course->value}</option>";
                        }
                    } else {
                        echo "<option value=\"\">Error: CollegeCourse class not found.</option>";
                    }
                ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Number of Hours</label>
            <input type="number" class="form-control" name="number_of_hours" value="<?= htmlspecialchars($intern['hoursNo']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Internship Start Date</label>
            <input type="date" class="form-control" name="internship_start" value="<?= htmlspecialchars($intern['startDate']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Internship End Date</label>
            <input type="date" class="form-control" name="internship_end" value="<?= htmlspecialchars($intern['endDate']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Assigned Division</label>
            <input type="text" class="form-control" name="division" value="<?= htmlspecialchars($intern['division']) ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Supervisor Name</label>
            <input type="text" class="form-control" name="supervisor" value="<?= htmlspecialchars($intern['supervisorName']) ?>" required>
          </div>
          <div class="col-md-12 d-flex mt-5 gap-4">
            <button type="submit" class="btn btn-success px-4">Save Changes</button>
            <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  <?php endif; ?>
</div>
<script>
function isNumberKey(evt) {
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  return !(charCode < 48 || charCode > 57); // only digits
}
</script>
</body>
</html>