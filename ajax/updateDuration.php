<?php
    
    require_once("../includes/config.php"); //go one folder back and to config.php

    if(isset($_POST["videoId"])  && isset($_POST["username"]) && isset($_POST["progress"]))  // finding in database of videoprogress
    {
        //updating the video progress table  NOW()->curr time
        $query = $con->prepare("UPDATE videoprogress SET progress=:progress, dateModified=NOW() WHERE username=:username AND videoId=:videoId");
        $query->bindValue(":username", $_POST["username"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->bindValue(":progress", $_POST["progress"]);
        $query->execute();

       
    }
    else{
        echo " No video ID or Username passed into file";
    }

?>