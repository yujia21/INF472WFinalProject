<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">

                    <?php 
                        require_once('utilities/loginregis.php'); 
                        require_once('utilities/messaging.php'); 
                        require_once('utilities/pagesetup.php'); 
                        require_once("utilities/userfunctions.php")
                        ;
                        
                        //to show number of new notifications
                        $login=$_SESSION["loggedIn"];
                        $n_messages = countnewmessages($login);
                        $n_requests = countrequests($login);

                        echo "<h1 style=\"text-align:center\">Messages (".$n_messages.") and Requests (".$n_requests.")</h1>";
                        
                        $validErr="Required";
                        $validrequest="";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (!empty($_POST["validrequest"])){
                                 $validrequest = $_POST["validrequest"];
                                 $login1 = $_POST["login1"];
                                 $login2 = $_POST["login2"];
                                 $ratedlevel = $_POST["ratedlevel"];
                                 $language = $_POST["language"];
                                 if ($validrequest=="Accept"){
                                    rateLanguage($login2,$ratedlevel,$language);
                                    deleterateRequest($login1,$login2,$ratedlevel,$language);
                                    echo "<script>alert(\"You have accepted ".$login1."'s rating of ".$ratedlevel." for your ".$language." ability.\")</script>";
                                    $validrequest=$login1=$login2=$ratedlevel=$language="";
                                    $n_requests = countrequests($login);
                                 } elseif ($validrequest=="Reject"){
                                    deleterateRequest($login1,$login2,$ratedlevel,$language);
                                    echo "<script>alert(\"You have rejected ".$login1."'s rating of your ".$language." ability.\")</script>";
                                    $validrequest=$login1=$login2=$ratedlevel=$language="";
                                    $n_requests = countrequests($login);
                                 }
                           }
                           if (!empty($_POST["deletecomment"])){
                               $id = $_POST["deletecomment"];
                               deletecomment($id);
                               echo "<script>alert(\"You have deleted a comment.\")</script>";
                           }
                           if (!empty($_POST["readcomment"])){
                               $id = $_POST["readcomment"];
                               readcomment($id);
                               echo "<script>alert(\"You have maked a comment as read.\")</script>";
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
    </div><br>
    
    
    <?php 
    //Show comments if admin
    if (checkadmin($login)){ ?>
    <div class="row">
        <div class="jumbotron">
            <div class="container">
                <?php
                    $n_comments=countnewcomments();
                    echo "<h1 style=\"text-align:center\">Comments (".$n_comments." new)</h1>";
                ?>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus"> 
            <form action="index.php?page=notifications" role="form" method="post">
            <?php require_once("utilities/userfunctions.php");
                showComments();
            ?>
            </form>
        </div>
    </div>
    <?php } ?>
</div>