<?php
// delete_task.php - Handles deleting a task

include 'db.php'; // Includes the database connection file (db.php)

// Checks if the 'id' parameter is set in the URL's GET request
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieves the task ID from the GET request

    try {
        // Prepares an SQL DELETE statement to remove a task from the 'tasks' table
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");

        // Binds the task ID parameter to the prepared statement, preventing SQL injection
        $stmt->bindParam(':id', $id);

        // Executes the prepared statement, deleting the task from the database
        $stmt->execute();

        // Redirects the user to the index.php page after successfully deleting the task
        header("Location: index.php");
    } catch (PDOException $e) {
        // Catches any PDOExceptions (database errors) that occur during the process
        // Displays an error message with the specific error details
        echo "Error: " . $e->getMessage();
    }
}
?>