<?php
include 'db.php'; // Includes the database connection file (db.php)

// Checks if the 'id' parameter is set in the URL's GET request
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Retrieves the task ID from the GET request

    // Prepares an SQL SELECT statement to fetch the task details based on the ID
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");

    // Binds the task ID parameter to the prepared statement, preventing SQL injection
    $stmt->bindParam(':id', $id);

    // Executes the prepared statement, fetching the task from the database
    $stmt->execute();

    // Fetches the task details as an associative array
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    // Checks if the task was found in the database
    if ($task) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Task</title>
        </head>
        <body>
            <h2>Edit Task</h2>
            <form action="update_task.php" method="post">
                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                <button type="submit">Update</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        // If the task with the given ID was not found, display an error message
        echo "Task not found.";
    }
}
?>