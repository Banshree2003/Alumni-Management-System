<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Add New Payment</title>
</head>
<body>

<h2>Add New Payment</h2>

<form action="process_payment.php" method="post">
  <label for="amount">Amount:</label><br>
  <input type="text" id="amount" name="amount"><br>
  <label for="description">Description:</label><br>
  <input type="text" id="description" name="description"><br><br>
  <input type="submit" value="Add Payment">
</form>

</body>
</html>
