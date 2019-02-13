<?php 
	ob_start();
	session_start();

	// variable declaration
	$fname="";
	$lname="";
	$username = "";
	$email= "";
	$email1 = "";
	$pass="";
	$pass1="";
	$gender="";
	//date of birth
	$dob="";
	// current date
	$date="";
	$errors = array(); 
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'registration');


	if(mysqli_connect_errno()){
	    echo "Failed to connect: " . mysqli_connect_errno();
	}

	// REGISTER USER
	if (isset($_POST['reg_user'])) {

		// First name
		// remove any HTML tags
		$fname = strip_tags($_POST['fname']);
		// and any spaces
		$fname = str_replace(' ', '', $fname);
		// convert first letter to upper
		$fname = ucfirst(strtolower($fname));
		$_SESSION['fname'] = $fname;

		// Last name
		// remove any HTML tags
		$lname = strip_tags($_POST['lname']);
		// and any spaces
		$lname = str_replace(' ', '', $lname);
		// convert first letter to upper
		$lname = ucfirst(strtolower($lname));
		$_SESSION['lname'] = $lname;

		//Username
		// remove any HTML tags
		$username = strip_tags($_POST['username']);
		// and any spaces
		$username = str_replace(' ', '', $username);

		// Email
		//remove any HTML tags
		$email = strip_tags($_POST['email']);
		// and any spaces
		$email = str_replace(' ', '', $email);
		$_SESSION['email'] = $email;

		// Email confirmation
		//remove any HTML tags
		$email1 = strip_tags($_POST['email1']);
		// and any spaces
		$email1 = str_replace(' ', '', $email1);
		$_SESSION['email1'] = $email1;

		// Password
		//remove any HTML tags
		$pass = strip_tags($_POST['pass']);

		// Password confirmation
		//remove any HTML tags
		$pass1 = strip_tags($_POST['pass1']);

		$dob = $_POST['dob'];

		$gender= $_POST['gender'];
		
		$date = date("Y/m/d");

		if($email == $email1)
		{
			if(filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$email=filter_var($email, FILTER_VALIDATE_EMAIL);

				// Check if email exists already
				$em_test = mysqli_query($db, "SELECT email FROM users WHERE email='$email';");

				// And notfiy the user
				if(mysqli_num_rows($em_test) > 0)
				{
					array_push($errors, "Email already exists!");
				}
				else
					$email = mysqli_real_escape_string($db, $_POST['email']);
			}
			else{
				array_push($erros, "Email is invalid!");
			}
		}
		else{
			array_push($errors, "Email doesn't match!");
		}

		$un_check = mysqli_query($db, "SELECT username FROM users WHERE username='$username';");

		if(mysqli_num_rows($un_check) > 0)
		{
			array_push($errors, "Username already exists!");
		}
		else $_SESSION['username'] = $username;

		if(strlen($username) > 30 || strlen($username) < 4)
			array_push($errors, "Username must be between 4 and 30 characters!");

		else if(preg_match('/[^A-Za-z0-9]/', $username))
			array_push($errors, "Use only letters and numbers, please!");
		else
			$username = mysqli_real_escape_string($db, $_POST['username']);
		
		if(strlen($fname) < 2 || strlen($fname) > 25)
		{
			array_push($errors, "First name must be between 2 and 25 characters!");
		}
		else
			$fname = mysqli_real_escape_string($db, $_POST['fname']);


		if(strlen($lname) < 2 || strlen($lname) > 25)
		{
			array_push($errors, "Last name must be between 2 and 25 characters!");
		}
		else
			$lname = mysqli_real_escape_string($db, $_POST['lname']);

		if(strlen($pass) < 4 || strlen($pass) > 100)
		{
			array_push($errors, "Password must be between 4 and 100 characters!");
		}

		if ($pass != $pass1) 
		{
			array_push($errors, "The two passwords do not match");
		}
		else{
			$pass = mysqli_real_escape_string($db, $_POST['pass']);
		
			$pass1 = mysqli_real_escape_string($db, $_POST['pass1']);
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$pass = md5($pass); //encrypt the password before saving in the database

			if($gender == "Male")
			{
				$prof_pic = "images/profile_pics/defaults/male.png";
				$cov_pic = "images/cover_pics/winter_cover.jpg";
			}

			else if($gender == "Female")
			{
				$prof_pic = "images/profile_pics/defaults/female.png";
				$cov_pic = "images/cover_pics/winter_cover_1.jpg";
			}

			$query = "INSERT INTO users (first_name, last_name, username, email, birth_date, gender, password, signup_date, prof_pic, cov_pic, num_posts, num_likes, user_closed, friend_array) VALUES ('$fname', '$lname', '$username', '$email', '$dob', '$gender', '$pass', '$date', '$prof_pic', '$cov_pic', 0, 0, 'no', ',');";
			mysqli_query($db, $query);

			$test_in = mysqli_query($db, "SELECT * FROM users WHERE first_name='$fname' AND last_name='$lname';");
			
			if(mysqli_num_rows($test_in) != 1)
				array_push($errors, "Something went really wrong!");
			else if(mysqli_num_rows($test_in) == 1)
			{
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}
		}
	}

	//------------------------------------------------------------------------------------------------------------------------

	// CHANGE PASSWORD
	if(isset($_POST['ch_pass'])) 
	{
		$user = mysqli_real_escape_string($db, $_POST['un']);

		$npass = mysqli_real_escape_string($db, $_POST['npass']);
		
		$npass1 = mysqli_real_escape_string($db, $_POST['npass1']);

		// Strip any HTML tags
		$user = strip_tags($_POST['un']);
		// and any spaces
		$user = str_replace(' ', '', $user);

		$npass = strip_tags($_POST['npass']);

		$npass1 = strip_tags($_POST['npass1']);

		if(empty($user)) { array_push($errors, "Username is required"); }
		
		if(empty($npass)) { array_push($errors, "New password is required!"); }
		
		if(empty($npass1)) { array_push($errors, "Password confirmation is required!"); }
		
		

		if($npass != $npass1){
			array_push($errors, "The two passwords don\'t match!");
		}

		if(count($errors) == 0)
		{
			$test_un = "SELECT * FROM users WHERE username = '$user'";
			$result = mysqli_query($db, $test_un);
			if(mysqli_num_rows($result) == 1)
			{
				$npass = md5($npass);
				$query = "UPDATE users SET password = '$npass'
						WHERE username = '$user'";

				mysqli_query($db, $query);
				
				//$test_np = "SELECT password FROM users WHERE username = '$user'";
				//$test = mysqli_query($db, $test_np);
				//if($test == $new_password)
				//{
				$_SESSION['username'] = $user;
				$_SESSION['success'] = "Password was changed! Try to login in.";
				header('location: login.php');
				//}
				//else{
				//	array_push($errors, "An error was encoutered when changing the password. Try again later.");
				//}
			}		
			else {
				array_push($errors, "Wrong username! Try again.");
			}
		}	
	}

	//------------------------------------------------------------------------------------------------------------------------
	$oldpass = "";
	$newpass1 = "";
	$newpass2 = "";

	// CHANGE PASSWORD FROM ACCOUNT
	if(isset($_POST['change_pass']))
	{
		$oldpass = mysqli_real_escape_string($db, $_POST['passw']);
		$newpass1 = mysqli_real_escape_string($db, $_POST['passw1']);
		$newpass2 = mysqli_real_escape_string($db, $_POST['passw2']);

	    $oldpass = strip_tags($oldpass);
	    $newpass1 = strip_tags($newpass1);
	    $newpass2 = strip_tags($newpass2);
	
	    if(empty($oldpass)) { array_push($errors, "Old password is required!"); }
	    if(empty($newpass1)) { array_push($errors, "New password is required!"); }
	    if(empty($newpass2)) { array_push($errors, "Password confirmation is required!"); }

	    if($newpass2 != $newpass1)
	    	array_push($errors, "The two passwords don't match!");


	    if(count($errors) == 0)
	    {
	    	$user_changing = "";

	    	if(isset($_SESSION['username']))
	    	{
	    		$user_changing = $_SESSION['username'];
	    	
	    		$pass_changed = md5($newpass1);

	    		$change_password_query = mysqli_query($db, "UPDATE users SET password = '$pass_changed' WHERE username = '$user_changing';");

	    		$test_if_changed = mysqli_query($db, "SELECT password FROM users WHERE username = '$user_changing';");
	    		$pass_array = mysqli_fetch_array($test_if_changed);
	    		$the_new_pass = $pass_array['password'];


	    		if($the_new_pass != $pass_changed)
	    			echo "There was a problem changing your password!";
	    	}
	    }
	}

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		// remove any HTML tags
		$username = strip_tags($_POST['username']);
		// and any spaces
		$username = str_replace(' ', '', $username);

		$pass = strip_tags($_POST['password']);

		//$username = mysqli_real_escape_string($db, $_POST['username']);
		//$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($pass)) {
			array_push($errors, "Password is required");
		}

		
		if (count($errors) == 0) {
			$pass = md5($pass);
			$query = "SELECT username, password FROM users WHERE username='$username' AND 
			password='$pass'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}
?>