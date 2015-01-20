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

function getDisplayTime($GMTDateTimePublished){
    $secondsAgo = strtotime(gmdate('Y-m-d H:i:s')) - strtotime($GMTDateTimePublished);
        if($secondsAgo < 60){
            $s = "s";
            if($secondsAgo == 1){
                $s = "";
            }
            $displayTime = "$secondsAgo second$s ago";
        } else if($secondsAgo < (60 * 60)){
            $s = "s";
            if(round($secondsAgo / 60, 0) == 1){
                $s = "";
            }
            $displayTime = round($secondsAgo / 60, 0) . " minute$s ago";
        } else if($secondsAgo < (60 * 60 * 24)){
            $s = "s";
            if(round($secondsAgo / 60 / 60, 0) == 1){
                $s = "";
            }
            $displayTime = round($secondsAgo / 60 / 60, 0) . " hour$s ago";
        } else if($secondsAgo < (60 * 60 * 24 * 7)){
            $s = "s";
            if(round($secondsAgo / 60 / 60 / 24,0) == 1){
                $s = "";
            }
            $displayTime = round($secondsAgo / 60 / 60 / 24,0) . " day$s ago";
        } else if($secondsAgo < (60 * 60 * 24 * 30)){
            $s = "s";
            if(round($secondsAgo / 60 / 60 / 24 / 7,0) == 1){
                $s = "";
            }
            $displayTime = round($secondsAgo / 60 / 60 / 24 / 7,0) . " week$s ago";
        } else if($secondsAgo < (60 * 60 * 24 * 365)){
            $s = "s";
            if(round($secondsAgo / 60 / 60 / 24 / 30,0) == 1){
                $s = "";
            }
            $displayTime = round($secondsAgo / 60 / 60 / 24 / 30,0) . " month$s ago";
        } else {
            $s = "s";
            if(round($secondsAgo / 60 / 60 / 24 / 365,0) == 1){
                $s = "";
            }
            $displayTime = round($secondsAgo / 60 / 60 / 24 / 365,0) . " year$s ago";
        }
    return $displayTime;
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
                    $sql2 = "UPDATE accounts SET `verification_link` = '$verificationLink' WHERE `emailorfb_value` = '$email';";
                    $conn->query($sql2);
                    $alertMessage .= "The verification email has been resent successfully.";
                    $submitted = true;
                    $submittedsuccess = true;
                } else {
                    $alertMessage = "Your account has been verified already. Click <a href='login.php'>here</a> to log in.";
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
    } else if(isset($_COOKIE["place"]) && $_COOKIE["place"] != NULL) {
         $place = $_COOKIE["place"];
    } else {
         $explode = explode("/", $_SERVER["PHP_SELF"]);
         if($explode[count($explode)-1] == "index.php"){
            header("Location: postalcode.php");
         } else {
            $place = ""; 
         }
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
    
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script>
      $(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});
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
          <a class="navbar-brand" href="index.php">RestaurantWebApp</a>
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
              <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){ $sql = "SELECT * FROM restaurants WHERE user_id = '".$_SESSION["user_id"]."'"; 
$result = $conn->query($sql);	if ($result->num_rows > 0) { ?><li style="margin-top:8px;margin-left:10px;"><div class="dropdown">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
    My restaurant
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="restaurant.php?id=<?php $sql = "SELECT * FROM `restaurantwebapp`.`restaurants` WHERE `user_id`=".$_SESSION["user_id"].";";
                               if($res = $conn->query($sql)){
                                  while($row = $res->fetch_object()){
                                      echo $row->id;
                                  }
                               }
                               ?>"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_info.png" height="16" style="margin-top:-4px;" /> View my restaurant's page</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="editrestaurant.php"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/edit.png" height="16" style="margin-top:-4px;" /> Edit my restaurant</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="editmenu.php"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_add.png" height="16" style="margin-top:-4px;" /> Add a dish</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="deletedish.php"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_deny.png" height="16" style="margin-top:-4px;" /> Remove a dish</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="ownerorder.php"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/arrow_refresh.png" height="16" style="margin-top:-4px;" /> Orders from customers</a></li>
  </ul>
              </div></li><?php } else {?>
            <li><a href="restaurantowner.php">I'm an owner!</a></li><?php } } else {?>
            <li><a href="restaurantowner.php">I'm an owner!</a></li><?php } ?>
            <li><a href="postalcode.php">Front Page</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li><?php
    if(!$loggedIn){
    ?><span style="display:none" id="logged-in"><?php echo "0"; ?></span>
              <li id="user-info-li" onclick="showOrHideUserInfo();"><a style="cursor:pointer;"><img src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/user.png" height="20" style="margin-top:-5px;margin-right:7px;"/></a>
                  <div id="user-drop-info-wrapper" class="user-drop-info-wrapper" style="width:200px;margin-left:-170px;">
                          
                  </div>
              </li>
            <li><a class="login-link" id="login-link" href="signup.php">Sign up</a></li>
              <li><a href="login.php<?php $xpl = explode("/", $_SERVER["PHP_SELF"]); if($xpl[count($xpl)-1] == "order.php" && isset($_POST["restaurant-id"])){echo "?redirectUrl=restaurant.php?id=".urlencode($_POST["restaurant-id"]);} else { echo "?redirectUrl=".urlencode($_SERVER["REQUEST_URI"]); } ?>">Login <!--<img src="https://www.facebook.com/images/fb_icon_325x325.png" class="small-facebook-logo" />--></a></li>
              <?php } else { ?><span style="display:none" id="logged-in"><?php echo "1"; ?></span>
              <li id="user-info-li" onclick="showOrHideUserInfo();"><a style="cursor:pointer;"><img src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/user.png" height="20" style="margin-top:-5px;margin-right:7px;"/>Bon Appetit, <?php $sql = "SELECT * FROM `restaurantwebapp`.`accounts` WHERE `user_id` = ".$_SESSION["user_id"].";";
                            if($res = $conn->query($sql)){
                                while($obj = $res->fetch_object()){
                                    echo $obj->first_name; 
                                }
                            }
                  ?>!</a>
                  <div class="user-drop-info-wrapper">
                      <div class="user-drop-info" >
                          
                      </div>
                  </div>
              </li>
              <li><a href="logout.php<?php $xpl = explode("/", $_SERVER["PHP_SELF"]); if($xpl[count($xpl)-1] == "order.php" && isset($_POST["restaurant-id"])){echo "?redirectUrl=restaurant.php?id=".urlencode($_POST["restaurant-id"]);} else { echo "?redirectUrl=".urlencode($_SERVER["REQUEST_URI"]); } ?>">Logout</a></li>
              <?php } ?>
          </ul>
          
        </div>
      </div>
    </nav>
          <?php
          }   ?>