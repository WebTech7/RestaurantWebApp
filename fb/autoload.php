<?php
FacebookSession::setDefaultApplication('1033735633321196 ', '9639ebd18b9a0370c538c7f1aefb670f');
$helper = new FacebookRedirectLoginHelper('index.php');
$loginUrl = $helper->getLoginUrl();
// Use the login url on a link or button to redirect to Facebook for authentication
$helper = new FacebookRedirectLoginHelper();
try {
  $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
  echo "hey";
} catch(\Exception $ex) {
  echo "hey";
}
if ($session) {
  echo "hey";
} 
    
    ?>s