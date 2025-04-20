<?php
include_once __DIR__ . '/../../backend/db.php';

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: {$conn->connect_error}");
}

// Get the Emp_No from the query string
$emp_no = $_GET['Emp_No'] ?? null;

if (!$emp_no) {
    die("<div class='alert alert-danger'>Emp_No is missing in the query string. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
}

// Retrieve employee details from the database
$query = $conn->prepare("
    SELECT 
        p.personnel_id, p.Emp_No, p.full_name, p.position, p.division, p.contact_number, 
        r.plantillaNo, r.acaPera, 
        s.salaryGrade, s.step, s.level, s.monthlySalary
    FROM personnel p
    LEFT JOIN reg_emp r ON p.personnel_id = r.personnel_id
    LEFT JOIN salary s ON r.salary_id = s.salary_id
    WHERE p.Emp_No = ?
");
$query->bind_param("s", $emp_no);

if (!$query->execute()) {
    die("Query execution failed: {$query->error}");
}

$result = $query->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("<div class='alert alert-danger'>Employee not found in the database. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with default values to avoid warnings
    $fullName = $_POST["full_name"] ?? null;
    $position = $_POST["position"] ?? null;
    $division = $_POST["division"] ?? null;
    $plantillaNo = $_POST["plantilla_no"] ?? null;
    $contactNumber = $_POST["contact_number"] ?? null;
    $salaryGrade = $_POST["salary_grade"] ?? null;
    $step = $_POST["step"] ?? null;
    $level = $_POST["level"] ?? null;
    $acaPera = $_POST["aca_pera"] ?? null;
    $monthlySalary = $_POST["monthly_salary"] ?? null;

    // Validate required fields
    if (!$fullName || !$position || !$division) {
        die("<div class='alert alert-danger'>Full Name, Position, and Division are required fields. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
    }

    // Update the employee details in the database
    $updatePersonnel = $conn->prepare("
        UPDATE personnel 
        SET full_name = ?, position = ?, division = ?, contact_number = ?
        WHERE Emp_No = ?
    ");
    $updatePersonnel->bind_param(
        "sssss",
        $fullName,
        $position,
        $division,
        $contactNumber,
        $emp_no
    );

    $updateRegEmp = $conn->prepare("
        UPDATE reg_emp 
        SET plantillaNo = ?, acaPera = ?
        WHERE personnel_id = ?
    ");
    $updateRegEmp->bind_param(
        "iii",
        $plantillaNo,
        $acaPera,
        $employee['personnel_id']
    );

    $updateSalary = $conn->prepare("
        UPDATE salary 
        SET salaryGrade = ?, step = ?, level = ?, monthlySalary = ?
        WHERE personnel_id = ?
    ");
    $updateSalary->bind_param(
        "iiiii",
        $salaryGrade,
        $step,
        $level,
        $monthlySalary,
        $employee['personnel_id']
    );

    // Execute updates
    $success = true;
    if (!$updatePersonnel->execute()) {
        $success = false;
        echo "<div class='alert alert-danger'>Failed to update personnel details: {$updatePersonnel->error}</div>";
    }
    if (!$updateRegEmp->execute()) {
        $success = false;
        echo "<div class='alert alert-danger'>Failed to update reg_emp details: {$updateRegEmp->error}</div>";
    }
    if (!$updateSalary->execute()) {
        $success = false;
        echo "<div class='alert alert-danger'>Failed to update salary details: {$updateSalary->error}</div>";
    }

    if ($success) {
      echo "<div class='alert alert-success text-end' style='position: fixed; top: 10px; right: 10px; z-index: 1050; cursor: pointer;' onclick='this.style.display=\"none\";'>
            <i class='fa fa-check-circle me-2'></i>Employee details have been successfully updated!
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Add custom styles for input fields */
        input.form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            background-color: #f9f9f9;
        }
        input.form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            background-color: #ffffff;
        }
        label.form-label {
            font-weight: bold;
            color: #black;
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
    </style>
  </head>
<body>
<?php include_once __DIR__ . '/../hero/navbar.php'; ?>
<?php include_once __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h4 class="mb-0" style="font-weight: bold;">Edit Employee</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/index.php">Home</a></li>
                <li class="breadcrumb mb-0"><a class="breadcrumb-link" href="/src/components/profile.php?Emp_No=<?php echo htmlspecialchars($emp_no); ?>"> / Profile </a></li>
                <li class="breadcrumb-item active" aria-current="page"> / Edit Employee</li>
            </ol>     
        </nav>
    </div>
    <div class="row mt-3">
        <form method="POST" action="">
          <div class="mb-1">
            <label for="Emp_No" class="form-label">Employee Number</label>
            <input type="text" class="form-control" id="Emp_No" name="Emp_No" value="<?php echo htmlspecialchars($employee['Emp_No']); ?>" readonly>
          </div>
          <div class="mb-1">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
          </div>
          <div class="mb-1">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
          </div>
          <div class="mb-1">
            <label for="division" class="form-label">Division</label>
            <input type="text" class="form-control" id="division" name="division" value="<?php echo htmlspecialchars($employee['division']); ?>" required>
          </div>
          <div class="mb-1">
            <label for="plantilla_no" class="form-label">Plantilla Number</label>
            <input type="text" class="form-control" id="plantilla_no" name="plantilla_no" value="<?php echo htmlspecialchars($employee['plantillaNo']); ?>">
          </div>
          <div class="mb-1">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($employee['contact_number']); ?>">
          </div>
          <div class="mb-1">
            <label for="salary_grade" class="form-label">Salary Grade</label>
            <input type="text" class="form-control" id="salary_grade" name="salary_grade" value="<?php echo htmlspecialchars($employee['salaryGrade']); ?>">
          </div>
          <div class="mb-1">
            <label for="step" class="form-label">Step</label>
            <input type="text" class="form-control" id="step" name="step" value="<?php echo htmlspecialchars($employee['step']); ?>">
          </div>
          <div class="mb-1">
            <label for="level" class="form-label">Level</label>
            <input type="text" class="form-control" id="level" name="level" value="<?php echo htmlspecialchars($employee['level']); ?>">
          </div>
          <div class="mb-1">
            <label for="aca_pera" class="form-label">ACA Pera</label>
            <input type="text" class="form-control" id="aca_pera" name="aca_pera" value="<?php echo htmlspecialchars($employee['acaPera']); ?>">
          </div>
          <div class="mb-1">
            <label for="monthly_salary" class="form-label">Monthly Salary</label>
            <input type="text" class="form-control" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($employee['monthlySalary']); ?>">
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && $success) {
            ob_start(); // Start output buffering
            header("Location: /ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no));
            exit();
          }
          ?>
          <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
        </form>
      </div>
    </div>
</div>
</body>
</html>