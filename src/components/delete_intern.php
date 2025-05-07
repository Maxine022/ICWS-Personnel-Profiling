<?php
include_once __DIR__ . '/../../backend/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection
include_once __DIR__ . '/../../backend/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    $intern_id = intval($data['intern_id'] ?? 0);

    // Validate the ID
    if ($intern_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID.']);
        exit;
    }

    // Delete the intern from the database
    $sql = "DELETE FROM intern WHERE intern_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $intern_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Intern deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete intern: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}