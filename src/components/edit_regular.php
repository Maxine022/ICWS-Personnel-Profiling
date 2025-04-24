<?php
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
        p.personnel_id, p.Emp_No, p.full_name, p.sex, p.birthdate, p.position, p.division, p.emp_status, p.contact_number, p.address,
        r.plantillaNo, r.acaPera, r.salary_id,
        s.salaryGrade, s.step, s.level, s.monthlySalary
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

// Fetch salary data for dynamic dropdowns
$jsSalaryData = [];
include_once __DIR__ . '/ideas/salary.php';
if (class_exists('SalaryGrade')) {
    foreach (SalaryGrade::cases() as $grade) {
        $jsSalaryData[$grade->value] = SalaryGrade::getStepsForGrade($grade);
    }
} else {
    die("<div class='alert alert-danger'>Error: SalaryGrade class not found in salary.php.</div>");
}

// Handle form submission
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with default values to avoid warnings
    $fullName = $_POST["full_name"] ?? null;
    $position = $_POST["position"] ?? null;
    $division = $_POST["division"] ?? null;
    $sex = $_POST["sex"] ?? null;
    $birthdate = $_POST["birthdate"] ?? null;
    $address = $_POST["address"] ?? null;
    $emp_status = $_POST["emp_status"] ?? null;
    $plantillaNo = $_POST["plantillaNo"] ?? null;
    $contactNumber = $_POST["contact_number"] ?? null;
    $salaryGrade = $_POST["salary_grade"] ?? null;
    $step = $_POST["step"] ?? null;
    $level = $_POST["level"] ?? null;
    $acaPera = $_POST["aca_pera"] ?? null;
    $monthlySalary = $_POST["monthly_salary"] ?? 0;

    // Validate required fields
    if (!$fullName || !$position || !$division || !$sex || !$birthdate || !$emp_status) {
        die("<div class='alert alert-danger'>Full Name, Position, Division, Sex, Birthdate, and Status are required fields. <a href='javascript:history.back()' class='btn btn-secondary'>Go Back</a></div>");
    }

    // Prepare statements for updating the database
    $updatePersonnel = $conn->prepare("
        UPDATE personnel 
        SET full_name = ?, position = ?, division = ?, contact_number = ?, sex = ?, birthdate = ?, emp_status = ?, address = ?
        WHERE Emp_No = ?
    ");

    if (!$updatePersonnel) {
        die("<div class='alert alert-danger'>Failed to prepare personnel update query: {$conn->error}</div>");
    }

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

    $updateSalary = $conn->prepare("
        UPDATE salary 
        SET salaryGrade = ?, step = ?, level = ?, monthlySalary = ?
        WHERE salary_id = ?
    ");

    if (!$updateSalary) {
        die("<div class='alert alert-danger'>Failed to prepare salary update query: {$conn->error}</div>");
    }

    $updateSalary->bind_param(
        "iiiii",
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
        echo "<script>window.location.href='/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
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
        .form-action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: flex-start;
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
    <form method="POST">
        <div class="mb-3">
            <label for="Emp_No" class="form-label">Employee Number</label>
            <input type="text" class="form-control" id="Emp_No" name="Emp_No" value="<?php echo htmlspecialchars($employee['Emp_No']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo htmlspecialchars($employee['full_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="sex" class="form-label">Sex</label>
            <select class="form-control" id="sex" name="sex" required>
                <option value="">Select Sex</option>
                <option value="Male" <?php echo ($employee['sex'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($employee['sex'] === 'Female') ? 'selected' : ''; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Birthdate</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($employee['birthdate']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="address" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($employee['address']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="division" class="form-label">Division</label>
            <input type="text" class="form-control" id="division" name="division" value="<?php echo htmlspecialchars($employee['division']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="emp_status" class="form-label">Status</label>
            <select class="form-control" id="emp_status" name="emp_status" required>
                <option value="Active" <?php echo ($employee['emp_status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                <option value="Inactive" <?php echo ($employee['emp_status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="plantillaNo" class="form-label">Plantilla Number</label>
            <input type="text" class="form-control" id="plantillaNo" name="plantillaNo" value="<?php echo htmlspecialchars($employee['plantillaNo']); ?>">
        </div>
        <div class="mb-3">
            <label for="contact_number" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($employee['contact_number']); ?>">
        </div>
        <div class="mb-3">
            <label for="salary_grade" class="form-label">Salary Grade</label>
            <select class="form-control" id="salary_grade" name="salary_grade" required>
                <option value="">Select Grade</option>
                <?php
                foreach (SalaryGrade::cases() as $grade) {
                    $selected = ((int)$employee['salaryGrade'] === $grade->value) ? 'selected' : '';
                    echo "<option value=\"{$grade->value}\" $selected>Grade {$grade->value}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="step" class="form-label">Step</label>
            <select class="form-control" id="step" name="step" required>
                <option value="">Select Step</option>
                <?php
                $salaryGradeObj = SalaryGrade::tryFrom((int)$employee['salaryGrade']);
                if ($salaryGradeObj) {
                    $steps = SalaryGrade::getStepsForGrade($salaryGradeObj);
                    foreach ($steps as $index => $salary) {
                        $stepNumber = $index + 1;
                        $selected = ((int)$employee['step'] === $stepNumber) ? 'selected' : '';
                        echo "<option value=\"$stepNumber\" $selected>Step $stepNumber</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="text" class="form-control" id="level" name="level" value="<?php echo htmlspecialchars($employee['level']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="monthly_salary" class="form-label">Monthly Salary</label>
            <input type="text" class="form-control" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($employee['monthlySalary']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="aca_pera" class="form-label">ACA Pera</label>
            <input type="text" class="form-control" id="aca_pera" name="aca_pera" value="<?php echo htmlspecialchars($employee['acaPera']); ?>">
        </div>
        <div class="form-action-buttons">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
document.getElementById('salary_grade').addEventListener('change', function () {
    const salaryGrade = this.value;
    const stepSelect = document.getElementById('step');
    const monthlySalaryInput = document.getElementById('monthly_salary');
    stepSelect.innerHTML = '<option value="">Select Step</option>';
    if (salaryGrade) {
        <?php echo "const salaryData = " . json_encode($jsSalaryData) . ";"; ?>
        if (salaryData[salaryGrade]) {
            salaryData[salaryGrade].forEach((salary, index) => {
                const option = document.createElement('option');
                option.value = index + 1;
                option.textContent = `Step ${index + 1}`;
                stepSelect.appendChild(option);
            });
        }
    }
});
</script>
</body>
</html>