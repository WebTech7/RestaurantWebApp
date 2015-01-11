<?php

function stripAccents($stripAccents){
$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
return $str = strtr( $stripAccents, $unwanted_array );
}

function emailAlreadyExists($email, $conn){
    $returnArray = array("exists" => false, "verificated" => 0);
    $sql = "SELECT * FROM `restaurantwebapp`.`accounts`";
    $hasBeen = false;
    if($result = $conn->query($sql)){
        while($obj = $result->fetch_object()){ 
            if(strtolower($email) == strtolower($obj->emailorfb_value)){
                $returnArray["exists"] = true;
                if($obj->verified == 1){
                    $returnArray["verified"] = 1;
                } else {
                    $returnArray["verified"] = 0;
                }
                $hasBeen = true;
            }
        }
    }
    if(!$hasBeen){
        $returnArray["exists"] = false;
    }
    return $returnArray;
}

function sendVerificationEmail($email, $verificationLink, $conn) {
    
    $subject = "RestaurantWebApp verification";
	$from = "noreply@coen.pe.hu";
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html ; charset=iso-8859-1' . "\r\n";
        // Additional headers
        $headers .= "From: $from\r\n";
        $host = "http://$_SERVER[HTTP_HOST]/";
    $message = "Thank you for your interest in RestaurantWebApp.<br />Verificate your email address with this link: <a href='".$host."auth.php?link=$verificationLink'>".$host."auth.php?link=$verificationLink</a>";
	   mail($email,$subject,$message,$headers);
	    return $message;
    }

function getVerificationLink($conn){
    $verificationLink = md5(rand(0,999999999));
    $verLinkUnique = false;
    while(!$verLinkUnique){
            $sql = "SELECT `emailorfb_value` FROM `accounts`";
            $res = $conn->query($sql);
            $hasBeenThere = false; if($res){
            while($row = $res->fetch_object()){
                if(isset($row->verification_link) && $row->verification_link){
                    $hasBeenThere = true;
                }
            }
            }
            if($hasBeenThere){
                $verificationLink = md5(rand(0,999999999));
            } else {
                $verLinkUnique = true;
            }
        }
    return $verificationLink;
}

function getResetPassLink($conn){
    $resetPassLink = md5(rand(0,999999999));
    $verLinkUnique = false;
    while(!$verLinkUnique){
        $resetPassLink = md5(rand(0,999999999));
            $sql = "SELECT `emailorfb_value` FROM `restaurantwebapp`.`resetpass`";
            $res = $conn->query($sql);
            $hasBeenThere = false;
        if($res){
            while($row = $res->fetch_object()){
                if($row->link == $resetPassLink){
                    $hasBeenThere = true;
                }
            } }
            if($hasBeenThere){
                $resetPassLink = md5(rand(0,999999999));
            } else {
                $verLinkUnique = true;
            }
        }
    return $resetPassLink;
}

function resendVerification($email, $conn){
    if(emailAlreadyExists($email, $conn)){
        $sql = "SELECT * FROM `restaurantwebapp`.`accounts`;";
        $mail = "";
        $alertMessage = "";
        $res = $conn->query($sql); 
        if($res){
        while($row = $res->fetch_object()){
            if($row->emailorfb_value == $email){
                if($row->verified == 0){
                    $verificationLink = getVerificationLink($conn);
                    $mail = sendVerificationEmail($email, $verificationLink,$conn);
                    $sql = "UPDATE `restaurantwebapp`.`accounts` SET `verification_link` = '$verificationLink' WHERE `email` = '$email';";
                    $conn->query($sql);
                    $alertMessage = "The verification email has been resent successfully.";
                    $submitted = true;
                    $submittedsuccess = true;
                } else {
                    $alertMessage = "Your account has been verificated already. Click <a href='login.php'>here</a> to log in.";
                    $submitted = true;
                    $mail = "";
                }
            }
        } }
        return array('mail' => $mail, 'alertMessage' => $alertMessage);
    }
}

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
    if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
    $loggedIn = true;
} else {
    $loggedIn = false;
}
    
    $servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
    
        $title2 = $title;
    $formsubmit = $homepage;
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
    } else if(isset($_COOKIE["q"]) && $_COOKIE["q"] != ""){
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
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);
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
              <form class="navbar-form navbar-right top-form" id="topform" <?php if(!$formsubmit){ ?> action="index.php" method="get" <?php } ?>>
            <input class="form-control top-search-input" id="top-search-q" style="width:145px;" placeholder="Italian, Domino's">
            <input type="text" <?php if(isset($_COOKIE["place"])){echo "value='".$_COOKIE["place"]."'";} ?> class="form-control top-search-input" id="top-search-place" style="width:135px;border-radius:4px 0 0 4px;margin-right:0;" placeholder="1234AB, Eindhoven">
                  <div class="btn btn-regular" id="top-search-location"><img id="location-or-load" onclick="topSearchLocation();" src="https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/location-24-48.png" height="24"/></div>
              <div class="btn btn-regular" id="top-search-button"><img onclick='<?php if(!$formsubmit){ echo 'document.location.href="index.php?q="+$("#top-search-q").val()+"&place="+$("#top-search-place").val();'; } else echo 'submitTopSearch();'; ?>' src="https://cdn0.iconfinder.com/data/icons/slim-square-icons-basics/100/basics-02-48.png" height="30"/></div>
                  </form>
              </li>
            <li><a href="signupowner.php">I'm an owner!</a></li>
            <li><a href="postalcode.php">Front Page</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li><?php
    if(!$loggedIn){
    ?>
            <li><a class="login-link" id="login-link" href="signup.php">Sign up</a></li>
              <li><a class="login-link" id="login-link" href="login.php">Login <img src="https://www.facebook.com/images/fb_icon_325x325.png" class="small-facebook-logo" /></a></li>
              <?php } else { ?>
              <li><a style="color:#222 !important;">Bon Appetit, <?php $sql = "SELECT * FROM `restaurantwebapp`.`accounts` WHERE `user_id` = ".$_SESSION["user_id"].";";
                            if($res = $conn->query($sql)){
                                while($obj = $res->fetch_object()){
                                    echo $obj->first_name; 
                                }
                            }
                  ?>!</a></li>
              <li><a href="logout.php">Logout</a></li>
              <?php } ?>
          </ul>
          
        </div>
      </div>
    </nav>
          <?php
          }   ?>