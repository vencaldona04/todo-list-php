<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            display: flex;
            background-color: #f0f0f0;
        }

        .sidebar {
            background-color: #003399;
            width: 200px;
            padding: 20px;
            box-sizing: border-box;
            color: white;
            text-align: center;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
            background-color: white;
            border-radius: 10px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .task-input {
            width: calc(100% - 100px); /* Adjusted width to accommodate the button */
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: inline-block; /* Align with the button */
        }

        .add-task-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            display: inline-block; /* Align with the input */
            margin-left: 10px; /* Space between input and button */
            vertical-align: top; /* Align to the top */
        }

        .task-list {
            list-style: none;
            padding: 0;
        }

        .task-list li {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task-list li:last-child {
            border-bottom: none;
        }

        .completed-tasks {
            margin-top: 20px;
        }

        .completed-tasks li {
            background-color: #f0f0f0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-decoration: line-through;
            border-radius: 5px;
        }

        .completed-tasks li:last-child {
            border-bottom: none;
        }

        .complete-btn, .delete-btn, .edit-btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            margin-left: 5px;
            border-radius: 5px;
            text-decoration: none;
        }

        .complete-btn {
            background-color: #28a745;
            color: white;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .edit-btn {
            background-color: #ffc107;
            color: black;
        }

        .task-actions {
            display: flex;
        }
        .edit-form {
            display: none;
        }

        h2 {
            text-align: left; /* Align headings to the left */
        }

        .new-task-form {
            margin-bottom: 20px;
        }

        .new-task-form::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Add Task</h2>
        <a href="#"> </a>
    </div>

    <div class="content">
        <div class="new-task-form">
            <h2>New Task</h2>
            <form action="add_task.php" method="post">
                <input type="text" class="task-input" name="task_name" placeholder="Task" required>
                <button type="submit" class="add-task-btn">ADD</button>
            </form>
        </div>

        <h2>List</h2>
        <ul class="task-list">
            <?php
            include 'db.php';

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $tasksPerPage = 5;
            $offset = ($page - 1) * $tasksPerPage;

            $stmt = $conn->prepare("SELECT * FROM tasks WHERE is_completed = 0 ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $stmt->bindParam(':limit', $tasksPerPage, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($tasks as $task) {
                echo "<li>";
                echo htmlspecialchars($task['task_name']);
                echo "<div class='task-actions'>";
                echo "<a href='edit_task.php?id=" . $task['id'] . "' class='edit-btn'>Edit</a>";
                echo " <a href='complete_task.php?id=" . $task['id'] . "' class='complete-btn'>Complete</a>";
                echo " <a href='delete_task.php?id=" . $task['id'] . "' class='delete-btn'>Delete</a>";
                echo "</div>";
                echo "</li>";
            }
            ?>
        </ul>
        <?php
            $totalTasks = $conn->query("SELECT COUNT(*) FROM tasks WHERE is_completed = 0")->fetchColumn();
            $totalPages = ceil($totalTasks / $tasksPerPage);

            if ($totalPages > 1) {
                echo "<div class='pagination'>";
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?page=" . $i . "'>" . $i . "</a> ";
                }
                echo "</div>";
            }
        ?>

        <div class="completed-tasks">
            <h2>Completed</h2>
            <ul class="task-list">
                <?php
                $stmt = $conn->query("SELECT * FROM tasks WHERE is_completed = 1 ORDER BY created_at DESC");
                $completedTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($completedTasks as $task) {
                    echo "<li>" . htmlspecialchars($task['task_name']) . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>