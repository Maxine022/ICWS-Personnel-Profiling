<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include_once __DIR__ . '/../../backend/db.php';

$emp_no = $_GET['Emp_No'] ?? null;
if (!$emp_no) {
    echo "<h3>Error: Employee number is missing.</h3>";
    exit();
}

// Fetch employee
$stmt = $conn->prepare("SELECT * FROM personnel WHERE Emp_No = ?");
$stmt->bind_param("s", $emp_no);
$stmt->execute();
$employee = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$employee) {
    echo "<h3>Error: Employee not found.</h3>";
    exit();
}

// Normalize employment type
$stmt = $conn->prepare("SELECT emp_type FROM personnel WHERE personnel_id = ?");
$stmt->bind_param("i", $employee['personnel_id']);
$stmt->execute();
$result = $stmt->get_result();
$employment_type = strtolower($result->fetch_assoc()['emp_type'] ?? '');
$stmt->close();

// Fetch service records with proper aliases
$service_records = [];
if ($employment_type === 'regular') {
    $stmt = $conn->prepare("
        SELECT 
            startDate AS start_date,
            endDate AS end_date,
            position,
            company
        FROM service_record
        WHERE personnel_id = ?
    ");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $service_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Fetch job order work experience for all job order type variants
$jo_work_experience = [];
if (in_array($employment_type, ['job order', 'job_order', 'joborder']) && !empty($employee['personnel_id'])) {
    $stmt = $conn->prepare("
        SELECT date_from, date_to, position_title, department, monthly_salary
        FROM jo_work_experience
        WHERE personnel_id = ?
    ");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $jo_work_experience = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Fetch salaryRate for job order
if ($employment_type === 'job_order') {
    $stmt = $conn->prepare("SELECT salaryRate FROM job_order WHERE personnel_id = ?");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $job_order_info = $stmt->get_result()->fetch_assoc();
    $employee['salaryRate'] = $job_order_info['salaryRate'] ?? null;
    $stmt->close();
}

if (in_array($employment_type, ['job order', 'job_order', 'joborder'])) {
    $stmt = $conn->prepare("SELECT salaryRate FROM job_order WHERE personnel_id = ?");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $job_order_info = $stmt->get_result()->fetch_assoc();
    $employee['salaryRate'] = $job_order_info['salaryRate'] ?? null;
    $stmt->close();
}

// Contract service records
$contract_service_records = [];
if ($employment_type === 'contract') {
    $stmt = $conn->prepare("SELECT contractStart, contractEnd, remarks FROM contractservice_record csr JOIN contract_service cs ON csr.contractservice_id = cs.contractservice_id WHERE cs.personnel_id = ?");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $contract_service_records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Salary info
$stmt = $conn->prepare("SELECT * FROM salary WHERE personnel_id = ?");
$stmt->bind_param("i", $employee['personnel_id']);
$stmt->execute();
$salary = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Regular employee details
$stmt = $conn->prepare("SELECT * FROM reg_emp WHERE personnel_id = ?");
$stmt->bind_param("i", $employee['personnel_id']);
$stmt->execute();
$reg_emp = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Profile picture
$profile_picture_path = __DIR__ . '/../../uploads/profile_' . $employee['personnel_id'] . '.png';
$profile_picture_url = file_exists($profile_picture_path)
    ? '../../uploads/profile_' . $employee['personnel_id'] . '.png'
    : '../../assets/profile.jpg';

$cos = [];
if ($employment_type === 'contract') {
    $stmt = $conn->prepare("SELECT salaryRate FROM contract_service WHERE personnel_id = ?");
    $stmt->bind_param("i", $employee['personnel_id']);
    $stmt->execute();
    $cos = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>  


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print - <?= htmlspecialchars($employee['full_name'] ?? 'Unknown') ?></title>
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
    <div><img src="/ICWS-Personnel-Profiling/assets/LGU.png" alt="City of Iligan Logo"></div>
    <div class="header-center" style="line-height: 1.4;">
      <div style="font-weight: bold; font-size: 16px;">Republic of the Philippines</div>
      <div style="font-weight: bold; font-size: 16px;">City of Iligan</div>
      <div style="font-weight: bold; font-size: 18px;">OFFICE OF THE ILIGAN CITY WATERWORKS SYSTEM</div>
      <div style="font-size: 14px;">Lluch Park Street, Dona Juana Lluch Subdivision</div>
      <div style="font-size: 14px;">Pala-o, Iligan City 9200 Philippines</div>
    </div>
    <div><img src="/ICWS-Personnel-Profiling/assets/logo.png" alt="Waterworks Logo"></div>
  </div>

  <div style="text-align: center; margin-top: 10px;">
  <div style="font-size: 28px; font-weight: bold; letter-spacing: 1px;">EMPLOYEE PROFILE SUMMARY</div>
</div>

<div style="text-align: center; margin-top: 30px;">
  <img src="<?= htmlspecialchars($profile_picture_url) ?>"
     alt="Profile Picture"
     style="width: 192px; height: 192px; object-fit: cover; margin-bottom: 5px;">
</div>

<!-- PERSONAL DETAILS -->
<section>
  <div class="section-title">PERSONAL DETAILS</div>
  <table>
    <tr><td><strong>Full Name:</strong></td><td><?= htmlspecialchars($employee['full_name'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Sex:</strong></td><td><?= htmlspecialchars($employee['sex'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Birthdate:</strong></td><td><?= htmlspecialchars($employee['birthdate'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Address:</strong></td><td><?= htmlspecialchars($employee['address'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Contact No:</strong></td><td><?= htmlspecialchars($employee['contact_number'] ?? 'N/A') ?></td></tr>
  </table>
</section>

<!-- INFORMATION DETAILS -->
<section>
  <div class="section-title">EMPLOYMENT DETAILS</div>
  <table>
    <tr><td><strong>Employment Type:</strong></td><td><?= ucfirst($employment_type) ?></td></tr>
    <tr><td><strong>Position:</strong></td><td><?= htmlspecialchars($employee['position'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Division:</strong></td><td><?= htmlspecialchars($employee['division'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Section:</strong></td><td><?= htmlspecialchars($employee['section'] ?? 'N/A') ?></td></tr>
    <tr><td><strong>Unit</strong>:</strong></td><td><?= htmlspecialchars($employee['unit'] ?? 'N/A') ?></td></tr>

    <?php if (!empty($employee['team'])): ?>
    <tr><td><strong>Team:</strong></td><td><?= htmlspecialchars($employee['team']) ?></td></tr>
    <?php endif; ?>
    <?php if (!empty($employee['operator'])): ?>
    <tr><td><strong>Operator:</strong></td><td><?= htmlspecialchars($employee['operator']) ?></td></tr>
    <?php endif; ?>

    <?php if ($employment_type === 'regular'): ?>
      <tr><td><strong>Plantilla Number:</strong></td><td><?= htmlspecialchars($reg_emp['plantillaNo'] ?? 'N/A') ?></td></tr>
      <tr><td><strong>Step:</strong></td><td><?= htmlspecialchars($salary['step'] ?? 'N/A') ?></td></tr>
      <tr><td><strong>Level:</strong></td><td><?= htmlspecialchars($salary['level'] ?? 'N/A') ?></td></tr>
      <tr><td><strong>Salary Grade:</strong></td><td><?= htmlspecialchars($salary['salaryGrade'] ?? 'N/A') ?></td></tr>
      <tr><td><strong>Monthly Salary:</strong></td><td><?= htmlspecialchars($salary['monthlySalary'] ?? 'N/A') ?></td></tr>
      <tr><td><strong>ACA Pera:</strong></td><td><?= htmlspecialchars($reg_emp['acaPera'] ?? 'N/A') ?></td></tr>
      <?php elseif (in_array(strtolower($employment_type), ['job order', 'job_order', 'joborder'])): ?>
      <tr><td><strong>Salary Rate:</strong></td>
      <td>
          <?= isset($employee['salaryRate']) ? '₱' . number_format((float)$employee['salaryRate'], 2) : 'N/A' ?>
      </td>
      </tr>
          <?php elseif (strtolower($employment_type) === 'contract'): ?>
          <tr><td><strong>Salary Rate:</strong></td>
        <td>
            <?= isset($cos['salaryRate']) ? '₱' . number_format((float)$cos['salaryRate'], 2) : 'N/A' ?>
        </td>
      </tr>
      <?php endif; ?>
  </table>
</section>

<!-- WORK EXPERIENCE -->
<section>
<div class="section-title">WORK EXPERIENCE</div>
<table class="service-record">
<thead>
<tr>
  <?php if ($employment_type === 'regular'): ?>
    <th>Starting Date</th>
    <th>Ending Date</th>
    <th>Position</th>
    <th>Department</th>
  <?php elseif (in_array($employment_type, ['job order', 'job_order', 'joborder'])): ?>
    <th>Date From</th>
    <th>Date To</th>
    <th>Position Title</th>
    <th>Department</th>
    <th>Monthly Salary</th>
  <?php elseif ($employment_type === 'contract'): ?>
    <th>Contract Start</th>
    <th>Contract End</th>
    <th>Remarks</th>
  <?php endif; ?>
</tr>
</thead>
<tbody>
<?php if ($employment_type === 'regular'): ?>
  <?php if (!empty($service_records)): ?>
    <?php foreach ($service_records as $record): ?>
      <tr>
        <td><?= htmlspecialchars($record['start_date']) ?></td>
        <td><?= htmlspecialchars($record['end_date']) ?></td>
        <td><?= htmlspecialchars($record['position']) ?></td>
        <td><?= htmlspecialchars($record['company']) ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="4">No service records available.</td></tr>
  <?php endif; ?>

  <?php elseif (in_array($employment_type, ['job order', 'job_order', 'joborder'])): ?>
  <?php if (!empty($jo_work_experience)): ?>
      <?php foreach ($jo_work_experience as $exp): ?>
          <tr>
              <td><?= htmlspecialchars($exp['date_from']) ?></td>
              <td><?= htmlspecialchars($exp['date_to']) ?></td>
              <td><?= htmlspecialchars($exp['position_title']) ?></td>
              <td><?= htmlspecialchars($exp['department']) ?></td>
              <td>₱<?= number_format($exp['monthly_salary'], 2) ?></td>
          </tr>
      <?php endforeach; ?>
  <?php else: ?>
      <tr><td colspan="5">No job order work experience records available.</td></tr>
  <?php endif; ?>

<?php elseif ($employment_type === 'contract'): ?>
  <?php if (!empty($contract_service_records)): ?>
    <?php foreach ($contract_service_records as $record): ?>
      <tr>
        <td><?= htmlspecialchars($record['contractStart']) ?></td>
        <td><?= htmlspecialchars($record['contractEnd']) ?></td>
        <td><?= htmlspecialchars($record['remarks']) ?></td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="3">No contract service records available.</td></tr>
  <?php endif; ?>
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