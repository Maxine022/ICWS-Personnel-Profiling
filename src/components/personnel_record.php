<?php
session_start();

$jsonData = file_exists("personnel.json") ? file_get_contents("personnel.json") : '[]';
$personnel = json_decode($jsonData, true) ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICWS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .content.expanded {
            margin-left: 0;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .cell-content {
            width: 100%;
            padding: 10px;
            border: 1px solid transparent;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .breadcrumb-container {
            font-size: 14px;
            color: #6c757d;
        }
        .breadcrumb-container a {
            text-decoration: none;
            color: #6c757d;
        }
        .breadcrumb-container a:hover {
            color: #007BFF;
        }
        .dataTables_wrapper .dataTables_filter {
            float: left !important;
            margin-bottom: 10px;
        }
        .dataTables_wrapper .dt-buttons {
            float: right !important;
            margin-bottom: 10px;
        }
        .dataTables_length {
            margin-top: 20px; 
        }

        .dataTables_paginate {
            margin-top: 20px; 
        }
        #personnelTable {
            border: 1px solid #000 !important; /* Ensures the table has a border */
            width: 100%;
            border-collapse: collapse;
        }
        #personnelTable th, #personnelTable td {
            border: 1px solid rgb(182, 182, 182) !important;
        }
        #personnelTable th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
            padding: 10px;
        }
        #personnelTable td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        #personnelTable tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-csv {
            background-color: #28a745 !important;
            color: white !important;
            border: none !important;
        }

        .btn-pdf {
            background-color: #dc3545 !important;
            color: white !important;
            border: none !important;
        }

        .btn-print {
            background-color: #007bff !important;
            color: white !important;
            border: none !important;
        }
        .btn-csv:hover {
            transform: rotate(5deg);
            background-color: #218838 !important;
        }

        .btn-pdf:hover {
            transform: rotate(5deg);
            background-color: #c82333 !important;
        }

        .btn-print:hover {
            transform: rotate(5deg);
            background-color: #0069d9 !important;
        }
        
    </style>
</head>

<?php include __DIR__ . '/../hero/navbar.php'; ?>
<?php include __DIR__ . '/../hero/sidebar.php'; ?>

<body>
    <div class="content" id="content">
        <!-- Title + Breadcrumb in same row -->
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
            <h4 class="mb-0">Manage Regular Employees</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/src/index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="/src/components/personnel_record.php">Manage Personnel</a></li>
                    </ol>
                </nav>
        </div>

        <div class="d-flex justify-content-between align-items-center my-3">
            <div class="dataTables_filter"></div>
            <div class="dt-buttons"></div>
        </div>

        <table id="personnelTable" class="table" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Position(s)</th>
                    <th>Division(s)</th>
                    <th>Salary per Day</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($personnel as $person): ?>
                <tr>
                    <td><div class="cell-content"><?= htmlspecialchars($person["name"]) ?></div></td>
                    <td><div class="cell-content"><?= htmlspecialchars($person["position"]) ?></div></td>
                    <td><div class="cell-content"><?= htmlspecialchars($person["division"]) ?></div></td>
                    <td><div class="cell-content"><?= htmlspecialchars($person["salary"]) ?></div></td>
                    <td><div class="cell-content"><a href="#" class="btn btn-primary btn-sm">View Profile</a></div></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#personnelTable').DataTable({
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "ordering": true,
                "searching": true,
                "info": true,
                "dom": '<"row"<"col-md-6 text-start"f><"col-md-6 text-end"B>>rt<"row mt-4"<"col-md-6"l><"col-md-6 text-end"p>>',
                "buttons": [
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn btn-csv btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        className: 'btn btn-pdf btn-sm' 
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-print btn-sm' 
                    }
                ],
                "initComplete": function() {
                    $('.dt-buttons .btn').removeClass('dt-button'); 
                }
            });

            // Move DataTable controls into predefined divs
            $('.dataTables_filter').appendTo($('.content .d-flex:first-child .dataTables_filter'));
            $('.dt-buttons').appendTo($('.content .d-flex:first-child .dt-buttons'));
        });
    </script>
</body>

</html>