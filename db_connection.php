<?php
// Database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "agro_web_app";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Optional: Set charset to avoid encoding issues
$conn->set_charset("utf8mb4");
?>
