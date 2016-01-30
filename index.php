<?php 
    require_once('utilities/loginregis.php'); 
    require_once('utilities/messaging.php'); 
    require_once('utilities/pagesetup.php'); 
    require_once("utilities/userfunctions.php")
    ;
    session_name("newuser" );
    session_start();
    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id();
        $_SESSION['initiated'] = true;
    }

?>
<!DOCTYPE html>
<html>
    <head>
      <?php
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
            <?php 
            generateMenu();
            $members = checkMember($askedPage);
            ?>
        </nav>
        
        <div id="content">
            <?php 
            if ($authorized && $members){require ("content/content-$askedPage.php");}
            else {
                echo <<<FIN
                <div class="row jumbotron container">
                    <h1 style="text-align:center">ERROR</h1>
                    <p class="text-center">Sorry, this page is only for members ! </p>
                </div>
FIN;
                }
            ?>
        </div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.js"></script>

<script type="text/javascript">
// create the back to top button
$('body').prepend('<a href="#" class="back-to-top">Back to Top</a>');

var amountScrolled = 300;

$(window).scroll(function() {
	if ( $(window).scrollTop() > amountScrolled ) {
		$('a.back-to-top').fadeIn('slow');
	} else {
		$('a.back-to-top').fadeOut('slow');
	}
});

$('a.back-to-top, a.simple-back-to-top').click(function() {
	$('html, body').animate({
		scrollTop: 0
	}, 700);
	return false;
});
</script>

    </body>
    <?php 
    generateHTMLFooter();
    ?>
</html>