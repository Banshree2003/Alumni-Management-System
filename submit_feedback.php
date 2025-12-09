<?php
// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$category = $_POST['category'];
$message = $_POST['message'];
$suggestions = $_POST['suggestions'];

// Connect to your database (replace placeholders with your actual database details)
include_once "connect_database.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert feedback into database
$sql = "INSERT INTO feedback (name, email, category, message, suggestions) VALUES ('$name', '$email', '$category', '$message', '$suggestions')";

if ($conn->query($sql) === TRUE) {
    echo "Feedback submitted successfully!";
    header("Location: feedback_form.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
