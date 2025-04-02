<?php
$jsonData = file_exists("personnel.json") ? file_get_contents("personnel.json") : '[]';
$personnel = json_decode($jsonData, true) ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ICWS</title>
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
        .sidebar {
            height: 100vh;
            width: 250px;
            background: #2C3E50;
            position: fixed;
            padding-top: 20px;
            color: white;
        }
        .sidebar.hidden {
            width: 0;
            padding: 0;
            overflow: hidden;
        }
        .content.expanded {
            margin-left: 0;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #007BFF;
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
<body>
    <div class="sidebar" id="sidebar">
        <div class="d-flex align-items-center justify-content-start mb-3 ps-3">
            <img src="/assets/logo.png" alt="ICWS Logo" width="40" height="40" class="me-2">
            <h3 class="m-0 fw-bold">ICWS</h3>
        </div>
        <hr>
        <div class="d-flex align-items-center justify-content-start mb-3 ps-3">
            <img src="/assets/profile.jpg" class="rounded-circle" alt="User Profile" width="40" height="40">
            <p class="m-0 ms-2">User Name</p>
        </div>
        <hr>
        <a href="#"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#"><i class="fas fa-user"></i> Profile</a>
        <a href="#"><i class="fas fa-tasks"></i> Manage</a>
        <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <div class="content" id="content">
        <div class="header">
            <h2>Personnel Records</h2>
            <div class="breadcrumb-container">
                <a href="#">Home</a> / <a>Personnel</a>
            </div>
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
            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("hidden");
                document.getElementById("content").classList.toggle("expanded");
            }
    </script>
</body>
</html>