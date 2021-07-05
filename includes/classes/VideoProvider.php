<?php

class VideoProvider
{
    public static function getUpNext($con, $currentVideo)
    {   
        // dont fetch current video running and curr season and episode should be greater than curr episode and select only one video
        $query = $con->prepare("SELECT * FROM videos 
                            WHERE entityId=:entityId AND id != :videoId
                            AND (
                                (season=:season AND episode > :episode) OR season > :season  
                            )
                            ORDER BY season, episode ASC LIMIT 1");  //select one video --> no episode get next season

        $query->bindValue(":entityId",$currentVideo->getEntityId());
        $query->bindValue(":season",$currentVideo->getSeasonNumber());
        $query->bindValue(":episode",$currentVideo->getEpisodeNumber());
        $query->bindValue(":videoId",$currentVideo->getId());

        $query->execute();

        //if in last season last episode

        if($query->rowCount()==0)               //returns nothing
        {
            //selecting s1 e1 or movie not curr video on high views and selecting one 
            $query = $con->prepare( "SELECT * FROM videos WHERE season<=1 AND episode <=1 AND id!=:videoId
                                    ORDER BY views DESC LIMIT 1");
            $query->bindValue(":videoId",$currentVideo->getId());
            $query->execute();
        }

        $row = $query->fetch(PDO::FETCH_ASSOC); //fetching data from db
        return new Video($con, $row);
    }

    public static function getEntityVideoForUser($con,$entityId,$username)
    {
        $query = $con->prepare("SELECT videoid from videoprogress INNER JOIN videos
                                ON videoprogress.videoid = videos.id
                                WHERE videos.entityId=:entityId 
                                AND videoprogress.username=:username
                                ORDER BY videoprogress.dateModified DESC
                                LIMIT 1");
        $query->bindValue(":entityId", $entityId);
        $query->bindValue(":username", $username);
        $query->execute();

        if($query->rowCount()==0)  //if user has not seen it || query return null
        {   
            //select lowest ep from lowest season 
            $query = $con->prepare("SELECT id FROM videos
                                    WHERE entityId=:entityId
                                    ORDER BY season, episode ASC LIMIT 1");

              $query->bindValue(":entityId", $entityId);
              $query->execute();

        }
        return $query->fetchColumn();
    }
}

?>