<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

$emp_no = $_GET['Emp_No'] ?? null;

if (!$emp_no) {
    die("Employee number not provided.");
}

// Fetch employee and job order info
$stmt = $conn->prepare("
    SELECT 
        p.full_name, p.sex, p.personnel_id, jo.jo_id 
    FROM personnel p
    JOIN job_order jo ON p.personnel_id = jo.personnel_id
    WHERE p.Emp_No = ?
");
$stmt->bind_param("s", $emp_no);
$stmt->execute();
$employee = $stmt->get_result()->fetch_assoc();

if (!$employee) {
    die("Job Order employee not found.");
}


// Determine gender salutation
$gender = strtolower($employee['sex']) === 'male' ? 'Mr.' : 'Ms.';

// Fetch COC records for the job order ID
$stmt = $conn->prepare("SELECT * FROM coc WHERE jo_id = ?");
$stmt->bind_param("i", $employee['jo_id']);
$stmt->execute();
$coc_entries = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Totals
$total_earned = array_sum(array_column($coc_entries, 'earned_hours')) ?? 0;
$total_used = array_sum(array_column($coc_entries, 'used_hours')) ?? 0;
$net_balance = $total_earned - $total_used;

$date_issued = $coc_entries[0]['startingDate'] ?? date('Y-m-d');
$valid_until = date('Y-m-d', strtotime($date_issued . ' +12 months'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Print Certificate</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      padding: 20px;
      background: #fff;
      color: #000;
    }

    .certificate {
      border: 1px solid #ccc;
      padding: 30px;
      max-width: 800px;
      margin: auto;
      position: relative;
    }

    .header-logos {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .header-logos img {
      width: 100px;
      height: auto;
    }

    .gov-header {
      flex: 1;
      text-align: center;
      font-family: 'Times New Roman', Times, serif;
      line-height: 1.3;
    }

    .gov-header h3 {
      margin: 2px 0;
      font-size: 16px;
    }

    .gov-header h2 {
      margin: 4px 0;
      font-size: 15px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .gov-header p {
      margin: 2px 0;
      font-size: 14px;
    }

    .banner-title {
      background-image: url('/assets/wavebanner.png');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      height: 115px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 10px 0;
    }

    .banner-title h2 {
      font-size: 35px;
      font-weight: bold;
      color: black;
      margin: 0;
    }

    p {
      margin: 10px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid black;
    }

    thead th {
      background-color: #A8E6A3;
      font-weight: bold;
    }

    th, td {
      padding: 10px;
      text-align: center;
    }

    .signature-section {
      display: flex;
      justify-content: space-between;
      margin-top: 50px;
      gap: 30px;
    }

    .prepared {
      width: 45%;
    }

    .prepared p,
    .approved-received p {
      margin-bottom: 8px;
    }

    .copy-notes {
      margin-top: 60px;
    }

    .copy-notes p {
      font-style: italic;
      font-size: 14px;
      margin: 2px 0;
      color: red;
    }

    .approved-received {
      width: 45%;
      display: flex;
      flex-direction: column;
      gap: 30px;
    }

    .received-line {
      border-bottom: 1px solid black;
      width: 100%;
      margin-top: 30px;
      margin-bottom: 5px;
    }

    .signature-label {
      font-style: italic;
      font-size: 13px;
      text-align: right;
    }

    footer .note {
      margin-top: 40px;
      font-size: 12px;
      font-style: italic;
      text-align: left;
    }

    @media print {
      body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
    }
  </style>
</head>
<body onload="window.print()">
  <div class="certificate">
    <!-- Header -->
    <div class="header-logos">
      <img src="../../assets/LGU.png" alt="City of Iligan Logo">
      <div class="gov-header">
        <h3>Republic of the Philippines</h3>
        <h3><strong>City of Iligan</strong></h3>
        <h2>OFFICE OF THE ILIGAN CITY WATERWORKS SYSTEM</h2>
        <p>Lluch Park Street, Dona Juana Lluch Subdivision</p>
        <p>Pala-o, Iligan City 9200 Philippines</p>
      </div>
      <img src="../../assets/logo.png" alt="Waterworks Logo">
    </div>

    <!-- Title Banner -->
    <div class="banner-title">
      <h2>CERTIFICATE OF COC EARNED</h2>
    </div>

    <!-- Content -->
        <p>
      This certificate entitles <?= $gender ?> <?= htmlspecialchars($employee['full_name']) ?> to 
      <strong><?= $net_balance ?> hours</strong> of Compensatory Overtime Credits (COC).
    </p>

    <!-- based on a total of <strong><?= $total_earned ?> hours earned</strong> and <strong><?= $total_used ?> hours used</strong>. -->

    <!-- Table -->
    <table>
      <thead>
        <tr>
          <th>Date of CTO</th>
          <th>Earned COCs</th>
          <th>Date of Usage</th>
          <th>Remaining COCs</th>
          <th>Title of Activity</th>
          <th>Remarks</th>

        </tr>
      </thead>
      <tbody>
        <?php if (!empty($coc_entries)): ?>
                 <?php foreach ($coc_entries as $entry): 
                      $earned = $entry['earned_hours'] ?? 0;
                      $used = $entry['used_hours'] ?? 0;
                      $remaining = $earned - $used;
                    ?>
                    <tr>
                    <td><?= htmlspecialchars(date('m/d/Y', strtotime($entry['date']))) ?></td>
                    <td><?= htmlspecialchars($entry['earned_hours']) ?></td>
                    <td><?= htmlspecialchars(date('m/d/Y', strtotime($entry['date_usage']))) ?></td>
                    <td><?= htmlspecialchars($entry['used_hours']) ?></td>
                    <td><?= htmlspecialchars($entry['ActJust']) ?></td>
                    <td><?= htmlspecialchars(!empty($entry['remarks']) ? $entry['remarks'] : 'Approved') ?></td>

              </tr>
              <?php endforeach; ?>

        <?php else: ?>
          <tr><td colspan="6">No COC records available.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Signatures -->
    <div class="signature-section">
      <div class="prepared">
      <p>Prepared by:</p><br>
      <p><strong>JOHN RYAN C. DELA CRUZ, PhD.</strong><br>
      Supervising Administrative Officer</p>
      <div class="copy-notes">
        <p><em>First Copy: Admin</em></p>
        <p><em>Second Copy: Employee</em></p>
      </div>
      </div>

      <div class="approved-received">
      <div>
        <p>Approved by:</p><br>
        <p>_______________________________<br>
        Department Head</p>
      </div>
      <div>
          <p>Received by:</p>
          <div class="received-line"></div>
          <p class="signature-label">Printed Name and Signature</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>