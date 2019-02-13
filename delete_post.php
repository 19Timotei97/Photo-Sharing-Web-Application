<?php
		include 'server.php';
		include 'post.php';
		include 'user.php';

		// If a user deletes a post of his / her
		if(isset($_POST['delete']))
		{
			$postid = $_POST['post_id'];

			$user = $_SESSION['username'];

			$delete_posts_query = mysqli_query($db, "DELETE FROM posts WHERE id = $postid AND added_by = '$user';");

			$test_if_deleted_query = mysqli_query($db, "SELECT * FROM posts WHERE id = $postid AND added_by = '$user';");

			$update_posts_number = mysqli_query($db, "UPDATE users SET num_posts = num_posts - 1 WHERE username = '$user';");

			if(mysqli_num_rows($test_if_deleted_query) == 0)
				echo "Post deleted!";

			else
				echo "There was an error deleting your post!";
		}
?>