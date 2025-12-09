<?php
session_start(); // Start the session (if not already started)

// Include database connection script
include_once "connect_database.php";

// Check if the form for deleting an event is submitted
if(isset($_POST['deleteevent'])) {
    // Retrieve event ID from the form
    $event_id_to_delete = $_POST['e_id'];

    // Prepared statement to delete the event
    $stmt = $conn->prepare("DELETE FROM event WHERE e_id = ?");
    $stmt->bind_param("s", $event_id_to_delete);

    if ($stmt->execute()) {
        echo "<p class='p1'>*****Event successfully deleted.*****</p>";

        // Redirect to event page after deletion
        header("Location: events.php");
        exit(); // Ensure no further output is sent after redirection
    } else {
        $error = "Failed to delete event: " . $stmt->error; // Get specific error message
        echo $error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Function to retrieve and display events for admin to choose from
function displayEvents($conn) {
    $sql = "SELECT e_id, e_name FROM event";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<select name='e_id'>";
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['e_id'] . "'>" . $row['e_name'] . "</option>";
        }
        echo "</select>";
    } else {
        echo "No events found";
    }
}
?>

<!DOCTYPE html> 
<html>
<head>
    <title>Delete Event</title>
</head>
<body>
<form action="deleteevent.php" method="post">
<table align="center" style="border:2px hidden;" cellspacing="20">
<caption style= "font-size:30px"> Select Event to Delete: </caption>
<tr>
<th align="left" width="250" style="border:hidden;font-size:20px">Event: </th>
<td width="150" style="border:hidden">
    <?php displayEvents($conn); ?>
</td>
</tr>
<tr>
<td colspan=2 align="right" style="border:hidden;"><button class="bt1" type="submit" name="deleteevent" >Delete</button></td>
</tr>
</table>
</form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
