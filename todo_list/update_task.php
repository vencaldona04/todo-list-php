<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && isset($_POST['task_name'])) {
    $id = $_POST['id']; 
    $task_name = $_POST['task_name']; 

    try {
        $stmt = $conn->prepare("UPDATE tasks SET task_name = :task_name WHERE id = :id");

        $stmt->bindParam(':task_name', $task_name);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        header("Location: index.php");
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
    }
}
?>