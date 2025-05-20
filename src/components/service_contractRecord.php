<?php
include_once __DIR__ . '/../../backend/db.php'; // Include database connection

// Retrieve contractservice_id from GET or fallback variable
$contractservice_id = $_GET['contractservice_id'] ?? $contractservice_id_to_include ?? null;

// Debugging: Check if contractservice_id is set
echo "<!-- Debug: contractservice_id = " . ($contractservice_id ?? 'NOT SET') . " -->";

if (!$contractservice_id) {
    echo "<!-- No contractservice_id passed, but still rendering UI -->";
}


// Validate contractservice_id
$validate_query = $conn->prepare("SELECT COUNT(*) FROM contract_service WHERE contractservice_id = ?");
$validate_query->bind_param("i", $contractservice_id);
$validate_query->execute();
$validate_query->bind_result($count);
$validate_query->fetch();
$validate_query->close();

if ($count === 0) {
    echo "<div class='alert alert-warning'>Invalid contract service ID. Please ensure you are accessing this page with a valid contractservice_id.</div>";
    return;
}

// Initialize error messages
$errors = [];
$success_message = null;

// Handle form submission for adding a new contract record
if ($_SERVER["REQUEST_METHOD"] == "POST" && $contractservice_id && !isset($_POST['serviceRecord_id'])) {
    $contractStart = $_POST["contractStart"] ?? null;
    $contractEnd = $_POST["contractEnd"] ?? null;
    $remarks = $_POST["remarks"] ?? '';

    // Debugging
    echo "<!-- Debug: POST data = " . print_r($_POST, true) . " -->";

    // Validate form inputs
    if (empty($contractStart)) {
        $errors[] = "Contract Start date is required.";
    }
    if (empty($contractEnd)) {
        $errors[] = "Contract End date is required.";
    }

    if (empty($errors)) {
        $contractStart = date('Y-m-d', strtotime($contractStart));
        $contractEnd = date('Y-m-d', strtotime($contractEnd));
        $remarks = $conn->real_escape_string($remarks);

        $sql = "INSERT INTO contractservice_record (contractservice_id, contractStart, contractEnd, remarks) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $errors[] = "Error preparing statement for contractservice_record: " . $conn->error;
        } else {
            $stmt->bind_param("isss", $contractservice_id, $contractStart, $contractEnd, $remarks);
            if ($stmt->execute()) {
                $success_message = "Contract record added successfully!";
            } else {
                $errors[] = "Error executing statement: " . $stmt->error;
            }
        }
    }
}

// Handle form submission for updating an existing contract record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['serviceRecord_id']) && !isset($_POST['delete_service_record'])) {
    $serviceRecord_id = intval($_POST['serviceRecord_id']);
    $contractStart = $_POST["contractStart"] ?? null;
    $contractEnd = $_POST["contractEnd"] ?? null;
    $remarks = $_POST["remarks"] ?? '';

    // Validate inputs
    if (!empty($contractStart) && !empty($contractEnd)) {
        $contractStart = date('Y-m-d', strtotime($contractStart));
        $contractEnd = date('Y-m-d', strtotime($contractEnd));
        $remarks = $conn->real_escape_string($remarks);

        // Update the record in the database
        $stmt = $conn->prepare("UPDATE contractservice_record SET contractStart = ?, contractEnd = ?, remarks = ? WHERE serviceRecord_id = ?");
        if ($stmt) {
            $stmt->bind_param("sssi", $contractStart, $contractEnd, $remarks, $serviceRecord_id);
            if ($stmt->execute()) {
                $success_message = "Contract record updated successfully!";
            } else {
                $errors[] = "Error updating record: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Error preparing statement: " . $conn->error;
        }
    } else {
        $errors[] = "Both Contract Start and Contract End dates are required.";
    }
}

