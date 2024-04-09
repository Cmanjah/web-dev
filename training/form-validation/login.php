<?php
print_r($_POST)

?><!DOCTYPE html>
<html>
<head>
	<title>Slide Navbar</title>
	<link rel="stylesheet" type="text/css" href="slide navbar style.css">
<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="login">
				<form method="POST" action="validation.php" name="loginForm" id="loginForm">
				<!-- <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="loginForm" id="loginForm"> -->
				<label for="chk" aria-hidden="true">Login</label>
					<input type="text" name="username" placeholder="Username" required="">
					<input type="password" name="paswd" placeholder="Password" required="">
					<input type="hidden" name="submitform" value="1" >
					<button type="submit" name="login">Login</button>
				</form>
			</div>

			<div class="register">
				<form method="POST" action="validation.php" name="registerForm" id="registerForm">
					<label for="chk" aria-hidden="true">Register</label>
					<input type="text" name="firstname" placeholder="First name" required="">
					<input type="text" name="lastname" placeholder="Last name" required="">
					<input type="text" name="username" placeholder="Username" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="password" placeholder="Password" required="">
					<input type="password" name="confirm_password" placeholder="Password" required="">
					<input type="hidden" name="submitform" value="1">
					<button type="submit" name="register">Register</button>
				</form>
			</div>
	</div>
</body>
</html>