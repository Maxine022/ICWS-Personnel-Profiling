<?php
include_once __DIR__ . '/../../backend/db.php'; // Path to your db connection file
include_once __DIR__ . '/ideas/salary.php'; // Include the SalaryGrade definition

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
    $file = $_FILES['data_file'];

    if ($file['type'] === 'text/csv' || pathinfo($file['name'], PATHINFO_EXTENSION) === 'csv') {
        if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
            $header = fgetcsv($handle); // Skip the header row

            $conn->begin_transaction();

            try {
                while (($data = fgetcsv($handle)) !== false) {
                    $Emp_No = $data[0];
                    $full_name = $data[1];
                    $sex = $data[2];
                    $birthdate = date('Y-m-d', strtotime(str_replace('-', '/', $data[3])));
                    $contact_number = $data[4];
                    $address = $data[5];
                    $position = $data[6];
                    $division = $data[7];
                    $plantillaNo = $data[8];
                    $salary_grade = (int)$data[9];
                    $step = (int)$data[10];
                    $level = $data[11];
                    $acaPera = is_numeric($data[13]) ? number_format((float)$data[13], 2, '.', '') : $data[13];

                    // Calculate Monthly Salary
                    $monthly_salary = 0;
                    if (class_exists('SalaryGrade')) {
                        $salaryGradeObj = SalaryGrade::tryFrom($salary_grade);
                        $monthly_salary = $salaryGradeObj ? (SalaryGrade::getStepsForGrade($salaryGradeObj)[$step - 1] ?? 0) : 0;
                    }

                    // Insert into personnel table
                    $stmt1 = $conn->prepare("INSERT INTO personnel (Emp_No, full_name, position, division, contact_number, sex, birthdate, address, emp_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'regular')");
                    $stmt1->bind_param("ssssssss", $Emp_No, $full_name, $position, $division, $contact_number, $sex, $birthdate, $address);
                    $stmt1->execute();
                    $personnel_id = $stmt1->insert_id;
                    $stmt1->close();

                    // Insert into salary table
                    $stmt2 = $conn->prepare("INSERT INTO salary (personnel_id, salaryGrade, step, level, monthlySalary) VALUES (?, ?, ?, ?, ?)");
                    $stmt2->bind_param("iisss", $personnel_id, $salary_grade, $step, $level, $monthly_salary);
                    $stmt2->execute();
                    $salary_id = $stmt2->insert_id;
                    $stmt2->close();

                    // Insert into reg_emp table
                    $stmt3 = $conn->prepare("INSERT INTO reg_emp (personnel_id, salary_id, plantillaNo, acaPera) VALUES (?, ?, ?, ?)");
                    $stmt3->bind_param("iisd", $personnel_id, $salary_id, $plantillaNo, $acaPera); // Use "d" for decimal/float
                    $stmt3->execute();
                    $stmt3->close();
                }

                $conn->commit(); // Commit the transaction
                fclose($handle);
                header("Location: manage_regEmp.php?status=success");
                exit();
            } catch (Exception $e) {
                $conn->rollback(); // Rollback the transaction on error
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
        }
    }
}
?>

<?php
// Display message after upload
if (isset($message)) {
    echo "<p>$message</p>";
}
?>

<!-- HTML Form to upload the CSV file -->
<form action="" method="POST" enctype="multipart/form-data">
    <label for="data_file">Choose CSV File</label>
    <input type="file" name="data_file" accept=".csv" required>
    <button type="submit">Upload</button>
</form>