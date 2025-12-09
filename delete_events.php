<?php
session_start(); // Start the session (if not already started)
?>
<!DOCTYPE html>
<html>
<head>
<title>Events - Delete Event</title>

<link rel="stylesheet" href="css/header_navigationbar.css" />
<link rel="stylesheet" href="css/add_forum_post.css"/>
<?php
include_once "setting/adminpage_navigation.php";
include_once "connect_database.php";
?>

</head>
<style>
table, th, td {
    border: 2px solid saddlebrown;
    border-collapse: collapse;
	font-size: 20px;
	text-align: center;
}
button.bt1
{
	border-radius:4px;
	font-size:16px;
	padding:5px 15px;
	font-weight:bold;
	border:2px;
	background-color:burlywood;
	color:saddlebrown;
}
button.bt1:hover
{
	background-color:sienna;
	color:navajowhite;
}
</style>
<body>
<form action="delete_events.php" method="post">
<table align="center" style="border:2px hidden;" cellspacing="20">
<caption style= "font-size:30px"> Insert Event ID for deletion: </caption>
<tr>
<th align="left" width="250" style="border:hidden;font-size:20px">Event ID: </th>
<td width="150" style="border:hidden"><input size="45" type="text" value="" name="evid"/></td>
</tr>
</tr>
<td colspan=3 align="right" style="border:hidden;"><button class="bt1" type="submit" name="deleteevent" >Delete</button></td>
</tr>
</table>
</form>
<br></br><br></br>
<table align="center">
<caption> Event Details: </caption>
<tr>
	<th> NO </th>
	<th> Event ID </th>
	<th> Event Name </th>
	<th> Event Date </th>
	<th> Event Time </th>
	<th> Event Description </th>
	<th> Event Venue </th>
</tr>

<?php
$sqlshowev= "SELECT * FROM event";
$resultev = $conn->query($sqlshowev);
$no = 1;

while ($row = mysqli_fetch_assoc($resultev))
{
	echo "<tr>";
	echo "<td>" . $no. "</td>";
	echo "<td>" . $row['e_id']. "</td>";
	echo "<td>" . $row['e_name']. "</td>";
	echo "<td>" . $row['e_date']. "</td>";
	echo "<td>" . $row['e_time']. "</td>";
	echo "<td>" . $row['e_desc']. "</td>";
	echo "<td>" . $row['e_venue']. "</td>";
	$no++;
}
?>

<?php
session_start(); // Start the session (if not already started)

// Include database connection script
include_once "connect_database.php";

// Check if the form for deleting an event is submitted
if(isset($_POST['delete_event'])) {
    // Retrieve event ID from the form
    $event_id_to_delete = $_POST['event_id'];

    // Prepared statement to delete the event
    $stmt = $conn->prepare("DELETE FROM event WHERE e_id = ?");
    $stmt->bind_param("s", $event_id_to_delete);

    if ($stmt->execute()) {
        echo "<p class='p1'>*****Event successfully deleted.*****</p>";
    } else {
        $error = "Failed to delete event: " . $stmt->error; // Get specific error message
        echo $error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
</body>
<script>

</script>
</html>