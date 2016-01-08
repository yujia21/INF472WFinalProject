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
                
                //rating system
                echo "<b>".$altuser['name']." and you spoke in this language: </b><br>";
                findsimilarlangues($_SESSION["loggedIn"],$altuserlogin);
                ?>

                <form action="index.php?page=languages" role="form" method="post">
                <div class="form-group">
                <div class="form-group">
                  <label for="level">Rate <?php echo $altuser['name']?>'s Level:</label>
                  <input type="number" name="level" class="form-control" id="level" min="1" max="100" value="<?php echo $level;?>">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
                </div>
    
            
                
        </div>
    </div>    
    
</div>