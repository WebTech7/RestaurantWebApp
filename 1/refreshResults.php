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
        if(isset($_COOKIE["q"])){
            $q = $_COOKIE["q"];
        } else {
            $q = "";    
        }
    }
$get = "";
if(isset($_GET["useq"])){
    $q = makeInputSafe2($_GET["q"]);
    setcookie("q", $q);
}
if(isset($_GET["usecookieget"]) && $_GET["usecookieget"] == 1 && isset($_COOKIE["get"])){
    $get = $_COOKIE["get"];
} else {
    if(!(isset($_GET["kindofrest"]) && trim($_GET["kindofrest"]) != "")){
    $get = trim("&term=restaurants ".urlencode($q));
    setcookie("get", $get);
 }
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
if(isset($_GET["order"]) && trim($_GET["order"]) != ""){
    $order = $_GET["order"];
} else {
    $order = "niks";
}
 if(isset($_GET["kindofrest"]) && trim($_GET["kindofrest"]) != ""){
    $get .= "&radius_filter=40000&category_filter=".strtolower(urlencode($_GET["kindofrest"]));
 }
if(!isset($_COOKIE["get"])){
    setcookie("get", $get);
}
if(!isset($_COOKIE["get"])){
    setcookie("get", $get);
}
$_COOKIE["get"] = $get;
$url = "http://api.yelp.com/v2/search?$get&location=";
$unsigned_url = $url . urlencode($place);
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
        $countBoxes = 0;echo "<div id='list'><div class='row'>";
        for($i=0;$i<count($result->businesses);$i++){
            $go = false;
            if($order == ""){
                $go = true;
            } else if($order == "orderorpickup") {
                $go = false;
            } else if($order == "order") {
                $go = false;
            } else if($order == "pickup") {
                $go = false;
            } else if($order == "no") {
                $go = true;
            } else {
                $go = true;
            }
            if($rating <= $result->businesses[$i]->rating && $go){
                $countBoxes++;
            ?>
                    <div class="col-lg-6">
                        <div class="result-box" onclick="document.location.href='restaurant.php?id=<?php echo $result->businesses[$i]->id; ?>';">
                            <div class="result-image" style="background:url(<?php if(isset($result->businesses[$i]->image_url) && $result->businesses[$i]->image_url != ""){ echo $result->businesses[$i]->image_url; } else { echo "https://cdn4.iconfinder.com/data/icons/home-sweet-home-2/120/cafe-512.png"; } ?>) #FFF;background-size:cover;background-position:center;"></div>
                            <div class="result-content result-content-search">
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
                                    <div style="float:left;margin-left:3px;width:100px;overflow:hidden">
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

                        </div></div>
                            </div>
                        <?php
                         } }
if($countBoxes == 0){
    ?>
<div style="width:calc(100% - 40px);color:#FFF;background:#f5bb4d;margin:30px 20px 0 20px;padding:25px;border-radius:5px;"><div class="row"><div style="float:left;width:100px;"><img alt="Not found" src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678069-sign-error-256.png" width="100%"/></div><div style="padding-left:20px;float:left;width:calc(100% - 100px);"><h4 style="font-weight:normal;">No results found.<br /><br />Suggestions:<br /><ul style="margin-top:5px;margin-bottom:0;"><li>Make sure everything is spelled right.</li><li>Be more general.</li></ul></h4></div></div></div>
<?php
}
?>
                </div>
                    </div>
<span style="display:none;" id="current-q"><?php echo $q; ?></span>
<div id="map" style="display:none;background:green;">
    <div id="googleMap" style="width:100%;height:100%;"></div>
</div>
