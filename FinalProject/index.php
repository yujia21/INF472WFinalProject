<?php
    session_name("newuser" );
    session_start();
    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id();
        $_SESSION['initiated'] = true;
    }
require_once("utilities/userfunctions.php");
?>
<!DOCTYPE html>
<html>
    <head>
      <?php require_once('utilities/utils.php');
      if(isset($_GET['page'])){$askedPage=$_GET['page'];}
      else {$askedPage="welcome";}
      
      $authorized=checkPage($askedPage);
      if ($authorized){$pageTitle = getPageTitle($askedPage);}
      else {$pageTitle="Error";}
      
      $members = checkMember($askedPage);
      
      generateHTMLHeader($pageTitle,"css/perso.css");
      ?>
    </head>
    
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <?php require_once('utilities/utils.php');
            generateMenu();
            $members = checkMember($askedPage);
            ?>
        </nav>
        
        <div id="content">
            <?php require_once('utilities/utils.php'); 
            if ($authorized && $members){require ("content/content-$askedPage.php");}
            else {
                echo <<<FIN
                <div class="row jumbotron container">
                    <h1 style="text-align:center">ERREUR</h1>
                    <p class="text-center">Désolé, la page demandée n'existe pas ou n'est accessible qu'aux membres ! </p>
                </div>
FIN;
                }
            ?>
        </div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.js"></script>
    </body>
    <?php require_once('utilities/utils.php');
    generateHTMLFooter();
    ?>
</html>