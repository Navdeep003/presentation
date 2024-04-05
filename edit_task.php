<?php
include 'db_info.php';

// Check if task ID is provided
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Redirect to index page if task ID is not provided
    exit();
}

$taskId = $_GET['id'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $taskContent = isset($_POST['taskContent']) ? $_POST['taskContent'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $priority = isset($_POST['priority']) ? $_POST['priority'] : '';
    $dueDate = isset($_POST['dueDate']) ? $_POST['dueDate'] : '';

    // Update task in database
    $sql = "UPDATE tasks SET taskcontent='$taskContent', description='$description', priority='$priority', dueDate='$dueDate' WHERE id='$taskId'";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // Redirect to index page after updating task
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Retrieve task details from database
$sql = "SELECT * FROM tasks WHERE id='$taskId'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Task not found.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Task</h1>
        <form action="edit_task.php?id=<?php echo $taskId; ?>" method="post">
            <input type="text" name="taskContent" value="<?php echo isset($row['taskContent']) ? htmlspecialchars($row['taskContent']) : ''; ?>" required>
            <textarea name="description"><?php echo isset($row['description']) ? htmlspecialchars($row['description']) : ''; ?></textarea>
            <select name="priority" required>
                <option value="high" <?php if (isset($row['priority']) && $row['priority'] == 'high') echo 'selected'; ?>>High Priority</option>
                <option value="medium" <?php if (isset($row['priority']) && $row['priority'] == 'medium') echo 'selected'; ?>>Medium Priority</option>
                <option value="low" <?php if (isset($row['priority']) && $row['priority'] == 'low') echo 'selected'; ?>>Low Priority</option>
            </select>
            <input type="date" name="dueDate" value="<?php echo isset($row['dueDate']) ? $row['dueDate'] : ''; ?>">
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>

