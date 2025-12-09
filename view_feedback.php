<html><style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 70%;
	background-color: white;
}

td, th {
    border: 1px solid #050119;
    text-align: center;
    padding: 8px;
}
</style>
</html>
<?php
include_once "setting/adminpage_navigation.php";
include_once "connect_database.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve feedback from database
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display feedback in a table
    echo "<center><h2>Feedback Entries</h2></center>";
    echo "<table border='1' >
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Category</th>
                <th>Message</th>
                <th>Suggestions</th>
                <th>Date Submitted</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "<td>" . $row['suggestions'] . "</td>";
        echo "<td>" . $row['submitted_at'] . "</td>";
        echo "<td><a href='delete_feedback.php?id=".$row['id']."'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No feedback entries found.";
}

$conn->close();
?>
