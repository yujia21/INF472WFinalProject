<?php

class Database {
        public static function connect() {
        $dsn = 'mysql:dbname=finalproject;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            //echo "<p>Connected to database!</p>";
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

//LOGIN, REGISTRATION ET LANGUES
    function registering(){
        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `password`, `name`, `lastname`, `birthdate`, `email`) VALUES(?,SHA1(?),?,?,?,?)");
        $sth->execute(array($_POST['login'],$_POST['pwd'],$_POST['name'],$_POST['lname'],$_POST['bdate'],$_POST['email']));
 
        $dbh = null; // Déconnexion de MySQL
    }
    
    function languetoid($language){
        $dbh = Database::connect();
        $sth = $dbh->prepare("SELECT `langue_id` FROM `langues` WHERE `langue` = '$language'");
        $sth ->execute();
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
            $id = $row['langue_id'];
        }
        $dbh = null;
        return $id;
    }
       
    function idtolangue($id){
        $dbh = Database::connect();
        $sth = $dbh->prepare("SELECT `langue` FROM `langues` WHERE `langue_id` = '$id'");
        $sth ->execute();
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
            $langue = $row['langue'];
        }
        $dbh = null;
        return $langue;
    }
    
    function addLanguage($login,$level,$language){
        $id = languetoid($language);
        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `known_languages` (`login`, `level`,`language_id`) VALUES(?,?,?)");
        $sth->execute(array($login,$level,$id));
         $dbh = null; // Déconnexion de MySQL
    }
    
    function updateLanguage($login,$level,$language){
        $id = languetoid($language);
        $dbh = Database::connect();
        $sth = $dbh->prepare("UPDATE `known_languages` SET `level`='$level' WHERE  `login`='$login' AND `language_id`='$id' ");
        $sth->execute();
 
        $dbh = null; // Déconnexion de MySQL
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
        $dbh = null;    
            
    }
        
    function languageExists($login ,$language){
        $id = languetoid($language);
        $dbh = Database::connect();
        $query = "SELECT * FROM `known_languages` WHERE `login`='$login' AND `language_id`='$id' ";
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
        
    function usersalllangue ($login){
        $dbh=Database::connect();
        $query= "SELECT `language_id` FROM `known_languages` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            $id=$row['language_id'];
            echo "<b>".idtolangue($id).":</b><br>";
            usersforlangue($login,$id);
        }
    }
         
    function usersforlangue ($login,$id){
        $dbh=Database::connect();
        $query= "SELECT `level`  FROM `known_languages` WHERE `login`='$login' AND `language_id`='$id'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
            $level=$row['level'];
        }

        $query= "SELECT `login`  FROM `known_languages` WHERE `language_id`='$id' AND `level`<='$level'+10 AND `level`>='$level'-10";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            $user=$row['login'];
            if ($user != $login){
                echo $user.": <a href='index.php?page=userprofile&altuser=$user'>View Profile</a><br>";
                $n=$n+1;
            }
        }
        echo $n." user(s) found<br><br>";
        $dbh = null;    

    }
    
    //REQUESTS
    function rateRequest($login1,$login2,$ratedlevel,$language){
        $id = languetoid($language);
        $dbh = Database::connect();
        $sth = $dbh->prepare("SELECT * FROM `rating_requests` WHERE  `login1`='$login1' AND `login2`='$login2' AND `language_id`='$id'");
        $sth->execute();    
        if($sth->fetch(PDO::FETCH_ASSOC)){
            echo "You have already rated $login2's $language ability, your score for $login2 will be updated! <br>";
            $sth = $dbh->prepare("DELETE FROM `rating_requests` WHERE (`login1`, `login2`,`language_id`)=(?,?,?)");
            $sth->execute(array($login1,$login2,$id));
        }
        // TO ADD : WHAT HAPPENS IF SAME USER TRIES TO RATE USER2 FOR SAME LANGUAGE : UPDATES
        $sth = $dbh->prepare("INSERT INTO `rating_requests` (`login1`, `login2`,`language_id`,`ratedlevel`) VALUES(?,?,?,?)");
        $sth->execute(array($login1,$login2,$id,$ratedlevel));
        $dbh = null; // Déconnexion de MySQL
        //login1 is the rater, login2 is rated
    }
    
    function showrateRequests($login){
        $dbh = Database::connect();
        $sth = $dbh->prepare("SELECT * FROM `rating_requests` WHERE  `login2`='$login'");
        $sth->execute();

        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            $language = idtolangue($row['language_id']);
            if ($row['login1'] != null){
                echo "<p>".$row['login1']." rated your ".$language." language abilities!";
                echo "<input type=\"hidden\" name =\"login1\" id =\"login1\" value=\"".$row['login1']."\">";
                echo "<input type=\"hidden\" name =\"login2\" id =\"login2\" value=\"".$row['login2']."\">";
                echo "<input type=\"hidden\" name =\"language\" id =\"language\" value=\"".$language."\">";
                echo "<input type=\"hidden\" name =\"ratedlevel\" id =\"ratedlevel\" value=\"".$row['ratedlevel']."\">";
                echo "  <button type=\"submit\" name =\"validrequest\" id =\"validrequest\" value=\"Accept\">&#10004;</button>";
                echo "  <button type=\"submit\" name =\"validrequest\" id =\"validrequest\" value=\"Reject\">&#10008;</button></p>"; //how to submit all data from row
            }
        }
        $dbh=null;
    }
    
    function deleterateRequest($login1,$login2,$ratedlevel,$language){
        $id = languetoid($language);
        $dbh = Database::connect();
        $sth = $dbh->prepare("DELETE FROM `rating_requests` WHERE (`login1`, `login2`,`language_id`,`ratedlevel`)=(?,?,?,?)");
        $sth->execute(array($login1,$login2,$id,$ratedlevel));
        $dbh = null; // Déconnexion de MySQL
    }
            
    function rateLanguage($login,$ratedlevel,$language){
        $id = languetoid($language);
        $dbh = Database::connect();
        $sth = $dbh->prepare("SELECT `ratedlevel`,`conversations` FROM `known_languages` WHERE  `login`='$login' AND `language_id`='$id' ");
        $sth->execute();
        
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
            $oldlevel = $row['ratedlevel'];
            $oldnumber = $row['conversations'];
            $newnumber = $oldnumber + 1;
        }
        if ($oldnumber == 0){
            $newlevel = $ratedlevel;
        } else {
            $newlevel = ($oldlevel * $oldnumber + $ratedlevel) / $newnumber;
        }
        
        $sth = $dbh->prepare("UPDATE `known_languages` SET `ratedlevel`='$newlevel', `conversations` = '$newnumber' WHERE  `login`='$login' AND `language_id`='$id' ");
        $sth->execute();
        $dbh = null; // Déconnexion de MySQL
    }
    
    function showLanguages ($login, $self){
        $dbh=Database::connect();
        $query= "SELECT `language_id`,`level`,`ratedlevel`,`conversations`  FROM `known_languages` WHERE `login`='$login'";
        $sth = $dbh->prepare($query);
        $sth->execute();
          
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){   
            $langue = idtolangue($row['language_id']);
            echo "<u>".$langue. "</u>: <br> ";
            if ($self==true){
                echo "You rated yourself level ".$row['level']. "<br>"; 
                if ($row['conversations']!=0){
                    echo "After ".$row['conversations']." conversations, others rated you level ".$row['ratedlevel']. "<br><br>"; 
                } else {echo "You haven't had any conversations in ".$langue." yet!<br><br>";}
            } else {
                echo $login." rated him/herself level ".$row['level']. "<br>"; 
                if ($row['conversations']!=0){
                    echo "After ".$row['conversations']." conversations, others rated him/her level ".$row['ratedlevel']. "<br><br>"; 
                } else {echo "He/She hasn't had any conversations in ".$langue." yet!<br><br>";}
            }
        }
          
        $dbh = null;    
          
    }
    
    function findsimilarlangues($login1,$login2){
        if ($login1==$login2){echo "Error! You can't rate yourself!";}
        else {
        $dbh=Database::connect();
        $query= "SELECT `language_id`  FROM `known_languages` WHERE `login`='$login1'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        while($row1 = $sth->fetch(PDO::FETCH_ASSOC)){
            $id = $row1['language_id'];
            $query2= "SELECT *  FROM `known_languages` WHERE `login`='$login2' AND `language_id`=$id";
            $sth2 = $dbh->prepare($query2);
            $sth2->execute();
            while($row2 = $sth2->fetch(PDO::FETCH_ASSOC)){   
                $aux = idtolangue($row2['language_id']);

                echo "<input type=\"radio\" name=\"language\"  id=\"language\" value=\"".$aux."\">".PHP_EOL; 
                echo "<label for=\"language\">" .$aux. "</label>".PHP_EOL;
            }
        }
        $dbh=null;
        }
    }
    
    function countrequests($login){
        $dbh=Database::connect();
        $query= "SELECT * FROM `rating_requests` WHERE  `login2`='$login'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
            
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            $n = $n+1;
        }
        return $n;
    }

    
    
