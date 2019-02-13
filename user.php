<?php
	
class User
{
	private $user;
	private $db;

	// Used to create an 'User' object
	public function __construct($con, $user)
	{
		$this->db = $con;

		// Get the details about the user
		$user_details_query = mysqli_query($this->db, "SELECT * FROM users WHERE username = '$user';");
		
		$this->user = mysqli_fetch_array($user_details_query);
	}

	// Returns the username of a user
	public function getUsername()
	{ return $this->user['username']; }

	// Returns the profile photo of the user
	public function getProfilePhoto()
	{ 
		$username = $this->user['username'];
		$get_prof_pic_query = mysqli_query($this->db, "SELECT prof_pic FROM users WHERE username='$username';");
		$row = mysqli_fetch_array($get_prof_pic_query);
		return $row['prof_pic']; 
	}

	// Returns the number of posts of a user
	public function getNumPosts()
	{
		$username = $this->user['username'];
		$num_posts_Query = mysqli_query($this->db, "SELECT num_posts FROM users WHERE username='$username';");
		$num_posts = mysqli_fetch_array($num_posts_Query);
		return $num_posts['num_posts'];
	}

	// Returns the first and last name of a user
	public function getFNameAndLName()
	{
		$username = $this->user['username'];
		$getFnameAndLname_query = mysqli_query($this->db, "SELECT first_name, last_name FROM users WHERE username = '$username';");
		$row = mysqli_fetch_array($getFnameAndLname_query);
		return $row['first_name'] . " " . $row['last_name'];
	}

	// Check if the $user_To_check is a friend of the logged in user
	/* public function IsFriend($user_to_ckeck)
	{
		$usernameComma = "," . $user_to_ckeck . ",";

		if((strstr($this->user['friend_array'], $usernameComma) || $user_to_ckeck == $this->user['username']))
			return true;

		else
			return false;

	} */
}

?>