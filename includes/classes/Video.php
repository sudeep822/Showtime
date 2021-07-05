<?php

class Video
{

    private $con, $sqlData, $entity;

    public function __construct($con, $input){

        $this->con=$con;
        if(is_array($input))
            {
                $this->sqlData=$input;
            }

            else{
                $query=$this->con->prepare("SELECT * FROM videos WHERE id=:id");
                $query->bindValue(":id",$input);
                $query->execute();

                $this->sqlData= $query->fetch(PDO::FETCH_ASSOC); //fetch from table
                }

                $this->entity = new Entity($con, $this->sqlData["entityId"]);
    }

// func for retrieving id title des from video db
    public function getId()
    {
        return $this->sqlData["id"];  //get video id from database
    }

    public function getTitle()
    {
        return $this->sqlData["title"];  //get title from database
    }

    public function getDescription()
    {
        return $this->sqlData["description"];  //get description from database
    }

    public function getFilePath()
    {
        return $this->sqlData["filePath"];  //get file from database
    }

    public function getThumbnail()
    {
        return $this->entity->getThumbnail();  //get thumbnail from Entity class
    }
    

    public function getEpisodeNumber()
    {
        return $this->sqlData["episode"];  //get episode number from database
    }

    public function getSeasonNumber()
    {
        return $this->sqlData["season"];  //get season number from database
    }

    public function getEntityId()
    {
        return $this->sqlData["entityId"];  //get entityId from database
    }


 // func to inc views in database
    public function incrementViews()
    {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindValue( ":id", $this->getId());
        $query->execute();
    }


    public function getSeasonAndEpisode()
    {
            if($this->isMovie()) return; //do nothing

            $season = $this->getSeasonNumber();
            $episode =$this->getEpisodeNumber();

            return " Season $season, Episode $episode";
    }

    public function isMovie()  //checking whether isMovie
    {
        return $this->sqlData["isMovie"] ==1;
    }


    public function isInProgress($username)
    {
        $query = $this->con->prepare("SELECT * FROM videoprogress
                                    WHERE videoid=:videoId AND userName=:username
                                    ");

        
        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":username", $username);

        $query->execute();

        return $query->rowCount()!=0;  //return true or false
    }

    public function hasSeen($username)
    {
        $query = $this->con->prepare("SELECT * FROM videoprogress
                                    WHERE videoid=:videoId AND userName=:username
                                    AND finished=1");

        
        $query->bindValue(":videoId", $this->getId());
        $query->bindValue(":username", $username);

        $query->execute();

        return $query->rowCount()!=0;  //return true or false
    }

}

    
?>