// Handle form submission for deleting a contract record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_service_record'])) {
    $serviceRecord_id = intval($_POST['serviceRecord_id']);

    // Delete the record from the database
    $stmt = $conn->prepare("DELETE FROM contractservice_record WHERE serviceRecord_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $serviceRecord_id);
        if ($stmt->execute()) {
            $success_message = "Contract record deleted successfully!";
        } else {
            $errors[] = "Error deleting record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $errors[] = "Error preparing statement: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service Contract Records</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold">Contract Service Records</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add Contract Record
        </button>
    </div>

    <!-- Display Success Message -->
    <?php if ($success_message): ?>
      <div class="alert alert-success">
        <?= htmlspecialchars($success_message) ?>
      </div>
    <?php endif; ?>

    <!-- Display Errors -->
    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <table id="serviceContractsTable" class="display nowrap" style="width:100%">
      <thead> 
        <tr>
          <th>Contract Start</th>
          <th>Contract End</th>
          <th>Remarks</th>
          <th>Actions</th>  
        </tr>
      </thead>
      <tbody>
        <?php
        if ($contractservice_id) {
            $stmt = $conn->prepare("SELECT serviceRecord_id, contractStart, contractEnd, remarks FROM contractservice_record WHERE contractservice_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $contractservice_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['contractStart']}</td>
                                <td>{$row['contractEnd']}</td>
                                <td>{$row['remarks']}</td>
                                <td>
                                  <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#editModal{$row['serviceRecord_id']}'>Edit</button>
                                  <button class='btn btn-sm btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal{$row['serviceRecord_id']}'>Delete</button>
                                </td>
                              </tr>";

                        // Edit Modal
                        echo "<div class='modal fade' id='editModal{$row['serviceRecord_id']}' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog'>
                                  <form method='POST' action=''>
                                    <input type='hidden' name='serviceRecord_id' value='{$row['serviceRecord_id']}'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title'>Edit Contract Record</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                      </div>
                                      <div class='modal-body'>
                                        <div class='mb-3'>
                                          <label for='contractStart' class='form-label'>Contract Start</label>
                                          <input type='date' class='form-control' name='contractStart' value='{$row['contractStart']}' required>
                                        </div>
                                        <div class='mb-3'>
                                          <label for='contractEnd' class='form-label'>Contract End</label>
                                          <input type='date' class='form-control' name='contractEnd' value='{$row['contractEnd']}' required>
                                        </div>
                                        <div class='mb-3'>
                                          <label for='remarks' class='form-label'>Remarks</label>
                                          <textarea class='form-control' name='remarks' rows='2'>{$row['remarks']}</textarea>
                                        </div>
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                        <button type='submit' class='btn btn-primary'>Save Changes</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>";

                        // Delete Modal
                        echo "<div class='modal fade' id='deleteModal{$row['serviceRecord_id']}' tabindex='-1' aria-hidden='true'>
                                <div class='modal-dialog'>
                                  <form method='POST' action=''>
                                    <input type='hidden' name='delete_service_record' value='1'>
                                    <input type='hidden' name='serviceRecord_id' value='{$row['serviceRecord_id']}'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title'>Delete Contract Record</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                      </div>
                                      <div class='modal-body'>
                                        Are you sure you want to delete this service record?
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                        <button type='submit' class='btn btn-danger'>Delete</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>";
                    }
                }
            }
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Add Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="">
          <div class="modal-header">
            <h5 class="modal-title" id="addModalLabel">Add New Contract Record</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="contractStart" class="form-label">Contract Start</label>
              <input type="date" class="form-control" id="contractStart" name="contractStart" required>
            </div>
            <div class="mb-3">
              <label for="contractEnd" class="form-label">Contract End</label>
              <input type="date" class="form-control" id="contractEnd" name="contractEnd" required>
            </div>
            <div class="mb-3">
              <label for="remarks" class="form-label">Remarks</label>
              <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Contract Record</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editServiceRecordId" name="serviceRecord_id">
            <div class="mb-3">
              <label for="editContractStart" class="form-label">Contract Start</label>
              <input type="date" class="form-control" id="editContractStart" name="contractStart" required>
            </div>
            <div class="mb-3">
              <label for="editContractEnd" class="form-label">Contract End</label>
              <input type="date" class="form-control" id="editContractEnd" name="contractEnd" required>
            </div>
            <div class="mb-3">
              <label for="editRemarks" class="form-label">Remarks</label>
              <textarea class="form-control" id="editRemarks" name="remarks" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#serviceContractsTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        paging: true,
        ordering: true,
        searching: false, // Disable the search functionality
      });
    });

    function openEditModal(record) {
      // Populate the modal fields with the record's data
      document.getElementById('editServiceRecordId').value = record.serviceRecord_id;
      document.getElementById('editContractStart').value = record.contractStart;
      document.getElementById('editContractEnd').value = record.contractEnd;
      document.getElementById('editRemarks').value = record.remarks;

      // Show the modal
      const editModal = new bootstrap.Modal(document.getElementById('editModal'));
      editModal.show();
    }

    function deleteRecord(serviceRecordId) {
      if (confirm("Are you sure you want to delete this record? This action cannot be undone.")) {
        // Redirect to a PHP script to handle deletion
        window.location.href = `http://192.168.1.26/ICWS-Personnel-Profiling/src/components/delete_contractRecord.php?serviceRecord_id=${serviceRecordId}`;
      }
    }
  </script>
</body>
</html>