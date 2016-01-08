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
                    <h1 style="text-align:center">User Profile Of <?php echo $altuser['name'] ?></h1>
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
                showLanguages($altuser['login']);
                echo "</p>";
            ?>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <g:hangout render="createhangout"
                invites="[{ id : <?php $altuser['email']?>, invite_type : 'EMAIL' }]">
            </g:hangout>
            <p>
            <?php 
                echo "<a href='index.php?page=rateuser&altuser=$altuserlogin'>Rate ".$altuser['name']."s language skills!'</a>";
            ?>
            </p>
        </div>
    </div>    
    
</div>