<?php
    
    require_once("../includes/config.php"); //go one folder back and to config.php

    if(isset($_POST["videoId"])  && isset($_POST["username"]))  // finding in database of videoprogress
    {
        // select progress column to keep track where to resume video
        $query = $con->prepare("SELECT progress FROM videoprogress WHERE username=:username AND videoId=:videoId");
        $query->bindValue(":username", $_POST["username"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->execute();

        echo $query->fetchColumn();

       
    }
    else{
        echo " No video ID or Username passed into file";
    }

?>