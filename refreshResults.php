<?php if(!isset($_SESSION)){session_start();}
$servername = "mysql.hostinger.nl";
$username = "u831903280_web7";
$password = "webtech7";
$db = "u831903280_rest";
error_reporting(E_ERROR | E_PARSE);
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
function stripAccents2($stripAccents){
$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
return $str = strtr( $stripAccents, $unwanted_array );
}
function getDistanceHemelsbreed2( $latitude1, $longitude1, $latitude2, $longitude2 )
{  
////    $latitude1 = intval($latitude1);
////    $longitude1 = intval($longitude1);
////    $latitude2 = intval($latitude2);
////    $longitude2 = intval($longitude2);
//    $earth_radius = 6371;
//    $dLat = deg2rad( $latitude2 - $latitude1 );  
//    $dLon = deg2rad( $longitude2 - $longitude1 );  
//    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
//    $c = 2 * asin(sqrt($a));  
//    $d = $earth_radius * $c;  
//    return $d;  
    // Het is nu eigenlijk niet meer hemelsbreed
    return getDistance2($latitude1.",".$longitude1,$latitude2.",".$longitude2);
}

function getLanLon2($address){
  $Address = $address;// moet een straat zijn
  $Address = urlencode($Address);
  $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true&API_key=AIzaSyBcUwbb6V_uVzOGRnne_af0t0YhWC-QpE0";
  $xml = simplexml_load_file($request_url) or die("url not loading");
  $status = $xml->status;
  if ($status=="OK") {
      $Lat = $xml->result->geometry->location->lat;
      $Lon = $xml->result->geometry->location->lng;
  }
 return array("lat" => $Lat, "lon" => $Lon);
 } 

function makeInputSafe2($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}
 function getDistance2($from, $to) {  
     $request_url = file_get_contents(("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=car&API_key=AIzaSyBcUwbb6V_uVzOGRnne_af0t0YhWC-QpE0"));
    $json = json_decode($request_url,true);
    return $json["rows"][0]["elements"][0]["distance"]["value"];
}

