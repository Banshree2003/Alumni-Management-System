
<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $expectedEmail = "admin@gmail.com";
    $expectedPassword = "banshree";

    if ($email === $expectedEmail && $password === $expectedPassword) {
        // Admin login successful, store admin info in session
        $_SESSION["admin_logged_in"] = true;
        $_SESSION["admin_email"] = $email;

        header("Location: admin_homepage.php");
        exit;
    } else {
        $error_message = "Invalid email or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href="style.css" rel="stylesheet" type="text/css">
		
<link rel="stylesheet" href="css/login.css" />
  
	</head>
	<body>
	<div class="login_wrapper">
	<div class="login_container">
		<div class="login">
			<h1>Admin Login</h1>
			<form action="admin_loginpage.php" method="post">
				<label for="adminemail">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="Admin Email" id="email" required><BR>
				<BR>
				<BR>
				<TABLE>
					<TR>
</TR>
</TABLE>

				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required><BR>
				<TABLE>
					<TR>
</TR>
</TABLE>
				<input type="submit" value="Login">
			</form>
		</div>
		<?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
	</body>
</html>
