<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include_once __DIR__ . '/../../backend/db.php';
if (!isset($conn) || !$conn) {
    die("Database connection failed.");
}

// Initialize variables
$error = '';
$Emp_no = $_POST['Emp_no'] ?? '';
$full_name = $_POST['full_name'] ?? '';
$sex = $_POST['sex'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$address = $_POST['address'] ?? '';
$position = $_POST['position'] ?? '';
$division = $_POST['division'] ?? '';
$section = $_POST['section'] ?? '';
$unit = $_POST['unit'] ?? '';
$team = $_POST['team'] ?? '';
$operator = $_POST['operations'] ?? '';
$salary_rate = $_POST['salary_rate'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    if (!$Emp_no || !$full_name) {
        $error = "Please fill in all required fields.";
    } else {
        // Check for duplicate Emp_No
        $dupCheck = $conn->prepare("SELECT COUNT(*) FROM personnel WHERE Emp_No = ?");
        $dupCheck->bind_param("s", $Emp_no);
        $dupCheck->execute();
        $dupCheck->bind_result($dupCount);
        $dupCheck->fetch();
        $dupCheck->close();

        if ($dupCount > 0) {
            $error = "The Employee Number <strong>" . htmlspecialchars($Emp_no) . "</strong> already exists. Please use a unique Employee Number.";
        } else {
            // Insert into personnel table
            $stmt = $conn->prepare("
                INSERT INTO personnel (Emp_No, full_name, sex, birthdate, contact_number, address, position, division, section, unit, team, operator, emp_type, emp_status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Contract', 'Active')
            ");
            $stmt->bind_param("ssssssssssss", $Emp_no, $full_name, $sex, $birthdate, $contact_number, $address, $position, $division, $section, $unit, $team, $operator);
            if (!$stmt->execute()) {
                $error = "Error executing query: {$stmt->error}";
            } else {
                $personnel_id = $conn->insert_id;
                if (!$personnel_id) {
                    $error = "Error retrieving last inserted ID: {$conn->error}";
                } else {
                    // Insert into contract_service table
                    $stmt = $conn->prepare("
                        INSERT INTO contract_service (personnel_id, salaryRate)
                        VALUES (?, ?)
                    ");
                    $stmt->bind_param("id", $personnel_id, $salary_rate);
                    if (!$stmt->execute()) {
                        $error = "Error inserting contract_service: {$stmt->error}";
                    } else {
                        // Redirect after successful insertion
                        header("Location: http://localhost/ICWS-Personnel-Profiling/src/components/manage_cos.php");
                        exit;
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Contract of Service</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const divisionSelect = document.querySelector('select[name="division"]');
            const sectionSelect = document.querySelector('select[name="section"]');
            const unitSelect = document.querySelector('select[name="unit"]');
            const teamSelect = document.querySelector('select[name="team"]');
            const operatorSelect = document.querySelector('select[name="operator"]');

            function toggleFields() {
                const selectedDivision = divisionSelect.value;
                const selectedSection = sectionSelect.value;

                // Enable or disable fields based on specific division and section
                if (selectedDivision === 'SpecificDivision' && selectedSection === 'SpecificSection') {
                    unitSelect.disabled = false;
                    teamSelect.disabled = false;
                } else {
                    unitSelect.disabled = true;
                    teamSelect.disabled = true;
                }
            }

            function updateDependentFields() {
                const selectedUnit = unitSelect.value;

                // Enable or disable Teams
                Array.from(teamSelect.options).forEach(option => {
                    option.hidden = !option.dataset.unit || option.dataset.unit !== selectedUnit;
                });

                // Enable or disable Operators
                Array.from(operatorSelect.options).forEach(option => {
                    option.hidden = !option.dataset.unit || option.dataset.unit !== selectedUnit;
                });
            }

            divisionSelect.addEventListener('change', toggleFields);
            sectionSelect.addEventListener('change', toggleFields);
            unitSelect.addEventListener('change', updateDependentFields);

            // Initialize fields on page load
            toggleFields();
            updateDependentFields();
        });
    </script>
    <style>
        .breadcrumb-link {
      color: inherit;
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .breadcrumb-link:hover {
      color: #007bff;
      text-decoration: underline;
    }
    .view-link {
      color: #0d6efd;
      text-decoration: none;
      transition: color 0.2s ease, text-decoration 0.2s ease;
    }
    .view-link:hover {
      color: #0a58ca;
      text-decoration: underline;
    }
    </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
<div class="container mt-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0 fw-bold"> Add Contract of Service Employees</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/personnel_record.php">Manage Personnel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contract of Service</li>
      </ol>
    </nav>
  </div>
    <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="col-md-6">
                <label for="Emp_no" class="form-label">Employee Number</label>
                <input type="text" class="form-control" id="Emp_no" name="Emp_no" value="<?php echo htmlspecialchars($Emp_no); ?>" required>
            </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
            </div>
            <div class="col-md-3">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-select" id="sex" name="sex" required>
                    <option value="">Select Sex</option>
                    <option value="Male" <?php if($sex=='Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($sex=='Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="birthdate" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>">
            </div>
            <div class="col-md-6">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" maxlength="11" pattern="\d{11}" title="Contact number must be 11 digits">
            </div>
            <div class="col-md-6">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
            </div>
            <div class="col-md-6">
                <label for="position" class="form-label">Position</label>
                <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($position); ?>">
            </div>
            <div class="col-md-6">
            <label class="form-label">Division</label>
            <select class="form-select" name="division">
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
                <input type="text" class="form-control" id="unit" name="unit" value="<?php echo htmlspecialchars($unit); ?>">
            </div>
            <div class="col-md-6">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" value="<?php echo htmlspecialchars($section); ?>">
            </div>
            <div class="col-md-6">
                <label for="team" class="form-label">Team, if applicable</label>
                <input type="text" class="form-control" id="team" name="team" value="<?php echo htmlspecialchars($team); ?>">
            </div>
            <div class="col-md-6">
                <label for="operations" class="form-label">Operators, if applicable</label>
                <input type="text" class="form-control" id="operations" name="operations" value="<?php echo htmlspecialchars($operator); ?>">
            </div>
            <div class="col-md-6">
                <label for="salary_rate" class="form-label">Salary Rate</label>
                <input type="number" step="0.01" class="form-control" id="salary_rate" name="salary_rate" value="<?php echo htmlspecialchars($salary_rate); ?>">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Add Contract of Service</button>
            <a href="http://localhost/ICWS-Personnel-Profiling/src/components/manage_cos.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
