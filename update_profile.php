<?php
session_start();
if (!isset($_SESSION['id'])){
	header("location:login.html");
}
else
{
	$userid=$_SESSION['id'];
	$alusername=$_SESSION['alname'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" conten="text/html; charset=utf-8" />
<title>Update Profile</title>
<link rel="stylesheet" href="css/update_profile.css" />
</head>

<body>
<?php 
include_once"connect_database.php";
include_once"setting/updateprofile_navigation.php";
?>
<div>
<br /><br />
<h2>Update Profile</h2>
<br />
<form method="post" name="profile" enctype="multipart/form-data">
<table class="updatetable1" cellspacing="20px" align="center">
  <tr>
    <th>Address:</th>
    <td class="updatetd1"><textarea name="address" cols="40" rows="6"></textarea></td>
  </tr>
  <tr>
    <th>Mobile Number:</th>
    <td class="updatetd1"><input type="text" name="contact" size="38" maxlength="10" pattern="[0-9]{10}" required></td>
  </tr>
  <tr>
    <th>Email:</th>
	<td class="updatetd1"><input type="email" name="email" size="38" /></td>
  </tr>
  <tr>
    <th>Profile Picture:</th>
    <td class="updatetd1"><input type="file" name="pp" size="38" /></td>
  </tr>
  <tr>
    <td class="updatetd1" colspan="2" align="right">
	<button class="updatebt" type="submit" name="update">Update</button></td>
  </tr>
</table>
</form>
</div>
<br /><br /><br /><br /><br /><br />
<?php
if(isset($_POST['update']))
{
	$address=$_REQUEST['address'];
	$contact=$_REQUEST['contact'];
	$email=$_REQUEST['email'];
	$pp=addslashes(file_get_contents($_FILES['pp']['tmp_name']));
	
	if(empty($address) && empty($contact) && empty($email) && empty($pp))
	{
		echo "<script>alert('Empty fields. No update made.')</script>";		
	}
	else
	{
		$sql = "UPDATE alumniinfo SET ";
		$updateFlag = false;
		
		if(!empty($address)){
			$sql .= "pi_address='$address', ";
			$updateFlag = true;
		}
		
		if(!empty($contact)){
			$sql .= "pi_mobile='$contact', ";
			$updateFlag = true;
		}
		
		if(!empty($email)){
			$sql .= "pi_email='$email', ";
			$updateFlag = true;
		}
		
		if(!empty($pp)){
			$sql .= "pi_picture='$pp', ";
			$updateFlag = true;
		}
		
		// Remove the trailing comma and space from the SQL statement
		$sql = rtrim($sql, ", ");
		
		// Add the WHERE clause
		$sql .= " WHERE pi_register='$userid'";
		
		if($updateFlag){
			if($conn->query($sql)){
				echo "<script>alert('Update Success.')</script>";
			} else {
				echo "Error updating record: " . $conn->error;
			}
		} else {
			echo "<script>alert('No fields to update.')</script>";
		}
	}
}
?>
</body>
</html>
