<?php
// Database credentials
$host = "localhost"; // Replace with your server address
$user = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "print_zone"; // Replace with your database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Close connection
/*$conn->close();*/
?>
