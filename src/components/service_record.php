<?php include_once __DIR__ . '/../../backend/db.php'; 

$emp_no = $_GET['Emp_No'] ?? null; // Get Emp_No from the query string or set it to null

if ($emp_no) {
    $stmt = $conn->prepare("SELECT * FROM service_record WHERE Emp_No = ?");
    $stmt->bind_param("s", $emp_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $pagedRecords = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $pagedRecords = []; // No records if Emp_No is not provided
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold">Service Record</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceRecordModal">Add Service Record</button>
</div>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Starting Date</th>
            <th>Ending Date</th>
            <th>Position</th>
            <th>Division</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $pagedRecords = $pagedRecords ?? []; 
        foreach ($pagedRecords as $record) { ?>
            <tr>
                <td><?php echo htmlspecialchars($record['start']); ?></td>
                <td><?php echo htmlspecialchars($record['end']); ?></td>
                <td><?php echo htmlspecialchars($record['position']); ?></td>
                <td><?php echo htmlspecialchars($record['division']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<nav class="pagination-container">
    <ul class="pagination pagination-sm justify-content-center">
        <?php 
        $currentPage = $currentPage ?? 1; // Default to 1 if not set
        $totalPages = $totalPages ?? 1; // Default to 1 if not set

        if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link prev-next" href="?page=<?php echo $currentPage - 1; ?>">« Prev</a>
            </li>
        <?php endif; ?>
        <?php 
        for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link prev-next" href="?page=<?php echo $currentPage + 1; ?>">Next »</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Add Service Record Modal -->
<div class="modal fade" id="addServiceRecordModal" tabindex="-1" aria-labelledby="addServiceRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="addServiceRecordModalLabel">Add Service Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Starting Date</label>
                        <input type="date" class="form-control" id="startDate" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">Ending Date</label>
                        <input type="date" class="form-control" id="endDate" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
                    <div class="mb-3">
                        <label for="division" class="form-label">Division</label>
                        <input type="text" class="form-control" id="division" name="division" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// service_record.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $position = $_POST['position'];
    $division = $_POST['division'];

    // Correct the column names to match the schema
    $stmt = $conn->prepare("INSERT INTO service_record (startDate, endDate, position, division) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $start_date, $end_date, $position, $division);

    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect to the same page to display the updated records
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>