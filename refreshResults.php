<?php

function makeInputSafe2($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

    if(isset($_GET["place"]) && $_GET["place"] != ""){
        $place = makeInputSafe2($_GET["place"]);
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
    if(isset($_GET["q"]) && $_GET["q"]!=""){
        $q = makeInputSafe2($_GET["q"]);
        setcookie("q", $q);
        if(trim($q) != ""){
            $title = $q . " | " . $place;
        } else {
            $_COOKIE["q"] = $q;
        }
    } else {
        $q = $_COOKIE["q"];
    }

if(isset($_GET["useq"])){
    $q = makeInputSafe2($_GET["q"]);
    setcookie("q", $q);
}
if(isset($_GET["usecookieget"]) && $_GET["usecookieget"] == 1 && isset($_COOKIE["get"])){
    $get = $_COOKIE["get"];
} else {
$get = "&term=restaurant ".urlencode($q);
setcookie("get", $get);
}
if(isset($_GET["sort"]) && trim($_GET["sort"]) != ""){
    $get .= "&sort=".urlencode($_GET["sort"]);
}
if(isset($_GET["radius_filter"]) && trim($_GET["radius_filter"]) != ""){
    $get .= "&radius_filter=".urlencode($_GET["radius_filter"]);
}
if(isset($_GET["rating"]) && trim($_GET["rating"]) != ""){
    $rating = $_GET["rating"];
} else {
    $rating = 0;
}
if(!isset($_COOKIE["get"])){
    setcookie("get", $get);
}
if(!isset($_COOKIE["get"])){
    setcookie("get", $get);
}
$_COOKIE["get"] = $get;
$url = "http://api.yelp.com/v2/search?$get&location=";
$unsigned_url = $url . $place;
echo '<script>$(document).prop("title", '.$title.');</script>';
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
        $result = json_decode($json_string);
        $countBoxes = 0;
        for($i=0;$i<count($result->businesses);$i++){
            if($rating <= $result->businesses[$i]->rating){
                $countBoxes++;
            if($i % 2 == 0){
                ?><div class="row"><?php
            }
        ?>
                    <div class="col-lg-6">
                        <div class="result-box" onclick="document.location.href='restaurant.php?id=<?php echo $result->businesses[$i]->id; ?>';">
                            <div class="result-image" style="background:url(<?php if($result->businesses[$i]->image_url != ""){ echo $result->businesses[$i]->image_url; } else { echo "https://cdn0.iconfinder.com/data/icons/kameleon-free-pack-rounded/110/Food-Dome-128.png"; } ?>) #FFF;background-size:cover;background-position:center;"></div>
                            <div class="result-content">
                                <h4 style="height:20px;overflow:hidden;"><?php echo $result->businesses[$i]->name;
 ?></h4>
                                <p class="description-short">
                                    <?php echo $result->businesses[$i]->location->city; $cat = $result->businesses[$i]->categories; if(count($cat) != 0){echo " | ";}
                                    for($j=0;$j<count($cat);$j++){
                                        $categorie = $cat[$j][0];
                                        if($j == 0){
                                            echo $categorie;
                                        } else if($j + 1 == count($cat)){
                                            echo " & " . $categorie;
                                        } else {
                                            echo ", " . $categorie;
                                        }
                                    }
                                    ?><br />
                                </p>
                                <div style="float:left;margin-top:15px;">
                                    <p><?php $review_count = $result->businesses[$i]->review_count; echo $review_count; if($review_count == 1){echo " review";} else {echo " reviews";} ?> &bull;</p></div>
                                    <div style="float:left;margin-left:17px;width:100px;overflow:hidden">
                                    <?php
        $outOfFiveStars = $result->businesses[$i]->rating;
        $pxWidthOfStar = 13;
        $pxMarginLeft = 3;
        for($j=0;$j<5;$j++){
                                    if($j < $outOfFiveStars){
                                        if($outOfFiveStars - $j < 1){
                                            ?>
                                        <div style="float:left;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div><div style="position:absolute;z-index:1;width:0;height:0;"><div style="z-index:1;position:relative;width:<?php echo ($outOfFiveStars - $j)*$pxWidthOfStar; ?>px;left:<?php echo ($pxWidthOfStar+$pxMarginLeft)*$j + $pxMarginLeft; ?>px;overflow:hidden;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star" style="margin-left:0 !important;"/></div></div>
                                    <?php
                                        } else {
                                    ?>
                                        <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star"/></div>
                                    <?php } } else {
                                        ?> <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div> <?php   
                                    } }
                                        ?></div>
                                
                        </div>
                            
                            </div>
                        <?php
                        if($i % 1 == 0){
                ?></div><?php } } }
if($countBoxes == 0){
    ?>
<div style="width:calc(100% - 20px);background:#f5bb4d;margin:20px;padding:10px;border-radius:5px;"><h4>No results found.<br /><br />Suggestions:<br /><ul><li>Make sure everything is spelled right.</li><li>Be more general.</li></ul></h4></div>
<?php
}
?>
                
                    </div>
<span style="display:none;" id="current-q"><?php echo $q; ?></span>