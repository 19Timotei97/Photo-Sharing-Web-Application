<?php include 'server.php';

if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($db, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}
else
{
    header("location: register.php");
}
?>

<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="style.css">
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" intergrity=sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

<div class="header_bar">
  <div class="nav-center">
      <div class="dropdown"><?php echo "Hello, " . $user['last_name'] . "!";?>
        <span><img src="<?php echo $user['prof_pic']; ?>"></span>
        <div class="dropdown-content">
            <div class="dropdown-a">
                <h5><a href="profile.php"><i style="color:#3875c5;" class="fas fa-user"></i>
                       <?php echo $user['username']?></a></h5>
                <hr>

                <a href="index.php">
                  <i style="color: #3875C5;" class="fas fa-home"></i>&nbsp;Home</a>&nbsp;&nbsp;
                 
                <hr>

                <a href="login.php"><i style="color:#3875c5;" class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
            </div>
        </div>         
      </div>
  </div>
</div>
<div class="wrapper">
