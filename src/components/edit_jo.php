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

// Fetch divisions from the database
$divisions = [];
$division_query = $conn->query("SELECT DISTINCT division FROM personnel ORDER BY division ASC");
if ($division_query && $division_query->num_rows > 0) {
    while ($row = $division_query->fetch_assoc()) {
        $divisions[] = $row['division'];
    }
}

// Fetch personnel and job order info
$query = $conn->prepare("
    SELECT 
        p.personnel_id, p.Emp_No, p.full_name, p.sex, p.birthdate, p.position, p.division, p.emp_status, p.contact_number, p.address,
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

// Handle form submission
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["full_name"] ?? null;
    $contactNumber = $_POST["contact_number"] ?? null;
    $birthdate = $_POST["birthdate"] ?? null;
    $sex = $_POST["sex"] ?? null;
    $position = $_POST["position"] ?? null;
    $division = $_POST["division"] ?? null;
    $emp_status = $_POST["emp_status"] ?? null;
    $address = $_POST["address"] ?? null;
    $salaryRate = $_POST["salary_rate"] ?? null;
    $justification = $_POST["justification"] ?? null;

    // Validate required fields
    if (!$fullName || !$position || !$division || !$sex || !$birthdate || !$emp_status) {
        echo "<div class='alert alert-danger'>Full Name, Position, Division, Sex, Birthdate, and Status are required fields.</div>";
    } else {
        // Update personnel
        $updatePersonnel = $conn->prepare("
            UPDATE personnel 
            SET full_name = ?, position = ?, division = ?, contact_number = ?, sex = ?, birthdate = ?, emp_status = ?, address = ?
            WHERE Emp_No = ?
        ");
        $updatePersonnel->bind_param(
            "sssssssss",
            $fullName,
            $position,
            $division,
            $contactNumber,
            $sex,
            $birthdate,
            $emp_status,
            $address,
            $emp_no
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
            echo "<div class='alert alert-success'>Employee details have been successfully updated!</div>";
            echo "<script>window.location.href='http://192.168.1.96/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
            exit();
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

<div class="content" id="content">
<div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0 fw-bold">Update Job Order Employee</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://192.168.1.96/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://192.168.1.96/ICWS-Personnel-Profiling/src/components/manage_jo.php">Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Order</li>
      </ol>
    </nav>
  </div>

  <div class="form-section">
    <form method="POST" action="">
      <div class="row g-3">
        <div class="col-md-6">
            <label for="Emp_No" class="form-label">Employee Number</label>
            <input type="text" class="form-control" id="Emp_No" name="Emp_No" value="<?php echo htmlspecialchars($employee['Emp_No']); ?>" readonly>
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
          <label class="form-label">Full Name</label>
          <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($employee['full_name']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Contact Number</label>
          <input type="text" class="form-control" name="contact_number" value="<?= htmlspecialchars($employee['contact_number']) ?>" maxlength="11" pattern="\d{11}" title="Please enter an 11-digit contact number">
        </div>
        <div class="col-md-6">
          <label class="form-label">Birthdate</label>
          <input type="date" class="form-control" name="birthdate" value="<?= htmlspecialchars($employee['birthdate']) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Sex</label>
          <select name="sex" class="form-select" required>
            <option value="">Select</option>
            <?php foreach ($enum_values as $sex): ?>
              <option value="<?= htmlspecialchars($sex) ?>" <?= ($employee['sex'] === $sex) ? 'selected' : '' ?>><?= htmlspecialchars($sex) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-6">
          <label class="form-label">Address</label>
          <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($employee['address']) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label">Position</label>
          <select class="form-select" name="position" required>
            <option value="">Select Position</option>
            <?php foreach ($positions as $position): ?>
              <option value="<?= htmlspecialchars($position) ?>" <?= ($employee['position'] === $position) ? 'selected' : '' ?>><?= htmlspecialchars($position) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Division</label>
          <select class="form-select" name="division" required>
            <option value="">Select Division</option>
            <?php foreach ($divisions as $division): ?>
              <option value="<?= htmlspecialchars($division) ?>" <?= ($employee['division'] === $division) ? 'selected' : '' ?>><?= htmlspecialchars($division) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Salary Rate</label>
          <input type="number" step="0.01" class="form-control" name="salary_rate" value="<?= htmlspecialchars($employee['salaryRate']) ?>">
        </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success px-4">Save Changes</button>
        <button type="button" onclick="history.back()" class="btn btn-cancel px-4">Cancel</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>