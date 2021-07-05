<?php
require_once("includes/classes/FormSanitizer.php");
require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

  $account = new Account($con);

  
 if(isset($_POST["submitButton"]))     // same name as name in submit
{
 
 $username= FormSanitizer::sanitizeFormUsername($_POST["username"]);
 
 $password= FormSanitizer::sanitizeFormPassword($_POST["password"]);
 

$success = $account->login( $username,  $password); //calling the register funtion for validating
    
if($success)
{
  $_SESSION["userLoggedIn"]=$username;
  header("Location: index.php");  //go to this file if success is true
}
}

function getInputValue($name)
{
  if(isset($_POST[$name]))  //if value is there then echo
  {
    echo $_POST[$name];
  }
}
?>



<!DOCTYPE html>
<html>
   <head> <title>Welcome to showtime</title></head>
    <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
  <body>
    
  <div class="signInContainer">
     
     <div class="column">
         <div class="header">
         <img src="assets/images/logo.png" title="logo" alt="site logo"/> 
             <h3>Sign In</h3>
             <span>to continue showtime</span>
             

         </div>
         <form method="POST">

         
         <?php echo $account->getError(Constants::$loginFailed);    ?>
         <input type="text" name="username" placeholder="Username" value="<?php getInputValue("username"); ?>" required>

         <input type="password" name="password" placeholder="Password" required>

         <input type="submit" name="submitButton" value="SUBMIT">
         </form>

         <a href="register.php" class="signInMessage">Need an Account? Sign up here!</a>
     </div>
  
    </div>

  </body>

</html>