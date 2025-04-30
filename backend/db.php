<?php
$conn = new mysqli('localhost', 'root', '', 'icws_db');  // Ensure 'icws_db' matches your database name

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>