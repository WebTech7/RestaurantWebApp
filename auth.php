<?php  ob_start(); session_start();
$servername = "mysql.hostinger.nl";
$username = "u831903280_web7";
$password = "webtech7";
$db = "u831903280_rest";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once("functions.php");
$everyThingRight = false;
$alertMessage = "";
$formAlreadySent = false;
$formSentWell = false;

if(isset($_GET["link"])){
    $link = makeInputSafe($_GET["link"]);
    $sql = "SELECT * FROM `$db`.`accounts`";
    $res = $conn->query($sql);
    $hasBeen = false;
    $hasBeenVerificated = false;
    while($row = $res->fetch_object()){
        if($row->verification_link == $link){
            if($row->verified == 1){
                $hasBeenVerificated = true;
            } else if($row->verified == 0){
                $everyThingRight = true;
            }
        }
    }
    if($everyThingRight){
        if(isset($_POST["submit-auth"])){
            $formAlreadySent = true;
            $somethingWrong = false;
            $firstName = makeInputSafe($_POST["first-name-auth"]);
            $lastName = makeInputSafe($_POST["last-name-auth"]);
            $username = makeInputSafe($_POST["username-auth"]);
            $pass = makeInputSafe($_POST["pass-auth"]);
            $repass = makeInputSafe($_POST["re-pass-auth"]);
            if(strlen($firstName) == 0){
                $alertMessage .= "Please, fill in a first name.<br />";
                $somethingWrong = true;
            }
            if(strlen($firstName) > 50){
                $alertMessage .= "A first name may not be longer than 50 characters.<br />";
                $somethingWrong = true;
            }
            if(strlen($lastName) == 0){
                $alertMessage .= "Please, fill in a last name.<br />";
                $somethingWrong = true;
            }
            if(strlen($lastName) > 100){
                $alertMessage .= "A last name may not be longer than 100 characters.<br />";
                $somethingWrong = true;
            }
            if(strlen($username) == 0){
                $alertMessage .= "Please choose a username.<br />";
                $somethingWrong = true;
            }
            if(strlen($username) > 50){
                $alertMessage .= "A username may not be longer than 100 characters.<br />";
                $somethingWrong = true;
            }
            if(filter_var($username, FILTER_VALIDATE_EMAIL)){
                $alertMessage .= "A username may not be in the form of an email address.<br />";
                $somethingWrong = true;
            }
            $sql = "SELECT * FROM `$db`.`accounts`";
            $res = $conn->query($sql);
            $usernameExists = false;
            while($row = $res->fetch_object()){
                if($row->username == $username){
                    $usernameExists = true;
                }
            }
            if($usernameExists){
                $alertMessage .= "Username already exists. Choose another one.<br />";
                $somethingWrong = true;
            }
            if(strlen($pass) == 0){
                $alertMessage .= "Please fill in a password.<br />";
                $somethingWrong = true;
            } 
            if(strlen($pass) > 50){
                $alertMessage .= "Password may not be longer than 50 characters.<br />";
                $somethingWrong = true;
            } else if($pass != $repass){
                $alertMessage .= "Passwords don't match.<br />";
                $somethingWrong = true;
            }
            if(!isset($_POST["uses-name-or-username"])){
                $alertMessage .= "Please make a choice, whether you want to display your name or username, when you post something.<br />";
                $somethingWrong = true;
            }
            if(!$somethingWrong){
                $formSentWell = true;
                $sql = "SELECT * FROM  `$db`.`accounts`";
                $res = $conn->query($sql);
                while($row = $res->fetch_object()){
                    if($link == $row->verification_link){
                        $email = $row->emailorfb_value;
                    }
                }
                $hash = sha1($email . "fheuidns8723cssdio" . $pass);
                $sql = "UPDATE `$db`.`accounts` SET `first_name` = '$firstName', `last_name`='$lastName', `hash_code_email_password` = '$hash', `verified` = 1, `username` = '$username', `uses_name_or_username` = ".$_POST["uses-name-or-username"]." WHERE `verification_link` = '$link';";
                $conn->query($sql);
            }
        }
    } else if($hasBeenVerificated){
        $everyThingRight = false;
        $alertMessage = "This verification link has already been used successfully. Please log in <a href='login.php'>here</a>.";
    } else {
        $everyThingRight = false;
       $alertMessage .= "This verification link is not valid. Please sign up <a href='signup.php'>here</a> or login <a href='login.php'>here<a>";
    }
} else {
   header("Location: signup.php");
}

showHeader("Verify your account", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
    <div class="container">
      <form id="form-signin" method="post" action="auth.php?link=<?php echo $link; ?>" class="form-signin" role="form">
        
            <h3>Verification of your account</h3><br />
          <?php
if($everyThingRight){
    // If link is valid
    if($formAlreadySent && $formSentWell){
        ?>
          <div class="alert-message alert alert-danger">
              <p>Congratulations, your account is verified. Click <a href='login.php'>here</a> to log in.</p>
          </div>
          <?php
    } else { if($formAlreadySent){
        ?>
          <div class="alert-message alert alert-danger">
            <p><?php echo $alertMessage; ?></p>
          </div>
          <?php
    }
    
    ?>
          <p>What is your first name?</p>
          <input autocomplete="off" type="text" name="first-name-auth" placeholder="First name" />
          <br /><br />
          <p>What is your last name?</p>
          <input autocomplete="off" type="text" name="last-name-auth" placeholder="Last name" />
          <br /><br />
          <p>Pick a username</p>
          <input autocomplete="off" type="text" name="username-auth" placeholder="Username" />
          <br /><br />
          <p>When you will post something, do you want your name or your username to be displayed?</p>
          <div style="overflow:hidden"><div class="choice-field" margin-right:10px;><label for="name-choice"><p>Name</p></label><input autocomplete="off" id="name-choice" type="radio" value="0" name="uses-name-or-username" /></div>
              <div class="choice-field" style="margin-left:10px;"><label for="username-choice"><p>Username</p></label><input autocomplete="off" id="username-choice" type="radio" value="1" name="uses-name-or-username" /></div></div><br />
          <p>Think of a good password, that's your own responsibility.</p>
          <input autocomplete="off" type="password" name="pass-auth" placeholder="Password" /><br /><br />
          <input autocomplete="off" type="password" name="re-pass-auth" placeholder="Retype your password" /><br /><br />
          <input autocomplete="off" type="submit" class="submit-auth" name="submit-auth" value="Verify"/>
        </form>
          <?php
} } else {
    // If link is not valid
    
    ?>
          <div class="alert-message alert alert-danger">
            <p><?php echo $alertMessage; ?></p>
          </div>
          <?php
}
?>
          
    </div><!-- /.container -->
    </div>
          
      
      
      
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>