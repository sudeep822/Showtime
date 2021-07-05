<?php
require_once("includes/header.php");

$preview= new PreviewProvider($con,$userLoggedIn);  //name of class
echo $preview->createTvShowPreviewVideo();

$containers= new CategoryContainers($con,$userLoggedIn);  //name of class
echo $containers->showTvShowCategories();


?>