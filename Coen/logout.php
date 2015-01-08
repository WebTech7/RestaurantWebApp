<?php 
session_start();
require("lib/autoload.php");

require("lib/facebook.php");

$host = "http://localhost:8000/RestaurantWebApp/";
$app_id = "1033735633321196";
$app_secret = "9639ebd18b9a0370c538c7f1aefb670f";
$redirecturl = $host . "";

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
use Facebook\FacebookThrottleException;
use Facebook\GraphLocation;
use Facebook\GraphPage;
use Facebook\GraphUserPage;

$facebook = new Facebook(array(
    'appId'  => $app_id,
    'secret' => $app_secret
)); 

$token = $facebook->getAccessToken();
$url = 'https://www.facebook.com/logout.php?next=' . $redirecturl .
  '&access_token='.$token;
session_destroy();
header('Location: '.$_SERVER["HTTP_REFERER"]);
?>a