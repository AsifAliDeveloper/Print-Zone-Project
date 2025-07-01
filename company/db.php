<?php
$servername = "localhost";  // Your server address
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password
$dbname = "print_zone";     // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
