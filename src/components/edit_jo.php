<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

// Check DB connection
if ($conn->connect_error) {
    die("<div class='alert alert-danger'>Database connection failed: {$conn->connect_error}</div>");
}

// Get Emp_No from query string
$emp_no = $_GET['Emp_No'] ?? null;
if (!$emp_no) {
    die("<div class='alert alert-danger'>Emp_No is missing in the query string. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
}

// Fetch ENUM values for sex
$enum_values = [];
$enum_query = $conn->query("SHOW COLUMNS FROM personnel LIKE 'sex'");
$enum_result = $enum_query->fetch_assoc();
if ($enum_result) {
    preg_match('/^enum\((.*)\)$/', $enum_result['Type'], $matches);
    if (isset($matches[1])) {
        $enum_values = array_map(fn($v) => trim($v, "'"), explode(",", $matches[1]));
    }
}

// Fetch positions from the database
$positions = [];
$position_query = $conn->query("SELECT DISTINCT position FROM personnel ORDER BY position ASC");
if ($position_query && $position_query->num_rows > 0) {
    while ($row = $position_query->fetch_assoc()) {
        $positions[] = $row['position'];
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

// Fetch personnel and job order info
$query = $conn->prepare("
    SELECT 
        p.personnel_id, p.Emp_No, p.full_name, p.sex, p.birthdate, p.position, p.section, p.unit, p.team, p.operator, p.division, p.emp_status, p.contact_number, p.address,
        j.jo_id, j.salaryRate
    FROM personnel p
    LEFT JOIN job_order j ON p.personnel_id = j.personnel_id
    WHERE p.Emp_No = ?
    ORDER BY j.jo_id DESC LIMIT 1
");
if (!$query) {
    die("<div class='alert alert-danger'>Failed to prepare the query: {$conn->error}</div>");
}
$query->bind_param("s", $emp_no);
$query->execute();
$result = $query->get_result();
$employee = $result->fetch_assoc();
if (!$employee) {
    die("<div class='alert alert-danger'>Job Order employee not found. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
}

// Store original Emp_No before form submission
$original_emp_no = $employee['Emp_No'];

// Handle form submission
$success = false;
$showDupAlert = false;
$dupAlertMsg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["full_name"] ?? null;
    $contactNumber = $_POST["contact_number"] ?? null;
    $birthdate = !empty($_POST["birthdate"]) ? $_POST["birthdate"] : null; // <-- allow null
    $sex = $_POST["sex"] ?? null;
    $position = $_POST["position"] ?? null;
    $division = $_POST["division"] ?? null; 
    $unit = $_POST["unit"] ?? null;
    $section = $_POST["section"] ?? null;
    $team = $_POST["team"] ?? null;
    $operator = $_POST["operator"] ?? null;
    $emp_status = $_POST["emp_status"] ?? null;
    $address = $_POST["address"] ?? null;
    $salaryRate = $_POST["salaryRate"] ?? null;
    $justification = $_POST["justification"] ?? null;
    $emp_no = $_POST["Emp_No"] ?? null; // new Emp_No from form

    // Validate required fields
    if (!$fullName) {
        echo "<div class='alert alert-danger'>Full Name is a required field.</div>";
    } else {
        // Check for duplicate Emp_No (excluding the current record)
        $dupCheck = $conn->prepare("SELECT COUNT(*) FROM personnel WHERE Emp_No = ? AND Emp_No != ?");
        $dupCheck->bind_param("ss", $emp_no, $original_emp_no);
        $dupCheck->execute();
        $dupCheck->bind_result($dupCount);
        $dupCheck->fetch();
        $dupCheck->close();

        if ($dupCount > 0) {
            $showDupAlert = true;
            $dupAlertMsg = "The Employee Number <strong>" . htmlspecialchars($emp_no) . "</strong> already exists. Please use a unique Employee Number.";
        } else {
            // Update personnel
            $updatePersonnel = $conn->prepare("
                UPDATE personnel 
                SET Emp_No = ?, full_name = ?, position = ?, section = ?, unit = ?, team = ?, operator = ?, division = ?, contact_number = ?, sex = ?, birthdate = ?, emp_status = ?, address = ?
                WHERE Emp_No = ?
            ");
            $updatePersonnel->bind_param(
                "ssssssssssssss",
                $emp_no,
                $fullName,
                $position,
                $section,
                $unit,
                $team,
                $operator,
                $division,
                $contactNumber,
                $sex,
                $birthdate, // will be null if empty
                $emp_status,
                $address,
                $original_emp_no
            );

            // Update job_order
            $updateJobOrder = $conn->prepare("
                UPDATE job_order 
                SET salaryRate = ?
                WHERE jo_id = ?
            ");
            
            $updateJobOrder->bind_param(
                "di", // double, int
                $salaryRate,
                $employee['jo_id']
            );

            $success = true;
            if (!$updatePersonnel->execute()) {
                $success = false;
                echo "<div class='alert alert-danger'>Failed to update personnel details: {$updatePersonnel->error}</div>";
            }
            if (!$updateJobOrder->execute()) {
                $success = false;
                echo "<div class='alert alert-danger'>Failed to update job order details: {$updateJobOrder->error}</div>";
            }

            if ($success) {
                echo "<div class='alert alert-success' role='alert'>
                        Employee details have been successfully updated!
                      </div>";
                echo "<script>window.location.href='http://localhost/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
                exit();
            }
        }
    }
}

// After your POST logic, before the HTML output
$formData = $employee;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        // If duplicate error, keep Emp_No as original
        if ($key === 'Emp_No' && !empty($showDupAlert)) {
            $formData['Emp_No'] = $original_emp_no;
        } else {
            $formData[$key] = $value;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Job Order Employee</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { 
      font-family: 'Arial';
    }
    .main {
       margin-left: 220px; 
       padding: 2rem; 
       background-color: #f8f9fa; 
       min-height: 100vh; 
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
    .breadcrumb-link {
      color: inherit;
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .breadcrumb-link:hover {
      color: #007bff;
      text-decoration: underline;
    }
  </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<?php if (!empty($showDupAlert)): ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $dupAlertMsg ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<?php endif; ?>

<div class="content" id="content">
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0 fw-bold">Update Job Order Employee</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_jo.php">Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Order</li>
      </ol>
    </nav>
  </div>

  <div class="form-section">
    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-6">
            <label for="Emp_No" class="form-label">Employee Number</label>
            <input type="text" class="form-control" id="Emp_No" name="Emp_No" value="<?php echo htmlspecialchars($formData['Emp_No'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="emp_status" class="form-label">Employment Status</label>
            <div class="dropdown"></div>
            <select class="form-control" id="emp_status" name="emp_status" required>
                <option value="Active" <?php echo (isset($formData['emp_status']) && $formData['emp_status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo (isset($formData['emp_status']) && $formData['emp_status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($formData['full_name'] ?? '') ?>" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number" value="<?= htmlspecialchars($formData['contact_number'] ?? '') ?>" maxlength="11" pattern="\d{11}" title="Please enter an 11-digit contact number">
        </div>
        <div class="col-md-3">
          <label class="form-label">Birthdate</label>
          <input type="date" class="form-control" name="birthdate" value="<?= htmlspecialchars($formData['birthdate'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Sex</label>
          <select name="sex" class="form-select">
            <option value="">Select</option>
            <?php foreach ($enum_values as $sex): ?>
              <option value="<?= htmlspecialchars($sex) ?>" <?= (isset($formData['sex']) && $formData['sex'] === $sex) ? 'selected' : '' ?>><?= htmlspecialchars($sex) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6">
          <label class="form-label">Address</label>
          <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($formData['address'] ?? '') ?>">
        </div>
        <div class="col-md-6">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($formData['position'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
        <label for="division" class="form-label">Division</label>
          <select class="form-control" id="division" name="division">
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
            <input type="text" class="form-control" id="section" name="section" value="<?php echo htmlspecialchars($formData['section'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" value="<?php echo htmlspecialchars($formData['unit'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
            <label for="team" class="form-label">Team, if applicable</label>
            <input type="text" class="form-control" id="team" name="team" value="<?php echo htmlspecialchars($formData['team'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
            <label for="operator" class="form-label">Operators, if applicable</label>
            <input type="text" class="form-control" id="operator" name="operator" value="<?php echo htmlspecialchars($formData['operator'] ?? ''); ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Salary Rate</label>
          <input type="number" step="0.01" class="form-control" name="salaryRate" value="<?= htmlspecialchars($formData['salaryRate'] ?? '') ?>">
        </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success px-4">Save Changes</button>
        <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
      </div>
    </form>
  </div>
</div>
<script>
function showDivisionSelect() {
  document.getElementById('division-static').style.display = 'none';
  document.getElementById('division-select').style.display = '';
  document.getElementById('division-dropdown').focus();
}
</script>
</body>
</html>