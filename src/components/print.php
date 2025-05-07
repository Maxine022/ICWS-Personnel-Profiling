<?php
include_once __DIR__ . '/../../backend/db.php';

// Detect which page is printing
$current_page = $_GET['type'] ?? basename($_SERVER['HTTP_REFERER'] ?? '');

// Fetch data based on type
$data = [];
if ($current_page === 'manage_regEmp.php' || $current_page === 'regular') {
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
    if ($result === false) {
        echo "<div style='color:red;'>SQL Error: " . $conn->error . "</div>";
    } else {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $printType = 'regular';
} elseif ($current_page === 'manage_jo.php' || $current_page === 'joborder') {
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
        jo.salaryRate
      FROM job_order jo
      JOIN personnel p ON jo.personnel_id = p.personnel_id
      WHERE p.emp_type = 'Job Order'
      ORDER BY p.personnel_id ASC, p.full_name ASC
    ");
    if ($result === false) {
        echo "<div style='color:red;'>SQL Error: " . $conn->error . "</div>";
    } else {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $printType = 'joborder';
} elseif ($current_page === 'manage_cos.php' || $current_page === 'contract') {
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
        cs.salaryRate
      FROM contract_service cs
      JOIN personnel p ON cs.personnel_id = p.personnel_id
      WHERE p.emp_type = 'Contract'
      ORDER BY p.personnel_id ASC, p.full_name ASC
    ");
    if ($result === false) {
        echo "<div style='color:red;'>SQL Error: " . $conn->error . "</div>";
    } else {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $printType = 'contract';
} else {
    $printType = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { font-family: Arial; }
    .print-header { text-align: center; margin-bottom: 20px; }
    .print-header img { max-height: 120px; }
    .print-header div { line-height: 1.3; }
    .print-title { font-size: 22px; font-weight: bold; margin-top: 15px; text-transform: uppercase; }
    .print-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 20px; }
    .print-table th, .print-table td { border: 1px solid black; padding: 6px; text-align: center; }
    .print-footer { margin-top: 40px; font-size: 13px; }
    .print-footer .signatures { display: flex; justify-content: space-between; margin-top: 50px; }
    .print-footer .signatures div { width: 45%; text-align: center; }
    .print-footer strong { display: block; margin-top: 5px; }
    @media print {
      #sidebar, #navbar, .btn, .breadcrumb, .search-buttons-container { display: none !important; }
      @page{ size: landscape; margin: 0; }
      body * { visibility: hidden; }
      #print-layout, #print-layout * { visibility: visible; }
    }
    #print-layout { visibility: visible !important; position: static !important; margin: 0 !important; padding: 20px !important; width: 100% !important; }
    .print-table { width: 100% !important; border-collapse: collapse !important; }
    .print-table th, .print-table td { font-size: 12px !important; text-align: center !important; }
  </style>
</head>
<body>
<div id="print-layout" class="d-none d-print-block">
  <div class="print-header d-flex align-items-center justify-content-center mb-4" style="max-width: 1000px; margin: 0 auto;">
    <div style="width: 120px; text-align: center;">
      <img src="../../assets/LGU.png" alt="LGU Iligan Logo" style="max-height: 160px;">
    </div>
    <div class="flex-grow-1 text-center px-3" style="line-height: 1.5; font-family: 'Times New Roman', Times, serif;">
      <div style="font-size: 22px; font-weight: bold;">Republic of the Philippines</div>
      <div style="font-size: 22px; font-weight: bold;">City of Iligan</div>
      <div style="font-size: 24px; font-weight: bold; text-transform: uppercase;">
        Office of the Iligan City Waterworks System
      </div>
      <div style="font-size: 18px;">Lluch Park Street, Dona Juana Lluch Subdivision</div>
      <div style="font-size: 18px;">Pala-o, Iligan City 9200 Philippines</div>
    </div>
    <div style="width: 120px; text-align: center;">
      <img src="../../assets/logo.png" alt="ICWS Logo" style="max-height: 140px;">
    </div>
  </div>

  <?php if ($printType === 'regular'): ?>
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
      <?php foreach ($data as $emp): ?>
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
  <?php elseif ($printType === 'joborder' || $printType === 'contract'): ?>
    <div style="font-size: 30px; font-weight: bold; margin-top: 20px; text-align: center;">
      LIST OF <?= $printType === 'joborder' ? 'JOB ORDER' : 'CONTRACT OF SERVICE' ?> EMPLOYEES
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
        <th>Salary Rate</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($data as $emp): ?>
        <tr>
        <td><?= htmlspecialchars($emp['Emp_No']) ?></td>
        <td><?= htmlspecialchars($emp['full_name']) ?></td>
        <td><?= htmlspecialchars($emp['sex']) ?></td>
        <td><?= htmlspecialchars($emp['birthdate']) ?></td>
        <td><?= htmlspecialchars($emp['contact_number']) ?></td>
        <td><?= htmlspecialchars($emp['address']) ?></td>
        <td><?= htmlspecialchars($emp['position']) ?></td>
        <td><?= htmlspecialchars($emp['division']) ?></td>
        <td><?= htmlspecialchars($emp['salaryRate']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <br />
  <div class="print-footer">
    <div class="signatures">
      <div>_________________________________________<br><strong>Prepared By</strong></div>
      <div>_________________________________________<br><strong>Approved By</strong></div>
    </div>
    <div style="text-align: right; margin-top: 80px;">
      Date Printed: <?= (new DateTime("now", new DateTimeZone("Asia/Manila")))->format("F j, Y - g:i A") ?>
      <br/>
      Generated by ICWS Personnel Profiling System
      <div></div>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
    window.print();
    window.onafterprint = function() {
      window.history.back();
    };
  };
</script>
</body>
</html>