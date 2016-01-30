<?php
//MESSAGES; CONTACT US FORM
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
        $dbh = null;    
    }
    
    function updateconversation($login1,$login2){ //sent by login1 to login2, called by login1
        $dbh=Database::connect();
        $query= "SELECT *  FROM `chatroom` WHERE (`messageread`='0') AND (`login1`='$login2' AND `login2`='$login1')" ;
        $sth = $dbh->prepare($query);
        $sth->execute();
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            return true;
        }
        return false;
        $dbh = null;    
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
            echo "<td>".$row['date']."</td>"; //how to force an arrange by date?
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
        $dbh = null;    
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
        $dbh = null;    
    }
    
    
    function sendmessage($login1,$login2,$message){
        $date = date ("Y-m-d H:i:s", time()); 
        $dbh=Database::connect();
        $query ="INSERT INTO `chatroom` (`login1`, `login2`, `date`, `message`, `messageread`) VALUES (?,?,?,?,?)";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login1,$login2,$date,$message,False));
        //echo "<script> alert(\"Your message is sent at ".$date."!\")</script>";
        $dbh = null;    
    }
    
    
    //CONTACT FORM
    function contactform($message, $name, $email){
        $dbh=Database::connect();
        $query ="INSERT INTO `comments` (`email`, `message`, `name`, `commentread`) VALUES (?,?,?,?)";
        $sth = $dbh->prepare($query);
        $sth->execute(array($email,$message,$name,FALSE));
        echo "<script> alert(\"Your comment is sent! We will take it into consideration!\")</script>";
        $dbh = null;    
    }
    
    function countnewcomments(){
        $dbh=Database::connect();
        $query= "SELECT `commentread`  FROM `comments`";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            if ($row['commentread']==0){
                $n = $n + 1;
            }
        }
        return $n;
        $dbh = null;    
    }
    
    function showComments(){
        $dbh=Database::connect();
        $query= "SELECT *  FROM `comments`";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $n=0;
        while($row = $sth->fetch(PDO::FETCH_ASSOC)){
            if ($n ==0){
                echo "<table style=\"width:100%\">";
                echo "<tr><td><b>Name: </b></td>";
                echo "<td><b>Message: </b></td>";
                echo "<td><b>Read: </b></td>";
                echo "<td><b>Delete: </b></td>";
                //echo "<td><b>Email: </b></td>";
                
            }
            if ($row['commentread']==0){
                echo "<tr bgcolor = \"#00FA9A\">";
            } else {echo "<tr>";}
            echo "<td>".$row['name']."</td>";
            echo "<td>".$row['message']."</td>";
            
            $id = $row['id'];
            if ($row['commentread']==0){
                echo "  <td><button type=\"submit\" name =\"readcomment\" id =\"readcomment\" value=\"".$id."\">&#10004;</button></td>";
            } else {
                echo "  <td> </td>";
            }
            
            echo "  <td><button type=\"submit\" name =\"deletecomment\" id =\"deletecomment\" value=\"".$id."\">&#10008;</button></td></tr>"; 
            //echo "<td>".$row['email']."</td>"; 
            $n=$n+1;
            echo "</tr>";
            
        }
        if ($n!=0){
            echo "</table>";
        }
        $dbh = null;  
    }
    function readcomment($id){
        $dbh=Database::connect();
        $query= "UPDATE `comments` SET `commentread`='1' WHERE  (`id`='$id')";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $dbh = null;    
    }
    
    function deletecomment($id){
        $dbh=Database::connect();
        $query= "DELETE FROM `comments` WHERE  (`id`='$id')";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $dbh = null;    
    }
    
?>