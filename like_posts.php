<?php
	include 'server.php';
	include 'post.php';
	include 'user.php';

	// If the user likes a post
	if(isset($_POST['liked']))
	{
		$user = $_SESSION['username'];
		$get_uid_query = mysqli_query($db, "SELECT id FROM users WHERE username='$user';");
		$uid_arr = mysqli_fetch_array($get_uid_query);
		$uid = $uid_arr['id'];

		if(isset($_POST['post_id']))
			$post_id = $_POST['post_id'];
		else echo "No post_id!";
		
		$result = mysqli_query($db, "SELECT * FROM posts WHERE id = $post_id;");

		$row = mysqli_fetch_array($result);
		$num_likes = (int)$row['likes'];

		// Update both likes and posts tables
		mysqli_query($db, "INSERT INTO likes (user_id, post_id) VALUES ($uid, $post_id);");
		mysqli_query($db, "UPDATE posts SET likes = $num_likes + 1 	WHERE id = $post_id;");
	
		exit();
	}

	// If a user unlikes a post
	if(isset($_POST['unliked']))
	{
		$user = $_SESSION['username'];
		$get_uid_query = mysqli_query($db, "SELECT id FROM users WHERE username='$user';");
		$uid_arr = mysqli_fetch_array($get_uid_query);
		$uid = $uid_arr['id'];

		$post_id = $_POST['post_id'];
		$result = mysqli_query($db, "SELECT * FROM posts WHERE id = $post_id;");

		$row = mysqli_fetch_array($result);
		$num_likes = (int)$row['likes'];

		mysqli_query($db, "DELETE FROM likes WHERE post_id = $post_id AND user_id = $uid;");
		mysqli_query($db, "UPDATE posts SET likes = $num_likes - 1 	WHERE id = $post_id;");

		exit();
	}
?>