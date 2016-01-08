<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Start a Conversation</h1>
                    <p>
                    <?php require_once("utilities/userfunctions.php");
                            showLanguages($_SESSION["loggedIn"]);
                            ?></p>
                    <p class="text-center">Here are some people you can speak with: </p>
                    <p>
                        <?php require_once("utilities/userfunctions.php");
                            usersalllangue($_SESSION["loggedIn"]);
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </header>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <h1>blabla</h1><br>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <g:hangout render="createhangout"
                invites="[{ id : <?php $other_email?>, invite_type : 'EMAIL' }]">
            </g:hangout>
        </div>
    </div>    
    
</div>

<?php
$other_email = "odonut@gmail.com";
?>