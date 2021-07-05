<?php
    
    require_once("../includes/config.php"); //go one folder back and to config.php

    if(isset($_POST["videoId"])  && isset($_POST["username"]))  // finding in database of videoprogress
    {
        $query = $con->prepare("SELECT * FROM videoprogress WHERE username=:username AND videoId=:videoId");
        $query->bindValue(":username", $_POST["username"]);
        $query->bindValue(":videoId", $_POST["videoId"]);
        $query->execute();

        if(($query->rowCount() == 0))  //if row count in 0 then inserting in video progress table
        {
            $query = $con->prepare("INSERT INTO videoprogress (username,videoId) VALUES (:username, :videoId)");
            $query->bindValue(":username", $_POST["username"]);
            $query->bindValue(":videoId", $_POST["videoId"]);
            $query->execute();
            
        }
    }
    else{
        echo " No video ID or Username passed into file";
    }

?>