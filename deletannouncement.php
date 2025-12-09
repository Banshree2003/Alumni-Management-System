<!DOCTYPE html>
<html>
<head>
    <title>Announcement - Delete Announcement</title>
    <link rel="stylesheet" href="css/header_navigationbar.css" />
    <?php
    // Start the session (if not already started)
    session_start();

    // Include necessary files
    include_once "setting/adminpage_navigation.php";
    include_once "connect_database.php";

    // Check if the delete link is clicked
    if(isset($_GET['deletannouncement'])) {
        // Retrieve announcement ID from the URL parameter
        $announcement_id_to_delete = $_GET['deletannouncement'];

        // Prepared statement to delete the announcement
        $stmt = $conn->prepare("DELETE FROM announcement WHERE ann_id = ?");
        $stmt->bind_param("s", $announcement_id_to_delete);        
        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "announcement deleted successfully.";
            header("Location: announcement.php");
            exit;
        } else {
            echo "Error deleting announcement: " . $conn->error;
    
        }
        // Close the prepared statement
        $stmt->close();
    }
    ?>
</head>
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
<body>
<br><br>
<table align="center">
    <caption>Announcement Details:</caption>
    <tr>
        <th>NO</th>
        <th>Announcement ID</th>
        <th>Announcement Name</th>
        <th>Announcement Description</th>
        <th>Announcement Time</th>
        <th>Action</th> <!-- Added Action column -->
    </tr>

    <?php
    $sqlshowann = "SELECT * FROM announcement";
    $resultannmt = $conn->query($sqlshowann);
    $no = 1;

    while ($row = $resultannmt->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td>" . $row['ann_id'] . "</td>";
        echo "<td>" . $row['ann_name'] . "</td>";
        echo "<td>" . $row['ann_desc'] . "</td>";
        echo "<td>" . $row['ann_time'] . "</td>";
        echo "<td><a href='announcement.php?deletannouncement=" . $row['ann_id'] . "'>Delete</a></td>"; // Added delete link
        echo "</tr>";
        $no++;
    }
    ?>
</table>
<br><br><br>
</body>
</html>