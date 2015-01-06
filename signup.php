<?php
require_once("fb.php");


use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
//use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\FacebookHttpable;
use Facebook\FacbeookCurlHttpClient;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\GraphSessionInfo;
ob_start();
require_once("functions.php");
if(!isset($_GET["place"]) && !isset($_COOKIE["place"])){
    header("Location: postalcode.php");
} else if((!isset($_GET["place"]) || trim($_GET["place"]) == "" ) && (!isset($_COOKIE["place"]) || trim($_COOKIE["place"]) == "") ) {
    header("Location: postalcode.php?error=2");
} else {
    if(isset($_GET["place"])){
    $place = makeInputSafe($_GET["place"]);
    setcookie("place", $place);
    }
    $place = makeInputSafe($_COOKIE["place"]);
    $title = $place;
    if(isset($_GET["q"])){
        $q = makeInputSafe($_GET["q"]);
        setcookie("q", $q);
        if(trim($q) != ""){
            $title = $q . " | " . $place;
        }
    } else {
        $q = $_COOKIE["q"];
    }
    $_COOKIE["get"] = "";
    if(isset($_GET["place"]) || isset($_GET["q"])){
        header("Location: index.php");
    }
    showHeader($title, true);
?>

                <div class="image-background jumbotron" style="background:url(http://static1.businessinsider.com/image/5130ceb369bedd012b000002-1200/use-it-as-a-controller-for-solenoids-for-my-eye-controlled-instruments-im-making-to-help-disabled-people-make-music.jpg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px - 80px);" id="image-background">
                        <h3>Sign up</h3>
                </div>
        <div class="result-content-wrapper info-main-page">
            <?php
    if(isset($_POST["email"])){
        $email = addslashes(makeInputSafe($_POST["email"]));
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

        } else {
            ?>
                <h4>a</h4>
            <?php
        }
    } else {
    ?>
           
            <?php } ?>
                </div>
              </div>
            </div>
          </div>
      </div>
</div></div></div>
      <div id="login-screen-wrapper" class="content-when-not-logged-in" onclick="closeLogin();">
          <div id="login-screen" class="container">
              <div class="something-absolute something-0"><div class="login-screen-cross"><img src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-32.png" width="15"/></div></div>
              <div class="fb-login-button" style="" target="_blank" onclick="document.location.href= '<?php echo $helper->getLoginUrl(); ?>';"><h3 style="">FACEBOOK LOGIN</h3></div>

                <hr />
                    <h4><span id="login-without-fb">Log in</span><span id="signup-without-fb">Sign up</span> without Facebook</h4>
                <br />
                <div><div class="btn-group" role="group" aria-label="...">
                  <button type="button" onclick="showLogin();" class="btn btn-default login-button">Log in</button>
                  <button type="button" onclick="showSignUp();" class="btn btn-default signup-button">Sign up</button>
                </div>
                        <br />

                <br />
                  <form role="form" id="login-form">
                    <div class="form-group">
                        <div class="alert alert-danger" role="alert" id="login-feedback-danger"></div>
                      <label for="login-email">Email:</label>
                      <input type="email" class="form-control" id="login-email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="pwd">Password:</label>
                      <input type="password" class="form-control" id="login-pwd" placeholder="Enter password">
                    </div>
                    <button type="submit" onclick="submitLogin();" value="login" class="btn btn-default">Log in</button>
                  </form>
                    <form role="form" id="signup-form">
                    <div class="form-group">
                      <label for="signup-email">Email:</label>
                        <span id="signup-alert"></span>
                      <input id="signup-email" type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <button type="submit" id="signup-submit" onclick="ajaxSubmit();" class="btn btn-default">Sign up</button>
                  </form>
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
<?php
}
    ?>
