<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../../backend/db.php';

$emp_no = $_GET['Emp_No'] ?? null;
$pagedRecords = []; 

if ($emp_no) {
    // Get personnel_id for this Emp_No
    $stmt = $conn->prepare("
    SELECT c.certificatecomp_id, c.date, c.date_usage, c.ActJust, c.remarks, c.earned_hours, c.used_hours
    FROM coc c
    INNER JOIN job_order j ON c.jo_id = j.jo_id
    INNER JOIN personnel p ON j.personnel_id = p.personnel_id
    WHERE p.Emp_No = ?
    ");

    $stmt->bind_param("s", $emp_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $pagedRecords = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Handle Add
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service_record'])) {
    $date = $_POST["startingDate"];
    $date_usage = $_POST["endDate"];
    $ActJust = $_POST["ActJust"];
    $remarks = $_POST["remarks"];
    $jo_id = $_POST["jo_id"];
    $earned_hours = $_POST["earned_hours"] ?? 0;
    $used_hours = $_POST["used_hours"] ?? 0;

    // Error trapping
    $errors = [];

    // Validate required fields
    if (!$jo_id) $errors[] = "Job Order ID (jo_id) is required.";
    if (!$date || !$date_usage) $errors[] = "Both are required.";
    if ($date >= $date_usage) $errors[] = "Date of CTO must be before the date of usage.";

    // Limit: COC record should not exceed 1 year from starting date
    $start = new DateTime($date);
    $end = new DateTime($date_usage);
    $interval = $start->diff($end);
    if ($interval->y > 1 || ($interval->y == 1 && ($interval->m > 0 || $interval->d > 0))) {
        $errors[] = "COC record duration must not exceed 1 year.";
    }
    
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'><ul>";
        foreach ($errors as $err) echo "<li>" . htmlspecialchars($err) . "</li>";
        echo "</ul></div>";
    } else {
        // Insert using jo_id
        $stmt = $conn->prepare("INSERT INTO coc (jo_id, date, date_usage, ActJust, remarks, earned_hours, used_hours) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssdd", $jo_id, $date, $date_usage, $ActJust, $remarks, $earned_hours, $used_hours);

        if ($stmt->execute()) {
            echo "<script>window.location.href = '?Emp_No=" . urlencode($emp_no) . "';</script>";
            exit();
        } else {
            echo "<script>alert('Error: Unable to add service record. {$stmt->error}');</script>";
        }
    }
}
// handle EDIT
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_service_record'])) {
    $id = $_POST['certificatecomp_id'];
    $date = $_POST["startingDate"];
    $date_usage = $_POST["endDate"];
    $ActJust = $_POST["ActJust"];
    $remarks = $_POST["remarks"];
    $earned_hours = $_POST["earned_hours"] ?? 0;
    $used_hours = $_POST["used_hours"] ?? 0;

    $stmt = $conn->prepare("UPDATE coc SET date=?, date_usage=?, ActJust=?, remarks=?, earned_hours=?, used_hours=? WHERE certificatecomp_id=?");
    $stmt->bind_param("ssssddi", $date, $date_usage, $ActJust, $remarks, $earned_hours, $used_hours, $id);

    if ($stmt->execute()) {
        echo "<script>window.location.href = '?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to update service record. {$stmt->error}');</script>";
    }
}

// Handle Delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_service_record'])) {
    $id = $_POST['certificatecomp_id'];
    $stmt = $conn->prepare("DELETE FROM coc WHERE certificatecomp_id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>window.location.href = '?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete service record. {$stmt->error}');</script>";
    }
}

// Get personnel_id for this Emp_No
$personnel_id = null;
if ($emp_no) {
$stmt = $conn->prepare("SELECT personnel_id FROM personnel WHERE Emp_No = ?");
$stmt->bind_param("s", $emp_no);
$stmt->execute();
$stmt->bind_result($personnel_id);
$stmt->fetch();
$stmt->close();
}

