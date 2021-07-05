<?php
require_once("includes/header.php");

if(!isset($_GET["id"]))
{
    ErrorMessage::show("No id passed to page");
}

$preview= new PreviewProvider($con,$userLoggedIn);  //name of class
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers= new CategoryContainers($con,$userLoggedIn);  //name of class
echo $containers->showCategory($_GET["id"]);


?>