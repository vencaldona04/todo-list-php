<?php
// add_task.php - Handles adding a new task

include 'db.php'; // Includes the database connection file (db.php)

// Checks if the request method is POST, ensuring the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST["task_name"]; // Retrieves the task name from the submitted form data

    try {
        // Prepares an SQL INSERT statement to add a new task to the 'tasks' table
        $stmt = $conn->prepare("INSERT INTO tasks (task_name) VALUES (:task_name)");

        // Binds the task name parameter to the prepared statement, preventing SQL injection
        $stmt->bindParam(':task_name', $task_name);

        // Executes the prepared statement, adding the task to the database
        $stmt->execute();

        // Redirects the user to the index.php page after successfully adding the task
        header("Location: index.php");
    } catch (PDOException $e) {
        // Catches any PDOExceptions (database errors) that occur during the process
        // Displays an error message with the specific error details
        echo "Error: " . $e->getMessage();
    }
}
?>