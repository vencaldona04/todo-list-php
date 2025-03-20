<?php
include 'db.php'; // Includes the database connection file (db.php)

// Checks if the request method is POST AND if both 'id' and 'task_name' are set in the POST data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['task_name'])) {
    $id = $_POST['id']; // Retrieves the task ID from the POST data
    $task_name = $_POST['task_name']; // Retrieves the updated task name from the POST data

    try {
        // Prepares an SQL UPDATE statement to update the task name in the 'tasks' table
        $stmt = $conn->prepare("UPDATE tasks SET task_name = :task_name WHERE id = :id");

        // Binds the task name parameter to the prepared statement, preventing SQL injection
        $stmt->bindParam(':task_name', $task_name);

        // Binds the task ID parameter to the prepared statement, preventing SQL injection
        $stmt->bindParam(':id', $id);

        // Executes the prepared statement, updating the task name in the database
        $stmt->execute();

        // Redirects the user to the index.php page after successfully updating the task
        header("Location: index.php");
    } catch (PDOException $e) {
        // Catches any PDOExceptions (database errors) that occur during the process
        // Displays an error message with the specific error details
        echo "Error: " . $e->getMessage();
    }
}
?>