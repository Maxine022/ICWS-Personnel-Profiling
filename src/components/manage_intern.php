<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

// Fetch interns data from the database
$interns = [];
$sql = "SELECT 
            intern_id,
            fullName,
            contactNo,
            school, 
            course,
            hoursNo,
            startDate,
            endDate,
            division, 
            supervisorName
        FROM intern";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $interns[] = $row;
    }
} else {
    // Handle no data or query error
    $error = $conn->error ? "Database Error: {$conn->error}" : "No interns found.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Interns</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body { 
      font-family: Arial; 
      font-size: 15px;
    }
    .content {
      padding: 30px;
    }
    .table-bordered td, .table-bordered th {
      border: 1px solid #dee2e6 !important;
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
    .table-container {
      margin-top: 15px;
    }
    .search-buttons-container {
      margin-top: 25px;
    }
    .table-container table td:last-child {
    white-space: nowrap; /* Prevent text wrapping */
    overflow: visible; /* Allow content to overflow */
    text-overflow: ellipsis; /* Add ellipsis for overflowed text */
    max-width: 150px; /* Set a max width for the cell */
    }
    .table-container table td:first-child {
      white-space: nowrap;
    }
  </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0" style="font-weight: bold;">Manage Interns</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://192.168.1.100/ICWS-Personnel-Profilingg/src/hero/home.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="http://192.168.1.100/ICWS-Personnel-Profiling/src/components/personnel_record.php">Manage Personnel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Interns</li>
      </ol>
    </nav>
  </div>

  <!-- Display Error if Exists -->
  <?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <div class="search-buttons-container row align-items-center mb-4">
    <div class="col-md-6 d-flex align-items-center gap-2">
      <label for="searchInput" class="form-label mb-0"><strong>Search:</strong></label>
      <div id="customSearchContainer"></div>
    </div>

    <div class="col-md-6 text-end">
      <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
        <button class="btn btn-primary btn-sm" onclick="window.location.href='http://192.168.1.100/ICWS-Personnel-Profiling/src/components/add_intern.php'"><i class="fas fa-plus"></i> Add</button>

      <span class="vr d-none d-md-inline"></span>
        <button class="btn btn-outline-success export-btn btn-sm" data-type="csv">CSV</button>
        <button class="btn btn-warning export-btn btn-sm" data-type="print">Print</button>
      </div>
    </div>
  </div>

  <div class="table-container">
    <table class="table table-striped table-bordered" id="personnelTable">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Contact Number</th>
          <th>School</th>
          <th>Course/Program</th>
          <th>Hours</th>
          <th>Period</th>
          <th>Division</th>
          <th>Supervisor</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
    <?php foreach ($interns as $intern): ?>
        <tr id="row-<?= htmlspecialchars($intern['intern_id']) ?>">
            <td><?= htmlspecialchars($intern['fullName']) ?></td>
            <td><?= htmlspecialchars($intern['contactNo']) ?></td>
            <td><?= htmlspecialchars($intern['school']) ?></td>
            <td><?= htmlspecialchars($intern['course']) ?></td>
            <td><?= htmlspecialchars($intern['hoursNo']) ?></td>
            <td>
              <?= htmlspecialchars(date('F d, Y', strtotime($intern['startDate']))) ?> to 
              <?= htmlspecialchars(date('F d, Y', strtotime($intern['endDate']))) ?>
            </td>
            <td><?= htmlspecialchars($intern['division']) ?></td>
            <td><?= htmlspecialchars($intern['supervisorName']) ?></td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="window.location.href='http://192.168.1.100/ICWS-Personnel-Profiling/src/components/edit_intern.php?intern_id=<?= urlencode($intern['intern_id']) ?>'">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteIntern(<?= htmlspecialchars($intern['intern_id']) ?>)">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
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
<script>
  function editIntern(id) {
    window.location.href = `http://192.168.1.100/ICWS-Personnel-Profiling/src/components/edit_intern.php?id=${intern_id}`;
  }

  function deleteIntern(intern_id) {
  if (confirm("Are you sure you want to delete this intern?")) {
    fetch('http://192.168.1.100/ICWS-Personnel-Profiling/src/components/delete_intern.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ intern_id: intern_id }), // Corrected parameter name
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert(data.message);
          // Remove the row from the table
          document.querySelector(`#row-${intern_id}`).remove();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('An unexpected error occurred.');
      });
  }
}

  $(document).ready(function () {
    const table = $('#personnelTable').DataTable({
      dom:
        "<'d-none'f>" +
        "<'row'<'col-12'tr>>" +
        "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>",
      buttons: [
        { extend: 'csv', className: 'd-none', title: 'Interns' },
        { extend: 'print', className: 'd-none', title: 'Interns' }
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
</body>
</html>