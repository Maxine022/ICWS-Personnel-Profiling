<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';
$conn->set_charset('utf8mb4');

$jobOrders = [];

$result = $conn->query("
  SELECT 
    p.Emp_No,
    p.full_name,
    p.sex,
    p.birthdate,
    p.contact_number,
    p.address,
    p.position,
    p.division,
    jo.salaryRate AS salaryRate
  FROM job_order jo
  JOIN personnel p ON jo.personnel_id = p.personnel_id
  ORDER BY p.full_name ASC
  ");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobOrders[] = $row;
    }
} else {
    echo "No records found.";
    var_dump($result); // Log the result
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Job Order Employees</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS Libraries -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
  
  <style>
    body { 
      font-family: Arial; 
    }
    .content {
      padding: 30px;
    }
    .container {
    margin-top: 20px;
    }
    .form-label {
      font-weight: bold;
    }
    .table-container {
      margin-top: 30px;
    }
    .breadcrumb-link {
      color: inherit;
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .breadcrumb-link:hover {
      color: #007bff;
      text-decoration: underline;
    }
    .view-link {
      color: #0d6efd;
      text-decoration: none;
      transition: color 0.2s ease, text-decoration 0.2s ease;
    }
    .view-link:hover {
      color: #0a58ca;
      text-decoration: underline;
    }
    .search-buttons-container {
      margin-top: 25px;
    }
    .shadow-custom {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    #personnelTable_wrapper {
      overflow-x: auto; /* Enables horizontal scrolling if the table overflows */
    }
  </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0 fw-bold">Manage Job Order Employees</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://localhost/ICWS-Personnel-Profiling/src/components/personnel_record.php">Manage Personnel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Job Order</li>
      </ol>
    </nav>
  </div>

  <div class="search-buttons-container row align-items-center mb-4">
    <div class="col-md-6 d-flex align-items-center gap-2">
      <label for="searchInput" class="form-label mb-0">Search:</label>
      <div id="customSearchContainer"></div>
    </div>

    <div class="col-md-6 text-end">
      <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
        <button class="btn btn-primary btn-sm" onclick="window.location.href='http://localhost/ICWS-Personnel-Profiling/src/components/add_jo.php'"><i class="fas fa-plus"></i> Add</button>
        <button class="btn btn-success btn-sm shadow-custom text-white" style="background-color: success;" data-bs-toggle="modal" data-bs-target="#uploadModal">
          <i class="fas fa-upload"></i> Upload File
        </button>

        <span class="vr d-none d-md-inline"></span>
        <button class="btn btn-outline-success export-btn btn-sm" data-type="csv">CSV</button>
        <button class="btn btn-warning btn-sm" onclick="window.location.href='http://localhost/ICWS-Personnel-Profiling/src/components/print.php'"">
          Print
        </button>
      </div>
    </div>
  </div>

  <div class="table-container">
    <table class="table table-striped table-bordered" id="personnelTable">
      <thead>
        <tr>
          <th>Emp No</th>
          <th>Full Name</th>
          <th>Sex</th>
          <th>Birthdate</th>
          <th>Contact Number</th>
          <th>Address</th>
          <th>Position</th>
          <th>Division</th>
          <th>Salary Rate</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($jobOrders as $index => $jo): ?>
        <tr>
          <td><?= htmlspecialchars($jo['Emp_No']) ?></td>
          <td><?= htmlspecialchars($jo['full_name']) ?></td>
          <td><?= htmlspecialchars($jo['sex']) ?></td>
          <td>
            <?= !empty($jo['birthdate']) 
                ? date('F d, Y', strtotime($jo['birthdate'])) 
                : 'N/A'; 
            ?>
          </td>
          <td><?= htmlspecialchars($jo['contact_number']) ?></td>
          <td><?= htmlspecialchars($jo['address']) ?></td>
          <td><?= htmlspecialchars($jo['position']) ?></td>
          <td><?= htmlspecialchars($jo['division']) ?></td>
          <td><?= htmlspecialchars($jo['salaryRate']) ?></td>
          <td><a href="profile.php?Emp_No=<?= urlencode($jo['Emp_No']) ?>" class="view-link">View Profile</a></td>
        </tr>
      <?php endforeach; ?>  
      </tbody>
    </table>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function () {
    const table = $('#personnelTable').DataTable({
        "pageLength": 10,
        "order": [[1, "asc"]],
        dom:
            "<'d-none'f>" +
            "<'row'<'col-12'tr>>" +
            "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>",
        buttons: [
            { extend: 'csv', className: 'd-none', title: 'Job Order Employees' },
            { extend: 'print', className: 'd-none', title: 'Job Order Employees' }
        ]
    });

    $('#customSearchContainer').append($('#personnelTable_filter input'));
    $('#personnelTable_filter').remove();

    $('.export-btn').on('click', function () {
        const type = $(this).data('type');
        table.button(`.buttons-${type}`).trigger();
    });
  });
</script>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow">
      <form action="uploadjO.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="uploadModalLabel">Upload Employee Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="data_file" class="form-label">Choose CSV File</label>
            <input type="file" class="form-control" id="data_file" name="data_file" accept=".csv" required>
            <small class="text-muted">Please upload a CSV file with the correct format.</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Upload</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>