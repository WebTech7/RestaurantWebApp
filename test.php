

<?php
$search = $_POST["name"];
$url = "http://api.yelp.com/v2/search?term=food&limit=10&location=";
$unsigned_url = $url . $search;

// Enter the path that the oauth library is in relation to the php file
require_once('/OAuth.php');
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
        $result = json_decode($json_string);

// Print it for debugging
echo '<ol>';
//print_r($result); 
for($i = 0; $i < count($result->businesses); ++$i){
        $business = $result->businesses[$i];
        $businessID = $business->id;

        echo "<li>";
        echo $business->name;
        echo "<br>";
        echo "rating: " . $business->rating;
        echo "<br>";
        echo "Number of reviews: " . $business->review_count;
        echo "<br>";
        echo "tags: ";
                if(isset($business->categories)) {
                        $tags = count($business->categories);

                        for($j = 0; $j < $tags; ++$j){
                                echo $business->categories[$j][0];
                                echo " ";
                        }
                }
                else{
                        echo "None ";    
                };
        echo "<br>";
        echo "<a href=" . $business->url . ">" . $business->url . "</a>";
        echo "<br>";
        echo "phone: " . $business->display_phone;
        echo "<br>";
        echo $business->location->display_address[0];
        echo "<br>";
        echo $business->location->display_address[1];
        echo "<br>";
        echo $business->location->display_address[2];
        echo "</li>";
        echo "<br>";
        };
echo ' </ol>';

?>