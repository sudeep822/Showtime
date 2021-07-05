<?php
 class PreviewProvider
 {
     private $con,$username;

     public function __construct($con, $username)
     {
        $this->con=$con;
        $this->username=$username;
     }

     public function createCategoryPreviewVideo($categoryId)   //for category page/tvshow in nav bar
     {
         $entitiesArray =  EntityProvider::getEntities($this->con,$categoryId,1);

         if(sizeof($entitiesArray)==0)
         {
             ErrorMessage::show("No TV shows to display");
         }
         return $this->createPreviewVideo($entitiesArray[0]);
     }

     public function createTVShowPreviewVideo()   //for tv show page in nav bar
     {
         $entitiesArray =  EntityProvider::getTVShowEntities($this->con,null,1);

         if(sizeof($entitiesArray)==0)
         {
             ErrorMessage::show("No TV shows to display");
         }
         return $this->createPreviewVideo($entitiesArray[0]);
     }



     public function createMoviesPreviewVideo()   //for movies page in nav bar
     {
         $entitiesArray =  EntityProvider::getMoviesEntities($this->con,null,1);

         if(sizeof($entitiesArray)==0)
         {
             ErrorMessage::show("No movies to display");
         }
         return $this->createPreviewVideo($entitiesArray[0]);
     }




     public function createPreviewVideo($entity)  //funtion to create preview video
     {
         if($entity==null)               //if it is null generate one for home page
         {
             $entity=$this->getRandomEntity();
         }
         //displaying id name preview thumbnail in index page
         $id=$entity->getId();
         $name=$entity->getName();
         $preview=$entity->getPreview();
         $thumbnail=$entity->getThumbnail();

         

         $videoId = VideoProvider::getEntityVideoForUser($this->con, $id, $this->username);  // calling for play button in preview
         $video = new Video($this->con, $videoId);

         $inProgress=$video->isInProgress($this->username);

         $playButtonText = $inProgress ? "Continue Watching" : "Play";
        
         $seasonEpisode = $video->getSeasonAndEpisode();
         $subHeading = $video->isMovie() ? "" : "<h4>$seasonEpisode</h4>"; //if movie do nothig else display subtitle 

        return "<div class= 'previewContainer'>
                    <img src='$thumbnail' class='previewImage' hidden>

                    <video autoplay muted class='previewVideo' onended='previewEnded()'>
                        <source src='$preview' type='video/mp4'>
                    </video>

                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                        <h3>$name</h3>
                        $subHeading
                        <div class='buttons'>
                            <button onclick='watchVideo($videoId)'><i class='fas fa-play'></i>  $playButtonText</button>
                            <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                        </div>

                        </div>



                    </div>
        
                </div>" ;
         

     }

     public function createEntityPreviewSquare($entity)
     {
         $id= $entity->getId();
         $thumbnail= $entity->getThumbnail();
         $name= $entity->getName();

         return " <a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                    <img src ='$thumbnail' title= '$name'>
                    </div>


         </a>";

     }

     private function getRandomEntity()  //get random entity function
     {
        $entity= EntityProvider::getEntities($this->con,null,1); // get 1 random entity 
        return $entity[0];
     }
     
 }
?>