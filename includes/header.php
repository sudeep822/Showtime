<?php
require_once("includes/config.php");  //path name where config is kept
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/Entity.php");
require_once("includes/classes/CategoryContainers.php");
require_once("includes/classes/EntityProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/SeasonProvider.php");
require_once("includes/classes/Season.php");
require_once("includes/classes/Video.php");
require_once("includes/classes/VideoProvider.php");
require_once("includes/classes/User.php");

if(!isset($_SESSION["userLoggedIn"]))  //already loggen in 
{
    header("Location:registter.php");  //go to register page
}

$userLoggedIn= $_SESSION["userLoggedIn"];

?>

<!DOCTYPE html>
<html>
   <head> <title>Welcome to ShowTime</title>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    <!-- jquery cds-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/ad5db0f3ca.js" crossorigin="anonymous"></script> <!-- font awesome-->
    <script src="assets/js/script.js"> </script>
    </head>
  <body>
    <div class='wrapper'>

    <?php

    if(!isset($hideNav))
    {
      include_once("includes/navBar.php"); // including nav bar if hideNav is set not in watch page
    }



   ?>