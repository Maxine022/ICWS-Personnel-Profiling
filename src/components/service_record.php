<?php
ob_start(); // Start output buffering
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once __DIR__ . '/../../backend/db.php';

$emp_no = $_GET['Emp_No'] ?? null; // Get Emp_No from the query string or set it to null

if ($emp_no) {
    $stmt = $conn->prepare("
        SELECT sr.startDate AS start, sr.endDate AS end, sr.position, sr.division
        FROM service_record sr
        JOIN personnel p ON sr.personnel_id = p.personnel_id
        WHERE p.Emp_No = ?
    ");
    $stmt->bind_param("s", $emp_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $pagedRecords = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $pagedRecords = []; // No records if Emp_No is not provided
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_service_record']) && $_POST['submit_service_record'] == '1') {
    // Validate required fields
    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['position']) && !empty($_POST['division'])) {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $position = $_POST['position'];
        $division = $_POST['division'];

        // Fetch the personnel_id using Emp_No
        if ($emp_no) {
            $stmt = $conn->prepare("SELECT personnel_id FROM personnel WHERE Emp_No = ?");
            $stmt->bind_param("s", $emp_no);
            $stmt->execute();
            $stmt->bind_result($personnel_id);
            $stmt->fetch();
            $stmt->close();

            if ($personnel_id) {
                // Insert the service record with the correct personnel_id
                $stmt = $conn->prepare("INSERT INTO service_record (personnel_id, startDate, endDate, position, division) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $personnel_id, $start_date, $end_date, $position, $division);

                if ($stmt->execute()) {
                    $stmt->close();
                    // Redirect to avoid form resubmission
                    header("Location: " . $_SERVER['PHP_SELF'] . "?Emp_No=" . urlencode($emp_no));
                    exit();
                } else {
                    echo "Error: Unable to add service record.";
                }
            } else {
                echo "Error: Employee not found.";
            }
        } else {
            echo "Error: Emp_No is missing.";
        }
    } else {
        echo "Error: All fields are required.";
    }
}
ob_end_flush(); // Flush the output buffer
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold">Service Record</h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addServiceRecordModal">
            <i class="fas fa-plus"></i> Add Service Record
        </button>
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
</div>

<!-- Add Service Record Modal -->
<div class="modal fade" id="addServiceRecordModal" tabindex="-1" aria-labelledby="addServiceRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceRecordModalLabel">Add Service Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="serviceRecordForm" method="POST" action="">
                <input type="hidden" name="submit_service_record" value="1">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="division" class="form-label">Division</label>
                            <input type="text" class="form-control" id="division" name="division" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Service Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript validation for the form
    document.getElementById('serviceRecordForm').addEventListener('submit', function (e) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const position = document.getElementById('position').value.trim();
        const division = document.getElementById('division').value.trim();

        if (!startDate || !endDate || !position || !division) {
            e.preventDefault(); // Prevent form submission
            alert('All fields are required!');
        } else if (new Date(startDate) > new Date(endDate)) {
            e.preventDefault(); // Prevent form submission
            alert('Start Date cannot be later than End Date!');
        }
    });
</script>