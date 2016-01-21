<?php
require_once("utilities/userfunctions.php");

function generateHTMLHeader($titre,$CSS){
    echo <<<FINHEADER
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>$titre</title>

    <!-- CSS Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- CSS Perso -->
    <link href=$CSS rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
FINHEADER;
}

function generateHTMLFooter(){
    echo <<<FINFOOTER
    <blockquote>&copy; 2015 : Renan Fernandes Moreira et Cheong Yu Jia </blockquote>
FINFOOTER;
}


function checkPage($askedPage){
    $pages = simplexml_load_file("xml/pages.xml");
    $page_list = $pages->page;
    foreach($page_list as $page){
        if ($askedPage==$page->name){return true;}
    }
    return false;
}

function checkMember($askedPage){
    $pages = simplexml_load_file("xml/pages.xml");
    $page_list = $pages->page;
    foreach($page_list as $page){
        if ($askedPage==$page->name){
             if($page->member=="true"){ // if private page
                 if (isset($_SESSION["loggedIn"])){return true;} else {return false;}
             } else {return true;}
        
        }
    }
    return false;
}
        
function getPageTitle($pagename){
    $pages = simplexml_load_file("xml/pages.xml");
    $page_list = $pages->page;
  
    foreach($page_list as $page){
        if ($pagename==$page->name){return $page->title;}
    }
}

function generateMenu(){
    $pages = simplexml_load_file("xml/pages.xml");
    $page_list = $pages->page;

echo <<<FINMENU
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">POLYGLOT</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
FINMENU;
foreach($page_list as $page){
    if ($page->showmenu=="true" & $page->member!="true"){
        global $askedPage;
        if ($askedPage==$page->name){
            echo "<li class=\"active\"><a href=\"/INF472WFinalProject/index.php?page=$page->name\">$page->menutitle</a></li>";
        }
        else {echo "<li><a href=\"/INF472WFinalProject/index.php?page=$page->name\">$page->menutitle</a></li>";}
    }
}

// define variables and set to empty values
$loginErr = $pwdErr = "";
$login = $pwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


 if(!empty($_POST["logout"])){
     session_unset();
 } else {
  if (empty($_POST["pwd"])) {
    $pwdErr = "Password is required";
  } else {
    $pwd = $_POST["pwd"];
  }
  
  
  if(empty($_POST["login"])) {
      $loginErr= "Login is required";
  } else {
      $login= $_POST["login"];
      $aux= Utilisateur::PasswordMatches($login,$pwd); 
      if($aux==2){ // AUX IS CORRECT, but doesn't pop up?
          $loginErr= "Login doesn't exist.";
      } else {
          if($aux==0){
              
              $pwdErr="Password incorrect";
          }               
      }
      
      //REMEMBER ME  - not sure if works always?
      if (isset($_POST['remember'])) {
          if ($_POST['remember']){
            $year = time() + 31536000;
            setcookie('remember_me', $login, $year);
          } else{
                if(isset($_COOKIE['remember_me'])) {
                    $past = time() - 100;
                    setcookie('remember_me', "", $past);
                }
          }
      }
      else{
	if(isset($_COOKIE['remember_me'])) {
            $past = time() - 100;
            setcookie('remember_me', "", $past);
	}
}
  }
  
  if($loginErr=="" && $pwdErr ==""){
      $_SESSION["loggedIn"]=$login;
      //$url="?todo=$login&page=$askedPage";
      //header("Location: $url");
  }
 }
}


if(!isset($_SESSION["loggedIn"])){
echo <<<notIn
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true">Log In<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <form class="form-signin" action="?page=profile" method="post">
notIn;
if (isset($_COOKIE['remember_me'])){
                        echo "<p><input type=\"text\" class=\"form-control\" placeholder=\"Login\" name=\"login\" id=\"login\" value = \"".$_COOKIE['remember_me']."\" required autofocus></p>";
} else {
                       echo "<p><input type=\"text\" class=\"form-control\" placeholder=\"Login\" name=\"login\" id=\"login\" required autofocus></p>";
}
echo <<<notIn
                        <span class="error"><?php echo .$loginErr.;?></span>
                        <p><input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd" required></p>
                        <span class="error"><?php echo .$pwdErr.;?></span>
notIn;
if (isset($_COOKIE['remember_me'])){
                        echo "<p><input type=\"checkbox\" name=\"remember\" value=\"1\" checked=\"checked\"/>Remember me</p>";
}
else {
                        echo "<p><input type=\"checkbox\" name=\"remember\" value=\"1\"/>Remember me</p>";
}
echo <<<notIn
                        <p><button type="submit" class="btn btn-default" />Submit</p>
                        </form>                 
                </ul>
                </li>
                <li><a href="/INF472WFinalProject/index.php?page=regis">Register Now! </a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
notIn;
   } else{
       $aux=$_SESSION['loggedIn'];
$n_messages = countnewmessages($aux);
$n_requests = countrequests($aux);
$n = $n_messages+$n_requests;
foreach($page_list as $page){
    if ($page->showmenu=="true" & $page->member=="true"){
        if ($page->name=="notifications"){
            global $askedPage;
            if ($askedPage==$page->name){
                echo "<li class=\"active\"><a href=\"/INF472WFinalProject/index.php?page=$page->name\">$page->menutitle ($n)</a></li>";
            }
            else {echo "<li><a href=\"/INF472WFinalProject/index.php?page=$page->name\">$page->menutitle ($n)</a></li>";}
            }
            
        else {
            global $askedPage;
            if ($askedPage==$page->name){
                echo "<li class=\"active\"><a href=\"/INF472WFinalProject/index.php?page=$page->name\">$page->menutitle</a></li>";
            }
            else {echo "<li><a href=\"/INF472WFinalProject/index.php?page=$page->name\">$page->menutitle</a></li>";}
            }
        }
    }
echo <<<IN
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true">Logged In<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <form class="form-signin" action="?page=welcome" method="post">
                        <p>Hi   $aux  </p>
                        <input type="hidden" name="logout" id="logout" value="logout">
                        <p><button type="submit" class="btn btn-default" />Log out</p>
                        </form>                 
                </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
IN;
   }
}

?>