<?php
include_once __DIR__ . '/../../backend/db.php'; // Include database connection

// Fetch regular employee data
$regulars = [];

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
    r.plantillaNo,
    s.salaryGrade,
    s.step,
    s.level,
    r.acaPera,
    s.monthlySalary
  FROM reg_emp r
  JOIN personnel p ON r.personnel_id = p.personnel_id
  JOIN salary s ON r.salary_id = s.salary_id
  ORDER BY p.personnel_id DESC, p.full_name ASC
");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $regulars[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

   <!-- Bootstrap -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

  <style>
    body { font-family: Arial; }
    .print-header {
        text-align: center;
        margin-bottom: 20px;
    }
      .print-header img {
        max-height: 120px;
    }
      .print-header div {
        line-height: 1.3;
    }
      .print-heading {
        text-align: center;
        font-size: 16px;
        line-height: 1.4;
    }
        .print-heading strong {
        font-size: 20px;
        display: block;
    }
      .print-title {
        font-size: 22px;
        font-weight: bold;
        margin-top: 15px;
        text-transform: uppercase;
    }
      .print-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        margin-top: 20px;
    }
      .print-table th, .print-table td {
        border: 1px solid black;
        padding: 6px;
        text-align: center;       
    }
      .print-footer {
        margin-top: 40px;
        font-size: 13px;
    }
      .print-footer .signatures {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
      .print-footer .signatures div {
        width: 45%;
        text-align: center;
    }
      .print-footer strong {
        display: block;
        margin-top: 5px;
    }
    @media print {
    /* Hide elements you don't want to include in the print view */
    #sidebar, #navbar, .btn, .breadcrumb, .search-buttons-container {
      display: none !important;
    }

    @page{
      size: landscape;
      margin: 0; /* Optional: Adjust margins as needed */
    }

    /* Hide elements you don't want to include in the print view */
    #sidebar, #navbar, .btn, .breadcrumb, .search-buttons-container {
      display: none !important;
    }
    }

    /* Adjust the layout for printing */
    #print-layout {
      visibility: visible !important;
      position: static !important;
      margin: 0 !important;
      padding: 20px !important;
      width: 100% !important;
    }

    /* Ensure the table fills the page width */
    .print-table {
      width: 100% !important;
      border-collapse: collapse !important;
    }

    .print-table th, .print-table td {
      font-size: 12px !important;
      text-align: center !important;
    }

    /* Hide other elements */
    body * {
      visibility: hidden;
    }

    /* Only show the print layout */
    #print-layout, #print-layout * {
      visibility: visible;
    }
  }
  </style>
</head>
<body>
  <!-- ✅ PRINT-ONLY LAYOUT -->
<div id="print-layout" class="d-none d-print-block">
  <div class="print-header d-flex align-items-center justify-content-center mb-4" style="max-width: 1000px; margin: 0 auto;">
    
    <!-- LGU Logo -->
    <div style="width: 120px; text-align: center;">
      <img src="../../assets/LGU.png" alt="LGU Iligan Logo" style="max-height: 160px;">
    </div>

    <!-- Center Heading -->
    <div class="flex-grow-1 text-center px-3" style="line-height: 1.5; font-family: 'Times New Roman', Times, serif;">
      <div style="font-size: 22px; font-weight: bold;">Republic of the Philippines</div>
      <div style="font-size: 22px; font-weight: bold;">City of Iligan</div>
      <div style="font-size: 24px; font-weight: bold; text-transform: uppercase;">
        Office of the Iligan City Waterworks System
      </div>
      <div style="font-size: 18px;">Lluch Park Street, Dona Juana Lluch Subdivision</div>
      <div style="font-size: 18px;">Pala-o, Iligan City 9200 Philippines</div>
    </div>

    <!-- ICWS Logo -->
    <div style="width: 120px; text-align: center;">
      <img src="../../assets/logo.png" alt="ICWS Logo" style="max-height: 140px;">
    </div>
  </div>

    <!-- ✅ Title (now outside of flex container) -->
    <div style="font-size: 30px; font-weight: bold; margin-top: 20px; text-align: center;">
      LIST OF REGULAR EMPLOYEES
    </div>
  <table class="print-table">
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
        <th>Plantilla No</th>
        <th>Salary Grade</th>
        <th>Step</th>
        <th>Level</th>
        <th>Monthly Salary</th>
        <th>ACA Pera</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($regulars as $emp): ?>
        <tr>
          <td><?= htmlspecialchars($emp['Emp_No']) ?></td>
          <td><?= htmlspecialchars($emp['full_name']) ?></td>
          <td><?= htmlspecialchars($emp['sex']) ?></td>
          <td><?= htmlspecialchars($emp['birthdate']) ?></td>
          <td><?= htmlspecialchars($emp['contact_number']) ?></td>
          <td><?= htmlspecialchars($emp['address']) ?></td>
          <td><?= htmlspecialchars($emp['position']) ?></td>
          <td><?= htmlspecialchars($emp['division']) ?></td>
          <td><?= htmlspecialchars($emp['plantillaNo']) ?></td>
          <td><?= htmlspecialchars($emp['salaryGrade']) ?></td>
          <td><?= htmlspecialchars($emp['step']) ?></td>
          <td><?= htmlspecialchars($emp['level']) ?></td>
          <td><?= htmlspecialchars($emp['monthlySalary']) ?></td>
          <td><?= htmlspecialchars($emp['acaPera']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <br />
  <div class="print-footer">
  <div class="signatures">
    <div>_________________________________________<br><strong>Prepared By</strong></div>
    <div>_________________________________________<br><strong>Approved By</strong></div>
  </div>

  <!-- ✅ Right-aligned Date Printed -->
  <div style="text-align: right; margin-top: 80px;">
    Date Printed: <?= (new DateTime("now", new DateTimeZone("Asia/Manila")))->format("F j, Y - g:i A") ?>
    <br/>
    Generated by ICWS Personnel Profiling System
    <div></div>
</div>
</body>
</html>


<script>
  // Automatically trigger print dialog
  window.onload = function() {
    window.print();
    // Redirect back after printing
    window.onafterprint = function() {
      window.location.href = '/src/components/manage_regEmp.php';
    };
  };
</script>