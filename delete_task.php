<?php
// Include database connection
include 'db_info.php';

// Check if task ID is provided
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Delete task from database
    $sql = "DELETE FROM tasks WHERE id='$taskId'";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // Redirect to the index page after deletion
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn); // Display error message if deletion fails
    }
}

// Close database connection
mysqli_close($conn);
?>
