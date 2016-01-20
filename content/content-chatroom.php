<div class="container-fluid">
    <header>
        <?php require_once('utilities/utils.php'); require_once("utilities/userfunctions.php");
        if(isset($_GET['altuser'])){
            $login=$_SESSION["loggedIn"];
            $altuserlogin=$_GET['altuser']; //securize this
            $authorized = Utilisateur::LoginExists($altuserlogin);
            if ($authorized){
                $altuser = Utilisateur::getUtilisateur($altuserlogin);
                $name = $altuser['name'];
        echo "<div class=\"row\">";
            echo "<div class=\"jumbotron\">";
                echo "<div class=\"container\">";
                    echo "<h1 style=\"text-align:center\">Chat with $name !</h1>";

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

                    
                echo <<<START
                        </div>;
            </div>
        </div>
    </header>
START
    ;} else {
            $authorized=false;
            echo <<<START
                <div class="row">
                    <div class="jumbotron">
                        <div class="container">
START
            ;
                            echo "<h1 style=\"text-align:center\">Error! ".$_GET['altuser']." does not exist! </h1>";
            echo <<<START
                        </div>
                    </div>
                </div>
START
        ;}
    }
        else {
            $authorized=false;
            echo <<<START
                <div class="row">
                    <div class="jumbotron">
                        <div class="container">
                            <h1 style=\"text-align:center\">Error! </h1>;
                        </div>
                    </div>
                </div>
START
        ;}
        ?>
    
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">     
            <?php 
            if ($authorized){
                showconversation($login,$altuserlogin);
            
            echo "<form action=\"index.php?page=chatroom&altuser=$altuserlogin\" role=\"form\" method=\"post\">";
            echo <<<START
            <div class="form-group">
            <div class="form-group">
              <label for="message">Your Message</label>
              <input type="text" name="message" class="form-control" id="message">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
            </div>
START
            ;} else {
                echo "<h2>Sorry! This is a bad link!</h2>";
            }
            ?>
        </div>
    </div>    
    
</div>