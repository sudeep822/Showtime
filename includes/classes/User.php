<?php
    class User{

        private $con,$username;

        public function __construct($con, $username)
        {
            $this->con= $con;

            $query= $con->prepare("SELECT * FROM users WHERE username=:username");  //selecting row of users
            $query->bindValue(":username",$username);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            
        }

        public function getFirstName()
        {
            return $this->sqlData["firstName"];
        }

        public function getLastName()
        {
            return $this->sqlData["lastName"];
        }
        
        public function getEmail()
        {
            return $this->sqlData["email"];
        }

        public function getIsSubscribed()
        {
            return $this->sqlData["isSubscribed"];
 
        }

        public function getUsername()
        {
            return $this->sqlData["username"];
 
        }

        public function setIsSubscribed($value)
        {
            $query = $this->con->prepare("UPDATE users SET isSubscribed=:isSubscribed WHERE username=:un");

            $query->bindValue(":isSubscribed",$value);
            $query->bindValue(":un",$this->getUsername());

           if($query->execute())   //if query return true update db
           {
               $this->sqlData["isSubscribed"] =$value;
               return true;
           }
           return false;
        }
    }
?>