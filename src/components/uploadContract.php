<?php
include_once __DIR__ . '/../../backend/db.php';

$conn->set_charset('utf8mb4');
?>
<meta charset="UTF-8">
<form ... accept-charset="UTF-8">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
    $file = $_FILES['data_file'];

    if ($file['type'] === 'text/csv' || pathinfo($file['name'], PATHINFO_EXTENSION) === 'csv') {
        if (($handle = fopen($file['tmp_name'], 'r')) !== false) {
            $header = fgetcsv($handle); // Skip the header row

            while (($data = fgetcsv($handle)) !== false) {
                $Emp_No = $data[0];
                $full_name = htmlspecialchars($data[1], ENT_QUOTES, 'UTF-8');
                $sex = $data[2];
                if (!empty($data[3])) {
                    $birthdate = date('Y-m-d', strtotime(str_replace('-', '/', $data[3])));
                } else {
                    $birthdate = null;
                }
                $contact_number = $data[4];
                $address = $data[5];
                $position = $data[6];
                $division = $data[7];
                $salaryRate = $data[8] ?? null;

                // Insert into personnel table
                $stmt1 = $conn->prepare("INSERT INTO personnel (Emp_No, full_name, position, division, contact_number, sex, birthdate, address, emp_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'contract')");
                $stmt1->bind_param("ssssssss", $Emp_No, $full_name, $position, $division, $contact_number, $sex, $birthdate, $address);
                $stmt1->execute();
                $personnel_id = $stmt1->insert_id;
                $stmt1->close();

                $stmt2 = $conn->prepare("INSERT INTO contract_service (personnel_id, salaryRate) VALUES (?, ?)");
                $stmt2->bind_param("id", $personnel_id, $salaryRate);
                $stmt2->execute();
                $stmt2->close();
            }
            fclose($handle);
            header("Location: manage_cos.php?status=success");
            exit();
        }
    }
}
