<?php
// Sample data
$data = [
  'gender' => 'Mr.',
  'employeeName' => 'Juan Dela Cruz',
  'earnedHours' => 12,
  'dateIssued' => '2025-04-10',
  'validUntil' => '2025-12-31',
  'cocDetails' => [
    [
      'beginningBalance' => 20,
      'dateOfCTO' => '2025-03-15',
      'usedCOCs' => 8,
      'remainingCOCs' => 12,
      'remarks' => 'Approved'
    ]
  ]
];
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
      max-width: 600px;
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
      margin-top: 30px;   /* ↓ tighter spacing */
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
      <img src="/assets/iligan_logo.png" alt="City of Iligan Logo">
      <div class="gov-header">
        <h3>Republic of the Philippines</h3>
        <h3><strong>City of Iligan</strong></h3>
        <h2>OFFICE OF THE ILIGAN CITY WATERWORKS SYSTEM</h2>
        <p>Lluch Park Street, Dona Juana Lluch Subdivision</p>
        <p>Pala-o, Iligan City 9200 Philippines</p>
      </div>
      <img src="/assets/logo.png" alt="Waterworks Logo">
    </div>

    <!-- Title Banner -->
    <div class="banner-title">
      <h2>CERTIFICATE OF COC EARNED</h2>
    </div>

    <!-- Content -->
    <p>This certificate entitles <?= $data['gender']; ?> <?= $data['employeeName']; ?> to <?= $data['earnedHours']; ?> hrs. of Compensatory Overtime Credits.</p>
    <p><strong>Date Issued:</strong> <?= $data['dateIssued']; ?></p>
    <p><strong>Valid Until:</strong> <?= $data['validUntil']; ?></p>

    <!-- Table -->
    <table>
      <thead>
        <tr>
          <th>No. of Hours of Earned COCs/ Beginning Balance</th>
          <th>Date of CTO</th>
          <th>Used COCs</th>
          <th>Remaining COCs</th>
          <th>Remarks</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['cocDetails'] as $row): ?>
          <tr>
            <td><?= $row['beginningBalance']; ?></td>
            <td><?= $row['dateOfCTO']; ?></td>
            <td><?= $row['usedCOCs']; ?></td>
            <td><?= $row['remainingCOCs']; ?></td>
            <td><?= $row['remarks']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- Signatures -->
    <div class="signature-section">
      <!-- Prepared by -->
      <div class="prepared">
        <p>Prepared by:</p>
        <strong>JOHN RYAN C. DELA CRUZ, PhD.</strong><br>
        <span>Supervising Administrative Officer</span>

        <div class="copy-notes">
          <p><em>First Copy: Admin</em></p>
          <p><em>Second Copy: Employee</em></p>
        </div>
      </div>

      <!-- Approved and Received -->
      <div class="approved-received">
        <div>
          <p>Approved by:</p>
          <p><strong>Engr. JAIME C. SATO</strong><br>Department Head</p>
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