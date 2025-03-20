<?php
// Database connection configuration
$host = 'localhost'; // Database host (usually 'localhost' for local development)
$dbname = 'todo_list'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (leave empty if no password is set)

try {
    // Attempt to create a new PDO (PHP Data Objects) database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception, so errors will throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // If a PDOException occurs (connection fails), display an error message and terminate script execution.
    die("Database connection failed: " . $e->getMessage());
}
?>