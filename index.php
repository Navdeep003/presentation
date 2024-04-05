<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Planner</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Daily Planner</h1>
        <form action="add_task.php" method="post">
            <input type="text" name="taskContent" placeholder="Add a new task" required>
            <textarea name="description" placeholder="Description"></textarea>
            <select name="priority" required>
                <option value="high">High Priority</option>
                <option value="medium">Medium Priority</option>
                <option value="low">Low Priority</option>
            </select>
            <input type="date" name="dueDate">
            <button type="submit">Add Task</button>
        </form>
        <ul class="task-list">
            <?php
            include 'db_info.php';
            $sql = "SELECT * FROM tasks ORDER BY FIELD(priority, 'high', 'medium', 'low'), dueDate ASC";
            $result = mysqli_query($conn, $sql);
            $currentPriority = '';
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $priority = ucfirst($row['priority']); // Capitalize priority for display
                    // Check if priority has changed
                    if ($priority != $currentPriority) {
                        echo "<h2 class='priority-heading'>$priority Priority</h2>"; // Display priority heading
                        $currentPriority = $priority;
                    }
                    // Display task
                    echo "<li class='task-item'>";
                    echo "<div class='task-content'>" . $row['taskContent'] . "</div>";
                    echo "<div class='task-description'>" . $row['description'] . "</div>";
                    echo "<div class='due-date'>Due: " . $row['dueDate'] . "</div>";
                    echo "<div class='action-buttons'>";
                    echo "<a href='edit_task.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>";
                    echo "<a href='delete_task.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a>";
                    echo "</div>";
                    echo "</li>";
                }
            } else {
                echo "<li class='no-tasks'>No tasks found.</li>";
            }
            mysqli_close($conn);
            ?>
        </ul>
    </div>
</body>
</html>
