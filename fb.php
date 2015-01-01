<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once( 'fb/src/Facebook/FacebookSession.php' );
use Facebook\FacebookSession;

require_once( 'fb/src/Facebook/FacebookRedirectLoginHelper.php' );
use Facebook\FacebookRedirectLoginHelper;

require_once( 'fb/src/Facebook/FacebookSDKException.php' );
use Facebook\FacebookSDKException;

FacebookSession::setDefaultApplication('1033735633321196 ', '9639ebd18b9a0370c538c7f1aefb670f');
 
$helper = new FacebookRedirectLoginHelper();
try {
  $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
  echo "error 1";
} catch(\Exception $ex) {
  echo "error 2";
}
if ($session) {
 echo "Logged in";
}

use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

if($session) {

  try {

    $user_profile = (new FacebookRequest(
      $session, 'GET', '/me'
    ))->execute()->getGraphObject(GraphUser::className());

    echo "Name: " . $user_profile->getName();

  } catch(FacebookRequestException $e) {

    echo "Exception occured, code: " . $e->getCode();
    echo " with message: " . $e->getMessage();

  }   

}echo "hey";
?>