//MESSAGES
    function showmessages($login){
        $dbh=Database::connect();
        $query= "SELECT *  FROM `chatroom` WHERE `login1`='$login' OR `login2`='$login'";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            if ($n ==0){
                echo "<table style=\"width:100%\">";
                echo "<tr><td><b>from: </b></td>";
                echo "<td><b>to: </b></td>";
                echo "<td><b>date: </b></td>";
                echo "<td><b>message: </b></td>";
            }
            if ($row["login1"]==$login){ // i sent them
                $login2=$row["login2"];
                echo "<tr><td>".$row['login1']."</td>";
                echo "<td><a href=\"index.php?page=chatroom&altuser=$login2\">".$row['login2']."</a></td>"; //make this a link to send
                echo "<td>".$row['date']."</td>"; //arrange by date?
                echo "<td>".$row['message']."</td></tr>";
            } else { // messages to me
                $login1=$row["login1"];
                if ($row['messageread']==0){
                    echo "<tr bgcolor = \"#00FA9A\">";
                } else {echo "<tr>";}

                echo "<td><a href=\"index.php?page=chatroom&altuser=$login1\">".$row['login1']."</a></td>"; //make this a link to send
                echo "<td>".$row['login2']."</td>";
                echo "<td>".$row['date']."</td>"; //arrange by date?
                echo "<td>".$row['message']."</td></tr>";
            }
            $n=$n+1;
        }
        if ($n!=0){
            echo "</table>";
        }
    }
    
    function showconversation($login1,$login2){ //sent by login1 to login2, called by login1
        $dbh=Database::connect();
        $query= "SELECT *  FROM `chatroom` WHERE (`login1`='$login1' AND `login2`='$login2') OR (`login1`='$login2' AND `login2`='$login1') ";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            if ($n ==0){
                echo "<table style=\"width:100%\">";
                echo "<tr><td><b>from: </b></td>";
                echo "<td><b>to: </b></td>";
                echo "<td><b>date: </b></td>";
                echo "<td><b>message: </b></td>";
            }
            if ($row['login2']==$login1 & $row['messageread']==0){
                echo "<tr bgcolor = \"#00FA9A\">";
            } else {echo "<tr>";}
            
            echo "<td>".$row['login1']."</td>";
            echo "<td>".$row['login2']."</td>"; 
            echo "<td>".$row['date']."</td>"; //arrange by date?
            echo "<td>".$row['message']."</td></tr>";
            $n=$n+1;
            echo "</tr>";
            
        }
        if ($n!=0){
            echo "</table>";
        }
        
        //Update all messages sent to login1 as read
        $sth = $dbh->prepare("UPDATE `chatroom` SET `messageread`='1' WHERE  `login2`='$login1' AND `login1`='$login2'");
        $sth->execute();
    }
    
    function countnewmessages($login){
        $dbh=Database::connect();
        $query= "SELECT `messageread`  FROM `chatroom` WHERE (`login2`='$login') "; //messages you received
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            if ($row['messageread']==0){
                $n = $n + 1;
            }
        }
        return $n;
    }
    
    
    function sendmessage($login1,$login2,$message){
        $date = date ("Y-m-d H:i:s", time()); 
        $dbh=Database::connect();
        $query ="INSERT INTO `chatroom` (`login1`, `login2`, `date`, `message`, `messageread`) VALUES (?,?,?,?,?)";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login1,$login2,$date,$message,False));
        echo "Your message is sent at $date!<br>";
    }
?>