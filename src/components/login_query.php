<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Dummy Login Logic (Replace with database authentication)
    if ($email == "admin@example.com" && $password == "password123") {
        echo "<script>alert('Login Successful!');</script>";
    } else {
        echo "<script>alert('Invalid Email or Password');</script>";
    }
}
?>