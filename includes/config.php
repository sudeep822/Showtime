<?php
 
 ob_start(); //turns on output buffering
 session_start();

 date_default_timezone_set("Asia/Dili");

 try{
    $con= new PDO("mysql:dbname=showtime;host=localhost", "root","");  //connneting to database
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
 }
 catch(PDOException $e){  // if conection fails
    exit("Connection failed:" .$e->getMessage());
 }
?>