<?php 
    require_once('utilities/loginregis.php'); 
    require_once('utilities/messaging.php'); 
    require_once('utilities/pagesetup.php'); 
    require_once("utilities/userfunctions.php");
    
    //Check if convo is updated
    if(isset($_POST['login1']) && isset($_POST['login2'])) {
        echo $login1;
        echo $login2;
        if(updateconversation($login1,$login2)){echo 1;}
    }
    
?>