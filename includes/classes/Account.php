<?php
class Account{
    
    private $con;
    private $errorArray=array();  //for inserting error if any in array

    public function __construct($con){
        $this->con=$con;
    }



    public function updateDetails($fn, $ln, $em, $un)  //updating details from profile.php
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln); 
        $this->validateNewEmails($em,$un);   //validating single mail

        if(empty($this->errorArray)) //updating users database sql
        {
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:em WHERE username=:un");
            
            $query->bindValue(":fn",$fn);
            $query->bindValue(":ln",$ln);
            $query->bindValue(":em",$em);
            $query->bindValue(":un",$un);

            return $query->execute();
            
        }
        return false;
    }

    public function register($fn, $ln, $un, $em, $em2, $pw, $pw2) //function for checking for each field in register form
    {
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateUsername($un);
            $this->validateEmails($em, $em2);
            $this->validatePassword($pw,$pw2);

            if(empty($this->errorArray))  //if error array is empty means no error in registration
            {
                return $this->insertUserDetails($fn,$ln,$un,$em,$pw);  //insert in database 
            }

            return false;
    }

    public function login($un,$pw)
    {
        $pw=hash("sha512",$pw);  //hiding the password using hash func ie generating 256 chr pasword
        $query= $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw"); //select and compare from database
        $query->bindValue(":un",$un);
        $query->bindValue(":pw",$pw); //username and passwrd if match found return true;

        $query->execute();

        if($query->rowCount()==1) return true;
        

        array_push($this->errorArray, Constants::$loginFailed);
        return false;

    }

    private function insertUserDetails($fn,$ln,$un,$em,$pw)  //func to insert user details
    {
            $pw=hash("sha512",$pw);  //hiding the password using hash func
            $query= $this->con->prepare("INSERT INTO users (firstName,lastName,username,email,password)
             VALUES (:fn,:ln,:un,:em,:pw)");

             $query->bindValue(":fn",$fn);
             $query->bindValue(":ln",$ln);
             $query->bindValue(":un",$un);
             $query->bindValue(":em",$em);
             $query->bindValue(":pw",$pw);

             return $query->execute();

    }

    private function validateFirstName($fn)  //funtion for validating first name
    {
        if(strlen($fn) < 2 || strlen($fn) > 25){
                array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln)   //funtion for validating last name
    {
        if(strlen($ln) < 2 || strlen($ln) > 25){
                array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($un)   //funtion for validating Username --> should be uinque
    {
        if(strlen($un) < 2 || strlen($un) > 25){  //1check) checking for length
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;   // if len is false no need to check further
        }

        $query=$this->con->prepare("SELECT * FROM users WHERE username=:un"); //2 check)selecting all usernam from db
        $query->bindValue(":un",$un);
        $query->execute();

        if($query->rowCount()!=0) { //alreay present username
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

  

    private function validateEmails($em,$em2)
    {
        if($em != $em2)    //  1 check) if curr and confrm mail are not matching
        {
            array_push($this->errorArray, Constants::$emailsDontMatch); 
            return;
        }
        
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){  //  2 check )inbuilt function to check curr mail with standard mail
            array_push($this->errorArray, Constants::$emailsInvalid); 
            return;
        }

        $query=$this->con->prepare("SELECT * FROM users WHERE email=:em"); //3 check)selecting all email from db
        $query->bindValue(":em",$em);
        $query->execute();

        if($query->rowCount()!=0) { //alreay present username
            array_push($this->errorArray, Constants::$emailTaken);
        }
        
    }



    private function validateNewEmails($em,$un)  //validating emails from profile page
    {
        
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){  //  filtering email
            array_push($this->errorArray, Constants::$emailsInvalid); 
            return;
        }

        $query=$this->con->prepare("SELECT * FROM users WHERE email=:em AND username != :un"); //checking em and un from db
        $query->bindValue(":em",$em);
        $query->bindValue(":un",$un);
        $query->execute();

        if($query->rowCount()!=0) { //alreay present username
            array_push($this->errorArray, Constants::$emailTaken);
        }
        
    }
  
    public function validatePassword($pw, $pw2)
    {
        if($pw != $pw2)  //1)check if password mis match
        {
            array_push($this->errorArray, Constants::$passwordDontMatch);
            return;
        }

        if(strlen($pw) < 5 || strlen($pw) > 15){  //2)check must [5,15]
            array_push($this->errorArray, Constants::$passwordLength);
    }
    }
    

    public function getError($error)
    {
        if(in_array($error,$this->errorArray))
        {
            return "<span class='errorMessage' >$error</span>";  //adding css effect to errors
        }
    }
    
    public function getFirstError()  //func to show first error in profile page fn ln em
    {
        if(!empty($this->errorArray))  //if array is not empty return first value
        {
            return $this->errorArray[0];
        }
    }

    public function updatePassword($oldPw, $pw, $pw2, $un)  //func to update password in profile page 
    {
      $this->validateOldPassword($oldPw,$un);  //check curr and entered pswrd
      $this->validatePassword($pw,$pw2);       //check new and re-enter pswrd

      if(empty($this->errorArray)) //updating users database sql if error array is empty make changes
        {
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un"); //updating db
            $pw=hash("sha512",$pw);

            $query->bindValue(":pw",$pw);
            $query->bindValue(":un",$un);

            return $query->execute();
            
        }
        return false;
    }

    public function validateOldPassword($oldPw, $un)  //func for validating old password
    {
      //selecting psrd from db and matching withe entered pswrd

        $pw=hash("sha512",$oldPw);  //hiding the password using hash func ie generating 256 chr pasword
        $query= $this->con->prepare("SELECT * FROM users WHERE username=:un AND password=:pw"); //select and compare from database
        $query->bindValue(":un",$un);
        $query->bindValue(":pw",$pw); //username and passwrd if match found return true;

        $query->execute();

        if($query->rowCount()==0)  //no matching paswrd
        {
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }
}

?>