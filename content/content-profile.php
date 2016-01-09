<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Your Profile</h1>
                </div>
            </div>
        </div>
    </header>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <?php require_once("utilities/userfunctions.php");
                $user = Utilisateur::getUtilisateur($_SESSION["loggedIn"]);
                echo "<p><b>First Name: </b>".$user['name']."<br>";
                echo "<b>Last Name: </b>".$user['lastname']."<br>";
                echo "<b>Login: </b>".$user['login']."<br>";
                echo "<b>Email: </b>".$user['email']."<br>";
                echo "<b>Birthdate: </b>".$user['birthdate']."<br></p>";
                //to do: ADD OPTION TO EDIT THIS INFO
                
                echo "<p class='text-left'><b>Your languages:</b><br>";
                showLanguages($_SESSION["loggedIn"], true);
                echo "</p>";
            ?>
            <p><a href="?page=languages"> Manage your spoken languages </a></p>
                
        </div>
    </div>    
    
</div>