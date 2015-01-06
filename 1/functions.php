<?php

require_once("connect.php");
$loggedIn = false;
//if($fbLoggedIn){
//    $loggedIn = true;
//}

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

function showHeader($title, $homepage) {
        $title2 = $title;
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
    if($q != ""){
        $title = $q . " | " . $title;
    } else if($_COOKIE["q"] != ""){
        $title = $_COOKIE["q"] . " | " . $title;
    }
    if(!$homepage){
        $title = $title2;
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
    <script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
var myCenter=new google.maps.LatLng(51.508742,-0.120850);


google.maps.event.addDomListener(window, 'load', function(){var mapProp = {
  center:myCenter,
  zoom:5,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);});
</script>
  </head>

  <body>
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
              <li>
              <form class="navbar-form navbar-right top-form">
            <input class="form-control top-search-input" id="top-search-q" style="width:145px;" placeholder="Italian, Domino's">
            <input type="text" <?php if(isset($_COOKIE["place"])){echo "value='".$_COOKIE["place"]."'";} ?> class="form-control top-search-input" id="top-search-place" style="width:135px;border-radius:4px 0 0 4px;margin-right:0;" placeholder="1234AB, Eindhoven">
                  <div class="btn btn-regular" id="top-search-location"><img id="location-or-load" onclick="topSearchLocation();" src="https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/location-24-48.png" height="24"/></div>
              <div class="btn btn-regular" id="top-search-button"><img onclick="submitTopSearch();" src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-02-48.png" height="30"/></div>
                  </form>
              </li>
            <li><a href="signupowner.php">I'm an owner!</a></li>
            <li><a href="postalcode.php">Front Page</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li><?php
    if(!$loggedIn){
    ?>
            <li><a class="login-link" id="login-link" onclick="openLogin('signup');">Sign up</a></li>
              <li><a class="login-link" id="login-link" onclick="openLogin('login');">Login <img src="https://www.facebook.com/images/fb_icon_325x325.png" class="small-facebook-logo" /></a></li>
              <?php } else { ?>
              <li><a href="logout.php">Logout (<?php echo $username; ?>)</a></li>
              <?php } ?>
          </ul>
          
        </div>
      </div>
    </nav>
          <?php
          }   ?>