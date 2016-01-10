<div class="container-fluid">
    <header>
        <?php require_once('utilities/utils.php'); require_once("utilities/userfunctions.php");
        if(isset($_GET['altuser'])){
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
                    <h1 style="text-align:center">Rate <?php echo $altuser['name'] ?>'s Language Skills!</h1>
                    <?php
                        require_once("utilities/userfunctions.php");
                        $languageErr=$levelErr="Required";
                        $language=$ratelevel="";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["language"])) {
                              $languageErr = "Language is required";
                             }else{
                                  $language=$_POST['language'];
                                  $languageErr="";
                              }


                            if (empty($_POST["ratelevel"])) {
                              $levelErr = "Level is required";
                            } else {
                                $ratelevel=$_POST['ratelevel'];
                                $levelErr="";
                            }
                        }

                        if($languageErr==""&&$levelErr==""){
                            rateRequest($_SESSION["loggedIn"],$altuserlogin, $ratelevel, $language);
                            echo "You rated ".$altuser['name']."'s ".$_POST["language"]." with a level of ".$_POST["ratelevel"].". This awaits his/her approval.<br>";
                        }

                    ?>
                </div>
            </div>
        </div>
    </header>
    
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <?php 
                echo "<p><b>First Name: </b>".$altuser['name']."<br>";
                echo "<b>Last Name: </b>".$altuser['lastname']."<br>";
                echo "<b>Email: </b>".$altuser['email']."<br>";
                
                echo "<p class='text-left'><b>His/her languages:</b><br>";
                showLanguages($altuser['login'], false);
                echo "</p>";
                
                ?>

                <form action="index.php?page=rateuser&altuser=<?php echo $altuserlogin ?>" role="form" method="post">
                <div class="form-group">
                    <?php
                    echo "<b><label for=\"language\">".$altuser['name']." and you spoke in this language: </b></label><br>";
                    findsimilarlangues($_SESSION["loggedIn"],$altuserlogin);
                    ?>
                <div class="form-group">
                  <label for="ratelevel">Rate <?php echo $altuser['name']?>'s Level:</label>
                  <input type="number" name="ratelevel" class="form-control" id="ratelevel" min="1" max="100">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
                </div>
    
            
                
        </div>
    </div>    
    
</div>