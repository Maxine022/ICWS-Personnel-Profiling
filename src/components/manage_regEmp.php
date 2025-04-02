<?php
// Load regular employee data
$regulars = file_exists("regulars.json") ? json_decode(file_get_contents("regulars.json"), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Regular Employees</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

  <style>
    body { font-family: Arial; }
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
  </style>
</head>
<body>
<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<div class="content" id="content">
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h4 class="mb-0 fw-bold">Manage Regular Employees</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/index.php">Home</a></li>
        <li class="breadcrumb-item"><a class="breadcrumb-link" href="/src/components/personnel_record.php">Manage Personnel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Regular</li>
      </ol>
    </nav>
  </div>

  <div class="search-buttons-container row align-items-center mb-4">
    <div class="col-md-6 d-flex align-items-center gap-2">
      <label for="searchInput" class="form-label mb-0"><strong>Search:</strong></label>
      <div id="customSearchContainer"></div>
    </div>

    <div class="col-md-6 text-end">
      <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
        <button class="btn btn-primary btn-sm" onclick="window.location.href='/src/components/add_regular_employee.php'"><i class="fas fa-plus"></i> Add</button>
        <span class="vr d-none d-md-inline"></span>
        <button class="btn btn-outline-success export-btn btn-sm" data-type="csv">CSV</button>
        <button class="btn btn-danger export-btn btn-sm" data-type="pdf">PDF</button>
        <button class="btn btn-warning export-btn btn-sm" data-type="print">Print</button>
      </div>
    </div>
  </div>

  <div class="table-container">
    <table class="table table-striped table-bordered" id="personnelTable">
      <thead>
        <tr>
          <th>Emp No</th>
          <th>Full Name</th>
          <th>Position</th>
          <th>Division</th>
          <th>Plantilla Number</th>
          <th>Contact Number</th>
          <th>Salary Grade</th>
          <th>Step</th>
          <th>Level</th>
          <th>ACA Pera</th>
          <th>Monthly Salary</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($regulars as $emp): ?>
          <tr>
            <td><?= htmlspecialchars($emp['Emp No'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($emp['full_name']) ?></td>
            <td><?= htmlspecialchars($emp['position']) ?></td>
            <td><?= htmlspecialchars($emp['division']) ?></td>
            <td><?= htmlspecialchars($emp['plantilla_number']) ?></td>
            <td><?= htmlspecialchars($emp['contact_number']) ?></td>
            <td><?= htmlspecialchars($emp['salary_grade']) ?></td>
            <td><?= htmlspecialchars($emp['step']) ?></td>
            <td><?= htmlspecialchars($emp['level']) ?></td>
            <td><?= htmlspecialchars($emp['aca_pera']) ?></td>
            <td><?= htmlspecialchars($emp['monthly_salary']) ?></td>
            <td><a href="/src/components/profile.php" class="view-link">View Profile</a></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script>
  $(document).ready(function () {
    const table = $('#personnelTable').DataTable({
      dom:
        "<'d-none'f>" +
        "<'row'<'col-12'tr>>" +
        "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>",
      buttons: [
        { extend: 'csv', className: 'd-none', title: 'Regular Employees' },
        { extend: 'pdf', className: 'd-none', title: 'Regular Employees' },
        { extend: 'print', className: 'd-none', title: 'Regular Employees' }
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
