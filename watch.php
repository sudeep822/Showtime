<?php
$hideNav= true; // for setting nav bar || nav bar wont show here
require_once("includes/header.php"); //for background

if(!isset($_GET["id"]))
{
    ErrorMessage::show("No ID passed into page");  //error message if no id passed
} 

$user = new User($con, $userLoggedIn);  //preventing user to watch video if not subscribed
 
// -- func to prevent user
/*if(!$user->getIsSubscribed())
{
    ErrorMessage::show("You must be subscribed to see this.
                        <a href='profile.php'> Click here to subscribe</a>");
}
*/
//------

$video = new Video($con, $_GET["id"]);
$video->incrementViews();
$upNextVideo=VideoProvider::getUpNext($con, $video);  //calling getupnext() from VideoProvider class
?>


<div class="watchContainer">  

        <div class="videoControls watchNav">
            <button onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
            <h1><?php echo $video->getTitle(); ?></h1>
        </div>

        <div class="videoControls upNext" style="display:none">        <!-- div for up next title-->
            <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>

            <div class="upNextContainer">
             <h2>Up next:</h2>
             <h3><?php echo $upNextVideo->getTitle();  ?></h3>
             <h3><?php echo $upNextVideo->getSeasonAndEpisode();  ?></h3>   <!--season and episode in next up -->

             
             <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>)"><i class="fas fa-play"></i> Play</button> 
             
            </div>

        </div>

    <video controls autoplay onended="showUpNext()">
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
</div>


<script>
initVideo("<?php echo $video->getId(); ?>" , " <?php echo $userLoggedIn; ?>");
 </script> 