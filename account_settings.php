<?php 	include 'header.php';
        include 'server.php';


 if(isset($_SESSION['username']))
{
	$userLoggedIn = $_SESSION['username'];
	$get_user_info = mysqli_query($db, "SELECT first_name, last_name, username, prof_pic, cov_pic, birth_date, gender, signup_date, num_posts, num_likes FROM users WHERE username = '$userLoggedIn';");
	$info_row = mysqli_fetch_array($get_user_info);

	if(mysqli_num_rows($get_user_info) != 1)
		echo "Failed!";
}

?>

<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="profile-wrapper">
	<div class="profile-box">
		<img src="<?php echo $info_row['cov_pic']; ?>" width=1300 height=400 style="position: relative; left: px;">
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
    	<div class="password_change">
    		<h3>Change your password:</h3><br>
    		<div class="form-group">
    			Old password: <i class="fa fa-key icon"></i>&nbsp;
                <input type="password" name="passw"> 
    		</div><br> <br>
    		<div class="form-group">
    			New password: <i class="fa fa-key icon"></i>&nbsp;
                <input type="password" name="passw1">
    		</div> <br><br>
    		<div class="form-group">
    			Repeat new password: <i class="fa fa-key icon"></i>&nbsp;
                <input type="password" name="passw2">
    		</div> <br><br>
    		<input type="submit" class="btn" value="Change" name="change_pass">
    	</div>
</div>
