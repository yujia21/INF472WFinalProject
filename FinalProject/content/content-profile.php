<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Profile</h1>
                    <p class="text-left">Your languages:</p><br>
                                
                 <?php
                 require_once("utilities/userfunctions.php");
                    showLanguages($_SESSION["loggedIn"]);
                    ?>
                </div>
            </div>
        </div>
    </header>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus">                         
            <h1>blabla</h1><br>

            <p><a href="?page=languages"> Manage your spoken languages </a></p>
                
        </div>
    </div>    
    
</div>