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
$success = false;
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
    <div class="row mt-3">
        <form method="POST" action=" ">
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
          
          <?php
            // Include salary.php for salary data
            $salaryFilePath = __DIR__ . '/ideas/salary.php'; // Adjust the path to the actual location of salary.php
            if (!file_exists($salaryFilePath)) {
                die("Error: salary.php file not found.");
            }
            include_once $salaryFilePath;

            // Example employee data (replace this with your actual database fetching logic)
            $employee = [
                'salaryGrade' => 5,
                'step' => 3,
                'level' => 'Level 1',
                'monthlySalary' => 0, // This will be calculated dynamically
            ];

            // Calculate the monthly salary based on the grade and step
            if (
                isset($employee['salaryGrade'], $employee['step']) &&
                class_exists('SalaryGrade')
            ) {
                $salaryGrade = SalaryGrade::tryFrom((int)$employee['salaryGrade']);
                if ($salaryGrade) {
                    $steps = SalaryGrade::getStepsForGrade($salaryGrade);
                    $stepIndex = (int)$employee['step'] - 1; // Step is 1-based index
                    if (isset($steps[$stepIndex])) {
                        $employee['monthlySalary'] = $steps[$stepIndex];
                    }
                }
            }
            ?>
              <div class="mb-1">
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
              <div class="mb-1">
                  <label for="step" class="form-label">Step</label>
                  <select class="form-control" id="step" name="step" required>
                      <option value="">Select Step</option>
                      <?php
                      if (isset($salaryGrade)) {
                          $steps = SalaryGrade::getStepsForGrade($salaryGrade);
                          foreach ($steps as $index => $salary) {
                              $stepNumber = $index + 1;
                              $selected = ((int)$employee['step'] === $stepNumber) ? 'selected' : '';
                              echo "<option value=\"$stepNumber\" $selected>Step $stepNumber</option>";
                          }
                      }
                      ?>
                  </select>
              </div>
              <div class="mb-1">
                  <label for="level" class="form-label">Level</label>
                  <input type="text" class="form-control" id="level" name="level" value="<?php echo htmlspecialchars($employee['level']); ?>" required>
              </div>
              <div class="mb-1">
                  <label for="monthly_salary" class="form-label">Monthly Salary</label>
                  <input type="text" class="form-control" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($employee['monthlySalary']); ?>" readonly>
              </div>

            <script>
                document.getElementById('salary_grade').addEventListener('change', function () {
                    const salaryGrade = this.value;
                    const stepSelect = document.getElementById('step');
                    const monthlySalaryInput = document.getElementById('monthly_salary');

                    // Reset step selection and salary
                    stepSelect.innerHTML = '<option value="">Select Step</option>';
                    stepSelect.disabled = true;
                    monthlySalaryInput.value = '';

                    if (salaryGrade) {
                        // Fetch steps dynamically using predefined PHP logic
                        <?php
                        $jsSalaryData = [];
                        foreach (SalaryGrade::cases() as $grade) {
                            $jsSalaryData[$grade->value] = SalaryGrade::getStepsForGrade($grade);
                        }
                        echo "const salaryData = " . json_encode($jsSalaryData) . ";";
                        ?>

                        if (salaryData[salaryGrade]) {
                            salaryData[salaryGrade].forEach((salary, index) => {
                                const stepOption = document.createElement('option');
                                stepOption.value = index + 1; // Step index starts from 1
                                stepOption.textContent = `Step ${index + 1}`;
                                stepSelect.appendChild(stepOption);
                            });

                            stepSelect.disabled = false;
                        }
                    }
                });

                document.getElementById('step').addEventListener('change', function () {
                    const salaryGrade = document.getElementById('salary_grade').value;
                    const step = this.value;

                    if (salaryGrade && step) {
                        <?php
                        echo "const salaryData = " . json_encode($jsSalaryData) . ";";
                        ?>

                        const monthlySalary = salaryData[salaryGrade][step - 1];
                        document.getElementById('monthly_salary').value = monthlySalary ?? '';
                    } else {
                        document.getElementById('monthly_salary').value = '';
                    }
                });

                // Trigger initial calculation if editing an existing employee
                document.addEventListener('DOMContentLoaded', function () {
                    const salaryGrade = document.getElementById('salary_grade').value;
                    const step = document.getElementById('step').value;
                    if (salaryGrade && step) {
                        const event = new Event('change');
                        document.getElementById('salary_grade').dispatchEvent(event);
                    }
                });
            </script>

          <div class="mb-1">
            <label for="aca_pera" class="form-label">ACA Pera</label>
            <input type="text" class="form-control" id="aca_pera" name="aca_pera" value="<?php echo htmlspecialchars($employee['acaPera']); ?>">
          </div>
          
          <div class="form-action-buttons">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
        </div>
        </form>
      </div>
    </div>
</div>
</body>
</html>