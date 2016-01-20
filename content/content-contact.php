<div class="container-fluid">
    <header>
        <?php require_once("utilities/userfunctions.php");
        if (ISSET($_SESSION["loggedIn"])){
            $user = Utilisateur::getUtilisateur($_SESSION["loggedIn"]);
        }
        ?>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Contact Us</h1>
                </div>
            </div>
        </div>
    </header>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <h1>Have a problem?</h1><br>
            <?php 
            if (empty($_POST["action"])) {
                ?> 
                <form  action="" method="POST" enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="submit"> 
                Your name:<br> 
                <input name="name" type="text" value="<?php if (ISSET($_SESSION["loggedIn"])){echo $user['name']." ".$user['lastname'];} ?>" size="30"/><br> 
                Your email:<br> 
                <input name="email" type="text" value="<?php if (ISSET($_SESSION["loggedIn"])){echo  $user['email'];} ?>" size="30"/><br> 
                Your message:<br> 
                <textarea name="message" rows="7" cols="30"></textarea><br> 
                <input type="submit" value="Send email"/> 
                </form> 
                <?php 
            }  
            else                /* send the submitted data */ 
                { 
                $name=$_POST['name']; 
                $email=$_POST['email']; 
                $message=$_POST['message']; 
                if (($name=="")||($email=="")||($message=="")) 
                    { 
                    echo "All fields are required, please fill <a href=\"\">the form</a> again."; 
                    } 
                else{         
                    $from="From: $name<$email>\r\nReturn-path: $email"; 
                    $subject="Message sent using your contact form"; 
                    mail("yu-jia.cheong@polytechnique.edu", $subject, $message, $from); 
                    //write mail function
                    echo "Email sent!"; 
                    } 
                }   
            ?> 
        </div>
    </div>
</div>