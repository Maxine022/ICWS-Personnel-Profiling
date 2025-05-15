<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error reporting for debugging

ob_start(); // Start output buffering
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../../backend/db.php';

$emp_no = $_GET['Emp_No'] ?? null; // Get Emp_No from query string or set it to null

if ($emp_no) {
    // Fetch service records for the employee
    $stmt = $conn->prepare("
        SELECT sr.record_id, sr.startDate AS start, sr.endDate AS end, sr.position, sr.company
        FROM service_record sr
        JOIN personnel p ON sr.personnel_id = p.personnel_id
        WHERE p.Emp_No = ?
    ");
    $stmt->bind_param("s", $emp_no);
    $stmt->execute();   
    $result = $stmt->get_result();
    $pagedRecords = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $pagedRecords = []; // No records if Emp_No is not provided
}

// Initialize error message for validation feedback
$error_message = "";

// Handle Add, Edit, and Delete form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_service_record']) && $_POST['submit_service_record'] == '1') {
        // Add Service Record
        if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['position']) && !empty($_POST['company'])) {
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $position = $_POST['position'];
            $company = $_POST['company'];
    
            // Validate that start_date is before end_date
            if ($start_date >= $end_date) {
                echo "<script>alert('Error: Start date must be before end date.');</script>";
            } else {
                if ($emp_no) {
                    // Fetch personnel_id for the given Emp_No
                    $stmt = $conn->prepare("SELECT personnel_id FROM personnel WHERE Emp_No = ?");
                    $stmt->bind_param("s", $emp_no);
                    $stmt->execute();
                    $stmt->bind_result($personnel_id);
                    $stmt->fetch();
                    $stmt->close();
    
                    if ($personnel_id) {
                        // Check for overlapping dates
                        $stmt = $conn->prepare("
                            SELECT COUNT(*) FROM service_record 
                            WHERE personnel_id = ? 
                            AND (
                                (startDate <= ? AND endDate >= ?) OR
                                (startDate <= ? AND endDate >= ?) OR
                                (startDate >= ? AND endDate <= ?)
                            )
                        ");
                        $stmt->bind_param(
                            "issssss", 
                            $personnel_id, 
                            $start_date, $start_date, 
                            $end_date, $end_date, 
                            $start_date, $end_date
                        );
                        $stmt->execute();
                        $stmt->bind_result($overlap_count);
                        $stmt->fetch();
                        $stmt->close();
                            
                        if ($overlap_count > 0) {
                            // If overlap exists, reject the insertion
                            echo "
                            <div style='
                                position: fixed; 
                                top: 20%; 
                                left: 50%; 
                                transform: translate(-50%, -20%);
                                z-index: 1050; 
                                width: 50%; 
                                max-width: 400px; 
                                background: white; 
                                border-radius: 8px; 
                                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
                                overflow: hidden;'>
                                <!-- Modal Header -->
                                <div style='
                                    padding: 15px; 
                                    border-bottom: 1px solid #dee2e6; 
                                    background-color: #f8d7da;
                                    color: #721c24;
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: space-between;'>
                                    <h5 style='margin: 0; font-size: 18px; font-weight: bold;'>
                                        <i class='fas fa-exclamation-triangle' style='margin-right: 8px;'></i>
                                        Error
                                    </h5>
                                    <button type='button' style='
                                        background: none; 
                                        border: none; 
                                        font-size: 20px; 
                                        line-height: 1; 
                                        color: #721c24; 
                                        cursor: pointer;' 
                                        onclick='this.parentElement.parentElement.remove()'>
                                        ×
                                    </button>
                                </div>
                                <!-- Modal Body -->
                                <div style='padding: 20px; text-align: center;'>
                                    <p style='margin: 0; font-size: 16px; color: #495057;'>
                                        The provided dates overlap with an existing service record.
                                    </p>
                                </div>
                                <!-- Modal Footer -->
                                <div style='
                                    padding: 15px; 
                                    border-top: 1px solid #dee2e6; 
                                    background-color: #f8f9fa; 
                                    text-align: center;'>
                                    <button type='button' style='
                                        padding: 10px 20px; 
                                        background-color: #007bff; 
                                        border: none; 
                                        color: white; 
                                        border-radius: 5px; 
                                        font-size: 14px; 
                                        cursor: pointer;' 
                                        onclick='this.parentElement.parentElement.remove()'>
                                        Close
                                    </button>
                                </div>
                            </div>
                            <script>
                                // Automatically close the modal after 5 seconds
                                setTimeout(() => {
                                    const modal = document.querySelector('div[style*=\"z-index: 1050\"]');
                                    if (modal) modal.remove();
                                }, 10000);
                            </script>";
                        } else {
                            // Insert the service record
                            $stmt = $conn->prepare("INSERT INTO service_record (personnel_id, startDate, endDate, position, company) VALUES (?, ?, ?, ?, ?)");
                            $stmt->bind_param("issss", $personnel_id, $start_date, $end_date, $position, $company);
    
                            if ($stmt->execute()) {
                                echo "<script>window.location.href='http://192.168.1.96/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
                                $stmt->close();
                            } else {
                                echo "<script>alert('Error: Unable to add service record. {$stmt->error}');</script>";
                            }
                        }
                    } else {
                        echo "<script>alert('Error: Employee not found.');</script>";
                    }
                } else {
                    echo "<script>alert('Error: Emp_No is missing.');</script>";
                }
            }
        } else {
            echo "<script>alert('Error: All fields are required.');</script>";
        }
    }
    } if (isset($_POST['edit_service_record']) && $_POST['edit_service_record'] == '1') {
        $record_id = $_POST['record_id'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $position = $_POST['position'];
        $company = $_POST['company'];
    
        if (!empty($record_id) && !empty($start_date) && !empty($end_date) && !empty($position) && !empty($company)) {
            $stmt = $conn->prepare("UPDATE service_record SET startDate = ?, endDate = ?, position = ?, company = ? WHERE record_id = ?");
            $stmt->bind_param("ssssi", $start_date, $end_date, $position, $company, $record_id);
    
            if ($stmt->execute()) {
                error_log("Service Record Updated: ID $record_id"); // Debug: Log the updated record_id
                $stmt->close();
                echo "<script>window.location.href='http://192.168.1.96/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
                exit();
            } else {
                echo "<script>alert('Error: Unable to update service record. {$stmt->error}');</script>";
            }
        } else {
            echo "<script>alert('Error: All fields are required for editing.');</script>";
        }
    } if (isset($_POST['delete_service_record']) && $_POST['delete_service_record'] == '1') {
        $record_id = $_POST['record_id'];
    
        if (!empty($record_id)) {
            error_log("Deleting Service Record with ID: $record_id"); // Debug: Log the record_id
            $stmt = $conn->prepare("DELETE FROM service_record WHERE record_id = ?");
            $stmt->bind_param("i", $record_id);
    
            if ($stmt->execute()) {
                $stmt->close();
                echo "<script>window.location.href='http://192.168.1.96/ICWS-Personnel-Profiling/src/components/profile.php?Emp_No=" . urlencode($emp_no) . "';</script>";
                exit();
            } else {
                echo "<script>alert('Error: Unable to delete service record. {$stmt->error}');</script>";
            }
        } else {
            echo "<script>alert('Error: Record ID is missing for deletion.');</script>";
        }
    }
ob_end_flush(); // Flush the output buffer
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Record</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Custom CSS */
        .table-container {
            margin-top: 15px;
        }
        .modal-header {
            background-color: #f8f9fa;
        }
        .btn-custom i {
            margin-right: 5px;
        }
        .form-label {
            font-weight: bold;
        }
        .modal-footer .btn {
            min-width: 100px;
        }
    </style>
</head>
<body>
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold">Service Record</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceRecordModal">
            <i class="fas fa-plus"></i> Add Service Record
        </button>
    </div>
    <div class="table-container">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Position</th>
                    <th>Division</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pagedRecords as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['start']) ?></td>
                        <td><?= htmlspecialchars($record['end']) ?></td>
                        <td><?= htmlspecialchars($record['position']) ?></td>
                        <td><?= htmlspecialchars($record['company']) ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editServiceRecordModal<?= $record['record_id'] ?>">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteServiceRecordModal<?= $record['record_id'] ?>">Delete</button>
                        </td>
                    </tr>
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editServiceRecordModal<?= $record['record_id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form method="POST" action="">
                                <input type="hidden" name="edit_service_record" value="1">
                                <input type="hidden" name="record_id" value="<?= htmlspecialchars($record['record_id']); ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Service Record</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Start Date</label>
                                                <input type="date" class="form-control" name="start_date" value="<?= htmlspecialchars($record['start']); ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">End Date</label>
                                                <input type="date" class="form-control" name="end_date" value="<?= htmlspecialchars($record['end']); ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Position</label>
                                                <input type="text" class="form-control" name="position" value="<?= htmlspecialchars($record['position']); ?>" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Company</label>
                                                <input type="text" class="form-control" name="company" value="<?= htmlspecialchars($record['company']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteServiceRecordModal<?= $record['record_id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="">
                                <input type="hidden" name="delete_service_record" value="1">
                                <input type="hidden" name="record_id" value="<?= htmlspecialchars($record['record_id']); ?>">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Service Record</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this service record?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Service Record Modal -->
<div class="modal fade" id="addServiceRecordModal" tabindex="-1" aria-labelledby="addServiceRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceRecordModalLabel">Add Service Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <input type="hidden" name="submit_service_record" value="1">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="company" class="form-label">Division</label>
                            <input type="text" class="form-control" id="company" name="company" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>