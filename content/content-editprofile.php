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
    require_once("utilities/userfunctions.php");
    $user = Utilisateur::getUtilisateur($_SESSION["loggedIn"]);
    $oldlogin = $user['login'];
    $name = $user['name'];
    $lname = $user['lastname'];
    $email = $user['email'];
    $bdate = $user['birthdate'];
// define variables and set to empty values
$loginErr = $nameErr = $lnameErr = $emailErr = $pwdErr = $cpwdErr = $opwdErr = $bdateErr = "";
$login=$oldlogin;
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

  if (!empty($_POST["pwd"])) {
    $pwd = test_input($_POST["pwd"]);
  
    if (empty($_POST["cpwd"])) {
        $pwdErr = "New password confirmation is required";
    } else {
        $cpwd = test_input($_POST["cpwd"]);
        if ($pwd != $cpwd){
        $cpwdErr  = "New passwords don't match";}
    }
  } else {
      if (!empty($_POST["cpwd"])){
         $cpwdErr = "New password is required";
      }
  }

    if (empty($_POST["bdate"])) {
    $bdateErr = "Birthdate is required";
  } 
  
  if(empty($_POST["login"])) {
      $loginErr= "Login is required";
  } else {
      $login=  test_input ($_POST["login"]);
      if($login != $oldlogin){
          if (Utilisateur::LoginExists($login)){
            $loginErr= "Login already exists. Please choose another login";
          }
      }
  }
  if (empty($_POST["opwd"])){
      $opwdErr = "Old password required!";
  } else {
    if (!Utilisateur::PasswordMatches($oldlogin,$_POST["opwd"])){
        echo $pwd;
        $opwdErr = "Old password doesn't match!";
    } else {
        $opwd = $_POST["opwd"];
        if (empty($_POST["pwd"]) && empty($_POST["cpwd"])){
            $pwd=$opwd;
        }
    }
  }
  
  if($loginErr=="" &&$nameErr =="" && $lnameErr =="" && $emailErr =="" && $opwdErr =="" && $pwdErr =="" && $cpwdErr =="" && $bdateErr == ""){
      updating($oldlogin);
  }
}


?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 aboutus"> 
            <p><span class="error">* required field.</span>  </p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?page=editprofile";?>" role="form" method="post">
            <div class="form-group">
              <label for="login">Login:</label>
              <input type="text" name="login" class="form-control" id="login" value="<?php echo $login;?>">
              <span class="error">* <?php echo $loginErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" class="form-control" id="name" value="<?php echo $name;?>">
              <span class="error">* <?php echo $nameErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="lname">Last Name:</label>
              <input type="text" name="lname" class="form-control" id="lname" value="<?php echo $lname;?>">
              <span class="error">* <?php echo $lnameErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="email">Email address:</label>
              <input type="email" name="email" class="form-control" id="email" value="<?php echo $email;?>">
              <span class="error">* <?php echo $emailErr;?></span>
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
              <span class="error">* <?php echo $bdateErr;?></span>
   <br><br>
            </div>
            <div class="form-group">
              <label for="pwd">Enter old password to confirm:</label>
              <input type="password" name="opwd" class="form-control" id="opwd" value="">
              <span class="error">* <?php echo $opwdErr;?></span>
   <br><br>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>
    </div>
    </body>
</div>

