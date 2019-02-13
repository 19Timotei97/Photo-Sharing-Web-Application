<?php 	include 'header.php';
        include 'post.php';


if(isset($_SESSION['username']))
{
    $userLoggedIn = $_SESSION['username'];
    if(isset($_GET['username']))
    {
    $find_user = $_GET['username'];

	$get_user_info = mysqli_query($db, "SELECT first_name, last_name, username, prof_pic, cov_pic, birth_date, gender, signup_date, num_posts, num_likes FROM users WHERE username = '$find_user';");
	$info_row = mysqli_fetch_array($get_user_info);

	if(mysqli_num_rows($get_user_info) != 1)
		echo "Failed!";
    }
    else echo "Couldn't find the user!";
}

?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="profile-wrapper">
	<div class="profile-box">
		<img src="<?php echo $user['cov_pic']; ?>" width=1300 height=400 style="position: relative; left: px;">
	</div>
	<div class="feed-info">
		<div class="prof-box">
                        <div class="prof-head">
                        	    Posts Likes
                        </div>
                        <div class="prof-body">
                            <?php echo $user['num_posts']; ?>
                                <?php echo $user['num_likes']; ?>
                        </div>
              </div>
	</div>
	<div class="pro-b-img">
        <img src="<?php echo $user['prof_pic']; ?>">
    </div>
	<div class="profile-information">
		<div class="profile-in-body">
           	<div class="pro-b-box">
            </div>
            <div class="pro-body-name">
            	<div class="pro-b-name">
                   <div><?php echo $user['first_name'] . " " . $user['last_name']; ?>
                   </div>
	           	    <div class="pro-uname">
	           	    	<span><small><?php echo "@" . $user['username'] ?>
	           	    </small></span>
	            	</div>
           		<br><br>
            	</div>
        	</div>

    	</div>
    	<div class="birthday">
        	<i class="fa fa-birthday-cake"></i>&nbsp;&nbsp;&nbsp;<?php
        	$now = new DateTime();
        	$birthday_date = $user['birth_date'];
        	
        	//$bd_time = strtotime($birthday_date);
        	$bd_date = new DateTime($birthday_date);

        	$diff = $bd_date->diff($now);

        	$year = substr($birthday_date, 0, 4);
        	$month = substr($birthday_date, 5, 2);
        	$day = substr($birthday_date, 8, 3);
        	
        	echo $day . "-" . $month . "-" . $year . " - " . $diff->y . " years old";
        	 ?>
        </div>
        <br>
        <div class="join-date">
        	<i class="far fa-clock"></i>&nbsp;&nbsp;&nbsp;Joined on <?php
        	 $sign_date = $user['signup_date'];
        	 $year = substr($sign_date, 0, 4);
        	 $month = substr($sign_date, 5, 2);
        	 $day = substr($sign_date, 8, 3);
        	 echo $day . "-" . $month . "-" . $year;
        	  ?>
        </div>
	</div>
</div>


<div class="profile_column_home">
    <div class="posts_area"></div>
    <img id="loading" src="images/icons/loading.gif">
</div>


<script>
    
    var userLoggedIn = '<?php echo $info_row['username']; ?>';

    $(document).ready(function(){
        $('#loading').show();

        $.ajax({
            url: "ajax_load_profile_posts.php",
            type: "POST",
            data: "page=1$info_row['username']=" + userLoggedIn,
            cache: false,

            success: function(data){
                $('#loading').hide();
                $('.posts_area').html(data);
            }
        });

        $(window).scroll(function() {

            var height = $('.post_area').height();
            var scroll_top = $(this).scrollTop();


            var page = $('.posts_area').find('.nextPage').val();
            var noMorePosts = $('.posts_area').find('.noMorePosts').val();

            if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false')
            {
                $('#loading').show();


                var ajaxReq = $.ajax ({
                    url: "ajax_load_profile_posts.php",
                    type: "POST",
                    data: "page=" + page + "&info_row['username']=" + userLoggedIn,
                    cache: false,


                    success: function(response)
                    {
                        $('.posts_area').find('.nextPage').remove();
                        $('.posts_area').find('.noMorePosts').remove();
                        $('.posts_area').find('.noMorePostsText').remove();


                        $('#loading').hide();
                        $('.posts_area').append(response);
                    }
                });
            }
            return false;
        });
    });

</script>

<!--/div-->