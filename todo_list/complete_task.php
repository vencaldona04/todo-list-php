<?php
// complete_task.php - Handles marking a task as completed

include 'db.php'; // Includes the database connection file (db.php)

// Checks if the 'id' parameter is set in the URL's GET request
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieves the task ID from the GET request

    try {
        // Prepares an SQL UPDATE statement to mark a task as completed
        $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id = :id");

        // Binds the task ID parameter to the prepared statement, preventing SQL injection
        $stmt->bindParam(':id', $id);

        // Executes the prepared statement, updating the task status in the database
        $stmt->execute();

        // Redirects the user to the index.php page after successfully marking the task as completed
        header("Location: index.php");
    } catch (PDOException $e) {
        // Catches any PDOExceptions (database errors) that occur during the process
        // Displays an error message with the specific error details
        echo "Error: " . $e->getMessage();
    }
}
?>