<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php 	include 'server.php';
		include 'user.php';
		include 'post.php';

		if(isset($_SESSION['username'])){
		    $userLoggedIn = $_SESSION['username'];
		    $user_details_query = mysqli_query($db, "SELECT * FROM users WHERE username='$userLoggedIn'");
		    $user = mysqli_fetch_array($user_details_query);
		}
		else
		    header("location: register.php");
?>

		<script type="text/javascript">
			function toggle(){
				var elem = document.getElementById("comment_section");
				
				// if the comment is visible
				if(elem.style.display == "block")
					elem.style.display = "none"; // hide it
				else // if isn't showing
					elem.style.display = "block"; // show it in a block
			}
		</script>

		<?php

			if(isset($_GET['post_id']))
				$post_id = $_GET['post_id'];
			

			// Get the details about the post
			$user_det_query = mysqli_query($db, "SELECT added_by, user_to FROM posts WHERE id='$post_id';");
			$row = mysqli_fetch_array($user_det_query);

			$posted_to = $row['added_by'];

			// When we are clicking on a post
			if(isset($_POST['postComment' . $post_id]))
			{
				$post_body = $_POST['post_body'];
				$post_body = mysqli_escape_string($db, $post_body);

				// Get the time the user comments on a post
				$date_time_now = date("Y/m/d H:i:s");

				// Insert the comment
				$insert_comment_query = mysqli_query($db, "INSERT INTO comments (post_body, posted_by, posted_to, date_added, removed, post_id)
					VALUES ('$post_body', '$userLoggedIn', '$posted_to', '$date_time_now', 'no', '$post_id');");

				echo "<div style='color:white;' class='comment_posted'> Comment was posted! </div>";
			}
		?>

		<form action="comment_structure.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="post">
			<textarea name="post_body"></textarea>
			<input class="post_comment" type="submit" name="postComment<?php echo $post_id; ?>" value="Post"> 
		</form>


		<?php 

			$get_comments_query = mysqli_query($db, "SELECT * FROM comments WHERE post_id = '$post_id' ORDER BY date_added ASC");

			if(mysqli_num_rows($get_comments_query) != 0)
			{
				while($get_comment = mysqli_fetch_array($get_comments_query))
				{
					$comment_body = $get_comment['post_body'];
					$posted_to = $get_comment['posted_to'];
					$posted_by = $get_comment['posted_by'];
					$date_added = $get_comment['date_added'];
					$removed = $get_comment['removed'];


					$date_time_now = date("Y/m/d H:i:s");
					$start_date = new DateTime($date_added);
					$end_date = new DateTime($date_time_now);
					$interval = $start_date->diff($end_date);

					if($interval->y >= 1)
					{
						if($interval == 1)
							$time_message = $interval->y . "year ago";
						else
							$time_message = $interval->y . "years ago";
					}

					else if($interval->m >= 1)
					{
						if($interval->d == 0)
							$days = " ago";
						else if($interval->d == 1)
							$days = $interval->d . "days ago";

						if($interval->m == 1)
							$time_message = $interval->m . " month";
						else
							$time_message = $interval->m . " months";
					}

					else if($interval->d >= 1)
					{
						if($interval->d == 1)
							$time_message = "Yesterday";

						else
							$time_message = $interval->d . " days ago";
					}

					else if($interval->h >= 1)
					{
						if($interval->h == 1)
							$time_message = $interval->h . " hour ago";

						else
							$time_message = $interval->h . " hours ago";
					}

					else if($interval->i >= 1)
					{
						if($interval->i == 1)
							$time_message = $interval->i . " minute ago";
						else
							$time_message = $interval->i . " minutes ago";
					}

					else
					{
						if($interval->s < 60)
							$time_message = "Just now";
						else
							$time_message = $interval->s . " seconds ago";
					}

					$user_obj = new User($db, $posted_by);
			?>
					<div class="comment_section">
						<a href="<?php echo $posted_by ?>" target="_parent">
							<img src="<?php echo $user_obj->getProfilePhoto(); ?>" title="<?php echo $posted_by; ?>" style="float:left;"
							height="30">
						</a>
						<a href="<?php echo $posted_by; ?>" style='color:white;' target="_parent"><b>
							<?php echo $user_obj->getFNameAndLName(); ?></b></a>
							<br> <?php echo "<div style=\"color:white; font-size:13px;\">$time_message</div>" . "<br>" .
							"<div class='comment_body'>$comment_body</div>" ?>
						<br>
						<hr>
					</div>

					<?php	
				}
			}
			else
				echo "<p style='float:left; position: relative; left: 10px; color:white; font-size:16px;'> <br>No comments yet! Be the first to comment.</p>";

		?>
</body>
</html>