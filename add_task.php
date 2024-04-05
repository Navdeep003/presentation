<?php
include 'db_info.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $taskContent = $_POST['taskContent']; // Update to match the column name in your tasks table
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $dueDate = $_POST['dueDate'];

    // Insert data into database
    $sql = "INSERT INTO tasks (taskContent, description, priority, dueDate) VALUES ('$taskContent', '$description', '$priority', '$dueDate')"; // Update column names here
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // Redirect to index page after adding task
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
