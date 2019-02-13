<?php 	include 'server.php';
		include 'post.php';
		include 'user.php';

$userLoggedIn = $_SESSION['username'];

$posts = new Post($db, $userLoggedIn);
$posts->displayPosts($_REQUEST);

?>