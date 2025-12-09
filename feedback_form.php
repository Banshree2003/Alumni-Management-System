<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header_navigationbar.css" />
<link rel="stylesheet" href="css/feedback.css" />
<?php
include_once"setting/index_navigation.php";
?>  
</head>
<body>
    <center>
    <h1>Feedback Form</h1>
    <form id="feedbackForm" action="submit_feedback.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email (Optional):</label>
        <input type="email" id="email" name="email"><br>

        <label for="category">Feedback Category:</label>
        <select id="category" name="category" required>
            <option value="User Experience">User Experience</option>
            <option value="Feature Request">Feature Request</option>
            <option value="Bug Report">Bug Report</option>
            <option value="General Feedback">General Feedback</option>
            <option value="Other">Other</option>
        </select><br>

        <label for="message">Feedback Message:</label>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>

        <label for="suggestions">Suggestions for Improvement (Optional):</label>
        <textarea id="suggestions" name="suggestions" rows="4" cols="50"></textarea><br>

        <button type="submit">Submit Feedback</button>
    </form>
    </center>
</body>
</html>
