<?php
include_once __DIR__ . '/../../backend/db.php'; // Path to your db connection file
include_once __DIR__ . '/ideas/salary.php'; // Include the SalaryGrade definition

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
    $file = $_FILES['data_file'];
    // Check if the file is a CSV file
    if ($file['type'] === 'text/csv' || pathinfo($file['name'], PATHINFO_EXTENSION) === 'csv') {
        // Open the CSV file for reading
        if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
            // Skip the header row if present
            $header = fgetcsv($handle);

            // Read each row from the CSV
            while (($data = fgetcsv($handle)) !== false) {
                // Assuming your CSV columns match the structure of your database
                $Emp_No = $data[0];  // Employee Number
                $full_name = $data[1];  // Full Name
                $sex = $data[2];  // Sex
                $birthdate = $data[3];  // Birthdate
                $contact_number = $data[4];  // Contact Number
                $address = $data[5];  // Address
                $position = $data[6];  // Position
                $division = $data[7];  // Division
                $plantilla_number = $data[8];  // Plantilla Number
                $salary_grade = (int)$data[9];  // Salary Grade
                $step = (int)$data[10];  // Step
                $level = $data[11];  // Level
                $aca_pera = $data[12];  // ACA Pera

                // Calculate Monthly Salary using SalaryGrade::getStepsForGrade
                if (class_exists('SalaryGrade')) {
                    $salaryGradeObj = SalaryGrade::tryFrom($salary_grade);
                    $monthly_salary = $salaryGradeObj ? (SalaryGrade::getStepsForGrade($salaryGradeObj)[$step - 1] ?? 0) : 0;
                } else {
                    $monthly_salary = 0; // Default if SalaryGrade class is not found
                }

                // Check if Emp_No or full_name already exists in the database
                $check = $conn->prepare("SELECT Emp_No, full_name FROM personnel WHERE Emp_No = ? OR full_name = ?");
                $check->bind_param("ss", $Emp_No, $full_name);
                $check->execute();
                $check->store_result();

                if ($check->num_rows > 0) {
                    // If there's a match for either Emp_No or full_name
                    echo "<script>alert('Employee number or full name already exists.');</script>";
                    echo "<script>window.location.href = '/src/components/manage_regEmp.php';</script>";
                    exit(); // Stop further execution
                }
                $check->close();

                // Insert into personnel table
                $stmt1 = $conn->prepare("INSERT INTO personnel (Emp_No, full_name, position, division, contact_number, sex, birthdate, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt1->bind_param("ssssssss", $Emp_No, $full_name, $position, $division, $contact_number, $sex, $birthdate, $address);
                $stmt1->execute();
                $personnel_id = $stmt1->insert_id; // Get the inserted personnel ID
                $stmt1->close();

                // Insert into salary table
                $stmt2 = $conn->prepare("INSERT INTO salary (personnel_id, salaryGrade, step, level, monthlySalary) VALUES (?, ?, ?, ?, ?)");
                $stmt2->bind_param("iisss", $personnel_id, $salary_grade, $step, $level, $monthly_salary);
                $stmt2->execute();
                $salary_id = $stmt2->insert_id; // Get the inserted salary ID
                $stmt2->close();

                // Insert into reg_emp table
                $stmt3 = $conn->prepare("INSERT INTO reg_emp (personnel_id, salary_id, plantillaNo, acaPera) VALUES (?, ?, ?, ?)");
                $stmt3->bind_param("iiss", $personnel_id, $salary_id, $plantilla_number, $aca_pera);
                $stmt3->execute();
                $stmt3->close();
            }
            fclose($handle);
            $message = "Data inserted into the database successfully!";
            // Redirect to the manage_regEmp.php page after successful upload
            header("Location: /src/components/manage_regEmp.php");
            exit(); // Make sure to call exit after header to stop script execution
        } else {
            $message = "Failed to open CSV file.";
        } 
    } else {
        $message = "Only CSV files are allowed.";
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