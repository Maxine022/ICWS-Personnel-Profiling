<?php
// Use LAN IP for database connection (change '192.168.1.100' to your MySQL server's LAN IP)
$conn = new mysqli('192.168.1.96', 'root', '', 'icws_db');  // LAN connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>