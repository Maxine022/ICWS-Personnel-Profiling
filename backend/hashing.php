<?php
// The password you want to hash
$password = 'your_password';  // Replace 'your_password' with the actual password you want to test

// Hash the password using the password_hash() function
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password to use it in phpMyAdmin
echo "Hashed password: " . $hashed_password;
?>
