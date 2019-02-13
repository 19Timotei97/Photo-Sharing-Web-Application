<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration system PHP and MySQL</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<!-- source: Create a social network - SkillShare-->
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
			<h1>Login into your account and start sharing your photos with your friends!</h1>
		</div>
	</div>

	<div class="header">
		<h2>Login</h2>
	</div>
	
	<form class="awj" method="post" action="login.php">

		<div class="form-group">
			<label>Username</label>
			<i class="fa fa-user icon"></i>
			<input type="text" name="username" value="<?php if(isset($_SESSION['username'])){
				echo $_SESSION['username'];
			} ?>">
		</div>
		<div class="form-group">
			<label>Password</label>
			<i class="fa fa-key icon"></i>
			<input type="password" name="password">
			<?php
				if(in_array("Wrong username/password combination", $errors))
					echo "Wrong username/password combination"; 
			?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn" name="login_user">Login</button>
			<span class="psw">Forgot your <a href="change_pass.php">password</a>?
		</div>
		
		<div class="form-group">
			Not yet a member? <a href="register.php">Sign up</a>
		</div>
	</form>

	 <script src="assets/js/jquery-1.11.1.min.js"></script>
     <script src="assets/bootstrap/js/bootstrap.min.js"></script>
     <script src="assets/js/jquery.backstretch.min.js"></script>
     <script src="assets/js/scripts.js"></script>


</body>
</html>