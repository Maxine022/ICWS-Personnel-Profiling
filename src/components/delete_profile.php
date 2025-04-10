<?php
session_start();
include_once __DIR__ . '/../../backend/db.php';

// Check if Emp_No is provided in the GET request
$Emp_No = $_GET['Emp_No'] ?? null;

if (!$Emp_No) {
    echo "Employee not found.";
    exit();
}

// Fetch the employee data based on the Emp_No
$query = $conn->prepare("SELECT * FROM personnel WHERE Emp_No = ?");
$query->bind_param("s", $Emp_No);
$query->execute();
$result = $query->get_result();
$employee = $result->fetch_assoc();

if (!$employee) {
    echo "Employee not found.";
    exit();
}

// Begin the transaction to delete from all related tables
$conn->begin_transaction();

try {
    // Insert the employee data into personnel_history
    $stmtHistory = $conn->prepare("
        INSERT INTO personnel_history (personnel_id, Emp_No, name, position, department, date_hired, other_columns)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmtHistory->bind_param(
        "issssss",
        $employee['personnel_id'],
        $employee['Emp_No'],
        $employee['name'],
        $employee['position'],
        $employee['department'],
        $employee['date_hired'],
    );
    $stmtHistory->execute();
    $stmtHistory->close();

    // Delete from reg_emp
    $stmt1 = $conn->prepare("DELETE FROM reg_emp WHERE personnel_id = ?");
    $stmt1->bind_param("i", $employee['personnel_id']);
    $stmt1->execute();
    $stmt1->close();

    // Delete from salary
    $stmt2 = $conn->prepare("DELETE FROM salary WHERE personnel_id = ?");
    $stmt2->bind_param("i", $employee['personnel_id']);
    $stmt2->execute();
    $stmt2->close();

    // Delete from jo (manage_jo.php related table)
    $stmt3 = $conn->prepare("DELETE FROM jo WHERE personnel_id = ?");
    $stmt3->bind_param("i", $employee['personnel_id']);
    $stmt3->execute();
    $stmt3->close();

    // Delete from cos (manage_cos.php related table)
    $stmt4 = $conn->prepare("DELETE FROM cos WHERE personnel_id = ?");
    $stmt4->bind_param("i", $employee['personnel_id']);
    $stmt4->execute();
    $stmt4->close();

    // Delete from personnel
    $stmt5 = $conn->prepare("DELETE FROM personnel WHERE Emp_No = ?");
    $stmt5->bind_param("s", $Emp_No);
    $stmt5->execute();
    $stmt5->close();

    // Commit the transaction
    $conn->commit();

    // Redirect to manage_regEmp.php after deletion
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = basename(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
        if (in_array($referer, ['manage_regEmp.php', 'manage_jo.php', 'manage_cos.php'])) {
            header("Location: $referer");
        } else {
            header("Location: personnel_record.php");
        }
    } else {
        header("Location: personnel_record.php");
    }
    $conn->close();
    exit();

} catch (Exception $e) {
    // If an error occurs, rollback the transaction
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    $conn->close();
    exit();
}
?>
