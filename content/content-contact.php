<div class="container-fluid">
    <header>
        <?php 
        require_once('utilities/loginregis.php'); 
        require_once('utilities/messaging.php'); 
        require_once('utilities/pagesetup.php'); 
        require_once("utilities/userfunctions.php")
        ;
        
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
        <style>
            .error {color: #FF0000;}
        </style>
    </header>
    <?php 
    $nameErr=$emailErr=$messageErr="";
    $name=$message=$email="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name=test_input($_POST["name"]);
        }
        if (empty($_POST["message"])) {
            $messageErr = "Message is required";
        } else {
            $message=test_input($_POST["message"]);
        }
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email=test_input($_POST["email"]);
        }
        if ($nameErr=="" && $emailErr == "" && $messageErr == ""){
            contactform($message, $name, $email); 
        } else {
            echo "<script>alert(\"There is an error!\");</script>";
        }
    }
    ?> 
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <h1>Have a problem?</h1><br>
            <form  action="index.php?page=contact" method="POST" role="form"> 
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?php if (ISSET($_SESSION["loggedIn"])){echo $user['name']." ".$user['lastname'];} ?>">
                    <span class="error"><?php echo $nameErr;?></span>
                    <br>
                </div>
                <div class="form-group">
                    <label for="name">Email:</label>
                    <input type="text" name="email" class="form-control" id="email" value="<?php if (ISSET($_SESSION["loggedIn"])){echo  $user['email'];} ?>">
                    <span class="error"><?php echo $emailErr;?></span>
                    <br>
                </div>
                <div class="form-group">
                    <label for="name">Message:</label>
                    <input type="text" name="message" rows ="7" cols ="30" class="form-control" id="message">
                    <span class="error"><?php echo $messageErr;?></span>
                    <br>
                </div>
                <button type="submit" class="btn btn-default">Submit</button><br><br>
            </form> 
        </div>
    </div>
</div>