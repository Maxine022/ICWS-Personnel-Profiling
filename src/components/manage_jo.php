<?php
include_once __DIR__ . '/../../backend/db.php';

// Fetch job orders from the job_order table and join with personnel and salary details
$query = $conn->prepare("
  SELECT 
    j.jobOrder_id,
    p.Emp_No,
    p.full_name,
    p.position,
    p.division,
    s.salaryGrade,
    s.monthlySalary,
    j.startingDate,
    j.endDate
  FROM job_order j
  JOIN personnel p ON j.personnel_id = p.personnel_id
  JOIN salary s ON j.salary_id = s.salary_id
");
$query->execute();
$result = $query->get_result();
$jobOrders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobOrders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Job Orders</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    <h4 class="mb-3">Manage Job Orders</h4>
    <a href="/src/components/add_job_order.php" class="btn btn-primary mb-3">Add New Job Order</a>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Job Order ID</th>
          <th>Employee Number</th>
          <th>Full Name</th>
          <th>Position</th>
          <th>Division</th>
          <th>Salary Grade</th>
          <th>Monthly Salary</th>
          <th>Starting Date</th>
          <th>Ending Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($jobOrders as $job): ?>
          <tr>
            <td><?= htmlspecialchars($job['jobOrder_id']) ?></td>
            <td><?= htmlspecialchars($job['Emp_No']) ?></td>
            <td><?= htmlspecialchars($job['full_name']) ?></td>
            <td><?= htmlspecialchars($job['position']) ?></td>
            <td><?= htmlspecialchars($job['division']) ?></td>
            <td><?= htmlspecialchars($job['salaryGrade']) ?></td>
            <td><?= htmlspecialchars($job['monthlySalary']) ?></td>
            <td><?= htmlspecialchars($job['startingDate']) ?></td>
            <td><?= htmlspecialchars($job['endDate']) ?></td>
            <td>
              <a href="/src/components/edit_job_order.php?id=<?= $job['jobOrder_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="/src/components/delete_job_order.php?id=<?= $job['jobOrder_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
