<?php ob_start(); session_start();
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

$loginSuccess = false;

$alertMessage = "";
$hasBeenReset = false;
$everyThingRight = false;

if(isset($_GET["link"])){
    $link = makeInputSafe($_GET["link"]);
    $sql = "SELECT * FROM `$db`.`resetpass`";
    $res = $conn->query($sql);
    $hasBeen = false;
    $hasBeenUsed = false;
    while($row = $res->fetch_object()){
        if($row->link == $link){
            if($row->used == 1){
                $hasBeenUsed = true;
            } else {
                $everyThingRight = true;
            }
        }
    }
    if($everyThingRight){
        // if link is valid
        if(isset($_POST["submit-reset"])){
            $formSentWell = false;
            $pass = makeInputSafe($_POST["pass"]);
            $repass = makeInputSafe($_POST["re-pass"]);
            if(strlen($pass) == 0){
                $alertMessage .= "Please, fill in a password.";
            } else if($pass == $repass){
                $formSentWell = true;
            } else {
                $alertMessage .= "Passwords don't match.";
            }
            if($formSentWell){
                $sql = "SELECT * FROM  `$db`.`resetpass`";
                $res = $conn->query($sql);
                while($row  = $res->fetch_object()){
                    if($link == $row->link){
                        $user_id = $row->user_id;
                    }
                }
                $sql = "SELECT * FROM  `$db`.`accounts`";
                $res = $conn->query($sql);
                while($row  = $res->fetch_object()){
                    if($user_id == $row->user_id){
                        $email = $row->emailorfb_value;
                    }
                }
                $hash = sha1($email . "fheuidns8723cssdio" . $pass);
                $alertMessage .= "Your password has been reset. Click <a href='login.php'>here</a> to log in.";
                $hasBeenReset = true;
                $sql = "UPDATE `$db`.`accounts` SET `hash_code_email_password` = '$hash' WHERE `user_id` = $user_id;";
                $conn->query($sql);
                $sql = "UPDATE `$db`.`resetpass` SET `used` = 1 WHERE `user_id` = $user_id;";
                $conn->query($sql);
            }
        }
    } else if(!$everyThingRight && $hasBeenUsed){
        // if link has already been used
        $alertMessage .= "This link has already been used. Click <a href='forgot.php'>here</a> to get a new one.";
    } else {
        // this link is not valid, display link to forgot.php
        $alertMessage .= "This is not a valid link. Click <a href='forgot.php'>here</a> to send a new link to reset your password.";
    }
} else {
    header("Location: index.php");
}
showHeader("Reset your password", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
    <div class="container">
      <form id="form-signin" method="post" action="resetpass.php?link=<?php echo $_GET["link"]; ?>" class="form-signin" role="form">
            <h3>Reset password</h3><br />
          <?php
if(isset($_POST["submit-reset"]) || !$everyThingRight){
    ?>
          <div class="alert-message alert <?php if($formSentWell){echo "alert-success";} else { echo "alert-danger"; } ?>">
            <p><?php echo $alertMessage; ?></p>
          </div>
          
          <?php
} if($everyThingRight && (!isset($_POST["submit-reset"]) || $alertMessage != "") && !$hasBeenReset) {
?>
          <p>New password:</p>
          <input autocomplete="off" type="password" name="pass" placeholder="Password" /><br /><br />
          <p>Retype password:</p>
          <input autocomplete="off" type="password" name="re-pass" placeholder="Retype password" />
          <br /><br />
          <input autocomplete="off" type="submit" class="submit-auth" name="submit-reset" value="Log in"/><br /><br />
          
        </form>
          <?php } ?>
    </div><!-- /.container -->
    </div>
      
      
      <div class="jumbotron footer">
        <div class="container">
            <!--<div class="footer-left"><p>Contact</p></div>-->
            <div class="footer-left">
                <p>Developed by Coen de Vente</p>
            </div>            
            <div class="footer-right"><p>A project for the course of Web Technology | <a href="http://www.tue.nl" target="_blank">TU/e</a></p></div>
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