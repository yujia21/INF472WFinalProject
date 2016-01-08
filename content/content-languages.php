<div class="container-fluid">
    <header>
        
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Languages</h1>
                    <p class="text-center">Here you can manage your languages</p>
                </div>
            </div>
        </div>
        <style>
             .error {color: #FF0000;}
        </style>
    </header>
</div>


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
                echo "Operation Successful!<br>";
            }
            ?>
            <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus"> 
            <p><span class="error">* required field.</span></p>
            <form action="index.php?page=languages" role="form" method="post">
            <div class="form-group">
              <label for="language">Language:</label>
              <?php languageForm(); ?><br>
              <span class="error">* <?php echo $languageErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
                
              
              <label for="level">Level:</label>
              <input type="range" data-popup-enabled="true" name="level" class="form-control" id="level" value="<?php echo $level;?>" min="1" max="100">
              
                
              <label for="level">Level:</label>
              <input type="number" name="level" class="form-control" id="level" min="1" max="100" value="<?php echo $level;?>">
              <span class="error">* <?php echo $levelErr;?></span>
   <br><br>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
            </div>
                
          </form>
        </div>
      </div>
