<?php
require_once("includes/header.php");

$preview= new PreviewProvider($con,$userLoggedIn);  //name of class
echo $preview->createPreviewVideo(null);

$containers= new CategoryContainers($con,$userLoggedIn);  //name of class
echo $containers->showAllCategories();


?>