<?php
    
    require_once("../includes/config.php"); //go one folder back and to config.php

    if(isset($_POST["videoId"])  && isset($_POST["username"]))  // finding in database of videoprogress
    {
        //updating the video progress finish column table  NOW()->curr time
        //set finished 1 as video is over and reset progress to 0 ie from statt
        $query = $con->prepare("UPDATE videoprogress SET finished=1, progress=0  WHERE username=:username AND videoId=:videoId");
        $query->bindValue(":username", $_POST["username"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->execute();

       
    }
    else{
        echo " No video ID or Username passed into file";
    }

?>