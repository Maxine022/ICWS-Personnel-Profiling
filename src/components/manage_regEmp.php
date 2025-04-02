<!-- jQuery, DataTables, and Export Plugins -->
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

<?php
$employees = [

];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Regular Employees</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

  <style>
    body { font-family: Arial; }
    .content {
      margin-left: 250px;
      padding: 30px;
    }
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    div.dataTables_filter {
    text-align: left !important;
    }
    .table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6 !important;
    }
    .search-buttons-container {
    margin-top: 25px;
    }
  </style>
</head>
<body>
    <?php include __DIR__ . '/../hero/navbar.php'; ?>
    <?php include __DIR__ . '/../hero/sidebar.php'; ?>

    <div class="content">

    <!-- Title + Breadcrumb in same row -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
        <h4 class="mb-0">Manage Regular Employees</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="/src/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Manage Personnel</a></li>
                <li class="breadcrumb-item active" aria-current="page">Regular</li>
                </ol>
            </nav>
        </div>

    <!-- Search and Buttons -->
    <div class="search-buttons-container row align-items-center mb-4">
        <!-- Search label + input -->
        <div class="col-md-6 d-flex align-items-center gap-2">
            <label for="searchInput" class="form-label mb-0"><strong>Search:</strong></label>
            <div id="customSearchContainer"></div>
        </div>

        <!-- Action Buttons -->
        <div class="col-md-6 text-end">
            <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
                <button class="btn btn-primary btn-sm" onclick="window.location.href='/src/components/add_regular_employee.php'">
                    <i class="fas fa-plus"></i> Add
                </button>
                <button class="btn btn-success btn-sm" onclick="window.location.href='/src/components/edit_regular.php'">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <span class="vr d-none d-md-inline"></span>
                <button class="btn btn-outline-success export-btn btn-sm" data-type="csv">CSV</button>
                <button class="btn btn-danger export-btn btn-sm" data-type="pdf">PDF</button>
                <button class="btn btn-warning export-btn btn-sm" data-type="print">Print</button>
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered" id="personnelTable">
        <thead>
            <tr>
            <th>Employee Name</th>
            <th>Position(s)</th>
            <th>Division(s)</th>
            <th>Salary Grade</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
            <tr>
            <td><?= $emp['name'] ?></td>
            <td><?= $emp['position'] ?></td>
            <td><?= $emp['division'] ?></td>
            <td><?= $emp['salary'] ?></td>
            <td><a href="#" class="text-primary">View Profile</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function () {
        const table = $('#personnelTable').DataTable({
        dom:
            "<'d-none'f>" + 
            "<'row'<'col-12'tr>>" +
            "<'row mt-3'<'col-md-6'i><'col-md-6 text-end'p>>",
        buttons: [
            { extend: 'csv', className: 'd-none', title: 'RegularEmployees' },
            { extend: 'pdf', className: 'd-none', title: 'RegularEmployees' },
            { extend: 'print', className: 'd-none', title: 'RegularEmployees' }
        ]
        });

        $('.export-btn').on('click', function () {
        const type = $(this).data('type');
        table.button(`.buttons-${type}`).trigger();
        });
    });
</script>
</script>
</body>
</html>