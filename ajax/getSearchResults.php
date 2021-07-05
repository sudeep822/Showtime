<?php
    
    require_once("../includes/config.php"); //go one folder back and to config.php
    require_once("../includes/classes/SearchResultsProvider.php");
    require_once("../includes/classes/EntityProvider.php");
    require_once("../includes/classes/Entity.php");
    require_once("../includes/classes/PreviewProvider.php");


    if(isset($_POST["term"])  && isset($_POST["username"]))  // finding in database of videoprogress
    {
        
        $srp = new SearchResultProvider($con, $_POST["username"]);
        echo $srp->getResults($_POST["term"]);
       
    }
    else{
        echo " No term or Username passed into file";
    }

?>