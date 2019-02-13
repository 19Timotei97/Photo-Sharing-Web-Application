<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Change the password</title>
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
	<div class="header">
		<h2>Reset your password</h2>
	</div>
	
	<form class="awj" method="post" action="change_pass.php">

		<!--?php include('errors.php'); ?-->

		<div class="form-group">
			<label>Enter your username</label>
			<i class="fa fa-user icon"></i>
			<input type="text" name="un">
		</div>
		<div class="form-group">
			<label>New password</label>
			<i class="fa fa-key icon"></i>
			<input type="password" name="npass">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<i class="fa fa-key icon"></i>
			<input type="password" name="npass1">
		</div>
		<div class="form-group">
			<button type="submit" class="btn" name="ch_pass">Change</button>
		</div>
		<p>
			Go back to the <a href="login.php">login</a> page.
		</p>
	</form>


	 <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
</body>
</html>