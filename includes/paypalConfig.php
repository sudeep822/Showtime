<?php

 require_once("PayPal-PHP-SDK/autoload.php");

 $apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
      'ARFz96A0_-d0BNr_vrAVhxkmEFhnBqKVv2ByG6D_7kmV0sBFEFdVXkWdESHBJKORFkap_n3AAQbqG7Cn',
      'EOhXKl8L4Xeo2Db0uspzD305hjMsZszyI3wYdYow1VeLh--eh516Hc8A3V2Bb-PlnFg2GEyjLFL3KDFr'
    )
  );

?>