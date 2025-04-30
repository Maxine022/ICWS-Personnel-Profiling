<?php
include_once __DIR__ . '/../../backend/db.php';

// Get personnel_id from GET or SESSION (adjust as needed)
$personnel_id = $_GET['personnel_id'] ?? null;

// Get contractservice_id for this personnel
$contract_service = null;
if ($personnel_id) {
    $stmt = $conn->prepare("SELECT contractservice_id FROM contract_service WHERE personnel_id = ?");
    $stmt->bind_param("i", $personnel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $contract_service = $result->fetch_assoc();
    $contractservice_id = $contract_service['contractservice_id'] ?? null;
} else {
    $contractservice_id = null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $contractservice_id) {
    $yearService = intval($_POST["yearService"]);
    $contractStart = date('Y-m-d', strtotime($_POST["contractStart"]));
    $contractEnd = date('Y-m-d', strtotime($_POST["contractEnd"]));
    $remarks = $conn->real_escape_string($_POST["remarks"]);

    $sql = "INSERT INTO contractservice_record (contractservice_id, yearService, contractStart, contractEnd, remarks) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $contractservice_id, $yearService, $contractStart, $contractEnd, $remarks);

    if ($stmt->execute()) {
        header("Location: service_contract.php?personnel_id=$personnel_id");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
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
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="fw-bold">Contract of Compensatory Record</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus"></i> Add Service Record
        </button>
    </div>
    <table id="serviceContractsTable" class="display nowrap" style="width:100%">
      <thead> 
        <tr>
          <th>Starting Date</th>
          <th>End Date</th>
          <th>Activity Justification</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT startingDate, endDate, ActJust, remarks FROM coc");
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['startingDate']}</td>
                    <td>{$row['endDate']}</td>
                    <td>{$row['ActJust']}</td>
                    <td>{$row['remarks']}</td>
                  </tr>";
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
            <h5 class="modal-title" id="addModalLabel">Add New Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="startingDate" class="form-label">Starting Date</label>
              <input type="datetime-local" class="form-control" id="startingDate" name="startingDate" required>
            </div>
            <div class="mb-3">
              <label for="endDate" class="form-label">End Date</label>
              <input type="datetime-local" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="mb-3">
              <label for="ActJust" class="form-label">Activity Justification</label>
              <textarea class="form-control" id="ActJust" name="ActJust" rows="2"></textarea>
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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#serviceContractsTable').DataTable({
        responsive: true,
        dom: 'Brtp',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
      });
    });
  </script>
</body>
</html>