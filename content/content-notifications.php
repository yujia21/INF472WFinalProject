<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">

                    <?php
                        require_once("utilities/userfunctions.php");
                        $login=$_SESSION["loggedIn"];
                        $n_messages = countnewmessages($login);
                        $n_requests = countrequests($login);
                        
                        echo "<h1 style=\"text-align:center\">Messages (".$n_messages.") and Requests (".$n_requests.")</h1>";

                        $validErr="Required";
                        $validrequest="";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["validrequest"]) | empty($_POST["login1"]) | empty($_POST["login2"]) | empty($_POST["ratedlevel"]) | empty($_POST["language"])){
                                $validErr = "Validation is required";
                             }
                             else {
                                 $validrequest = $_POST["validrequest"];
                                 $login1 = $_POST["login1"];
                                 $login2 = $_POST["login2"];
                                 $ratedlevel = $_POST["ratedlevel"];
                                 $language = $_POST["language"];
                                 if ($validrequest=="Accept"){
                                    rateLanguage($login2,$ratedlevel,$language);
                                    deleterateRequest($login1,$login2,$ratedlevel,$language);
                                    echo "You have accepted $login1's rating of $ratedlevel for your $language ability.<br>";
                                    $validrequest=$login1=$login2=$ratedlevel=$language="";
                                 } elseif ($validrequest=="Reject"){
                                    deleterateRequest($login1,$login2,$ratedlevel,$language);
                                    echo "You have rejected $login1's rating of $ratedlevel for your $language ability.<br>";
                                    $validrequest=$login1=$login2=$ratedlevel=$language="";
                                 }
                             }
                        }

                    ?>
                </div>
            </div>
        </div>
    </header>
    
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <?php 
            echo "<h2><b>Ratings (".$n_requests." new)</b></h2>";
            ?>
            <form action="index.php?page=notifications" role="form" method="post">
            <?php require_once("utilities/userfunctions.php");
                showrateRequests($login);
            ?>
            </form>
            <?php 
            echo "<h2><b>Messages (".$n_messages." new)</b></h2>";
            showmessages($login); 
            ?>
        </div>
    </div>    
    
</div>