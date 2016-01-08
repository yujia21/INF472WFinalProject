<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Start a Conversation</h1>
                    
                </div>
            </div>
        </div>
    </header>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <p class="text-center"><h3>Your Language Abilities: </h3></p>
            <p>
                <?php require_once("utilities/userfunctions.php");
                    showLanguages($_SESSION["loggedIn"]);
                ?>
            </p>
            <p class="text-center"><h3>Here are some people you can speak with: </h3></p>
            <p>
                <?php
                    usersalllangue($_SESSION["loggedIn"]);
                ?>
            </p>

        </div>
    </div>    
    
</div>

<?php
$other_email = "odonut@gmail.com";
?>