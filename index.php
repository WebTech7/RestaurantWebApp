<?php ob_start();
function checkIfPostalCode($postcode){
    $remove = str_replace(" ","", $postcode);
    $upper = strtoupper($remove);

    if(preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return $upper;
    } else {
        return false;
    }
}
function checkIfsearchQuery($query){    
    if(trim($query)!='') {
        return true;
    } else {
        return false;
    }
}

function makeStringSafe($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

if(!isset($_GET['postalCode']) && !isset($_GET["searchQuery"])){
    header("Location: postalCode.php");
} else if(isset($_GET["postalCode"]) && (!checkIfPostalCode($_GET['postalCode']))){
        header("Location: postalCode.php?error=1");
    } else if(isset($_GET["searchQuery"]) && (!checkIfsearchQuery($_GET['searchQuery'])) ) {
        header("Location: postalCode.php?error=2");
    } else {
    if(isset($_GET["postalCode"])) $postalCode = strtoupper(makeStringSafe($_GET['postalCode']));
    if(isset($_GET["searchQuery"])) $searchQuery = makeStringSafe($_GET['searchQuery']);
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Restaurant Info, Reviews and Orders">
    <meta name="author" content="WebTech7">

    <title>RestaurantWebApp</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1033735633321196',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
      <div id="wrap-everything">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="postalcode.php">RestaurantWebApp</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="postalcode.php">Front Page</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li>
            <li><a class="login-link" id="login-link" onclick="openLogin('signup');">Sign up</a></li>
            <li><a class="login-link" id="login-link" onclick="openLogin('login');">Login <img src="https://www.facebook.com/images/fb_icon_325x325.png" class="small-facebook-logo" /></a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search for restaurants">
          </form>
        </div>
      </div>
    </nav>

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
                    Do you want to order?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="order" id="order">
                            <option>No preference</option>  
                            <option>Yes</option>
                            <option>No</option>
                    </select>
                </div><br />
                <label for="radius"><p>
                    In what radius do you want to search?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="radius" id="radius">
                        <option>No preference</option>  
                        <option>2 km</option>
                          <option>5 km</option>
                          <option>10 km</option>
                          <option>25 km</option>
                            <option>50 km</option>
                      </select><br />
                </div>
                
                <label for="min-rating"><p>
                    Minimum rating:</p></label><br />
                <div class="specify-option-content star-specify-option-content">
                    <input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" id="1" value="1" class="star-large first-star-large" /><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="2" class="star-large" id="2"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="3" class="star-large" id="3"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="4" class="star-large" id="4"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="5" class="star-large" id="5"/>
                </div>
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main results">
            <div class="header"><h3>Results for <?php if(isset($_GET["postalCode"])){echo $postalCode;}else echo $searchQuery; ?> <div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div></h3><div style="right:30px;" class="something-absolute"><div class="something-0"><div class="sort-by-div">
                <label for="sort-by" >Sort by:</label>
                <select class="form-control" name="sort-by">
                    <option>Best reviews</option>  
                    <option>Newest</option>
                </select>
                </div></div></div></div>
            <div class="result-content-wrapper">
                        <?php    
    
        for($i=0;$i<1;$i++){
            if($i % 2 == 0){
                ?><div class="row"><?php
            }
        ?>
                    <div class="col-lg-6">
                        <div class="result-box">
                            <div class="result-image" style="background:url(http://www.foodnavigator-usa.com/var/plain_site/storage/images/publications/food-beverage-nutrition/foodnavigator-usa.com/regulation/subway-removing-controversial-dough-conditioner-baking-expert-deems-ingredient-unnecessary/8754193-1-eng-GB/Subway-removing-controversial-dough-conditioner-baking-expert-deems-ingredient-unnecessary.jpg);background-size:cover;background-position:center;"></div>
                            <div class="result-content">
                                <h4><?php echo "Subway"; ?></h4>
                                <p class="description-short">
                                    Some description...<br />
                                </p>
                                <div style="float:left;margin-top:15px;">
                                    <p>1 review &bull;</p></div>
                                    <div style="float:left;margin-left:17px;width:100px;overflow:hidden">
                                    <?php
        $outOfFiveStars = 3.45;
        $pxWidthOfStar = 13;
        $pxMarginLeft = 3;
        for($j=0;$j<5;$j++){
                                    if($j < $outOfFiveStars){
                                        if($outOfFiveStars - $j < 1){
                                            ?>
                                        <div style="float:left;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div><div style="position:absolute;z-index:1;width:0;height:0;"><div style="z-index:1;position:relative;width:<?php echo ($outOfFiveStars - $j)*$pxWidthOfStar; ?>px;left:<?php echo ($pxWidthOfStar+$pxMarginLeft)*$j + $pxMarginLeft; ?>px;overflow:hidden;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star" style="margin-left:0 !important;"/></div></div>
                                    <?php
                                        } else {
                                    ?>
                                        <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star"/></div>
                                    <?php } } else {
                                        ?> <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div> <?php   
                                    } }
                                        ?></div>
                            </div>
                        </div>
                        <?php
                        if($i % 1 == 0){
                ?></div><?php } } ?>
                    
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div id="login-screen-wrapper" onclick="closeLogin();">
          <div id="login-screen" class="container">
              <div class="something-absolute something-0"><div class="login-screen-cross"><img src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-22-32.png" width="15"/></div></div>
              <button type="button" onclick="document.location.href='fb';" class="btn btn-default btn-lg btn-primary"><img src="https://www.facebook.com/images/fb_icon_325x325.png" class="middle-facebook-logo" /> Log in with Facebook</button>
              
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
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
        <script>
            var clicked = 0;
            
            $(".star-large").click(function(){
                clicked = 0;
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=1;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=0;a<$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
                clicked = $(this).val();
            });
            $(".star-large").hover(function(){
                emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    this.src = emptySrc;
                    for(a=1;a<=5;a++){
                        $("#"+a+"").attr("src", emptySrc);
                    }
                fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=1;a<=$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
            }, function(){
                    fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                    emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                    for(a=0;a<=5;a++){
                        if(a > parseInt(clicked)){
                            $("#"+a+"").attr("src", emptySrc);
                        } else {
                            $("#"+a+"").attr("src", fullSrc);
                        }
                }
            });
        </script>
        
        <script>
            loginScreen = false;
            
            function showLogin(){
                $("#login-form").show();
                $("#signup-form").hide();      
                $("#login-without-fb").show();
                $("#signup-without-fb").hide();
                $(".login-button").css('background', '#CCC');
                $(".signup-button").css('background', '#e6e6e6');
                $(".login-button").css('pointer-events', 'none');                
                $(".signup-button").css('pointer-events', 'auto');
            }
            
            function showSignUp(){
                $("#signup-form").show();
                $("#login-form").hide();
                $("#signup-without-fb").show();
                $("#login-without-fb").hide();
                $(".signup-button").css('background', '#CCC');
                $(".login-button").css('background', '#e6e6e6');
                $(".signup-button").css('pointer-events', 'none');
                $(".login-button").css('pointer-events', 'auto');
            }
            
            function openLogin(type){
                $("#login-screen-wrapper").show();
                if(type == 'login'){
                    showLogin();
                } else if(type == 'signup'){
                    showSignUp();
                }
            }
            
            $("#login-screen-wrapper").on('click', function() {
              $("#login-screen-wrapper").hide();
            }).children().on('click',function(){
                return false;
            });
            
             $(".login-screen-cross").on('click', function() {
                $("#login-screen-wrapper").hide();
            })
            
            $(document).ready(function(){
                $("#login-screen-wrapper").hide();
            });
            
            function checkEmail(email) {
                if(email.length > 1){
                    return true;
                } else {
                    return false;
                }
            }
            
            function submitSignUp(){
                if(checkEmail($("#signup-email").val())){
                    document.getElementById("signup-feedback-success").innerHTML = 'A verification email has been sent to your email address. Click the verification link in the email, set your password and you\'re done.';
                    $("#signup-feedback-success").show();
                    $("#signup-feedback-danger").hide();
                } else {
                   document.getElementById("signup-feedback-danger").innerHTML = 'This is not a valid email address.';
                    $("#signup-feedback-danger").show();
                    $("#signup-feedback-success").hide();
                }
            }

            function loginSuccess(){
                if($("#login-email").val() == 'success'){
                    return true;
                } else {
                    return false;
                }
            }
            
            function login(){
                //some AJAX
            }
            
            function submitLogin(){
                if(loginSuccess()){
                    $("#login-screen-wrapper").hide();
                    $("#signup-feedback-danger").hide();
                    login();
                } else {
                    $("#login-feedback-danger").show();
                    document.getElementById("login-feedback-danger").innerHTML = 'The combination of email address and password is not known by us.';
                }
            }
        </script>
        
  </body>
</html>
<?php
}
    ?>