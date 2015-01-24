<?php
$unsigned_url = "http://api.yelp.com/v2/search?".$_SERVER['QUERY_STRING']."&sort=1";
// Enter the path that the oauth library is in relation to the php file
require_once('OAuth.php');
// Set your OAuth credentials here
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
$consumer_key = 'i7bZJazfcVtcYOVQMiiiDQ';
$consumer_secret = 'DYZf-xFkSU0oSYvd_p9GuoKrDrY';
$token = 'sbOK5g3X_9JiYjIibXPOPB9aN9yh4GKR';
$token_secret = 'oViN5ngntd0Ctb2qeAcwKd9fAOM';
$token = new OAuthToken($token, $token_secret);

$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

$oauthrequest->sign_request($signature_method, $consumer, $token);

$signed_url = $oauthrequest->to_url();

$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);

$data = curl_exec($ch);
curl_close($ch);

$response = json_decode($data);
$json_string = file_get_contents($signed_url);
$result = json_decode($json_string,true);

if(count($result["businesses"]) == 0){
    die( "<p>No matching restaurants found on Yelp. Please check your data again.</p>" );
}
?>

<label for=yelpId>Choose your restaurant from Yelp:</label><br />
<select class="form-control" id=yelpId name=yelpId style="width:300px;max-width:100%;">
    <?php
$a=0;
for($a=0;$a<count($result["businesses"]);$a++){
    echo "<option value='".$result[businesses][$a][id]."'>".$result["businesses"][$a]["name"]." ".$result["businesses"][$a]["city"]."</option>";
}

?>
</select>