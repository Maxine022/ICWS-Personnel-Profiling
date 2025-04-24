<?php
session_start();
include_once __DIR__ . '/../../backend/db.php';

$emp_no = $_GET['Emp_No'] ?? null;

if (!$emp_no) {
    echo "Employee not found.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM personnel WHERE Emp_No = ?");
$stmt->bind_param("s", $emp_no);
$stmt->execute();
$employee = $stmt->get_result()->fetch_assoc();

if (!$employee) {
    echo "Employee not found.";
    exit();
}

// Fetch service records for all employment types
$stmt = $conn->prepare("SELECT startDate, endDate, position, company FROM service_record WHERE personnel_id = ?");
$stmt->bind_param("i", $employee['personnel_id']);
$stmt->execute();
$service_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$stmt = $conn->prepare("SELECT * FROM salary WHERE personnel_id = ?");
$stmt->bind_param("i", $employee['personnel_id']);
$stmt->execute();
$salary = $stmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT * FROM reg_emp WHERE personnel_id = ?");
$stmt->bind_param("i", $employee['personnel_id']);
$stmt->execute();
$reg_emp = $stmt->get_result()->fetch_assoc();

$employment_type = '';
if (!empty($reg_emp['plantillaNo'])) {
    $employment_type = 'regular';
} elseif (!empty($employee['job_order'])) {
    $employment_type = 'job_order';
} elseif (!empty($employee['contract_status'])) {
    $employment_type = 'contract';
}

$job_orders = [];
$contracts = [];
$reg_emp_details = [];

