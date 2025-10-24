<?php
$servername = "localhost";
$username = "root";    
$password = "";        
$dbname = "user_auth_demo";


$conn = new mysqli($servername, $username, $password, $dbname);


$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}
?>
