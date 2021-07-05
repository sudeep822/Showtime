<?php
require_once("includes/header.php");

$preview= new PreviewProvider($con,$userLoggedIn);  //name of class
echo $preview->createMoviesPreviewVideo();

$containers= new CategoryContainers($con,$userLoggedIn);  //name of class
echo $containers->showMovieCategories();


?>