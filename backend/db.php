<?php
// Connect to both MySQL servers
$conn1 = new mysqli('192.168.1.96', 'root', '', 'icws_db');
$conn2 = new mysqli('192.168.1.113', 'root', '', 'icws_db');

// Check connections
if ($conn1->connect_error) {
    die("Connection to 192.168.1.96 failed: " . $conn1->connect_error);
}
if ($conn2->connect_error) {
    die("Connection to 192.168.1.113 failed: " . $conn2->connect_error);
}

// Example: Query from first server
$result1 = $conn1->query("SELECT * FROM some_table");

// Example: Query from second server
$result2 = $conn2->query("SELECT * FROM another_table");

// Use $result1 and $result2 as needed
?>