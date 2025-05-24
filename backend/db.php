<?php
// Connect to only one MySQL server
$conn = new mysqli('localhost', 'root', '', 'icws_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Now use $conn for all your queries
// Example:
$result = $conn->query("SELECT * FROM user");
// Use $result as needed
?>