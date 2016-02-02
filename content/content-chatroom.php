<div class="container-fluid">
    <header>
        <?php 
        require_once('utilities/loginregis.php'); 
        require_once('utilities/messaging.php'); 
        require_once('utilities/pagesetup.php'); 
        require_once("utilities/userfunctions.php")
        ;
        
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
                                  $message=test_input($_POST['message']);
                                  $messageErr="";
                              }
                        }

                        if($messageErr==""){
                            sendmessage($login,$altuserlogin,$message);
                        }

                echo <<<START
                                </div>
                    </div>
                </div>
            </header>
START
            ;} else { //NOT AUTHORIZED
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
        else { //altuser not set
            $authorized=false;
            echo <<<START
                <div class="row">
                    <div class="jumbotron">
                        <div class="container">
                            <h1 style=\"text-align:center\">Error! </h1>;
                        </div>
                    </div>
                </div>
START;
        }
        ?>

<script type="text/javascript">
    //refreshes every minute
    setInterval('window.location.reload()', 60*1000);
</script>

        <script>
            function chatupdate(){
                //trying to get it to refresh only when there are new messages but doesn't work
                $.post("utilities/updatechatroom.php", {login1: <?php $login ?>, login2: <?php $altuserlogin ?>}, function(response)){
                    if(response==1){
                        window.location.reload();
                    }
                }
            }
        </script>
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus" >     
            <?php 
            if ($authorized){
                echo <<<START
                <script>
                $(document).ready(function() {
                    setInterval(function(){
                        chatupdate();
                    },10000);
                }
                </script>
START;
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
            
START;
            echo "<div><a href='index.php?page=rateuser&altuser=$altuserlogin'>Rate ".$altuser['name']."'s language skills</a></div><br>";
            } else {
                echo "<h2>Sorry! This is a bad link!</h2>";
            }
            ?>
        </div>
    </div>    
    
</div>