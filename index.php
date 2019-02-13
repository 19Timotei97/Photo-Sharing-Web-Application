<?php   include 'header.php'; 
        include 'post.php';
        include 'user.php';

if(isset($_POST['post']))
{
    $uploadOK = 1;
    $imageName = $_FILES['fileToUpload']['name'];
    $errMess = "";

    if($imageName != "")
    {
        // Where the posts will be uploaded
        $targetDir = "posts/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        
        // Check if the size is within limits
        if($_FILES['fileToUpload']['size'] > 10000000)
        {
            $errMess .= "Sorry, your file is too large!";
            $uploadOK = 0;
            //echo $errMess;
        }
        
        // Check if the image is either jpeg, png or jpg
        if($imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "gif")
        {
            $errMess .= "Only .jpeg, .jpg, .png and .gif files are allowed!";
            $uploadOK = 0;
            //echo $errMess;
        }   
        
        if($uploadOK){
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'],
            $imageName)){} // Image is ready to be uploaded
            else
            {
                $errMess = "Sorry, there was an error uploading the file!";
                $uploadOK = 0;
                //echo $errMess;
            }
        }
    }

    if($uploadOK)
    {
        $post = new Post($db, $userLoggedIn);
        $post->submitPost($_POST['post_text'], 'none', $imageName);
    }
    else // Display the error message
        echo "<div style='text-aling: center;' class='alert alert-danger'> $errMess </div>";
}

?>

<style type="text/css">
    .wrapper{
        width:75%;
    }
</style>

<div class="index-wrapper">
    <div class="info-box">
        <div class="info-inner">
            <div class="info-in-head">
                <img src="<?php echo $user['cov_pic']; ?>">
            </div>
            <div class="info-in-body">
                <div class="in-b-box">
                    <div class="in-b-img">
                        <img src="<?php echo $user['prof_pic']; ?>">
                    </div>
                </div>
                <div class="info-body-name">
                    <div class="in-b-name">
                        <div><a href="profile.php"><?php echo $user['first_name'] . " " . $user['last_name']; ?></a>
                        </div>
                        <span><small><a href=""><?php echo "@" . $user['username'] ?></a></small></span>
                    </div>
                </div>
            </div>
            <div class="info-in-footer">
                <div class="number-wrapper">
                    <div class="num-box">
                        <div class="num-head">
                            Posts
                        </div>
                        <div class="num-body">
                            <?php echo $user['num_posts']; ?>
                        </div>
                    </div>
                    <div class="num-box">
                            <div class="num-head">
                            Likes
                            </div>
                        <div class="num-body">
                            <span class="likes_count">
                                <?php echo $user['num_likes']; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="post-wrap">
    <div class="post-inner">
            <div class="post-body">
                <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                    <textarea class="status" name="post_text" id="post_text" placeholder="What's on your mind?" rows="4" cols="50"></textarea>
                </div>
                <div class="post-footer">
                    <div class="p-fo-left">
                        <ul>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <label for="fileToUpload">
                            <i style="color:#3875C5" class="fas fa-camera"></i></label>
                            <span class="tweet-error"></span>
                        </ul>
                    </div>
                    <div class="p-fo-right">
                        <input type="submit" name="post" value="Share">
                    </form>
                </div>
            </div>
        </div>
        <div class="main_column_home">
            <div class="posts_area"></div>
            <img id="loading" src="images/icons/loading.gif">
        </div>
    </div>
</div>

<script>
    
    var userLoggedIn = '<?php echo $userLoggedIn; ?>';

    $(document).ready(function(){
        $('#loading').show();

        $.ajax({
            url: "ajax_load_posts.php",
            type: "POST",
            data: "page=1$userLoggedIn=" + userLoggedIn,
            cache: false,

            success: function(data)
            {
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

                var ajaxReq = 
                $.ajax ({
                    url: "ajax_load_posts.php",
                    type: "POST",
                    data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
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