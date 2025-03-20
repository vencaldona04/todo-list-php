<?php

include 'db.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id']; 

    try {
        $stmt = $conn->prepare("UPDATE tasks SET is_completed = 1 WHERE id = :id");

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        header("Location: index.php");
    } catch (PDOException $e) {
       
        echo "Error: " . $e->getMessage();
    }
}
?>