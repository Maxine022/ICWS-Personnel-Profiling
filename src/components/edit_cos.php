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

// Retrieve employee details from the database
$query = $conn->prepare("
    SELECT 
        p.personnel_id, p.Emp_No, p.full_name, p.sex, p.birthdate, p.contact_number, p.address, p.position, section, unit, team, operator, p.division, p.emp_status,
        cs.salaryRate
    FROM personnel p
    LEFT JOIN contract_service cs ON p.personnel_id = cs.personnel_id
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

// Store the original Emp_No before any changes
$original_emp_no = $employee['Emp_No'];

// Handle form submission
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Emp_No = $_POST["Emp_No"] ?? null;
    $fullName = $_POST["full_name"] ?? null;
    $address = $_POST["address"] ?? null;
    $sex = $_POST["sex"] ?? null;
    $birthdate = !empty($_POST["birthdate"]) ? $_POST["birthdate"] : null; // <-- allow null
    $contactNumber = $_POST["contact_number"] ?? null;
    $position = $_POST["position"] ?? null;
    $division = $_POST["division"] ?? null;
    $unit = $_POST["unit"] ?? null;
    $section = $_POST["section"] ?? null;
    $team = $_POST["team"] ?? null;
    $operator = $_POST["operations"] ?? null; // <-- match form field name
    $salaryRate = $_POST["salary_rate"] ?? null;
    $emp_status = $_POST["emp_status"] ?? null;

    // Validate required fields
    if (!$fullName) {
        die("<div class='alert alert-danger'>Full Name is a required field. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
    }

    // Check for duplicate Emp_No (excluding the current record)
    $dupCheck = $conn->prepare("SELECT COUNT(*) FROM personnel WHERE Emp_No = ? AND Emp_No != ?");
    $dupCheck->bind_param("ss", $Emp_No, $original_emp_no);
    $dupCheck->execute();
    $dupCheck->bind_result($dupCount);
    $dupCheck->fetch();
    $dupCheck->close();

    if ($dupCount > 0) {
        echo "<div class='alert alert-danger'>The Employee Number <strong>" . htmlspecialchars($Emp_No) . "</strong> already exists in the database. Please use a unique Employee Number.</div>";
    } else {
        // Update personnel table
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
            $Emp_No,         // New Emp_No from the form
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
            $original_emp_no // Use the original Emp_No for WHERE clause
        );

        // Update contract_service table
        $updateContractService = $conn->prepare("
            UPDATE contract_service 
            SET salaryRate = ?
            WHERE personnel_id = ?
        ");

        if (!$updateContractService) {
            die("<div class='alert alert-danger'>Failed to prepare contract_service update query: {$conn->error}</div>");
        }

        $updateContractService->bind_param(
            "di",
            $salaryRate,
            $employee['personnel_id']
        );

        // Execute updates
        $success = true;
        if (!$updatePersonnel->execute()) {
            $success = false;
            echo "<div class='alert alert-danger'>Failed to update personnel details: {$updatePersonnel->error}</div>";
        }
        if (!$updateContractService->execute()) {
            $success = false;
            echo "<div class='alert alert-danger'>Failed to update contract_service details: {$updateContractService->error}</div>";
        }

        if ($success) {
            echo "<div class='alert alert-success' role='alert'>
                    Employee details have been successfully updated!
                  </div>";
            echo "<script>window.location.href='http://localhost/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($Emp_No) . "';</script>";
            exit();
        }
    }
}

// Fetch division data for dynamic dropdowns
$jsDivisionData = [];
include_once __DIR__ . '/ideas/division.php';
if (class_exists('Division') && method_exists('Division', 'cases')) {
    foreach (Division::cases() as $division) {
        $jsDivisionData[] = $division->value;
    }
} else {
    die("<div class='alert alert-danger'>Error: Division class or cases method not found in division.php.</div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Contract of Service Employee</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
body { font-family: Arial; }
.content { padding: 30px; }
.table-container { margin-top: 30px; }
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

<?php if (isset($dupCount) && $dupCount > 0): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    The Employee Number <strong><?= htmlspecialchars($Emp_No) ?></strong> already exists in the database. Please use a unique Employee Number.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<?php endif; ?>

<div class="content" id="content">
<div class="container mt-0">
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h4 class="mb-0" style="font-weight: bold;">Edit Contract of Service Employee</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=<?php echo htmlspecialchars($emp_no); ?>">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contract of Service Employee</li>
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
                    <option value="Active" <?php echo (isset($employee['emp_status']) && $employee['emp_status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo (isset($employee['emp_status']) && $employee['emp_status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($employee['address']); ?>">
            </div>
            <div class="col-md-3">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-control" id="sex" name="sex" required>
                    <option value="Male" <?php echo ($employee['sex'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($employee['sex'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($employee['birthdate']); ?>">
            </div>
            <div class="col-md-6">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($employee['contact_number']); ?>" maxlength="11" pattern="\d{11}" title="Contact number must be 11 digits">
            </div>
            <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>">
            </div>
            <div class="col-md-6">
            <label for="division" class="form-label">Division</label>
              <select class="form-control" id="division" name="division">
              <option value="">Select Division</option>
              <?php
              foreach ($jsDivisionData as $division) {
                $selected = (trim(strtolower($employee['division'])) === trim(strtolower($division))) ? 'selected' : '';
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
                <label for="salary_rate" class="form-label">Salary Rate</label>
                <input type="number" step="0.01" class="form-control" id="salary_rate" name="salary_rate" value="<?php echo htmlspecialchars($employee['salaryRate']); ?>">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</div> 
</body>
</html>