<?php if(!isset($_SESSION)) {
    session_start();
} 
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once("functions.php");
$loginSuccess = false;

$alertMessage = "";

if(isset($_POST["username-or-email-login"])){
    $usernameOrEmail = makeInputSafe($_POST["username-or-email-login"]);
    $pass = makeInputSafe($_POST["pass"]);
    if(filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)){
        $hash = sha1($usernameOrEmail . "fheuidns8723cssdio" . $pass);
        $sql = "SELECT * FROM `$db`.`accounts`";
        if($res = $conn->query($sql)){
            while($obj = $res->fetch_object()){
                if($obj->emailorfb_value == $usernameOrEmail){
                    if($obj->hash_code_email_password == $hash){
                        $loginSuccess = true;
                        $alertMessage = "Logged in successfully. <a href='index.php'>Click here to go back to the home page.</a>";
                        $user_id = $row->user_id;
                    }
                }
            }
        }
    } else {
        $sql = "SELECT * FROM `$db`.`accounts`";
        $res = $conn->query($sql);
        $hasBeen = false;
        while($row = $res->fetch_object()){
            if($row->username == $usernameOrEmail){
                $hasBeen = true;
                $email = $row->emailorfb_value;
                $user_id = $row->user_id;
            }
        }
        if(!$hasBeen){
            $loginSuccess = false;
        } else {
            $sql = "SELECT * FROM `$db`.`accounts`";
            $res = $conn->query($sql);
            while($row = $res->fetch_object()){
                if($row->emailorfb_value == $email){
                    if($row->hash_code_email_password == sha1($email . "fheuidns8723cssdio" . $pass)){
                        $loginSuccess = true;
                        $alertMessage = "Logged in successfully. <a href='index.php'>Click here to go back to the home page.</a>";
                        $user_id = $row->user_id;
                    }
                }
            }
        }
    }
        if(!$loginSuccess){
            $alertMessage = "Combination of password and username email is not known by us.";
        } else {
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $user_id;
            if(isset($_GET["redirectUrl"])){
                header('Location: '.$_GET["redirectUrl"]);
            }
        }
}

      
showHeader("Log in", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
    <div class="container">
      <form id="form-signin" method="post" action="login.php<?php if(isset($_GET["redirectUrl"])){
                echo "?redirectUrl=".$_GET["redirectUrl"];
            } ?>" class="form-signin" role="form">
            <h3>Log in</h3><br />
          <?php
if(isset($_POST["username-or-email-login"])){
    ?>
          <div class="alert-message alert <?php if($loginSuccess){echo "alert-success";} else { echo "alert-danger"; } ?>">
            <p><?php echo $alertMessage; ?></p>
          </div>
          
          <?php
} if(!$loginSuccess){
?>
          <p>Username or email address:</p>
          <input autocomplete="off" type="text" name="username-or-email-login" placeholder="Username or email address" />
          <br /><br />
          <p>Password:</p>
          <input autocomplete="off" type="password" name="pass" placeholder="Password" /><div class="something-abolute"><div class="something-0"><div class="arrow-button" style="margin-left:202px;height:38px;width:38px;top:-38px;"  onclick="$('#form-signin').submit();"></div></div></div><br />
          <p><a href="forgot.php">Forgot password?</a></p>
        </form>
          <?php } ?>
    </div><!-- /.container -->
    </div>
          
      
      
      
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/main.js"></script>
    
  </body>
</html> */ ?>