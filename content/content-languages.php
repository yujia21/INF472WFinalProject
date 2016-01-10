<div class="container-fluid">
    <header>
        <script type="text/javascript">
        function updateTextInput(val) {
          document.getElementById('textInput').value=val; 
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
                        require_once("utilities/userfunctions.php");
                        $languageErr=$levelErr="Required";
                        $language=$level="";
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (empty($_POST["language"])) {
                              $languageErr = "Language is required";
                             }else{
                                  $language=$_POST['language'];
                                  $languageErr="";
                              }


                            if (empty($_POST["level"])) {
                              $levelErr = "Level is required";
                            } else {
                                $level=$_POST['level'];
                                $levelErr="";
                              /*if ($level<1 || $level>100) {
                                $levelErr = "Level must be a value between 1 and 100"; 
                              }*/
                            }
                        }

                        if($languageErr==""&&$levelErr==""){
                            if (languageExists($_SESSION["loggedIn"], $language)){
                                updateLanguage($_SESSION["loggedIn"], $level, $language);
                            }else{
                                addLanguage($_SESSION["loggedIn"], $level, $language);
                            }
                            echo "You have updated your ".$language." level to be ".$level."! <br>";
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
                <center><label for="language">Language:</label><br>
              <?php languageForm(); ?><br></center>
              <span class="error"><?php echo $languageErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
                
              
                <center><label for="level">Level:</label>
                    <!--updateSlider doesn't work-->
              <input type="text" id="textInput" value="" onchange="updateSliderInput(this.value);"></center>
              <input type="range" data-popup-enabled="true" name="level" class="form-control" id="level" value="" min="1" max="100"  onchange="updateTextInput(this.value);">
              

              <span class="error"><?php echo $levelErr;?></span>
   <br><br>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
            </div>
                
          </form>
        </div>
      </div>