if ($employment_type === 'job_order') {
    $stmt = $conn->prepare("SELECT * FROM job_order WHERE personnel_id = ?");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $job_orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

if ($employment_type === 'contract') {
    $stmt = $conn->prepare("SELECT * FROM contract_service WHERE personnel_id = ?");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $contracts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

if ($employment_type === 'regular') {
    $reg_emp_details = $reg_emp;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print - <?= htmlspecialchars($employee['full_name']) ?></title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 40px;
      color: #000;
    }

    .header-flex {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .header-flex img {
      height: 100px;
    }

    .header-center {
      text-align: center;
      flex: 1;
      font-family: 'Times New Roman', Times, serif;
    }

    .section-title {
      font-weight: bold;
      font-size: 18px;
      margin-top: 40px;
      margin-bottom: 10px;
      border-bottom: 1px solid #000;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    td, th {
      padding: 6px 10px;
      vertical-align: top;
      text-align: left;
    }

    .service-record th, .service-record td {
      border: 1px solid #000;
    }

    .service-record th {
      background-color: #f0f0f0;
    }

    footer {
      margin-top: 60px;
      text-align: right;
      font-size: 12px;
    }

    @media print {
      body { margin: 0; }
    }
  </style>
</head>
<body onload="window.print()">

<header>
  <div class="header-flex">
    <div><img src="/assets/LGU.png" alt="City of Iligan Logo"></div>
    <div class="header-center" style="line-height: 1.4;">
      <div style="font-weight: bold; font-size: 16px;">Republic of the Philippines</div>
      <div style="font-weight: bold; font-size: 16px;">City of Iligan</div>
      <div style="font-weight: bold; font-size: 18px;">OFFICE OF THE ILIGAN CITY WATERWORKS SYSTEM</div>
      <div style="font-size: 14px;">Lluch Park Street, Dona Juana Lluch Subdivision</div>
      <div style="font-size: 14px;">Pala-o, Iligan City 9200 Philippines</div>
    </div>
    <div><img src="/assets/logo.png" alt="Waterworks Logo"></div>
  </div>

  <div style="text-align: center; margin-top: 40px;">
    <div style="font-size: 28px; font-weight: bold; letter-spacing: 1px;">EMPLOYEE PROFILE SUMMARY</div>
  </div>
</header>

<!-- PERSONAL DETAILS -->
<section>
  <div class="section-title">PERSONAL DETAILS</div>
  <table>
    <tr><td><strong>Full Name:</strong></td><td><?= htmlspecialchars($employee['full_name']) ?></td></tr>
    <tr><td><strong>Sex:</strong></td><td><?= htmlspecialchars($employee['sex']) ?></td></tr>
    <tr><td><strong>Birthdate:</strong></td><td><?= htmlspecialchars($employee['birthdate']) ?></td></tr>
    <tr><td><strong>Address:</strong></td><td><?= htmlspecialchars($employee['address']) ?></td></tr>
    <tr><td><strong>Contact No:</strong></td><td><?= htmlspecialchars($employee['contact_number']) ?></td></tr>
  </table>
</section>

<!-- INFORMATION DETAILS -->
<section>
  <div class="section-title">INFORMATION DETAILS</div>
  <table>
    <tr><td><strong>Employment Type:</strong></td><td><?= ucfirst($employment_type) ?></td></tr>
    <tr><td><strong>Plantilla Number:</strong></td><td><?= htmlspecialchars($reg_emp_details['plantillaNo'] ?? '-') ?></td></tr>
    <tr><td><strong>Position:</strong></td><td><?= htmlspecialchars($employee['position']) ?></td></tr>
    <tr><td><strong>Division:</strong></td><td><?= htmlspecialchars($employee['division']) ?></td></tr>
    <tr><td><strong>Step:</strong></td><td><?= htmlspecialchars($salary['step'] ?? '-') ?></td></tr>
    <tr><td><strong>Level:</strong></td><td><?= htmlspecialchars($salary['level'] ?? '-') ?></td></tr>
    <tr><td><strong>Salary Grade:</strong></td><td><?= htmlspecialchars($salary['salaryGrade'] ?? '-') ?></td></tr>
    <tr><td><strong>Monthly Salary:</strong></td><td><?= htmlspecialchars($salary['monthlySalary'] ?? '-') ?></td></tr>
    <tr><td><strong>ACA Pera:</strong></td><td><?= htmlspecialchars($reg_emp_details['acaPera'] ?? '-') ?></td></tr>
  </table>
</section>

<!-- SERVICE RECORD -->
<section>
  <div class="section-title">SERVICE RECORD</div>
  <table class="service-record">
    <thead>
      <tr>
        <th>Starting Date</th>
        <th>Ending Date</th>
        <th>Position</th>
        <th>Company</th>
      </tr>
    </thead>
    <tbody>
            <?php if (!empty($service_records)): ?>
        <?php foreach ($service_records as $record): ?>
            <tr>
            <td><?= htmlspecialchars($record['startDate']) ?></td>
            <td><?= htmlspecialchars($record['endDate']) ?></td>
            <td><?= htmlspecialchars($record['position']) ?></td>
            <td><?= htmlspecialchars($record['company']) ?></td>
            </tr>
        <?php endforeach; ?>

      <?php elseif ($employment_type === 'contract' && !empty($contracts)): ?>
        <?php foreach ($contracts as $cos): ?>
          <tr>
            <td><?= htmlspecialchars($cos['start_date']) ?></td>
            <td><?= htmlspecialchars($cos['end_date']) ?></td>
            <td><?= htmlspecialchars($cos['designation']) ?></td>
            <td><?= htmlspecialchars($cos['company'] ?? '—') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php elseif ($employment_type === 'regular' && !empty($reg_emp_details)): ?>
        <tr>
          <td><?= htmlspecialchars($reg_emp_details['start_date'] ?? '-') ?></td>
          <td><?= htmlspecialchars($reg_emp_details['end_date'] ?? '-') ?></td>
          <td><?= htmlspecialchars($employee['position']) ?></td>
          <td><?= htmlspecialchars($employee['division']) ?></td>
        </tr>
      <?php else: ?>
        <tr><td colspan="4">No service records available.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>

<footer>
  <div><strong>Date Printed:</strong> <?= date('F d, Y') ?></div>
  <div>Generated by ICWS Personnel Profiling System</div>
</footer>

</body>
</html>