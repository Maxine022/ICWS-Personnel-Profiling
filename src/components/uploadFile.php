include 'db.php'; // path to your db connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['data_file'])) {
    $file = $_FILES['data_file'];
    if ($file['type'] === 'application/json') {
        $jsonData = file_get_contents($file['tmp_name']);
        $employees = json_decode($jsonData, true);

        if ($employees && is_array($employees)) {
            foreach ($employees as $emp) {
                $stmt = $conn->prepare("INSERT INTO regular_employees (full_name, position, division, plantilla_number, contact_number, salary_grade, step, level, aca_pera, monthly_salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param(
                    "ssssssssss",
                    $emp['full_name'],
                    $emp['position'],
                    $emp['division'],
                    $emp['plantilla_number'],
                    $emp['contact_number'],
                    $emp['salary_grade'],
                    $emp['step'],
                    $emp['level'],
                    $emp['aca_pera'],
                    $emp['monthly_salary']
                );
                $stmt->execute();
            }
            $message = "Data inserted into database successfully!";
        } else {
            $message = "Invalid JSON structure.";
        }
    } else {
        $message = "Only JSON files are allowed.";
    }
}
