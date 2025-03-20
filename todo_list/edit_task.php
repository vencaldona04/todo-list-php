<?php
include 'db.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id']; 

    $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = :id");

    $stmt->bindParam(':id', $id);

    $stmt->execute();

    $task = $stmt->fetch(PDO::FETCH_ASSOC);

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
        echo "Task not found.";
    }
}
?>