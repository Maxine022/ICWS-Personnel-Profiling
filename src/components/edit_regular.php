<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

// Check database connection
if ($conn->connect_error) {
    die("<div class='alert alert-danger'>Database connection failed: {$conn->connect_error}</div>");
}

// Get the Emp_No from the query string
$emp_no = $_GET['Emp_No'] ?? null;

if (!$emp_no) {
    die("<div class='alert alert-danger'>Emp_No is missing in the query string. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
}

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

// Retrieve employee details from the database
$query = $conn->prepare("
    SELECT 
        p.personnel_id, p.Emp_No, p.full_name, p.sex, p.birthdate, p.position, p.section, p.unit, p.team, p.operator, p.division, p.emp_status, p.contact_number, p.address, p.emp_status,
        r.plantillaNo, r.acaPera, r.salary_id,
        s.salaryGrade, s.step, s.monthlySalary, s.level
        FROM personnel p
    LEFT JOIN reg_emp r ON p.personnel_id = r.personnel_id
    LEFT JOIN salary s ON r.salary_id = s.salary_id
    WHERE p.Emp_No = ?
");

if (!$query) {
    die("<div class='alert alert-danger'>Failed to prepare the query: {$conn->error}</div>");
}

$query->bind_param("s", $emp_no);

if (!$query->execute()) {
    die("<div class='alert alert-danger'>Query execution failed: {$query->error}</div>");
}

$result = $query->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    die("<div class='alert alert-danger'>Employee not found in the database. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
}

$original_emp_no = $employee['Emp_No'];

// Handle form submission
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with default values to avoid warnings
    $emp_no = $_POST["Emp_No"] ?? null;
    $fullName = $_POST["full_name"] ?? null;
    $emp_status = $_POST["emp_status"] ?? null;
    $position = $_POST["position"] ?? null;
    $unit = $_POST["unit"] ?? null;
    $section = $_POST["section"] ?? null;
    $team = $_POST["team"] ?? null;
    $operator = $_POST["operator"] ?? null;
    $division = $_POST["division"] ?? null;
    $sex = $_POST["sex"] ?? null;
    $birthdate = !empty($_POST["birthdate"]) ? $_POST["birthdate"] : null; // <-- allow null
    $address = $_POST["address"] ?? null;
    $emp_status = $_POST["emp_status"] ?? null;
    $plantillaNo = $_POST["plantillaNo"] ?? null;
    $contactNumber = $_POST["contact_number"] ?? null;
    $salaryGrade = $_POST["salaryGrade"] ?? null;
    $step = $_POST["step"] ?? null;
    $level = $_POST["level"] ?? null;
    $acaPera = $_POST["aca_pera"] ?? null;
    $monthlySalary = $_POST["monthlySalary"] ?? 0;

    // Validate required fields
    if (!$fullName || !$position || !$division || !$sex || !$birthdate || !$emp_status) {
        die("<div class='alert alert-danger'>Full Name, Position, Division, Sex, Birthdate, and Status are required fields. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
    }

    // Prepare statements for updating the database
    $updatePersonnel = $conn->prepare("
        UPDATE personnel 
        SET Emp_No = ?, full_name = ?, position = ?, section = ?, unit = ?, team = ?, operator = ?, division = ?, contact_number = ?, sex = ?, birthdate = ?, emp_status = ?, address = ?
        WHERE Emp_No = ?
    ");

    if (!$updatePersonnel) {
        die("<div class='alert alert-danger'>Failed to prepare personnel update query: {$conn->error}</div>");
    }

    $updatePersonnel->bind_param(
        "ssssssssssssss",
        $emp_no,        // new Emp_No from form
        $fullName,
        $position,
        $section,
        $unit,
        $team,
        $operator,
        $division,
        $contactNumber,
        $sex,
        $birthdate,
        $emp_status,
        $address,
        $original_emp_no // old Emp_No for WHERE
    );

    if (!$updatePersonnel->execute()) {
        echo "<div class='alert alert-danger'>Failed to update personnel details: {$updatePersonnel->error}</div>";
    } else {
        echo "<div class='alert alert-success'>Personnel details updated successfully!</div>";
    }

    $updateRegEmp = $conn->prepare("
        UPDATE reg_emp 
        SET plantillaNo = ?, acaPera = ?
        WHERE personnel_id = ?
    ");

    if (!$updateRegEmp) {
        die("<div class='alert alert-danger'>Failed to prepare reg_emp update query: {$conn->error}</div>");
    }

    $updateRegEmp->bind_param(
        "isi",
        $plantillaNo,
        $acaPera,
        $employee['personnel_id']
    );

    // Update the salary table
    $updateSalary = $conn->prepare("
        UPDATE salary 
        SET salaryGrade = ?, step = ?, level = ?, monthlySalary = ?
        WHERE salary_id = ?
    ");

    if (!$updateSalary) {
        die("<div class='alert alert-danger'>Failed to prepare salary update query: {$conn->error}</div>");
    }

    $updateSalary->bind_param(
        "iiiid",
        $salaryGrade,
        $step,
        $level,
        $monthlySalary,
        $employee['salary_id']
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
        echo "<div class='alert alert-success' role='alert'>
                Employee details have been successfully updated!
              </div>";
        echo "<script>window.location.href='http://localhost/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
    }
}

// Fetch division data for dynamic dropdowns
include_once __DIR__ . '/ideas/division.php';
if (class_exists('Division')) {
  foreach (Division::cases() as $division) {
    $jsDivisionData[] = $division->value;
  }
} else {
  die("<div class='alert alert-danger'>Error: Division class not found in division.php.</div>");
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
    <style>
        /* Add custom styles for input fields */
        input.form-control, select.form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            background-color: #f9f9f9;
        }
        input.form-control:focus, select.form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            background-color: #ffffff;
        }
        label.form-label {
            font-weight: bold;
            color: #000;
        }
        .form-action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: flex-start;
        }
        .form-section {
            margin-top: 20px;
        }
        .row.g-3 > .col-md-6, .row.g-3 > .col-md-3 {
            margin-bottom: 15px;
        }
        .breadcrumb-link { color: inherit; text-decoration: none; transition: color 0.2s ease; }
        .breadcrumb-link:hover { color: #007bff; text-decoration: underline; }
        .view-link { color: #0d6efd; text-decoration: none; transition: color 0.2s ease, text-decoration 0.2s ease; }
        .view-link:hover { color: #0a58ca; text-decoration: underline; }
        .search-buttons-container { margin-top: 25px; }
        .shadow-custom { box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }
    </style>
</head>

<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>


<div class="content" id="content">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h4 class="mb-0" style="font-weight: bold;">Edit Employee</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=<?php echo htmlspecialchars($emp_no); ?>">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
            </ol>
        </nav>
    </div>
    <form method="POST">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="Emp_No" class="form-label">Employee Number</label>
                <input type="text" class="form-control" id="Emp_No" name="Emp_No" value="<?php echo htmlspecialchars($employee['Emp_No']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="emp_status" class="form-label">Employment Status</label>
                <div class="dropdown"></div>
                <select class="form-control" id="emp_status" name="emp_status" required>
                    <option value="Active" <?php echo ($employee['emp_status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo ($employee['emp_status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($employee['contact_number']); ?>" maxlength="10">
            </div>
            <div class="col-md-3">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-control" id="sex" name="sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male" <?php echo ($employee['sex'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($employee['sex'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($employee['birthdate']); ?>">
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($employee['address']); ?>">
            </div>
            <div class="col-md-6">
            <label for="position" class="form-label">Position</label>
              <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>">
            </div>
            <div class="col-md-6">
            <label for="division" class="form-label">Division</label>
              <select class="form-control" id="division" name="division" required>
              <option value="">Select Division</option>
              <?php
              foreach ($jsDivisionData as $division) {
                $selected = ($employee['division'] === $division) ? 'selected' : '';
                echo "<option value=\"{$division}\" $selected>{$division}</option>";
              }
              ?>
              </select>
            </div>
            <div class="col-md-6">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" value="<?php echo htmlspecialchars($employee['section']); ?>">
            </div>
            <div class="col-md-6">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" class="form-control" id="unit" name="unit" value="<?php echo htmlspecialchars($employee['unit']); ?>">
            </div>
            <div class="col-md-6">
                <label for="team" class="form-label">Team, if applicable</label>
                <input type="text" class="form-control" id="team" name="team" value="<?php echo htmlspecialchars($employee['team']); ?>">
            </div>
            <div class="col-md-6">
                <label for="operations" class="form-label">Operators, if applicable</label>
                <input type="text" class="form-control" id="operations" name="operations" value="<?php echo htmlspecialchars($employee['operator']); ?>">
            </div>
            <div class="col-md-6">
                <label for="plantillaNo" class="form-label">Plantilla Number</label>
                <input type="text" class="form-control" id="plantillaNo" name="plantillaNo" value="<?php echo htmlspecialchars($employee['plantillaNo']); ?>0" required>
            </div>
            <div class="col-md-2">
                <label for="salaryGrade" class="form-label">Salary Grade</label>
                <input type="text" class="form-control" id="salaryGrade" name="salaryGrade" value="<?php echo htmlspecialchars($employee['salaryGrade']); ?>">
            </div>
            <div class="col-md-2">
                <label for="step" class="form-label">Step</label>
                <input type="text" class="form-control" id="step" name="step" value="<?php echo htmlspecialchars($employee['step']); ?>">
            </div>
            <div class="col-md-2">
                <label for="monthlySalary" class="form-label">Monthly Salary</label>
                <input type="text" class="form-control" id="monthlySalary" name="monthlySalary" value="<?php echo htmlspecialchars($employee['monthlySalary']); ?>">
            </div>
            <div class="col-md-6">
                <label for="level" class="form-label">Level</label>
                <select class="form-control" id="level" name="level" >
                    <option value="">Select Level</option>
                    <?php
                    foreach ($jsLevelData as $levelValue) {
                        $selected = ($employee['level'] == $levelValue) ? 'selected' : '';
                        echo "<option value=\"$levelValue\" $selected>$levelValue</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="aca_pera" class="form-label">ACA Pera</label>
                <input type="text" class="form-control" id="aca_pera" name="aca_pera" value="<?php echo htmlspecialchars($employee['acaPera']); ?>">
            </div>
        </div>
        <div class="form-action-buttons">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
<script>
    const jsLevelData = <?php echo json_encode($jsLevelData); ?>;
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const levelSelect = document.getElementById('level');
    const currentLevel = <?php echo json_encode((int)$employee['level']); ?>;

    // Populate the level dropdown
    Object.keys(jsLevelData).forEach(levelValue => {
        const option = document.createElement('option');
        option.value = levelValue;
        option.textContent = jsLevelData[levelValue];
        if (parseInt(levelValue) === currentLevel) {
            option.selected = true;
        }
        levelSelect.appendChild(option);
    });
});
</script>
</body>
</html>