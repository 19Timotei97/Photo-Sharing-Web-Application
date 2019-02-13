<?php
		include 'server.php';
		include 'post.php';
		include 'user.php';


$user_posted = Post::$name;

$posts = new Post($db, $user_posted);
$posts->displayUserPosts($_REQUEST);
?>