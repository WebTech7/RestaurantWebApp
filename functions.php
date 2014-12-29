<?php

require_once("connect.php");

function checkIfsearchQuery($query){    
    if(trim($query)!='') {
        return true;
    } else {
        return false;
    }
}

function makeInputSafe($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}
                                 
function checkIfPostalCode($postcode){
    $remove = str_replace(" ","", $postcode);
    $upper = strtoupper($remove);

    if(preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return $upper;
    } else {
        return false;
    }
}

function showHeader($title) {

     if(isset($_GET["place"])){
        $place = makeInputSafe($_GET["place"]);
        setcookie("place", $place);
         if(!isset($_COOKIE["place"])){
            setcookie("place", $place);
         }
             $_COOKIE["place"] = $place;
    } else if(isset($_COOKIE["place"])) {
        $place = $_COOKIE["place"];
    } else {
        header("Location: index.php");
    }
    $title = $place;
    if(isset($_GET["q"])){
        $q = makeInputSafe($_GET["q"]);
        setcookie("q", $q);
        if(trim($q) != ""){
            $title = $q . " | " . $place;
        } else if(isset($_COOKIE["q"])) {
            $place = $_COOKIE["q"];
        } else {
            $q = "";
        }
    } else {
        $q = "";
    }

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Restaurant Info, Reviews and Orders">
    <meta name="author" content="WebTech7">

    <title><?php echo $title; ?> | RestaurantWebApp</title>

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
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      whenLoggedIn();
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : '1033735633321196',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
    });
  }
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->
      <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/nl_NL/sdk.js#xfbml=1&appId=1033735633321196&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
      
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
          <a class="navbar-brand" href="index.php?<?php if(isset($_COOKIE["q"])){echo "q=".$_COOKIE["q"]."&";} ?>place=<?php echo $_COOKIE["place"]; ?>">RestaurantWebApp</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="owner.php">I'm an owner!</a></li>
            <li><a href="postalcode.php">Front Page</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li>
            <li><a class="login-link" id="login-link" onclick="openLogin('signup');">Sign up</a></li>
              <li><a class="login-link" id="login-link" onclick="openLogin('login');">Login <img src="https://www.facebook.com/images/fb_icon_325x325.png" class="small-facebook-logo" /></a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input class="form-control top-search-input" id="top-search-q" style="width:145px;" placeholder="Italian, Domino's">
            <input type="text" <?php if(isset($_COOKIE["place"])){echo "value='".$_COOKIE["place"]."'";} ?> class="form-control top-search-input" id="top-search-place" style="width:165px;" placeholder="1234AB or Eindhoven">
              <div class="btn btn-regular" id="top-search-button"><img onclick="submitTopSearch();" src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-02-48.png" height="30"/></div>
          </form>
        </div>
      </div>
    </nav>
          <?php
          }   ?>