<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">	


	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/register-style.css">

    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
    
</head>
<body>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text">
			<h1>Sign up for free and enjoy a fun web photo application!</h1>
		</div>
	</div>


	<div class="header">
		<h2>Create an account</h2>
	</div>
	
	<form class="awj" method="post" action="register.php">

		<!--?php include('errors.php'); ?-->

		<div class="form-group">
			<label>First name</label>
			<i class="fa fa-user icon"></i>
			<input class="form-first-name form-control"
			type="text" name="fname" value="<?php if (isset($_SESSION['fname'])) {
				echo $_SESSION['fname'];
			} ?>" required>
			<?php
				if(in_array("First name must be between 2 and 25 characters!", $errors))
					echo "First name must be between 2 and 25 characters!"; 
			?>
		</div>

		<div class="form-group">
			<label>Last name</label>
			<i class="fa fa-user icon"></i>
			<input class="form-last-name form-control"
			type="text" name="lname" value="<?php if (isset($_SESSION['lname'])) {
				echo $_SESSION['lname'];
			} ?>" required>
			<?php
				if(in_array("Last name must be between 2 and 25 characters!", $errors))
					echo "Last name must be between 2 and 25 characters!"; 
			?>
		</div>

		<div class="form-group" color:DCDCDC>
			<label>Birth date</label>
			<i class="fa fa-birthday-cake"></i><br>
			<tr>
				<td>
				<input type="date" name="dob" required>
				</td>
			</tr>
		</div>

		<div class="form-group" color:#DCDCDC>
			<label>Gender</label><br>
			<tr>
				<!--&nbsp: non-breaking space used to create a line that cannot be broken by word wrap.-->
				<td>
				<input type="radio" name="gender" value="Male" <?php if(isset($_POST['gender']) && $_POST['gender'] == "Male")
				{?> checked <?php } ?> required> Male &nbsp;&nbsp;
				<input type="radio" name="gender"value="Female" <?php if(isset($_POST['gender']) && $_POST['gender'] == "Female")
				{?> checked <?php } ?> required> Female 
				</td>
		</tr>
		</div>

		<div class="form-group">
			<label>Username</label>
			<i class="fa fa-user icon"></i>
			<input class="form-username form-control" type="text" name="username" placeholder="Cannot be changed" required>
			<?php
				if(in_array("Username already exists!", $errors))
					echo "Username already exists!";
				else if(in_array("Username must be between 4 and 30 characters!", $errors))
					echo "Username must be between 4 and 30 characters!";
				else if(in_array("Use only letters and numbers, please!", $errors))
					echo "Use only letters and numbers, please!";
			?>
		</div>

		<div class="form-group">
			<label>Email</label>
			<i class="fa fa-envelope icon"></i>
			<input class="form-email form-control" type="email" name="email" value=
				"<?php 
				if(isset($_SESSION['email'])) {
					echo $email;}
				?>" required>
		</div>

		<div class="form-group">
			<label>Confirm email</label>
			<i class="fa fa-envelope icon"></i>
			<input class="form-email form-control" type="email" name="email1" value=
				"<?php 
				if(isset($_SESSION['email1'])) {
					echo $email1;}
				?>" required>
				<?php
				if(in_array("Email already exists!", $errors))
					echo "Email already exists!";
				else if(in_array("Email is invalid!", $errors))
					echo "Email is invalid!";
				else if(in_array("Email doesn't match!", $errors))
					echo "Email doesn't match!";
				?>
		</div>



		<div class="form-group">
			<label>Password</label>
			<i class="fa fa-key icon"></i>
			<input class="form-password form-control" type="password" name="pass" required>
		</div>

		<div class="form-group">
			<label>Confirm password</label>
			<i class="fa fa-key icon"></i>
			<input class="form-confirm-password form-control" type="password" name="pass1" required>
			<?php
				if(in_array("Password must be between 4 and 100 characters!", $errors))
					echo "Password must be between 4 and 100 characters!";
				else if(in_array("The two passwords do not match", $errors))
					echo "The two passwords do not match";
			?>
		</div>
		<!--div class="input-group"-->
		<button type="submit" class="btn" name="reg_user">Register</button><br>
		<?php if(in_array("Something went really wrong!", $errors))
				echo "<br>Something went really wrong. Try again later.";
			?>
		<!--/div-->	

		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
	</form>


	 <script src="assets/js/jquery-1.11.1.min.js"></script>
     <script src="assets/bootstrap/js/bootstrap.min.js"></script>
     <script src="assets/js/jquery.backstretch.min.js"></script>
     <script src="assets/js/scripts.js"></script>
</body>
</html>