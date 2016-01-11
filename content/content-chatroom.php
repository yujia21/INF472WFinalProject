<div class="container-fluid">
    <header>
        <?php require_once('utilities/utils.php'); require_once("utilities/userfunctions.php");
        if(isset($_GET['altuser'])){
            $login=$_SESSION["loggedIn"];
            $altuserlogin=$_GET['altuser']; //securize this
            $altuser = Utilisateur::getUtilisateur($altuserlogin);
        }
        else {
            $altuserlogin=$_SESSION["loggedIn"];}
            $altuser = Utilisateur::getUtilisateur($altuserlogin);
        ?>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Chat with <?php echo $altuser['name'] ?>!</h1>
                    <?php
                        require_once("utilities/userfunctions.php");
                        $messageErr="Required";
                        $message="";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["message"])) {
                              $messageErr = "Message is required!";
                             }else{
                                  $message=$_POST['message'];
                                  $messageErr="";
                              }
                        }

                        if($messageErr==""){
                            sendmessage($login,$altuserlogin,$message);
                        }

                    ?>
                </div>
            </div>
        </div>
    </header>
    
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <form action="index.php?page=chatroom&altuser=<?php echo $altuserlogin ?>" role="form" method="post">
            <div class="form-group">
            <div class="form-group">
              <label for="message">Your Message</label>
              <input type="text" name="message" class="form-control" id="message">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
            </div>
                
            <?php 
                showconversation($login,$altuserlogin);
            ?>
        </div>
    </div>    
    
</div>