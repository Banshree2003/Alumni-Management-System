<?php
session_start(); // Start the session (if not already started)

// Include database connection
include_once "connect_database.php";

// Check if the form for deleting an announcement is submitted
if (isset($_POST['delete_announcement']) && isset($_POST['announcement_id'])) {
    // Retrieve announcement ID from the form
    $announcement_id = $_POST['announcement_id'];

    // Prepared statement to delete the announcement
    $stmt = $conn->prepare("DELETE FROM announcement WHERE ann_id = ?");
    $stmt->bind_param("s", $announcement_id);

    if ($stmt->execute()) {
        // Close the prepared statement
        $stmt->close();
        
        // Redirect to the announcement page
        header("Location: announcement.php");
        exit(); // Ensure that script execution stops after redirection
    } else {
        echo "<p>Error deleting announcement: " . $stmt->error . "</p>";
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Announcement - Delete Announcement</title>
    <link rel="stylesheet" href="css/header_navigationbar.css" />
    <style>
        table, th, td {
            border: 2px solid #050119;
            border-collapse: collapse;
            font-size: 20px;
            width: 900px;
            text-align: center;
        }

        button.bt1 {
            border-radius: 4px;
            font-size: 16px;
            padding: 5px 15px;
            font-weight: bold;
            border: 2px;
            background-color: #050119;
            color: white;
        }

        button.bt1:hover {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
<center><H1> SELECT ANNOUNCEMENT TO DELETE</H1>
<?php
// Retrieve announcements from the database
$sql = "SELECT * FROM announcement";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Announcement Name</th><th>Announcement Description</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ann_name'] . "</td>";
        echo "<td>" . $row['ann_desc'] . "</td>";
        echo "<td>";
        echo "<form action='delete_announcement.php' method='post'>";
        echo "<input type='hidden' name='announcement_id' value='" . $row['ann_id'] . "'>";
        echo "<button type='submit' name='delete_announcement'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No announcements found";
}
?>
</center>
</body>
</html>
