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
$employment_type = null;
$personnel_id = null;

if ($emp_no) {
    // Get personnel_id and employment type
    $stmt = $conn->prepare("SELECT personnel_id, emp_type FROM personnel WHERE Emp_No = ?");
    $stmt->bind_param("s", $emp_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $person = $result->fetch_assoc();
    $stmt->close();

    $personnel_id = $person['personnel_id'] ?? null;
    $employment_type = strtolower($person['emp_type'] ?? '');

    if ($employment_type === 'regular') {
        $stmt = $conn->prepare("
            SELECT certificatecomp_id, date, date_usage, ActJust, remarks, earned_hours, used_hours
            FROM coc
            WHERE personnel_id = ?
            ORDER BY date DESC
        ");
        $stmt->bind_param("i", $personnel_id);
    } else {
        $stmt = $conn->prepare("
            SELECT c.certificatecomp_id, c.date, c.date_usage, c.ActJust, c.remarks, c.earned_hours, c.used_hours
            FROM coc c
            INNER JOIN job_order j ON c.jo_id = j.jo_id
            INNER JOIN personnel p ON j.personnel_id = p.personnel_id
            WHERE p.Emp_No = ?
        ");
        $stmt->bind_param("s", $emp_no);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $pagedRecords = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Handle Add COC Record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service_record'])) {
    // Retrieve values
    $date = $_POST["startingDate"];
    $date_usage = $_POST["endDate"] ?? null;
    $ActJust = $_POST["ActJust"];
    $remarks = $_POST["remarks"];
    $jo_id = $_POST["jo_id"] ?? null;
    $personnel_id = $_POST["personnel_id"] ?? null;
    $employment_type = $_POST["employment_type"] ?? null;
    $earned_hours = $_POST["earned_hours"] ?? null;
    $used_hours = $_POST["used_hours"] ?? 0;

    // Error trapping
    $errors = [];

    // Validate required fields
    if ($employment_type === 'regular') {
        if (!$personnel_id) $errors[] = "Personnel ID is required for regular employees.";
    } else {
        if (!$jo_id) $errors[] = "Job Order ID (jo_id) is required.";
    }

    // Optional: Date validations
    if (!$date || !$date_usage) $errors[] = "Both CTO Date and Usage Date are required.";
    if ($date && $date_usage && $date >= $date_usage) {
        $errors[] = "Date of CTO must be before the date of usage.";
    }

    // Check duration limit
    if ($date && $date_usage) {
        $start = new DateTime($date);
        $end = new DateTime($date_usage);
        $interval = $start->diff($end);
        if ($interval->y > 1 || ($interval->y == 1 && ($interval->m > 0 || $interval->d > 0))) {
            $errors[] = "COC record duration must not exceed 1 year.";
        }
    }

    // Show errors
    if (!empty($errors)) {
        echo "<div class='alert alert-danger'><ul>";
        foreach ($errors as $err) echo "<li>" . htmlspecialchars($err) . "</li>";
        echo "</ul></div>";
    } else {
        // Insert logic
        if ($employment_type === 'regular') {
            $stmt = $conn->prepare("INSERT INTO coc (personnel_id, date, date_usage, ActJust, remarks, earned_hours, used_hours)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("issssdd", $personnel_id, $date, $date_usage, $ActJust, $remarks, $earned_hours, $used_hours);
        } else {
            $stmt = $conn->prepare("INSERT INTO coc (jo_id, date, date_usage, ActJust, remarks, earned_hours, used_hours)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssdd", $jo_id, $date, $date_usage, $ActJust, $remarks, $earned_hours, $used_hours);
        }

       if ($stmt->execute()) {
            echo "<script>window.location.href = '?Emp_No=" . urlencode($emp_no) . "';</script>";
            exit();
        } else {
            die("❌ MySQL Error: " . $stmt->error);
        }
    }
}

// Handle Edit COC Record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_service_record'])) {
    $id = $_POST['certificatecomp_id'];
    $date = $_POST["startingDate"];
    $date_usage = $_POST["endDate"];
    $ActJust = $_POST["ActJust"];
    $remarks = $_POST["remarks"];
    $earned_hours = $_POST["earned_hours"] ?? 0;
    $used_hours = $_POST["used_hours"] ?? 0;

    $stmt = $conn->prepare("UPDATE coc SET date=?, date_usage=?, ActJust=?, remarks=?, earned_hours=?, used_hours=?
                            WHERE certificatecomp_id=?");
    $stmt->bind_param("ssssddi", $date, $date_usage, $ActJust, $remarks, $earned_hours, $used_hours, $id);

if ($stmt->execute()) {
    echo "<script>window.location.href = '?Emp_No=" . urlencode($emp_no) . "';</script>";
    exit();
    } else {
        echo "<script>alert('Error: Unable to update service record. {$stmt->error}');</script>";
    }
}

// Handle Edit Work Experience
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_work_experience'])) {
    $experience_id = $_POST["experience_id"];
    $date_from = $_POST["date_from"];
    $date_to = $_POST["date_to"];
    $position_title = $_POST["position_title"];
    $department = $_POST["department"];
    $monthly_salary = $_POST["monthly_salary"];

   $stmt = $conn->prepare("UPDATE jo_work_experience SET date_from=?, date_to=?, position_title=?, department=?, monthly_salary=? WHERE experience_id=?");
    $stmt->bind_param("ssssdi", $date_from, $date_to, $position_title, $department, $monthly_salary, $experience_id);

    if ($stmt->execute()) {
        echo "<script>location.href='?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to update work experience. {$stmt->error}');</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_work_experience'])) {
    $experience_id = $_POST["experience_id"];

    $stmt = $conn->prepare("DELETE FROM jo_work_experience WHERE experience_id=?");
    $stmt->bind_param("i", $experience_id);

    if ($stmt->execute()) {
        echo "<script>location.href='?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to delete work experience. {$stmt->error}');</script>";
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_work_experience'])) {
    $date_from = $_POST["date_from"];
    $date_to = $_POST["date_to"];
    $position_title = $_POST["position_title"];
    $department = $_POST["department"];
    $monthly_salary = $_POST["monthly_salary"];
    $personnel_id = $_POST["personnel_id"];

    $stmt = $conn->prepare("INSERT INTO jo_work_experience (personnel_id, date_from, date_to, position_title, department, monthly_salary) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssd", $personnel_id, $date_from, $date_to, $position_title, $department, $monthly_salary);

    if ($stmt->execute()) {
        echo "<script>location.href='?Emp_No=" . urlencode($emp_no) . "';</script>";
        exit();
    } else {
        echo "<script>alert('Error: Unable to add work experience. {$stmt->error}');</script>";
    }
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
  <title>Service Contracts</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold">COC Service Record</h5>
    <div>
      <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceRecordModal">
        <i class="fas fa-plus"></i> Add COC Record
      </button>

      <?php if ($employment_type === 'regular'): ?>
        <a href="cocprint.php?Emp_No=<?= urlencode($emp_no) ?>&type=regular" class="btn btn-info btn-sm" target="_blank">
          <i class="fas fa-print"></i> Print COC
        </a>
      <?php elseif (in_array($employment_type, ['job order', 'job_order', 'joborder'])): ?>
        <a href="cocprint.php?Emp_No=<?= urlencode($emp_no) ?>&type=jo" class="btn btn-info btn-sm" target="_blank">
          <i class="fas fa-print"></i> Print COC
        </a>
      <?php endif; ?>
    </div>
  </div>


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
      <?php if (!empty($pagedRecords)): ?>
        <?php foreach ($pagedRecords as $record): ?>
          <tr>
            <td>
              <?php
                if (!empty($record['date'])) {
                  $dt = DateTime::createFromFormat('Y-m-d', $record['date']);
                  echo $dt ? $dt->format('m/d/Y') : htmlspecialchars($record['date']);
                } else {
                  echo '';
                }
              ?>
            </td>
            <td>
              <?= ($record['earned_hours'] !== null && $record['earned_hours'] !== '') ? htmlspecialchars((string)$record['earned_hours']) : '' ?>
            </td>
            <td>
              <?php
                if (!empty($record['date_usage']) && $record['date_usage'] !== '0000-00-00') {
                  $dt = DateTime::createFromFormat('Y-m-d', $record['date_usage']);
                  echo $dt ? $dt->format('m/d/Y') : htmlspecialchars($record['date_usage']);
                } else {
                  echo '';
                }
              ?>
            </td>
            <td><?= htmlspecialchars((string)($record['used_hours'] ?? '')) ?></td>
            <td><?= htmlspecialchars($record['ActJust'] ?? '') ?></td>
            <td><?= htmlspecialchars($record['remarks'] ?? '') ?></td>
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
                <input type="hidden" name="certificatecomp_id" value="<?= htmlspecialchars($record['certificatecomp_id'] ?? '') ?>">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Service Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                        <label for="startingDate<?= $record['certificatecomp_id'] ?>" class="form-label">Date of CTO</label>
                        <input type="date" class="form-control" id="startingDate<?= $record['certificatecomp_id'] ?>" name="startingDate" value="<?= htmlspecialchars($record['date'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="earned_hours<?= $record['certificatecomp_id'] ?>" class="form-label">Earned COC</label>
                        <input type="number" step="0.01" class="form-control" id="earned_hours<?= $record['certificatecomp_id'] ?>" name="earned_hours" value="<?= htmlspecialchars((string)($record['earned_hours'] ?? '')) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="endDate<?= $record['certificatecomp_id'] ?>" class="form-label">Date of Usage</label>
                        <input type="date" class="form-control" id="endDate<?= $record['certificatecomp_id'] ?>" name="endDate" value="<?= htmlspecialchars($record['date_usage'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label for="used_hours<?= $record['certificatecomp_id'] ?>" class="form-label">Remaining COC</label>
                        <input type="number" step="0.01" class="form-control" id="used_hours<?= $record['certificatecomp_id'] ?>" name="used_hours" value="<?= htmlspecialchars((string)($record['used_hours'] ?? '')) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ActJust<?= $record['certificatecomp_id'] ?>" class="form-label">Title of Activity</label>
                        <textarea class="form-control" id="ActJust<?= $record['certificatecomp_id'] ?>" name="ActJust" rows="2"><?= htmlspecialchars($record['ActJust'] ?? '') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="remarks<?= $record['certificatecomp_id'] ?>" class="form-label">Remarks</label>
                        <select class="form-select" id="remarks<?= $record['certificatecomp_id'] ?>" name="remarks">
                        <option value="Approved" <?= ($record['remarks'] ?? '') === 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="Reject" <?= ($record['remarks'] ?? '') === 'Reject' ? 'selected' : '' ?>>Reject</option>
                        </select>
                    </div>
                    </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
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
                  <div class="modal-body">Are you sure you want to delete this record?</div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7" class="text-center">No COC records found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

<!-- Add COC Record Modal -->
<div class="modal fade" id="addServiceRecordModal" tabindex="-1" aria-labelledby="addServiceRecordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <!-- Hidden Fields for Identification -->
      <input type="hidden" name="add_service_record" value="1">
      <input type="hidden" name="employment_type" value="<?= $employment_type ?>">
      <input type="hidden" name="personnel_id" value="<?= $personnel_id ?>">
      <input type="hidden" name="jo_id" value="<?= htmlspecialchars($jo_id ?? '') ?>">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addServiceRecordModalLabel">Add COC Record</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="startingDate" class="form-label">Date of CTO</label>
            <input type="date" class="form-control" id="startingDate" name="startingDate">
          </div>
          <div class="mb-3">
            <label for="earned_hours" class="form-label">Earned COC</label>
            <input type="number" class="form-control" id="earned_hours" name="earned_hours">
          </div>
          <div class="mb-3">
            <label for="endDate" class="form-label">Date of Usage</label>
            <input type="date" class="form-control" id="endDate" name="endDate">
          </div>
          <div class="mb-3">
            <label for="used_hours" class="form-label">Used COC</label>
            <input type="number" class="form-control" id="used_hours" name="used_hours">
          </div>
          <div class="mb-3">
            <label for="ActJust" class="form-label">Title of Activity</label>
            <textarea class="form-control" id="ActJust" name="ActJust" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <select class="form-select" id="remarks" name="remarks">
              <option value="Approved">Approved</option>
              <option value="Reject">Reject</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Record</button>
        </div>
      </div>
    </form>
  </div>
</div>



<!-- Add Work Experience Modal -->
<div class="modal fade" id="addWorkExperienceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <input type="hidden" name="add_work_experience" value="1">
      <input type="hidden" name="personnel_id" value="<?= htmlspecialchars($personnel_id ?? '') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Work Experience</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Date From</label>
            <input type="date" name="date_from" class="form-control" value="<?= htmlspecialchars($_POST['date_from'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Date To</label>
            <input type="date" name="date_to" class="form-control" value="<?= htmlspecialchars($_POST['date_to'] ?? '') ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Position Title</label>
            <input type="text" name="position_title" value="<?= htmlspecialchars($_POST['position_title'] ?? '') ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Department</label>
            <input type="text" name="department" value="<?= htmlspecialchars($_POST['department'] ?? '') ?>" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Monthly Salary</label>
            <input type="number" step="0.01" name="monthly_salary" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php if (in_array($employment_type, ['job order', 'job_order', 'joborder'])): ?>
<!-- Job Order Work Experience Section -->
<div class="d-flex justify-content-between align-items-center mt-4 mb-2">
  <h5 class="fw-bold">Job Order Work Experience</h5>
  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">
    <i class="fas fa-plus"></i> Add Work Experience
  </button>
</div>

<table class="table table-bordered">
  <thead class="table-dark">
    <tr>
      <th>Date From</th>
      <th>Date To</th>
      <th>Position Title</th>
      <th>Department</th>
      <th>Monthly Salary</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($personnel_id) {
        $stmt = $conn->prepare("SELECT experience_id, date_from, date_to, position_title, department, monthly_salary FROM jo_work_experience WHERE personnel_id = ?");
        $stmt->bind_param("i", $personnel_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . (!empty($row['date_from']) ? DateTime::createFromFormat('Y-m-d', $row['date_from'])->format('m/d/Y') : '') . "</td>";
                echo "<td>" . (!empty($row['date_to']) ? DateTime::createFromFormat('Y-m-d', $row['date_to'])->format('m/d/Y') : '') . "</td>";
                echo "<td>" . htmlspecialchars($row['position_title'] ?? '') . "</td>";
                echo "<td>" . htmlspecialchars($row['department'] ?? '') . "</td>";
                echo "<td>₱" . number_format($row['monthly_salary'] ?? 0, 2) . "</td>";
                echo "<td>
                    <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editWorkExpModal{$row['experience_id']}'>Edit</button>
                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteWorkExpModal{$row['experience_id']}'>Delete</button>
                </td>";
                echo "</tr>";

                $editModals[] = $row; // for modal rendering below
            }
        } else {
            echo '<tr><td colspan="6" class="text-center">No work experience found.</td></tr>';
        }

        $stmt->close();
    } else {
        echo '<tr><td colspan="6" class="text-center">Personnel ID not found.</td></tr>';
    }
    ?>
  </tbody>
</table>

<?php if (!empty($editModals)): ?>
  <?php foreach ($editModals as $row): ?>
    <!-- Edit Modal -->
    <div class="modal fade" id="editWorkExpModal<?= $row['experience_id'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="">
          <input type="hidden" name="edit_work_experience" value="1">
          <input type="hidden" name="experience_id" value="<?= $row['experience_id'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Work Experience</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-2"><label>Date From</label><input type="date" name="date_from" value="<?= $row['date_from'] ?>" class="form-control"></div>
              <div class="mb-2"><label>Date To</label><input type="date" name="date_to" value="<?= $row['date_to'] ?>" class="form-control"></div>
              <div class="mb-2"><label>Position Title</label><input type="text" name="position_title" value="<?= htmlspecialchars($row['position_title'] ?? '') ?>" class="form-control"></div>
              <div class="mb-2"><label>Department</label><input type="text" name="department" value="<?= htmlspecialchars($row['department'] ?? '') ?>" class="form-control"></div>
              <div class="mb-2"><label>Monthly Salary</label><input type="number" name="monthly_salary" step="0.01" value="<?= $row['monthly_salary'] ?>" class="form-control"></div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteWorkExpModal<?= $row['experience_id'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="">
          <input type="hidden" name="delete_work_experience" value="1">
          <input type="hidden" name="experience_id" value="<?= $row['experience_id'] ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Deletion</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">Are you sure you want to delete this record?</div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Delete</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- Edit Modal -->
<div class="modal fade" id="editWorkExpModal<?= $row['experience_id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="">
      <input type="hidden" name="edit_work_experience" value="1">
      <input type="hidden" name="experience_id" value="<?= htmlspecialchars($row['experience_id'] ?? '') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Work Experience</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Date From</label>
            <input type="date" name="date_from" value="<?= htmlspecialchars($row['date_from'] ?? '') ?>" class="form-control">
          </div>
          <div class="mb-2">
            <label>Date To</label>
            <input type="date" name="date_to" value="<?= htmlspecialchars($row['date_to'] ?? '') ?>" class="form-control">
          </div>
          <div class="mb-2">
            <label>Position Title</label>
            <input type="text" name="position_title" value="<?= htmlspecialchars($row['position_title'] ?? '') ?>" class="form-control">
          </div>
          <div class="mb-2">
            <label>Department</label>
            <input type="text" name="department" value="<?= htmlspecialchars($row['department'] ?? '') ?>" class="form-control">
          </div>
          <div class="mb-2">
            <label>Monthly Salary</label>
            <input type="number" name="monthly_salary" step="0.01" value="<?= htmlspecialchars($row['monthly_salary'] ?? '0') ?>" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>