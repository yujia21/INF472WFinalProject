<div class="container-fluid">
    <header>
        <script type="text/javascript">
            //functions for updating rating level sliders
        function updateTextInput(val) {
          document.getElementById('textlevel').value=val; 
        }
        function updateSliderInput(val) {
          document.getElementById('level').value=val; 
        }
        </script>
        
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Languages</h1>
                    <p class="text-center">Here you can manage your languages</p>
                    
                    <?php 
                        require_once('utilities/loginregis.php'); 
                        require_once('utilities/messaging.php'); 
                        require_once('utilities/pagesetup.php'); 
                        require_once("utilities/userfunctions.php")
                        ;
                        $login=$_SESSION["loggedIn"];
                        $languageErr=$levelErr=" ";
                        $language=$level=$deletelanguage="";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["deletelanguage"])) { //submitted instead of delete
                                if (empty($_POST["language"])) {
                                  $languageErr = "Language is required";
                                } else{
                                      $language=$_POST['language'];
                                      $languageErr="";
                                }

                                if (empty($_POST["textlevel"])) {
                                  $levelErr = "Level is required";
                                } else {
                                    $level=$_POST['level'];
                                    $levelErr="";
                                }
                            

                                if($languageErr==""&&$levelErr==""){
                                    if (languageExists($_SESSION["loggedIn"], $language)){
                                        updateLanguage($_SESSION["loggedIn"], $level, $language);
                                    }else{
                                        addLanguage($_SESSION["loggedIn"], $level, $language);
                                    }
                                    echo "<script> alert(\"You have updated your ".$language." level to be ".$level."!\")</script>";
                                } else {
                                    echo "<script> alert(\"There's an error!\")</script>";
                                }


                            } else {
                                if (empty($_POST["language"])) {
                                    $languageErr = "Language is required";
                                  } else{
                                        $language=$_POST['language'];
                                        $languageErr="";
                                  }
                               if($languageErr==""){
                                  deleteLanguage($login, $language);
                                  echo "<script> alert(\"".$language." was deleted!\")</script>";
                               }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <style>
             .error {color: #FF0000;}
        </style>
    </header>
</div>



<div class="row">
    <div class="col-md-8 col-md-offset-2 aboutus"> 
        <form action="index.php?page=languages" role="form" method="post">
            <div class="form-group">
                <center><label for="language">Language:</label>  <span class="error"><?php echo $languageErr;?></span><br>
                <?php languageForm(); ?><br></center>
                <br>
            </div>
            <div class="form-group">
                <center><label for="level">Level (0 to 100): </label>  <span class="error"><?php echo $levelErr;?></span>
                <input type="number" name="textlevel" class="form-control" id="textlevel" min="1" max="100" value="" onchange="updateSliderInput(this.value);">
                </center>
                <input type="range" data-popup-enabled="true" name="level" class="form-control" id="level" value="" min="1" max="100"  onchange="updateTextInput(this.value);">
                <br>
            </div>
            <center>
            <button type="submit" class="btn btn-default">Submit</button>
            <button type="submit" class="btn btn-default" name ="deletelanguage" id ="deletelanguage" value="Delete">Delete Language</button> <br><br>
            </center>
        </form>
    </div>
    <div class="col-md-8 col-md-offset-2 aboutus">
        <?php showLanguages($_SESSION["loggedIn"], true); ?>
    </div>
</div>
