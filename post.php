<!DOCTYPE html>
<html>
<head>
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
<body>


<?php //include 'server.php';

// each post will be an object of this class
class Post
{
	//static $ID;
	private $user_obj;
	private $con;
	static $name;

	// Assign the connection and create a post object
	public function __construct($con, $user)
	{
		$this->con = $con;
		$this->user_obj = new User($con, $user);
	}

	public function submitPost($body, $user_to, $imageName)
	{
		// Get rid of any HTML tags
		$body = strip_tags($body);
		$body = mysqli_real_escape_string($this->con, $body);
		// Replace spaces with nothing
		$check_if_empty = preg_replace('/\s+/', '', $body);

		if($check_if_empty != "")
		{
			// if space is found in the description's body, split at that location
			$body_array = preg_split("/\s+/", $body);
			// and then recreate the description using spaces
			$body = implode(" ", $body_array);

			// Save the date when the post was created
			$date_added = date("Y/m/d H:i:s");
			
			// Get the username of the user who post it
			$added_by = $this->user_obj->getUsername();

			// If the user didn't send the post to another user, then treat it like a simple post
			if($user_to == $added_by)
				$user_to = "none";

			$query = mysqli_query($this->con, "INSERT INTO posts (body, added_by, user_to, date_added, user_closed, deleted, likes, image)
				VALUES ('$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', '$imageName');");

			$num_posts = $this->user_obj->getNumPosts();
			$num_posts++;

			$query_to_Update = mysqli_query($this->con, "UPDATE users SET num_posts = '$num_posts' WHERE username = '$added_by';");
		}
	}

	/*public function displayUserPosts($user)
	{
		$get_user_posts = mysqli_query($this->con, "SELECT * FROM posts WHERE added_by = '$user' ORDER BY likes DESC");
		$ret_str = "";

		if(mysqli_num_rows($get_user_posts) > 0)
		{
			while($row = mysqli_fetch_array($get_Data_Query))
			{
				$str_like = "like";
				
				if(!empty($row))
					$str_like = "unlike";

				$postid = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_added = $row['date_added'];
				$image = $row['image'];


				$user_row = mysqli_fetch_array($user_details_query);
				$f_name = $user_row['first_name'];
				$l_name = $user_row['last_name'];
				$prof_pic = $user_row['prof_pic'];

				?>

				<script type="text/javascript">
					function toggle<?php echo $postid; ?>()
					{
						var target = $(target);

						if(!target.is("a"))
						{
							var elem = document.getElementById("toggleComment<?php echo $postid; ?>");

							if(elem.style.display == "block")
								elem.style.diplay = "none";
							else
								elem.style.display = "block";
						}

					}
				</script>
				
				<?php

				$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id = '$postid';");
				$number_of_comments = mysqli_num_rows($comments_check);

				$posts_check = mysqli_query($this->con, "SELECT likes FROM posts WHERE id = '$postid'");
				$row_likes = mysqli_fetch_array($posts_check);
				$number_of_likes = $row_likes['likes'];

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
						$time_message = $interval->m . " month" . $days;
					else
						$time_message = $interval->m . " months" . $days;
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

				$ret_str .= "<div class='status-post'
				onClick='javascript:toggle$postid()'>
										<div class='post_prof_pic'>
											<img src='$prof_pic' width='50'>
										</div>

										<div class='posted_by'
											style='color:#ACACAC;'>
											<a href=#> $f_name
											$l_name </a> $user_to
											<br>
											<div class='time'> $time_message </div>
										</div>";
				$ret_str .= "<i class=''></i><span class='delete fas fa-trash-alt' id=\"$postid\"></span>";
				$ret_str .= "			<br>
										<br>

										<div class='post_body' id='post_body' style='font-size:20px;'>
											$body
											<br><br>";

				if($image != "")
					$ret_str .= "<img src='$image' style='height:auto; width:100%;'>";
												
				$ret_str .= "				<br>
											<br>
										</div>
									</div>

									

									<div class='newsfeedPostOptions'>
									Comments ($number_of_comments) 
									</div>
									
									$number_of_likes Like(s)

									<div class='post_comment' id='toggleComment$postid' style='display: none;'>
										<iframe src='comment_structure.php?post_id=$postid' id='comment_iframe' frameborder='0'></iframe>
									</div>
										
									<hr>";

				}				
			}
					$ret_str .= "<input type='hidden' class='noMorePosts' value='true'>
					<p style='text-align: center;'> No more posts to show for you! :( </p>";
		}
			echo $ret_str;
	}*/

	public function displayProfilePosts($data)
	{
		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();

		// If there's only one page with posts
		if($page == 1)
			// start from 0
			$start = 0;
		else
			$start = ($page - 1);


		$ret_str = "";

		$get_Data_Query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' AND added_by = '$userLoggedIn' ORDER BY likes DESC;");

		if(mysqli_num_rows($get_Data_Query) > 0)
		{
			$num_results_checked = 0;
			$count = 1;

			while($row = mysqli_fetch_array($get_Data_Query))
			{
				$str_like = "like";
				
				if(!empty($row))
					$str_like = "unlike";

				$postid = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				$date_added = $row['date_added'];
				$image = $row['image'];


				// If the user doesn't send his post to anyone
				if($row['user_to'] == "none")
					$user_to = "";
				else
				{
					// But if he does, then get the first and last name of that person
					$user_to_obj = new User($this->con, $row['user_to']);
					$user_to_name = $user_to_obj->getFNameAndLName();
					$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";

				}

				$user_logged_obj = new User($this->con, $userLoggedIn);
				if(isset($_SESSION['username']))
				{
					// continue loading the posts until there are no more to show
					if($num_results_checked++ < $start)
						continue;

					$count++;


				$user_details_query = mysqli_query($this->con, 
					"SELECT first_name, last_name, prof_pic FROM users WHERE username='$added_by';");

				$user_row = mysqli_fetch_array($user_details_query);
				$f_name = $user_row['first_name'];
				$l_name = $user_row['last_name'];
				$prof_pic = $user_row['prof_pic'];

				?>

				<script type="text/javascript">
					function toggle<?php echo $postid; ?>()
					{
						var target = $(target);

						if(!target.is("a"))
						{
							var elem = document.getElementById("toggleComment<?php echo $postid; ?>");

							if(elem.style.display == "block")
								elem.style.diplay = "none";
							else
								elem.style.display = "block";
						}

					}
				</script>
				
				<?php

				$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id = '$postid';");
				$number_of_comments = mysqli_num_rows($comments_check);

				$posts_check = mysqli_query($this->con, "SELECT likes FROM posts WHERE id = '$postid'");
				$row_likes = mysqli_fetch_array($posts_check);
				$number_of_likes = $row_likes['likes'];

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

				$ret_str .= "<div class='status-post'
				onClick='javascript:toggle$postid()'>
										<div class='post_prof_pic'>
											<img src='$prof_pic' width='50'>
										</div>

										<div class='posted_by'
											style='color:#ACACAC;'>
											<a href=#> $f_name
											$l_name </a> $user_to
											<br>
											<div class='time'> $time_message </div>
										</div>";
				$ret_str .= "<i class=''></i><span class='delete fas fa-trash-alt' id=\"$postid\"></span>";
				$ret_str .= "			<br>
										<br>

										<div class='post_body' id='post_body' style='font-size:20px;'>
											$body
											<br><br>";

				if($image != "")
					$ret_str .= "<img src='$image' style='height:auto; width:100%;'>";
												
				$ret_str .= "				<br>
											<br>
										</div>
									</div>									

									<div class='newsfeedPostOptions'>
									Comments ($number_of_comments) 
									</div>
									
									$number_of_likes Like(s)

									<div class='post_comment' id='toggleComment$postid' style='display: none;'>
										<iframe src='comment_structure.php?post_id=$postid' id='comment_iframe' frameborder='0'></iframe>
									</div>
										
									<hr>";

				}				
			}
					$ret_str .= "<input type='hidden' class='noMorePosts' value='true'>
					<p style='text-align: center;'> No more posts to show for you! :( </p>";
			}
			echo $ret_str;
	}

	public function displayPosts($data)
	{
		$page = $data['page'];
		$userLoggedIn = $this->user_obj->getUsername();

		// If there's only one page with posts
		if($page == 1)
			// start from 0
			$start = 0;
		else
			$start = ($page - 1);


		$ret_str = "";

		$get_Data_Query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY likes DESC;");

		if(mysqli_num_rows($get_Data_Query) > 0)
		{
			$num_results_checked = 0;
			$count = 1;

			while($row = mysqli_fetch_array($get_Data_Query))
			{
				$str_like = "like";
				
				if(!empty($row))
					$str_like = "unlike";

				$postid = $row['id'];
				$body = $row['body'];
				$added_by = $row['added_by'];
				Post::$name = $added_by;
				$date_added = $row['date_added'];
				$image = $row['image'];


				// If the user doesn't send his post to anyone
				if($row['user_to'] == "none")
					$user_to = "";
				else
				{
					// But if he does, then get the first and last name of that person
					$user_to_obj = new User($this->con, $row['user_to']);
					$user_to_name = $user_to_obj->getFNameAndLName();
					$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";

				}

				$user_logged_obj = new User($this->con, $userLoggedIn);
				if(isset($_SESSION['username']))
				{
					// continue loading the posts until there are no more to show
					if($num_results_checked++ < $start)
						continue;

					$count++;


				$user_details_query = mysqli_query($this->con, 
					"SELECT first_name, last_name, prof_pic FROM users WHERE username='$added_by';");

				$user_row = mysqli_fetch_array($user_details_query);
				$f_name = $user_row['first_name'];
				$l_name = $user_row['last_name'];
				$prof_pic = $user_row['prof_pic'];

				?>

				<script type="text/javascript">
					function toggle<?php echo $postid; ?>()
					{
						var target = $(target);

						if(!target.is("a"))
						{
							var elem = document.getElementById("toggleComment<?php echo $postid; ?>");

							if(elem.style.display == "block")
								elem.style.diplay = "none";
							else
								elem.style.display = "block";
						}

					}
				</script>
				
				<?php

				$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id = '$postid';");
				$number_of_comments = mysqli_num_rows($comments_check);

				$posts_check = mysqli_query($this->con, "SELECT likes FROM posts WHERE id = '$postid'");
				$row_likes = mysqli_fetch_array($posts_check);
				$number_of_likes = $row_likes['likes'];

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
						$time_message = $interval->m . " month ago";
					else
						$time_message = $interval->m . " months ago";
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

				$ret_str .= "<div class='status-post'
				onClick='javascript:toggle$postid()'>
										<div class='post_prof_pic'>
											<img src='$prof_pic' width='50'>
										</div>

										<div class='posted_by'
											style='color:#ACACAC;'>
											<a href=#> $f_name
											$l_name </a> $user_to
											<br>
											<div class='time'> $time_message </div>
										</div>";

				$ret_str .=        "	<br>
										<br>

										<div class='post_body' id='<?php echo $postid; ?>' style='font-size: 20px;'>
											$body
											<br><br>";

				if($image != "")
					$ret_str .= "<img src='$image' style='height:auto; width:100%;'>";
												
				$ret_str .= "				<br>
											<br>
										</div>
									</div>									

									<div class='newsfeedPostOptions'>
									Comments ($number_of_comments) 
									</div><br>";


				// Get the user id
				$get_user_id_query = mysqli_query($this->con, "SELECT id FROM users WHERE username='$userLoggedIn';");
				$uid = mysqli_fetch_array($get_user_id_query);
				$userID = $uid['id'];


				if($added_by != $userLoggedIn)
				{
				if($userID) {
					// Check if the user already liked the post
					$res = mysqli_query($this->con, "SELECT * FROM likes WHERE user_id = $userID AND post_id = $postid;");

					if(mysqli_num_rows($res) == 1) // The user already likes the post
						$ret_str .= "<i class=''></i><a href=\"index.php\" class='unlike far fa-thumbs-down' id=\"$postid\"></a>
						<i class=''></i><a href=\"index.php\" class='like hide far fa-thumbs-up' id=\"$postid\"></a>";

					else // The user didnt like the post yet
						$ret_str .= "<i class=''></i><a href=\"index.php\" class='like far fa-thumbs-up' id=\"$postid\"></a>
						<i class=''></i><a href=\"index.php\" class='unlike hide far fa-thumbs-down' id=\"$postid\"></a>";
				}
			}

				$ret_str .= "<span class='likes_count'>&nbsp;&nbsp;$number_of_likes Like(s) </span>

									</div>&nbsp;&nbsp;
										
									<div class='post_comment' id='toggleComment$postid' style='display: none;'>
										<iframe src='comment_structure.php?post_id=$postid' id='comment_iframe' frameborder='0'></iframe>
									</div>
										
									<hr>";
				}				
			}
			?>

			<?php
					$ret_str .= "<input type='hidden' class='noMorePosts' value='true'>
					<p style='text-align: center;'> No more posts to show for you! :( </p>";
			}
			echo $ret_str;
		}


	}
?>

</body>

<!--Javascript function to handle 'like' or 'unlike' click -->
				<script src="assets/js/jquery-1.11.1.min.js"></script>
				<script type="text/javascript">
					
					$(document).ready(function()
					{
						$('.like').click(function()
						{
							var postid = $(this).attr('id');
							alert("Post liked! Refresh the page.");
							$post = $(this);
							$post.addClass('tada animated');

							$.ajax({
								url: 'like_posts.php',
								type: 'POST',
								async: false,
								data: {
									'liked': 1,
									'post_id': postid
								},
								success: function()
								{
									$post.parent().find('span.likes_count').text(response + " likes");
									$post.addClass('hide');
									$post.siblings().removeClass('hide');
								}
							});
						});
					
						$('.unlike').click(function() 
						{
							var postid = $(this).attr('id');
							alert("Post unliked! Refresh the page.");
							$post = $(this);

							$.ajax({
								url: 'like_posts.php',
								type: 'POST',
								async: false,
								data: {
										'unliked': 1,
										'post_id': postid
								},
								success: function()
								{
									$post.parent().find('span.likes_count').text(response + " likes");
									$post.addClass('hide');
									$post.siblings().removeClass('hide');
								}
							});
						});
					});
					</script>

					<!-- Javascript function to handle 'delete' button click -->
					<script type="text/javascript">
						$(document).ready(function(){
							$('.delete').click(function()
							{
								var pid = $(this).attr('id');
								// For debug
								alert("Post deleted. Refresh the page.");

								$.ajax({
									url: 'delete_post.php',
									type: 'POST',
									async: false,
									data: {
										'delete' : 1,
										'post_id': pid
									},
									success: function(){}
								});
							});
						}); 
					</script>
</html>