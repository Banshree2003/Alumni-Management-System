<?php
// Check if the user is logged in and is an admin
session_start();

// Check if feedback ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Connect to database
    include_once "connect_database.php";
    
    // Prepare SQL statement to delete feedback
    $id = $_GET['id'];
    $sql = "DELETE FROM feedback WHERE id = $id";
    
    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Feedback deleted successfully.";
        header("Location: view_feedback.php");
        exit;
    } else {
        echo "Error deleting feedback: " . $conn->error;

    }
    
    $conn->close();
} else {
    echo "Invalid feedback ID.";
}
?>
