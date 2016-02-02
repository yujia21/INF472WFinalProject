<?php
    function test_input($data) {
         $data = trim($data);
         $data = stripslashes($data);
         $data = htmlspecialchars($data);
         return $data;
     }

//LOGIN, REGISTRATION ET LANGUES, RATINGS
    function registering(){
        $dbh = Database::connect();
        $sth = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `password`, `name`, `lastname`, `birthdate`, `email`) VALUES(?,SHA1(?),?,?,?,?)");
        $sth->execute(array($_POST['login'],$_POST['pwd'],$_POST['name'],$_POST['lname'],$_POST['bdate'],$_POST['email']));
 
        $dbh = null; // Déconnexion de MySQL
    }
    
    function updating($login,$pwd){
        $dbh = Database::connect();
        $sth = $dbh->prepare("UPDATE `utilisateurs` SET `password`=SHA1(?), `name`=?, `lastname`=?, `birthdate`=?, `email`=? WHERE `login` = '$login'");
        $sth->execute(array($pwd,$_POST['name'],$_POST['lname'],$_POST['bdate'],$_POST['email']));
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
    
    function deleteLanguage($login,$langue){
        $dbh = Database::connect();
        $sth = $dbh->prepare("DELETE FROM `known_languages` WHERE (`login`, `language_id`)=(?,?)");
        $sth->execute(array($login,languetoid($langue)));
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
            $id = $row['idknown'];
            if ($row['login1'] != null){
                echo "<p>".$row['login1']." rated your ".$language." language abilities!";
                echo "  <button type=\"submit\" name =\"acceptrequest\" id =\"acceptrequest\" value=\"$id\">&#10004;</button>";
                echo "  <button type=\"submit\" name =\"rejectrequest\" id =\"rejectrequest\" value=\"$id\">&#10008;</button></p>"; 
            }
        }
        $dbh=null;
    }
    
    function deleterateRequest($id){
        $dbh = Database::connect();
//        $sth = $dbh->prepare("SELECT * FROM `rating_requests` WHERE  `idknown`='$id'");
  //      $sth->execute();
//        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
//            $login1 = idtolangue($row['login1']);
//            $language = idtolangue($row['language_id']);
        //}
        //echo "<script>alert(\"You have rejected ".$login1."'s rating of your ".$language." ability.\")</script>";
        $sth = $dbh->prepare("DELETE FROM `rating_requests` WHERE `idknown`=$id");
        $sth->execute();
        $dbh = null; // Déconnexion de MySQL
    }
            
    function rateLanguage($id){
        $dbh = Database::connect();
        $sth = $dbh->prepare("SELECT * FROM `rating_requests` WHERE  `idknown`='$id'");
        $sth->execute();
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            $login1 = $row['login1']; //rater
            $login2 = $row['login2']; //ratee
            $language = idtolangue($row['language_id']);
            $ratedlevel = $row['ratedlevel'];
        }
        echo "<script>alert(\"You have accepted ".$login1."'s rating of ".$ratedlevel." for your ".$language." ability.\")</script>";
        $oldnumber = 0;
        $newnumber=$ratedlevel;
        
        $sth = $dbh->prepare("SELECT `ratedlevel`,`conversations` FROM `known_languages` WHERE  `login`='$login2' AND `language_id`='$id' ");
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
        
        $sth = $dbh->prepare("UPDATE `known_languages` SET `ratedlevel`='$newlevel', `conversations` = '$newnumber' WHERE  `login`='$login2' AND `language_id`='$id' ");
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
        $dbh = null;    
    }