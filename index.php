<?php ob_start(); session_start(); require_once("functions.php");
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
    showHeader($title);
?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar specify">
            <div class="header">
                <h3>
                    Specify
                </h3>
            </div>
            <div class="specify-content">
                <label for="kind-of-rest"><p>
                    What kind of restaurant are you looking for?
                    </p></label>
                <div class="specify-option-content">
                      <select class="form-control" name="kind-of-rest" id="kind-of-rest">
                          <option>No preference</option>  
                          <option>Fast food</option>
                          <option>Italian</option>
                          <option>Chinese</option>
                          <option>Dutch</option>
                      </select><br />
                </div>
                <label for="order"><p>
                    Do you want to order or pick up?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="order" id="order">
                            <option>No preference</option>  
                            <option>Order or pick up</option>
                            <option>Order</option>
                            <option>Pick up</option>
                            <option>No</option>
                    </select>
                </div><br />
                <label for="radius"><p>
                    In what radius do you want to search?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="radius" id="radius">
                        <option value="">No preference</option>  
                        <option value="2000">2 km</option>
                          <option value="5000">5 km</option>
                          <option value="10000">10 km</option>
                          <option value="25000">25 km</option>
                            <option value="50000" >50 km</option>
                      </select><br />
                </div>
                
                <label for="min-rating"><p>
                    Minimum rating:</p></label><br />
                <div class="specify-option-content star-specify-option-content">
                    <input onclick="" type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" id="1" value="1" class="star-large first-star-large" /><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="2" class="star-large" id="2"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="3" class="star-large" id="3"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="4" class="star-large" id="4"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="5" class="star-large" id="5"/><input style="display:none;" type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_deny.png" class="star-large-none"/><span style="display:none;" id="hidden-rating">0</span>
                </div>
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main results">
            <div id="results-loading"></div>
            <div class="header" style="overflow:hidden;"><h3 style="float:left !important;margin-right:20px;">Results for <span id="results-for"><?php if(isset($q) && trim($q)!=""){echo "<i>" . $q . "</i> around ";} echo "<i>".$place."</i>"; ?></span></h3><div style="float:left;"><div style="float:right !important;" id="sort-wrap"><div class="sort-by-div"></div>
                <label style="float:left;padding-top:5px;" for="sort-by">Sort by:</label>
                <select style="float:left;width:150px;margin-top:-2px;margin-left:5px;" class="form-control" id="sort-by" name="sort-by">
                    <option value="0">Best matched</option>
                    <option value="1">Distance</option>
                    <option value="2">Highest rated</option>  
                </select>
                </div></div></div>
            <div id="results-content-wrapper" class="result-content-wrapper">
                        <?php require_once("refreshResults.php"); ?>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div id="login-screen-wrapper" class="content-when-not-logged-in" onclick="closeLogin();">
          <div id="login-screen" class="container">
              <div class="something-absolute something-0"><div class="login-screen-cross"><img src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-32.png" width="15"/></div></div>
              <!--<button type="button" class="btn btn-default btn-lg btn-primary"><img src="https://www.facebook.com/images/fb_icon_325x325.png" class="middle-facebook-logo" scope="public_profile,email" onlogin="checkLoginState();" /> Log in with Facebook<-button><fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
</fb:login-button>--><div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="true"></div>

              
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
                        <div class="alert alert-danger" role="alert" id="signup-feedback-danger"></div>
                        <div class="alert alert-success" role="success" id="signup-feedback-success"></div>
                      <label for="signup-email">Email:</label>
                      <input id="signup-email" type="email" class="form-control" id="email" placeholder="Enter email">
                    </div>
                    <button type="submit" onclick="submitSignUp();" class="btn btn-default">Sign up</button>
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