<?php
$employees = [
  ["name" => "John Ryan Dela Cruz", "position" => "Firefox 1.0", "division" => "Administrative", "salary" => "580"],
  ["name" => "Jielven Rose Baraquel", "position" => "Firefox 1.5", "division" => "Win 98+ / OSX.2+", "salary" => "500"],
  ["name" => "Maxine Joyce Lesondra", "position" => "Firefox 2.0", "division" => "Win 98+ / OSX.2+", "salary" => "1.8"],
  ["name" => "Danny Boy Loberanes", "position" => "Firefox 3.0", "division" => "Win 2k+ / OSX.3+", "salary" => "1.9"],
  ["name" => "John Gylor Paypa", "position" => "Camino 1.0", "division" => "OSX.2+", "salary" => "1.8"],
  ["name" => "Thea Ancog", "position" => "Camino 1.5", "division" => "OSX.3+", "salary" => "1.8"],
  ["name" => "Britzil Baldovi", "position" => "Netscape 7.2", "division" => "Win 95+ / Mac OS 8.6-9.2", "salary" => "1.7"],
  ["name" => "Gecko", "position" => "Netscape Browser 8", "division" => "Win 98SE+", "salary" => "1.7"],
  ["name" => "Gecko", "position" => "Netscape Navigator 9", "division" => "Win 98+ / OSX.2+", "salary" => "1.8"],
  ["name" => "Gecko", "position" => "Mozilla 1.0", "division" => "Win 95+ / OSX.1+", "salary" => "1"],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Regular Employees</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
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
    margin-top: 25px; 
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
    <!-- Header and Breadcrumb -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h4 class="mb-0" style="font-weight: bold;">Manage Contract of Service Employees</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="#">Home</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="#">Manage Personnel</a></li>
          <li class="breadcrumb-item active" aria-current="page">COS</li>
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
        <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add</button>
        <button class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</button>
        <span class="vr d-none d-md-inline"></span>
        <button class="btn btn-outline-success export-btn btn-sm" data-type="csv">CSV</button>
        <button class="btn btn-danger export-btn btn-sm" data-type="pdf">PDF</button>
        <button class="btn btn-warning export-btn btn-sm" data-type="print">Print</button>
        </div>
    </div>
    </div>

    <!-- Data Table -->
    <div class="table-container">
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
            <td><a class="view-link" href="#">View Profile</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>

  <!-- JS Scripts -->
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
          { extend: 'csv', className: 'd-none', title: 'CSV' },
          { extend: 'pdf', className: 'd-none', title: 'PDF' },
          { extend: 'print', className: 'd-none', title: 'PRINT' }
        ]
      });

      // Move search bar to custom container
      $('#customSearchContainer').append($('#personnelTable_filter input'));
      $('#personnelTable_filter').remove();

      // Export buttons
      $('.export-btn').on('click', function () {
        const type = $(this).data('type');
        table.button(`.buttons-${type}`).trigger();
      });
    });
  </script>
</body>
</html>