<div class="container-fluid">
    <header>
        <div class="row">
            <div class="jumbotron">
                <div class="container">
                    <h1 style="text-align:center">Edit Profile</h1>
                    <style>
                         .error {color: #FF0000;}
                    </style>
                </div>
            </div>
        </div>
    </header>
    
    <body>
    <?php 
    require_once('utilities/loginregis.php'); 
    require_once('utilities/messaging.php'); 
    require_once('utilities/pagesetup.php'); 
    require_once("utilities/userfunctions.php")
    ;
        
    $user = Utilisateur::getUtilisateur($_SESSION["loggedIn"]);
    $login = $user['login'];
    $name = $user['name'];
    $lname = $user['lastname'];
    $email = $user['email'];
    $bdate = $user['birthdate'];
    
// define variables and set to empty values
    $loginErr = $nameErr = $lnameErr = $emailErr = $pwdErr = $cpwdErr = $opwdErr = $bdateErr = "";
    $opwd = $pwd = $cpwd = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }
  
  if (empty($_POST["lname"])) {
    $lnameErr = "Last Name is required";
  } else {
    $lname = test_input($_POST["lname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lnameErr = "Only letters and white space allowed"; 
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }

  if (!empty($_POST["pwd"])) { //New password entered
    $pwd = test_input($_POST["pwd"]);
  
    if (empty($_POST["cpwd"])) { // But confirm password empty
        $pwdErr = "New password confirmation is required";
    } else { //New password and confirm password entered
        $cpwd = test_input($_POST["cpwd"]);
        if ($pwd != $cpwd){
        $cpwdErr  = "New passwords don't match";}
    }
  } else { //New password empty
      if (!empty($_POST["cpwd"])){ //Confirm password not empty
         $cpwdErr = "New password is required";
      }
      // not important if both empty: no changing password
  }

  if (empty($_POST["bdate"])) {
    $bdateErr = "Birthdate is required";
  } else {
    $bdate = test_input($_POST["bdate"]);
  }
  
  if (empty($_POST["opwd"])){
      $opwdErr = "Old password required!";
  } else { //old password entered
    if (!Utilisateur::PasswordMatches($login,$_POST["opwd"])){ // but not correct
        $opwdErr = "Old password doesn't match!";
    } else { //old password is correct
        $opwd = $_POST["opwd"];
        if (empty($_POST["pwd"]) || empty($_POST["cpwd"])){
            $pwd=$opwd;
        }
    }
  }
  
  if($loginErr=="" &&$nameErr =="" && $lnameErr =="" && $emailErr =="" && $opwdErr =="" && $pwdErr =="" && $cpwdErr =="" && $bdateErr == ""){
      updating($login,$pwd);
      echo "<script type=\"text/javascript\">";
      echo "alert(\"Changes made!\");";
      echo "</script>";
  } else {
      echo "<script type=\"text/javascript\">";
      echo "alert(\"There's an error!\");";
      echo "</script>";      
  }
}

?>
        
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus"> 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?page=editprofile";?>" role="form" method="post">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" class="form-control" id="name" value="<?php echo $name;?>">
              <span class="error"><?php echo $nameErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="lname">Last Name:</label>
              <input type="text" name="lname" class="form-control" id="lname" value="<?php echo $lname;?>">
              <span class="error"><?php echo $lnameErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="email">Email address:</label>
              <input type="email" name="email" class="form-control" id="email" value="<?php echo $email;?>">
              <span class="error"><?php echo $emailErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="pwd">New Password:</label>
              <input type="password" name="pwd" class="form-control" id="pwd" value="">
              <span class="error"><?php echo $pwdErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="cpwd">Confirm New Password:</label>
              <input type="password" name="cpwd" class="form-control" id="cpwd" value="">
              <span class="error"><?php echo $cpwdErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="bdate">Birthdate:</label>
              <input type="date" name="bdate" class="form-control" id="bdate" value="<?php echo $bdate;?>">
              <span class="error"><?php echo $bdateErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="pwd">Enter old password to confirm:</label>
              <input type="password" name="opwd" class="form-control" id="opwd" value="">
              <span class="error"><?php echo $opwdErr;?></span>
   <br><br>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
    </div>
    </body>
</div>

