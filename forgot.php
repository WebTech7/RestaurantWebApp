<?php ob_start(); session_start();
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
$mailWorks = true;

$loginSuccess = false;

$alertMessage = "";

$userNameOrEmailExists = false;

$auth = false;

if(isset($_POST["username-or-email-login"])){
    $userNameOrEmail = makeInputSafe($_POST["username-or-email-login"]);
    if(filter_var($userNameOrEmail, FILTER_VALIDATE_EMAIL)){
        $sql = "SELECT * FROM `$db`.`accounts`";
        $res = $conn->query($sql);
        while($row = $res->fetch_object()){
            if($row->emailorfb_value == $userNameOrEmail){
                $userNameOrEmailExists = true;
                $email = $row->emailorfb_value;
                if($row->verified == 1){
                    $auth = true;
                }
            }
        }
    } else {
        $sql = "SELECT * FROM `$db`.`accounts`";
        $res = $conn->query($sql);
        while($row = $res->fetch_object()){
            if($row->username == $userNameOrEmail){
                $userNameOrEmailExists = true;
                $email = $row->emailorfb_value;
                if($row->verified == 1){
                    $auth = true;
                }
            }
        }
    }
    if($userNameOrEmailExists && $auth){
        $subject = "RestaurantWebApp reset password";
	    $from = "noreply@coen.pe.hu";
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html ; charset=iso-8859-1' . "\r\n";
        // Additional headers
        $headers .= "From: $from\r\n";
        $resetPassLink = getResetPassLink($conn);
        $host = "http://$_SERVER[HTTP_HOST]/";
        $sql = "SELECT * FROM `$db`.`accounts`";
            $res = $conn->query($sql);
            while($row = $res->fetch_object()){
                if($row->emailorfb_value == $email){
                    $user_id = $row->user_id;
                }
            }
	    $message = "On RestaurantWebApp, you asked to reset your password, because you forgot it.<br />Reset your password with this link: <a href='".$host."resetpass.php?link=$resetPassLink'>".$host."resetpass.php?link=$resetPassLink</a>";
	   mail($email,$subject,$message,$headers);
        if(!$mailWorks){
            echo "Our mail services currently don't work, so here is the original email: $message";
        }
        $sql = "INSERT INTO `$db`.`resetpass` (`id`, `link`, `user_id`, `used`) VALUES (NULL, '$resetPassLink', '$user_id', '0');";
        $conn->query($sql);
        $alertMessage .= "A link to change your password has been sent to your email.";
    } else if($userNameOrEmailExists){
        $alertMessage .= "Your account has not been verificated yet. Start doing this by clicking <a href='signup.php'>here</a>.";
    } else {
        $alertMessage .= "The given username or email address is not known by us.";
    }
}

showHeader("Forgot my password", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
    <div class="container">
      <form id="form-signin" method="post" action="forgot.php" class="form-signin" role="form">
            <h3>Forgot password</h3><br />
          <?php
if(isset($_POST["username-or-email-login"])){
    ?>
          <div class="alert-message alert <?php if($userNameOrEmailExists){echo "alert-success";} else { echo "alert-danger"; } ?>">
            <p><?php echo $alertMessage; ?></p>
          </div>
          
          <?php
} if(!$userNameOrEmailExists) {
?>
          <p>Username or email address:</p>
          <input autocomplete="off" type="text" name="username-or-email-login" placeholder="Username or email" />
          <div class="something-abolute"><div class="something-0"><div class="arrow-button" style="margin-left:202px;height:38px;width:38px;top:-38px;"  onclick="$('#form-signin').submit();"></div></div></div>
          
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