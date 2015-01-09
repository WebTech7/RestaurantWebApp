<?php
if(!isset($_SESSION)) {
    session_start();
} 
require("lib/autoload.php");

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

FacebookSession::setDefaultApplication($app_id, $app_secret);

$helper = new FacebookRedirectLoginHelper($redirecturl);

try {
  $session = $helper->getSessionFromRedirect();
  //var_dump($session);
} catch(FacebookRequestException $ex) {
} catch(\Exception $ex) {
}
if ($session) {
    //var_dump($session);
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    $grap = $response->getGraphObject(GraphUser::classname());
    $username=$grap->getName();
    $fbLoggedIn = true;
} else {
    $fbLoggedIn = false;
}

?>