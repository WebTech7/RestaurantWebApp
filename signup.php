<?php session_start();
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");

require_once("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$submitted = false;
$submittedsuccess = false;
$alertMessage = "";
$mailWorks = true;

if(isset($_GET["resend"]) && $_GET["resend"] == 1 && isset($_GET["email"])){
    $resendArray = resendVerification($_GET["email"], $conn);
    $email = makeInputSafe($_GET["email"]);
    $submitted = true;
    $emailAlreadyExists = emailAlreadyExists($email, $conn);
    $mail = $resendArray['mail'];
    $alertMessage = $resendArray['alertMessage'];
        if(!$mailWorks && $mail!=""){
            echo "Our mail services currently don't work, so here is the original email: $mail";
        }
        $submittedsuccess = true;
} else if(isset($_POST["emailadress-signup"])){
    $email = makeInputSafe($_POST["emailadress-signup"]);
    $submitted = true;
    $emailAlreadyExists = emailAlreadyExists($email, $conn);
    if($emailAlreadyExists["exists"]){
        $alertMessage .= "An account is already linked to this email address.";
        if($emailAlreadyExists["verified"] == 0){
            $alertMessage .= " Click <a href='signup.php?resend=1&email=".urlencode($email)."'>here</a> to resend the verification email.";
        }
        $alertMessage .= "<br />";
    } else if(!filter_var($_POST["emailadress-signup"], FILTER_VALIDATE_EMAIL)){
        $alertMessage .= "This is not a valid email address.";
    } else {
        $verLinkUnique = false;
        $verificationLink = getVerificationLink($conn);
        $sql = "INSERT INTO `restaurantwebapp`.`accounts` (`user_id`, `emailorfb`, `emailorfb_value`, `first_name`, `last_name`, `hash_code_email_password`, `verified`, `verification_link`, `street_name`, `postal_code`, `city`, `username`, `uses_name_or_username`, `street_number`) VALUES (NULL, '0', '$email', '', '', '', '0', '$verificationLink', '', '', '', '', '0', '');";
        $res = $conn->query($sql);
        $mail = sendVerificationEmail($email, $verificationLink, $conn);
        $alertMessage .= "A verification email has been sent. Click the verification link in the email, set your name, a password and you're done!";
        if(!$mailWorks){
            echo "Our mail services currently don't work, so here is the original email: $mail";
        }
        $submittedsuccess = true;
    }
}

?>
      
    <?php
showHeader("Sign up", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
    <div class="container">
      <form id="form-signin" method="post" action="signup.php" class="form-signin" role="form">
            <h3>Sign up</h3><br />
          <?php
if($alertMessage != ""){
    ?>
          <div class="alert-message alert <?php if($submittedsuccess){echo "alert-success";} else { echo "alert-danger"; } ?>">
            <p><?php echo $alertMessage; ?></p>
          </div>
          <?php
} if(!$submittedsuccess){
?>
          <p>What is your email address?</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="emailadress-signup" placeholder="Email address" />
          <div class="something-abolute"><div class="something-0"><div class="arrow-button" style="margin-left:202px;height:38px;width:38px;top:-38px;"  onclick="$('#form-signin').submit();"></div></div></div>
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
</html>