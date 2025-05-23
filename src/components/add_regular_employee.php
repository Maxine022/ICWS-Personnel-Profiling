<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

// Fetch the ENUM values for the "sex" column
$enum_values = [];
$enum_query = $conn->query("SHOW COLUMNS FROM personnel LIKE 'sex'");
$enum_result = $enum_query->fetch_assoc();
if ($enum_result) {
    preg_match('/^enum\((.*)\)$/', $enum_result['Type'], $matches);
    if (isset($matches[1])) {
        $enum_values = explode(",", $matches[1]);
        // Remove the single quotes around each value
        $enum_values = array_map(fn($value) => trim($value, "'"), $enum_values);
    }
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Emp_No = $_POST["Emp_No"] ?? '';
    $full_name = $_POST["full_name"] ?? '';
    $position = $_POST["position"] ?? '';
    $division = $_POST["division"] ?? '';
    $unit = $_POST["unit"] ?? '';
    $section  = $_POST["section"] ?? '';
    $team  = $_POST["team"] ?? '';
    $operator  = $_POST["operator"] ?? '';
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

    // Duplicate Emp_No check
    $dupCheck = $conn->prepare("SELECT COUNT(*) FROM personnel WHERE Emp_No = ?");
    $dupCheck->bind_param("s", $Emp_No);
    $dupCheck->execute();
    $dupCheck->bind_result($dupCount);
    $dupCheck->fetch();
    $dupCheck->close();

    if ($dupCount > 0) {
        $error = "The Employee Number <strong>" . htmlspecialchars($Emp_No) . "</strong> already exists. Please use a unique Employee Number.";
    } else {
        // Insert into personnel
        $stmt1 = $conn->prepare("INSERT INTO personnel (Emp_No, full_name, position, division, unit, section, team, operator, contact_number, sex, birthdate, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt1->bind_param(
            "ssssssssssss",
            $Emp_No,
            $full_name,
            $position,
            $division,
            $unit,
            $section,
            $team,
            $operator,
            $contact_number,
            $sex,
            $birthdate,
            $address
        );

        if ($stmt1->execute()) {
            $personnel_id = $stmt1->insert_id;

            // Insert into salary
            $stmt2 = $conn->prepare("INSERT INTO salary (personnel_id, salaryGrade, step, level, monthlySalary) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("iiisd", $personnel_id, $salaryGrade, $step, $level, $monthlySalary);
            
            if ($stmt2->execute()) {
                $salary_id = $stmt2->insert_id;

                // Insert into reg_emp
                $stmt3 = $conn->prepare("INSERT INTO reg_emp (personnel_id, salary_id, plantillaNo, acaPera) VALUES (?, ?, ?, ?)");
                $stmt3->bind_param("iiss", $personnel_id, $salary_id, $plantillaNo, $acaPera);

                if ($stmt3->execute()) {
                    header("Location: manage_regEmp.php");
                    exit();
                } else {
                    echo "<script>alert('Error inserting into reg_emp: {$stmt3->error}');</script>";
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
      <a href="http://192.168.1.100/ICWS-Personnel-Profiling/src/hero/home.php" class="breadcrumb-link">Home</a> /
      <a href="http://192.168.1.100/ICWS-Personnel-Profiling/src/components/manage_regEmp.php" class="breadcrumb-link">Manage</a> /
      <span class="text-dark">Add New Regular Employee</span>
    </div>
  </div>

  <div class="form-section">
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Emp_No</label>
          <input type="text" class="form-control" name="Emp_No" value="<?= htmlspecialchars($_POST['Emp_No'] ?? '') ?>" required>
        </div>
        <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">Sex</label>
            <select class="form-select" name="sex" required>
              <option value="">Select Sex</option>
              <?php
                if ($enum_values) {
                    foreach ($enum_values as $value) {
                        echo "<option value=\"$value\">$value</option>";
                    }
                }
              ?>
            </select>
        </div>
          <div class="col-md-4">
            <label class="form-label">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" value="<?= htmlspecialchars($_POST['birthdate'] ?? '') ?>">
          </div>
          <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number" 
                maxlength="11" pattern="\d{11}" 
                title="Contact number must be exactly 11 digits" 
                onkeypress="return isNumberKey(event)" value="<?= htmlspecialchars($_POST['contact_number'] ?? '') ?>">
        </div>
          <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
          </div>
        <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" value="<?= htmlspecialchars($_POST['position'] ?? '') ?>">
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
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" value="<?= htmlspecialchars($_POST['unit'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label for="section" class="form-label">Section</label>
            <input type="text" class="form-control" id="section" name="section" value="<?= htmlspecialchars($_POST['section'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label for="team" class="form-label">Team, if applicable</label>
            <input type="text" class="form-control" id="team" name="team" value="<?= htmlspecialchars($_POST['team'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label for="operations" class="form-label">Operations, if applicable</label>
            <input type="text" class="form-control" id="operations" name="operations" value="<?= htmlspecialchars($_POST['operations'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Plantilla Number</label>
          <input type="text" class="form-control" name="plantillaNo" value="<?= htmlspecialchars($_POST['plantillaNo'] ?? '') ?>" required>
        </div>
        <div class="col-md-2">
            <label for="salaryGrade" class="form-label">Salary Grade</label>
            <input type="text" class="form-control" id="salaryGrade" name="salaryGrade" value="<?= htmlspecialchars($_POST['salaryGrade'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <label for="step" class="form-label">Step</label>
            <input type="text" class="form-control" id="step" name="step" value="<?= htmlspecialchars($_POST['step'] ?? '') ?>">
        </div>
        <div class="col-md-2">
            <label for="monthlySalary" class="form-label">Monthly Salary</label>
            <input type="text" class="form-control" id="monthlySalary" name="monthlySalary" value="<?= htmlspecialchars($_POST['monthlySalary'] ?? '') ?>">
        </div>
            <div class="col-md-6">
              <label class="form-label">Level</label>
              <select class="form-select" name="level" required>
                <option value="">Select Level</option>
                <?php
                $salaryFilePath = __DIR__ . '/ideas/salary.php';
                if (!file_exists($salaryFilePath)) {
                  die("Error: salary.php file not found.");
                }
                include_once $salaryFilePath;

                if (class_exists('Level')) {
                  foreach (Level::cases() as $level) {
                    $selected = (isset($_POST['level']) && $_POST['level'] == $level->value) ? 'selected' : '';
                    echo "<option value=\"{$level->value}\" $selected>{$level->value}</option>";
                  }
                } else {
                  echo "<option value=\"\">Error: Level class not found.</option>";
                }
                ?>
              </select>
            </div>
        <div class="col-md-6">
          <label class="form-label">ACA Pera</label>
          <input type="text" class="form-control" name="acaPera" value="<?= htmlspecialchars($_POST['acaPera'] ?? '') ?>">
        </div>

        <div class="mt-4 d-flex gap-2">
        <button type="submit" onclick="http://192.168.1.100/ICWS-Personnel-Profiling/src/components/manage_regEmp.php" class="btn btn-primary px-4">Submit</button>
        <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
      </div>
      </div>
    </form>
  </div>
</div>

</body>
</html>
