<?php

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_name = $_POST["task_name"]; 

    try {
        $stmt = $conn->prepare("INSERT INTO tasks (task_name) VALUES (:task_name)");

        $stmt->bindParam(':task_name', $task_name);

        $stmt->execute();

        header("Location: index.php");
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
    }
}
?>