$jo_id = null;
if ($personnel_id) {
    $stmt = $conn->prepare("SELECT jo_id FROM job_order WHERE personnel_id = ? ORDER BY jo_id DESC LIMIT 1");
    $stmt->bind_param("i", $personnel_id);
    $stmt->execute();
    $stmt->bind_result($jo_id);
    $stmt->fetch();
    $stmt->close();
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service Contracts</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <style>
    body {
      font-family: 'Arial';
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 20px;
    }
    .dataTables_wrapper .dataTables_filter {
      float: right;
    }
    .dataTables_wrapper .dataTables_paginate {
      float: right;
    }
    .btn-add {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold">COC Service Record</h5>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceRecordModal">
                <i class="fas fa-plus"></i> Add COC Record
            </button>
            <a href="http://localhost/ICWS-Personnel-Profiling/src/components/cocprint.php?Emp_No=<?= urlencode($emp_no) ?>" target="_blank" class="btn btn-info btn-sm text-gray">
                <i class="fas fa-print"></i> Print COC
            </a>
        </div>
    </div>
    <div class="table-container">
        <table class="table table-bordered">
        <thead class="table-dark">
                <tr>
                    <th>Date of CTO</th>
                    <th>Earned COC</th>
                    <th>Date of Usage</th>
                    <th>Remaining COC</th>
                    <th>Title of Activity</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
                </thead>
            <tbody>
                <?php foreach ($pagedRecords as $record): ?>
                    <tr>
                            <td><?= htmlspecialchars($record['date']) ?></td>
                            <td><?= htmlspecialchars($record['earned_hours'] ?? '') ?></td>
                            <td><?= htmlspecialchars($record['date_usage']) ?></td>
                            <td><?= htmlspecialchars($record['used_hours'] ?? '') ?></td>
                            <td><?= htmlspecialchars($record['ActJust'] ?? '') ?></td>
                            <td><?= htmlspecialchars($record['remarks'] ?? 'Approved') ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editServiceRecordModal<?= $record['certificatecomp_id'] ?>">Edit</button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteServiceRecordModal<?= $record['certificatecomp_id'] ?>">Delete</button>
                            </td>
                            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editServiceRecordModal<?= $record['certificatecomp_id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="">
                        <input type="hidden" name="edit_service_record" value="1">
                        <input type="hidden" name="certificatecomp_id" value="<?= htmlspecialchars($record['certificatecomp_id']); ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Service Record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="datetime-local" class="form-control" name="startingDate"
                                        value="<?= date('Y-m-d\TH:i', strtotime($record['startingDate'])) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="datetime-local" class="form-control" name="endDate"
                                        value="<?= date('Y-m-d\TH:i', strtotime($record['endDate'])) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Earned Hours</label>
                                    <input type="number" class="form-control" name="earned_hours"
                                        value="<?= htmlspecialchars($record['earned_hours']) ?>" step="0.01" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Used Hours</label>
                                    <input type="number" class="form-control" name="used_hours"
                                        value="<?= htmlspecialchars($record['used_hours']) ?>" step="0.01" min="0" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Title of Activity</label>
                                    <textarea class="form-control" name="ActJust"><?= htmlspecialchars($record['ActJust']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <select class="form-select" id="remarks" name="remarks" required>
                                        <option value="Approved" <?= ($record['remarks'] === 'Approved' ? 'selected' : '') ?>>Approved</option>
                                        <option value="Reject" <?= ($record['remarks'] === 'Reject' ? 'selected' : '') ?>>Reject</option>
                                    </select>
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
                                <div class="modal fade" id="deleteServiceRecordModal<?= $record['certificatecomp_id'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="">
                                            <input type="hidden" name="delete_service_record" value="1">
                                            <input type="hidden" name="certificatecomp_id" value="<?= htmlspecialchars($record['certificatecomp_id']); ?>">
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
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="">
        <input type="hidden" name="add_service_record" value="1">
        <input type="hidden" name="jo_id" value="<?= htmlspecialchars($jo_id ?? '') ?>">

        <div class="modal-header">
          <h5 class="modal-title" id="addServiceRecordModalLabel">Add COC Record for <?= htmlspecialchars($emp_no) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="startingDate" class="form-label">Date of CTO</label>
            <input type="date" class="form-control" id="startingDate" name="startingDate" required>
          </div>
          <div class="mb-3">
            <label for="earned_hours" class="form-label">Earned COC</label>
            <input type="number" class="form-control" id="earned_hours" name="earned_hours" required>
          </div>
          <div class="mb-3">
            <label for="endDate" class="form-label">Date of Usage</label>
            <input type="date" class="form-control" id="endDate" name="endDate" required>
          </div>
          <div class="mb-3">
            <label for="used_hours" class="form-label">Remaining Hours</label>
            <input type="number" class="form-control" id="used_hours" name="used_hours"required>
          </div>
          <div class="mb-3">
            <label for="ActJust" class="form-label">Title of Activity</label>
            <textarea class="form-control" id="ActJust" name="ActJust" rows="2"></textarea>
          </div>
                    <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <select class="form-select" id="remarks" name="remarks" required>
                <option value="Approved">Approved</option>
                <option value="Reject">Reject</option>
            </select>
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