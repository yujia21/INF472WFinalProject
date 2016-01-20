<div class="container-fluid">
    <header>
        <?php require_once('utilities/utils.php'); require_once("utilities/userfunctions.php");
        if(isset($_GET['altuser'])){
            $altuserlogin=$_GET['altuser']; 
            $authorized = Utilisateur::LoginExists($altuserlogin);
            if ($authorized){
                $altuser = Utilisateur::getUtilisateur($altuserlogin);
                $name = $altuser['name'];
            
                echo <<<START
                <div class="row">
                    <div class="jumbotron">
                        <div class="container">
                            <h1 style=\"text-align:center\">User Profile Of $name</h1>;
                        </div>
                    </div>
                </div>
START
            ;} else {
                echo <<<START
                <div class="row">
                    <div class="jumbotron">
                        <div class="container">
                            <h1 style=\"text-align:center\">$altuserlogin ?!</h1>;
                        </div>
                    </div>
                </div>
START
            ;}
        ;}
        else {
            $authorized = false;
            echo <<<START
                <div class="row">
                    <div class="jumbotron">
                        <div class="container">
                            <h1 style=\"text-align:center\">Error !</h1>;
                        </div>
                    </div>
                </div>
START
        ;}
        ?>

    </header>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <?php 
            if ($authorized) {
                echo "<p><b>First Name: </b>".$altuser['name']."<br>";
                echo "<b>Last Name: </b>".$altuser['lastname']."<br>";
                
                echo "<p class='text-left'><b>His/her languages:</b><br>";
                showLanguages($altuser['login'],false);
                echo "</p>";

                echo "<a href='index.php?page=chatroom&altuser=$altuserlogin'>Chat with ".$altuser['name']."<br></a>";
                echo "<a href='index.php?page=rateuser&altuser=$altuserlogin'>Rate ".$altuser['name']."'s language skills</a>";
            } else {
                echo "<h2>Sorry, this user does not exist! </h2>";
            }
            ?>
            </p>
        </div>
    </div>    
    
</div>