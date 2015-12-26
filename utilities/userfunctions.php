<?php

class Database {
        public static function connect() {
        $dsn = 'mysql:dbname=tutoring;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            echo "<p>Connected to database!</p>";
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit(0);
        } 
        return $dbh;
        }
    }
    
class Utilisateur {
    public $login;
    public $password;
    public $lastname;
    public $name;
    public $birthdate;
    public $email;
   
    public function __toString() {
        $dob = explode('-', $this->birthdate);
       return  "[$this->login] $this->name <b>$this->lastname</b>, né le $dob[2]/$dob[1]/$dob[0], $this->email. <a href='?login=$this->login'>voir ses amis</a>";
    }
    
    public static function getUtilisateur($login){
        $dbh = Database::connect();
        $query = "SELECT * FROM `utilisateurs` WHERE `login`=\"$login\"";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();
        $dbh = null;
        if ($request_succeeded){return $sth->fetch(PDO::FETCH_ASSOC);}
        else {return null;}
    }
    
    public static function LoginExists($login){
        $dbh = Database::connect();
        $query = "SELECT * FROM `utilisateurs` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();
        $aux=$sth->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
        if($aux==NULL){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
        public static function PasswordMatches($login,$password){
        $dbh = Database::connect();
        $query = "SELECT * FROM `utilisateurs` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $request_succeeded = $sth->execute();
        $aux=$sth->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
        if($aux==NULL){
            return 2;
        } else {
            if ($aux["password"]==sha1($password)){
                return 1;
        } else{
            return 0;
        }
      }
    }
   
    public static function testerPassword($user, $password) {
        return ($user["password"]==sha1($password));
    }
    
    
    function changerPassword($login,$newpassword){
        $query = "UPDATE `utilisateurs` SET `password`='SHA1($newpassword)' WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $dbh = null; // Déconnexion de MySQL
    }
    
    function deleteUser($user,$dbh){
        $query = "DELETE FROM `utilisateurs` WHERE `login`='$user'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $dbh = null; // Déconnexion de MySQL
    }
}

    function registering(){
        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `password`, `name`, `lastname`, `birthdate`, `email`) VALUES(?,SHA1(?),?,?,?,?)");
        $sth->execute(array($_POST['login'],$_POST['pwd'],$_POST['name'],$_POST['lname'],$_POST['bdate'],$_POST['email']));
 
        $dbh = null; // Déconnexion de MySQL
    }
    
        function addLanguage($login,$level,$language){
        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `known_languages` (`login`, `level`,`language`) VALUES(?,?,?)");
        $sth->execute(array($login,$level,$language));
 
        $dbh = null; // Déconnexion de MySQL
    }
    
        function updateLanguage($login,$level,$language){
        $dbh = Database::connect();
        $sth = $dbh->prepare("UPDATE `known_languages` SET `level`='$level' WHERE  `login`='$login' AND `language`='$language' ");
        $sth->execute();
 
        $dbh = null; // Déconnexion de MySQL
    }
        function showLanguages ($login){
            $dbh=Database::connect();
            $query= "SELECT `language_id`,`level`  FROM `known_languages` WHERE `login`='$login'";
            $sth = $dbh->prepare($query);
            $sth->execute();

            while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
                echo $row;
                echo "You currently speak ".$row['language']. " at level ".$row['level']. "<br>"; 
            }
            
            $dbh = null;    
            
        }
        
        function languageForm(){
            $dbh= Database::connect();
            $sth = $dbh->prepare("SELECT `langue` FROM `langues`");
            $sth->execute();
                
            while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
                
                $aux=$row['langue'];
                echo "<input type=\"radio\" name=\"language\"  id=\"language\" value=\"".$aux."\">".PHP_EOL; 
                echo "<label for=\"language\">" .$aux. "</label>".PHP_EOL;
            }
            //class=\"form-control\"
            $dbh = null;    
            
        }
           function languageExists($login ,$language){
        $dbh = Database::connect();
        $query = "SELECT * FROM `known_languages` WHERE `login`='$login' AND `language`='$language' ";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $aux=$sth->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
        if($aux==NULL){
            return FALSE;
        } else {
            return TRUE;
        }
    }
        
        function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
         }
 
?>