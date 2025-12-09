<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Alumni - Approve </title>

<link rel="stylesheet" href="css/header_navigationbar.css" />
<link rel="stylesheet" href="css/add_forum_post.css"/>
<?php
include_once "setting/adminpage_navigation.php";
include_once "connect_database.php";
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
table, th, td {
    border: 2px solid #050119;
    border-collapse: collapse;
	font-size: 20px;
	width : 900px;
	text-align: center;
}
</style>
<body>

<?php
if(isset($_POST['approve']))
{
	$alid=$_REQUEST['aluid'];
	
	if ($alid=='')
	{
		echo "<br /><p class=p1>*****Please insert Alumni Registration Number for membership approval.*****</p>";
	}
	else
	{
		$sql = "UPDATE alumnimember SET al_status= 'Approve' WHERE pi_register = '$alid'";
		if ($conn->query($sql) === TRUE) 
		{
	    	echo "<br><p class=p1>*****Approval successful.*****</p>";
	    	echo "<p class=p2><a href=manage_alumni.php>View Alumni Membership</a></p><br>";
		} 
		else 
		{
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}	
}
?>

<br><br><br>

<form id="approveForm" method="post">
    <table align="center" style="border:2px hidden;" cellspacing="20">
        <caption style= "font-size:30px"> Insert Alumni Registration Number for approval: </caption>
        <tr>
            <th align="left" width="250" style="border:hidden;font-size:20px">Alumni Registration Number: </th>
            <td width="150" style="border:hidden"><input size="45" type="text" value="" name="aluid"/></td>
        </tr>
        <tr>
            <td colspan=3 align="right" style="border:hidden"><button type="button" id="approveButton">Approve</button></td>
        </tr>
    </table>
</form>

<br><br>

<table align="center">
    <caption> Alumni without Approval </caption>
    <tr>
        <th> NO </th>
        <th> Alumni Registration Number </th>
        <th> Alumni Name</th>
        <th> Approval Status </th>
    </tr>
    <?php
    $sqlshowAWA= "SELECT alumnimember.pi_register, alumniinfo.pi_name, alumnimember.al_status FROM alumnimember, alumniinfo WHERE alumnimember.pi_register = alumniinfo.pi_register AND alumnimember.al_status = 'Not Approve'";
    $resultAWA = $conn->query($sqlshowAWA);
    $no = 1;

    while ($row = mysqli_fetch_assoc($resultAWA))
    {
        echo "<tr>";
        echo "<td>" . $no. "</td>";
        echo "<td>" . $row['pi_register']. "</td>";
        echo "<td>" . $row['pi_name']. "</td>";
        echo "<td>" . $row['al_status']. "</td>";
        $no++;
    }
    ?>
</table>
<div style="text-align: center; margin-top: 20px;">
    <a href="manage_alumni.php">Back to Manage Alumni</a>
</div>

<script>
$(document).ready(function() {
    $('#approveButton').click(function() {
        var aluid = $('input[name="aluid"]').val();
        $.ajax({
            type: 'POST',
            url: 'approve.php',
            data: {
                approve: true,
                aluid: aluid
            },
            success: function(response) {
                // Reload the current page
                window.location.reload();
            }
        });
    });
});
</script>

<br><br><br><br><br><br>

</body>
</html>