function notTooFar2($distance, $from, $to){
    if( $distance >= getDistance2(urlencode($from), urlencode($to)) ){
        return true;
    } else {
        return false;
    }
}
    if(isset($_GET["place"]) && trim($_GET["place"]) != ""){
        $place = makeInputSafe2($_GET["place"]);
         if(!isset($_COOKIE["place"])){
            setcookie("place", $place);
         }
          $_COOKIE["place"] = $place;
    }
    if(isset($_COOKIE["place"])) {
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
//if(isset($_GET["postalcode"]) && isset($_GET["postalcode"]) != ""){
//    $place = $_GET["postalcode"];
//}
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
    $radius_filter = $_GET["radius_filter"];
} else {
    $radius_filter = 40000;
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
if(isset($_GET["postalcode"])){
    $ingegevenPostalcode = $_GET["postalcode"];
} else if(isset($_COOKIE["postal_code"])){
    $ingegevenPostalcode = $_COOKIE["postal_code"];
} else {
    $ingegevenPostalcode = "";
}
$_COOKIE["postal_code"] = $ingegevenPostalcode;
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

//own restaurants
$addressArray = array();
$contentsArray = array();
$contentsArray2 = array();
$ourRestaurants = array();
$sql = "SELECT * FROM `u831903280_rest`.`restaurants`";
$qArray = explode(" ", $q);
if($res = $conn->query($sql)){
    while($row = $res->fetch_object()){
        if((isset($q) && $q != "") || (isset($place) && $place != "")){
            for($d=0;$d<count($qArray);$d++){
                if (($q == "" || ($q != "" && ( preg_match(trim(strtolower('/'.$qArray[$d].'/')), trim(strtolower($row->id))) || trim(strtolower($row->id)) == trim(strtolower($qArray[$d])) ) ) ) ){
                    $go3 = true;
                    for($e=0;$e<count($ourRestaurants);$e++){
                        if(json_decode(json_encode($row), true) == $ourRestaurants[$e]){
                            $go3 = false;
                        }
                    }
                    $categories = json_decode($row->categories,true);
                    if(isset($_GET["kindofrest"]) && !empty($_GET["kindofrest"]) && str_replace(" ","",$_GET["kindofrest"]) != ""){
                        $catKlopt = false;
                        for($e=0;$e<count($categories);$e++){
                            if($_GET["kindofrest"] == $categories[$e]){
                                $catKlopt = true;
                            }
                        }
                        if(!$catKlopt){
                            $go3 = false;
                        }
                    };
                    for($e=0;$e<count($categories);$e++){
                        $categories[$e] = array($categories[$e]);
                    }
//                    var_dump($categories);
                    if($go3){
                        $ourRestaurants[count($ourRestaurants)] = json_decode(json_encode($row), true);
                    }
                }
//                $ourRestaurants[count($ourRestaurants)] = json_decode(json_encode($row), true);
            }
        }
    }
}
//                var_dump($ourRestaurants);
$b=0;
$i=-1;
        for($a=0;$a<( count($result->businesses) + count($ourRestaurants) );$a++){
            $go = true;
            if(count($ourRestaurants) > $b){
                // our own
                $resRating = 1;
                $img = "img/default.png";
                $name = $ourRestaurants[$b]["name"];
                $id = $ourRestaurants[$b]["id"];
                $postalcode = $ourRestaurants[$b]["postal_code"];
                $city = $ourRestaurants[$b]["city"];
                $addressArray[] = $ourRestaurants[$b]["city"]." ".$ourRestaurants[$b]["address_street"] . " " . $ourRestaurants[$b]["address_number"];
                $country_code = $ourRestaurants[$b]["country_code"];
//                $categories = array();
                $review_count = 0;
                $sql = "SELECT * FROM reviews WHERE `id` = '".$ourRestaurants[$b]["id"]."'";
                if($res = $conn->query($sql)){
                    while($row = $res->fetch_object()){
                        $review_count++;
                    }
                }
                $sql = "SELECT * FROM reviews WHERE id = '$id'";
                $review_count = 0;
                $rating_tot = 0;
                if($res = $conn->query($sql)){
                    while($row = $res->fetch_object()){
                        $review_count++;
                        $rating_tot += $row->rating;
                    }
                }
                if($ourRestaurants[$b]["yelp"] == "Y"){
                     $url = "http://api.yelp.com/v2/business/";
            $unsigned_url = stripAccents2($url . urlencode($ourRestaurants[$b]["yelp_id"]));
            // Enter the path that the oauth library is in relation to the php file
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
            $result2 = json_decode($json_string);//var_dump($result);
                    $review_count += $result2->review_count;
                    $rating_tot += $result2->review_count * $result2->rating;
                    
                if(isset($result2->businesses[$i]->image_url) && $result2->businesses[$i]->image_url != ""){ $img = $result2->businesses[$i]->image_url; } else { $img = "img/default.png"; }
                }
                $rating1 = $rating_tot / $review_count;
                $orders = $ourRestaurants[$b]["online_orders"];
                $address_street = $ourRestaurants[$b]["address_street"];
                $orderWithYou = false;
                $distance = $ourRestaurants[$b]["distance"] * 1000;
                if(preg_match(trim(strtolower('/'.$place.'/')), trim(strtolower($city))) || trim(strtolower($city)) == trim(strtolower($place)) || str_replace(" ", "", trim(strtolower($postal_code))) == str_replace(" ", "", trim(strtolower($place)))){
                    $go = true;
                }
                $lanLon1 = getLanLon2($place);
                $lanLon2 = getLanLon2($address_street . " $city " . $country_code);
                if(getDistanceHemelsbreed2($lanLon1["lat"], $lanLon1["lon"], $lanLon2["lat"], $lanLon2["lon"]) <= $radius_filter && (getDistanceHemelsbreed2($lanLon1["lat"], $lanLon1["lon"], $lanLon2["lat"], $lanLon2["lon"]) != 0 || $lanLon1["lat"].",".$lanLon1["lon"] == $lanLon2["lat"].",".$lanLon2["lon"])){
                    $go = true;
                } else {
                    $go = false;
                }
                if($order == "" || $order == "no"){
                    $go8 = true;
                } else if($order == "order") {
                    if($orders == "Y"){
                        if(notTooFar2(str_replace(" ", "", $distance), str_replace(" ", "", $postalcode), str_replace(" ", "", $ingegevenPostalcode)) && (getDistance2(str_replace(" ", "", $postalcode), str_replace(" ", "", $ingegevenPostalcode)) != 0 || str_replace(" ", "", $postalcode) == str_replace(" ", "", $ingegevenPostalcode)) && str_replace(" ", "", $distance) != "" && str_replace(" ", "", $postalcode) != "" && str_replace(" ", "", $ingegevenPostalcode) != ""){
                            $go8 = true;
                            $orderWithYou = true;
                        } else {
                            $go8 = false;
                        }
                    } else {
                        $go8 = false;
                    }
                } else {
                    $go8 = true;
                }
                $b++;
                if(!$go8){
                    $go = false;
                }
            } else {
                // yelp
                if($order == "" || $order == "no"){
                    $go = true;
                }
                $i++;
                if(isset($result->businesses[$i]->image_url) && $result->businesses[$i]->image_url != ""){ $img = $result->businesses[$i]->image_url; } else { $img = "img/default.png"; }
                if($order == "order"){$go = false;}
                $name = $result->businesses[$i]->name;
                $city = $result->businesses[$i]->location->city;
                $review_count = $result->businesses[$i]->review_count;
                $rating1 = $result->businesses[$i]->rating;
                $id = urlencode($result->businesses[$i]->id);
                $addressArray[] = (addslashes($result->businesses[$i]->location->city." ".$result->businesses[$i]->location->display_address[0]));
                if(isset($result->businesses[$i]->categories)){
                    $categories = $result->businesses[$i]->categories;
                } else {
                    $categories = array();
                }
                $orders = "N";
                for($y=0;$y<count($ourRestaurants);$y++){
                    if($ourRestaurants[$y]["yelp_id"] == $id){
                        $go = false;
                    }
                }
                    for($e=0;$e<count($ourRestaurants);$e++){
                        if($ourRestaurants[$e]["yelp_id"] == $id){
                            $go = false;
                        }
                    }
            }
            if(((isset($result->businesses[$i]->rating) && $i != -1 && $rating <= $rating1) || ($i == -1 && $rating <= $rating1)) && $go){
                      
//                echo getDistanceHemelsbreed2($lanLon1["lat"], $lanLon1["lon"], $lanLon2["lat"], $lanLon2["lon"]);
//                echo $radius_filter
                $countBoxes++;
                $firstRow = '';
                $firstRow .= $city; $cat = $categories; if(count($cat) != 0){$firstRow.= " | ";}
                for($j=0;$j<count($cat);$j++){
                    $categorie = $cat[$j][0];
                    if($j == 0){
                        $firstRow .= $categorie;
                    } else if($j + 1 == count($cat)){
                        $firstRow .= " & " . $categorie;
                    } else {
                        $firstRow .= ", " . $categorie;
                    }
                }
                $outOfFiveStars = $rating1;
                $pxWidthOfStar = 13;
                $pxMarginLeft = 3;
                $starsstring = '';
        for($j=0;$j<5;$j++){
                                    if($j < $outOfFiveStars){
                                        if($outOfFiveStars - $j < 1){
                $starsstring .= '<div style="float:left;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div><div style="position:absolute;z-index:1;width:0;height:0;"><div style="z-index:1;position:relative;width:'.(($outOfFiveStars - $j)*$pxWidthOfStar).'px;left:'.(($pxWidthOfStar+$pxMarginLeft)*$j + $pxMarginLeft).'px;overflow:hidden;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star" style="margin-left:0 !important;"/></div></div>';
                                        } else { $starsstring .= '<div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star"/></div>'; } } else {
                                        $starsstring .= '<div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div>';
                                    } }
                                        $starsstring .= "</div>";
                $starsstring = '';//addslashes($starsstring);
                $s = '';
                if($review_count == 1){$s = " review";} else {$s = " reviews";}
                $contentsArray[] = htmlentities("<a target=_parent href=restaurant.php?id=$id >".addslashes($name)."<br />");
                $contentsArray2[] = htmlentities(addslashes("</a>$firstRow<br />Rating: $rating1 out of 5 <br />$review_count $s"));
            ?>
                    <div class="col-lg-6">
                        <div class="result-box" onclick="showCatWaitingOnIndex(<?php echo "'".addslashes($name)."','".addslashes($city)."'"; ?>);document.location.href='restaurant.php?id=<?php echo $id; ?>';">
                            <div class="result-image" style="background:url(<?php echo $img; ?>) #82CCEC;background-size:cover;background-position:center;"></div>
                            <div class="result-content result-content-search">
                                <div style="overflow:hidden;"><h4 style="height:20px;overflow:auto;"><?php echo $name;
//                echo $lanLon1["lat"] . "|" . $lanLon1["lon"]."/".$lanLon2["lat"] . "|" . $lanLon2["lon"];echo "abc";
//                echo getDistanceHemelsbreed2($lanLon1["lat"], $lanLon1["lon"], $lanLon2["lat"], $lanLon2["lon"]);
 ?></h4></div>
                                <div style="overflow:hidden"><p class="description-short" style="overflow:auto !important;">
                                    <?php echo $city; $cat = $categories; if(count($cat) != 0){echo " | ";}
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
                if($orders == "Y"){
                    if(!$orderWithYou){
                        $titleA = "This restaurant delivers food.";
                    } else {
                        $titleA = "This restaurant delivers food at $ingegevenPostalcode.";
                    }
                    echo '<a title="'.$titleA.'"><img src="https://cdn2.iconfinder.com/data/icons/windows-8-metro-style/128/delivery_food.png" height="15" class="orders-icon" /></a>';
                }
                
                                ?><br />
                                </p></div>
                                <div style="float:left;margin-top:15px;">
                                    <p><?php echo $review_count; if($review_count == 1){echo " review";} else {echo " reviews";} ?> &bull;</p></div>
                                <div style="overflow:hidden;"><div style="float:left;margin-left:-10px;overflow:auto;margin-top:15px;width:80px;display:none" class="star-text-wrap">
                                    <p><?php echo round(($rating1*2) ,1); ?>/10</p>
                                    </div></div>
                                    <div style="overflow:hidden;"><div style="float:left;margin-left:3px;overflow:auto;width:100px;" class="star-pics-wrap">
                                    <?php
        $outOfFiveStars = $rating1;
        $pxWidthOfStar = 13;
        $pxMarginLeft = 3;
//                var_dump(getDistanceHemelsbreed2(getLanLon2($place)["lat"], getLanLon2($place)["lon"], getLanLon2($postalcode . " " . $country_code)["lat"], getLanLon2($postalcode . " " . $country_code)["lon"]));
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
                                        ?></div></div>

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
<div id="map" style="display:none;background:#f5f5f5;">
    <iframe id="map-iframe" style="border:none;" width="100%" height="100%" src="mapsiframe.php"></iframe>
</div>
<span style="display:none;" id="current-q"><?php echo $q; ?></span>
<span style="display:none;" id="addresses-json-results"><?php echo (json_encode($addressArray)); $_SESSION["addresses-json-results"] = json_encode($addressArray); ?></span>
<span style="display:none;" id="contents-json-results"><?php echo (json_encode($contentsArray)); $_SESSION["contents-json-results"] = json_encode($contentsArray); ?></span>
<span style="display:none;" id="contents2-json-results"><?php echo (json_encode($contentsArray2)); $_SESSION["contents2-json-results"] = json_encode($contentsArray2); ?></span>
<span style="display:none" id="amount-results-dont-show"><?php echo $countBoxes; ?></span>
