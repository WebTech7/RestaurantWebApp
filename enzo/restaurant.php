<?php ob_start(); session_start();
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
require_once("fb.php");
require_once("functions.php");
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
$go = true;
if(isset($_POST["rating"]) && isset($_SESSION["logged_in"]) && ($_SESSION["logged_in"])){
    $go = true;
    $alertMessage = "";
    $rating = addslashes(makeInputSafe($_POST["rating"]));
    $id = addslashes(($_POST["id"]));
    $user_id = $_SESSION["user_id"];
    $reviewcontent = trim(addslashes(makeInputSafe($_POST["reviewcontent"])));
    $summary = substr($reviewcontent, 0, 50);
    if(strlen($reviewcontent) <= 6){
        $go = false;
        if($alertMessage != ""){
            $alertMessage .= "<br />";
        }
        $alertMessage .= "<img src='https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_deny.png' style='margin-top:-4px;' height='14' alt='!' /> The review needs to be longer than 6 characters.";
    }
    if($rating == 0 && $rating < 6){
        $go = false;
        if($alertMessage != ""){
            $alertMessage .= "<br />";
        }
        $alertMessage .= "<img src='https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_deny.png' height='14' style='margin-bottom:4px;' alt='!' /> Please, give a rating.";
    }
    if($go){
        $sql = "INSERT INTO `restaurantwebapp`.`reviews` (`comment_id`, `user_id`, `id`, `gmt_date_time_published`, `summary`, `full_comment`, `rating`) VALUES (NULL, '$user_id', '$id', '2015-01-08 00:00:00', '$summary', '$reviewcontent', '$rating');";
        $conn->query($sql);
    }
}
$errorRestaurantId = 1;  //De boolean die nodig is voor het checken of alles klopt
$restaurantName = "";
$restaurantLogo  = "";
$restaurantCountry  = "";
$restaurantAdres  = "";
$restaurantRating  = "";
$restaurantRatingStars  = "";
$restaurantPhone  = "";
$restaurantCurrency  = "";
$restaurantCategory  = "";
$restaurantDeals  = "";

//$testing ="";  			Deze lines checken waar er iets fout gaat in de code, puur voor testen.
//$testing2 ="";
//$testing3 ="";
//$testing4 ="";
$testing5 = "Json geen error"; //Aangezien ik nog geen valid json heb is deze ervoor om het voor nu goed te laten werken
IF (isset($_GET['id']) ) { 
//$testing = "Id is uit url gehaald";									//Checkt of er een ID is meegegeven
	IF (preg_match("/^[a-zA-Z\-]*$/",$_GET['id']) || true) { 		//Checkt of de ID alleen uit spaties, dashes (-) en letters bestaat.
		//$testing2 = "Id is alleen letters of spaties";
		$restaurantID = $_GET['id']; 						//Geeft de variable de ID waarde mee, zodat je met deze variable de yelp api kan benaderen.
		$json = '{"error": {"text": "One or more parameters are missing in request", "id": "MISSING_PARAMETER", "field": "oauth_consumer_key"}}'; // Hier moet de json output data van de api komen. Ik heb hier nu een standaard foutmelding in gezet die yelps api geeft, omdat we hier ook een check voor nodig hebben. 
		$checkJson = explode('"',$json);
			IF ($checkJson[1] == "error" AND $testing5 == "Json error" ) { // checkt of de json een error heeft gegeven. 
				//$testing3 = "Json geeft een error";
				$errorRestaurantId = 0;
			} 
				ELSE {
					//$testing4 = "Alles ging goed";
					$restaurantName = "All good indeed";

            $url = "http://api.yelp.com/v2/business/";
            $unsigned_url = stripAccents($url . $restaurantID);

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
            //Hier kunnen alle gegevens uit de api in variables gezet worden.

            $restaurantName = $result->name;
            $restaurantLogo  = "";
            $restaurantCountry  = $result->location->display_address[2];
            $restaurantCity = $result->location->city;
            $restaurantAdres  = $result->location->display_address[0];
            $restaurantRating  = $result->rating;
            $restaurantPhone  = '';
            if(isset($result->display_phone)){
                $restaurantPhone  = $result->display_phone;
            }
            $restaurantCurrency  = "";
            $reviewRating = 0;
            $reviewUser = '';
            $reviewExcerpt = '';
                        $restaurantImg = 'http://s3-media3.fl.yelpcdn.com/assets/2/www/img/e98ed5a1460f/brand_guidelines/yelp-2c-outline.png';
            if(isset($result->categories)){
                $restaurantCategory  = $result->categories;
            };
            $restaurantDeals  = "";
            $restaurantRatingImg = $result->rating_img_url;
            $restaurantUrl = $result->url;
            if(isset($result->image_url)){
                $restaurantImg = $result->image_url;
            };
            if(isset($result->reviews[0]->user->name)) {
                $reviewUser = $result->reviews[0]->user->name;
            };
            if(isset($result->reviews[0]->excerpt)){
                $reviewExcerpt = $result->reviews[0]->excerpt;
            };
            if(isset($result->reviews[0]->rating)){
                $reviewRating = $result->reviews[0]->rating;
            }
           


    				}
    	} 
		ELSE 
		{ 
		$errorRestaurantId = 0;
		}

}

ELSE { // Zo niet wordt er een fout waarde gegeven. 
$errorRestaurantId = 0;
}

IF ($errorRestaurantId == FALSE) { // als er dus iets fout is gegaan heeft is $errorRestaurantId false en geeft het een foutmelding
//echo $testing . $testing2 . $testing3 . $testing4 ;
$errorMessage = "Something went wrong";

} IF ($errorRestaurantId == TRUE ){ 
showHeader($restaurantName, false); ?>

    <div class="container-fluid">
      <div class="row result-content-main">
        <div class="col-sm-3 col-md-2 sidebar" id="restaurant-small" style="padding:0;margin:0;">
            <br />
            <div class="information-box">
                <?php echo "<i>" . $restaurantName . "</i> in $restaurantCity"; ?>
            </div>
                <div class="information-box">
                <?php print $restaurantAdres; ?><br />
                <?php print $restaurantCity; ?>, 
                <?php print $restaurantCountry; ?>
                    
            </div>
            <?php if(isset($restaurantPhone) && $restaurantPhone != ""){ ?><div class="information-box">
                <?php print '<a href="callto:'.str_replace(" ","", str_replace("+", "", $restaurantPhone)).'">'.$restaurantPhone."</a>"; ?>
            </div><?php } ?>
            <div class="information-box">
                Categories:
                <?php    if(isset($restaurantCategory) && $restaurantCategory > 0) {
                        $tags = count($restaurantCategory);

                        $cat = $restaurantCategory; 
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
                                    
                }
                else{
                        echo "None ";    
                }; ?>
            </div>
             <div class="information-box" style="padding:0;background:url(http://maps.google.com/maps/api/staticmap?center=51.49,-0.12&zoom=8&size=400x300&sensor=false);height:200px;background-position:center;">
            </div>
 <!-- Enzo -->  <div class='information-box'>
                    <form method="post" action="order.php">
                    <input type="hidden" name="id" value="<?php echo $restaurantID; ?>"/>
                    <input type="Submit" name="submit" value="Would you like to order?">
                    </form>
                </div>
            
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-2 main" style="padding:0;overflow:hidden" id="restaurant-broad">
            <div style="box-shadow: inset 0 -100px 100px -100px #000;;width:100%;padding:200px 15px 15px 15px;color:#FFF;text-shadow:0 0 5px #222;background:<?php
    $json = file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photos.search&text='.urlencode($restaurantName . " food " . $restaurantCity).'&api_key=dea84f665d9878fe3bec4d20219a672c&safe_search=1&format=json&nojsoncallback=1');

$obj = json_decode($json);$photo = ($obj->photos->photo[0]);
    if($photo->id == NULL || $photo->id == ""){
        $json = file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photos.search&text='.urlencode($restaurantName . " restaurant " . $restaurantCity).'&api_key=dea84f665d9878fe3bec4d20219a672c&safe_search=1&format=json&nojsoncallback=1');

$obj = json_decode($json);$photo = ($obj->photos->photo[0]);
    }
    if($photo->id == NULL || $photo->id == ""){
        $json = file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photos.search&text='.urlencode($restaurantName . " " . $restaurantCity).'&api_key=dea84f665d9878fe3bec4d20219a672c&safe_search=1&format=json&nojsoncallback=1');

$obj = json_decode($json);$photo = ($obj->photos->photo[0]);
    }
    if($photo->id == NULL || $photo->id == ""){
        $json = file_get_contents('https://api.flickr.com/services/rest/?method=flickr.photos.search&text='.urlencode($restaurantCity).'&api_key=dea84f665d9878fe3bec4d20219a672c&safe_search=1&format=json&nojsoncallback=1');

$obj = json_decode($json);$photo = ($obj->photos->photo[0]);
    }
    $flickrImageUrl = 'https://farm'.$photo->farm.'.staticflickr.com/'.$photo->server.'/'.$photo->id.'_'.$photo->secret.'_b.jpg';
    if($photo->id != NULL && $photo->id != ""){echo "url($flickrImageUrl);background-size:cover;background-position:center center";} else echo "#f9a364"; ?>;overflow:hidden">
          <?php $imgHeight = 0; if(isset($restaurantImg)){ $imgHeight = 125; ?><div style="float:left;width:<?php echo $imgHeight; ?>px;height:<?php echo $imgHeight; ?>px;background:url(<?php echo $restaurantImg; ?>);background-size:cover;background-position:center;border-radius:3px;border:3px solid #FFF;"></div><?php } ?><div style="margin-top:<?php echo $imgHeight-40; ?>px;"><h1 style="<?php if($imgHeight!=0){ ?>padding-left:10px;<?php } ?>float:left;font-size:39px;"><?php print $restaurantName; ?></h1>
                <div style="float:left;width:200px;margin-top:-11px;margin-left:7px;">
                        <?php
                        $outOfFiveStars = $restaurantRating;
                        $pxWidthOfStar = 30;
                        $pxMarginLeft = 3;
                        for($j=0;$j<5;$j++){
                                    if($j < $outOfFiveStars){
                                        if($outOfFiveStars - $j < 1){
                    ?>
                                        <div style="float:left;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" style="width:<?php echo $pxWidthOfStar; ?>px;" class="star"/></div><div style="position:absolute;z-index:1;width:0;height:0;"><div style="z-index:1;position:relative;width:<?php echo ($outOfFiveStars - $j)*$pxWidthOfStar; ?>px;left:<?php echo ($pxWidthOfStar+$pxMarginLeft)*$j + $pxMarginLeft; ?>px;overflow:hidden;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star" style="width:<?php echo $pxWidthOfStar; ?>px;margin-left:0 !important;"/></div></div>
                                    <?php
                                        } else {
                                    ?>
                                        <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" style="width:<?php echo $pxWidthOfStar; ?>px;" class="star"/></div>
                                    <?php } } else {
                                        ?> <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" style="width:<?php echo $pxWidthOfStar; ?>px;" class="star"/></div> <?php   
                                    } }
                                        ?>
                                    
                        </div></div>
                </div>
            <div id="EnzoLeft" style="padding:10px 10px 0 10px;width:100%;">
            
                <h3 style="margin-bottom:10px;">Reviews:</h3>
                    <?php
    $reviewArray = array();
    if(isset($reviewExcerpt) && $reviewExcerpt != ""){
        $reviewArray[count($reviewArray)] = array("reviewRating" => $reviewRating, "onYelp" => true, "reviewUser" => $reviewUser, "reviewContent" => $reviewExcerpt);
    }
    
    $sql = "SELECT * FROM `reviews` WHERE `id` = '". $_GET["id"]."';";
    if($res = $conn->query($sql)){
        while($row = $res->fetch_object()){
            if($res2 = $conn->query("SELECT * FROM `accounts` WHERE `user_id` = ".$row->user_id.";")){
                while($obj = $res2->fetch_object()){
                    if($obj->uses_name_or_username == 0){
                        $displayName = $obj->first_name . " " . substr($obj->last_name, 0, 1) . ".";
                    } if($obj->uses_name_or_username == 1){
                        $displayName = $obj->username;
                    }
                }
            }
            $reviewArray[count($reviewArray)] =  array("reviewRating" => $row->rating, "onYelp" => false, "reviewUser" => $displayName, "reviewContent" => $row->summary, "reviewContentFull" => $row->full_comment);
        }
    }
    
    for($a=0;$a<count($reviewArray);$a++){ $onYelp = true;
                
                ?>
                <div class="review-wrapper">
                    <div class="review-top">
                        <div class="review-title"><h3 style="margin-top:-18px;"><?php
                        $outOfFiveStars = $reviewArray[$a]["reviewRating"];
                        $pxWidthOfStar = 26;
                        $pxMarginLeft = 3;
                        for($j=0;$j<5;$j++){
                                    if($j < $outOfFiveStars){
                                        if($outOfFiveStars - $j < 1){
                    ?>
                                        <div style="float:left;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" style="width:<?php echo $pxWidthOfStar; ?>px;" class="star"/></div><div style="position:absolute;z-index:1;width:0;height:0;"><div style="z-index:1;position:relative;width:<?php echo ($outOfFiveStars - $j)*$pxWidthOfStar; ?>px;left:<?php echo ($pxWidthOfStar+$pxMarginLeft)*$j + $pxMarginLeft; ?>px;overflow:hidden;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star" style="width:<?php echo $pxWidthOfStar; ?>px;margin-left:0 !important;"/></div></div>
                                    <?php
                                        } else {
                                    ?>
                                        <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" style="width:<?php echo $pxWidthOfStar; ?>px;" class="star"/></div>
                                    <?php } } else {
                                        ?> <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" style="width:<?php echo $pxWidthOfStar; ?>px;" class="star"/></div> <?php   
                                    } }
                                        ?></h3></div>
                        <div class="review-user"><h4><?php print $reviewArray[$a]["reviewUser"]; if($reviewArray[$a]["onYelp"]){echo ' on <a href="'.$restaurantUrl.'">Yelp</a>';} ?></h4></div></div>
                    <div class="review-content"><?php if($reviewArray[$a]["onYelp"]){ print rtrim($reviewArray[$a]["reviewContent"], "...")."... <a href='$restaurantUrl'>Read more</a>"; } else {echo $reviewArray[$a]["reviewContent"];} ?></div>
                </div>
                <?php } ?>
                <?php if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){ ?>                
                    <hr />
                <h3 id="spring-to-here">Have you been here? Share your opinion about it, by writing a review:</h3>
                <form action="#spring-to-here" method="post">
                    <?php if(!$go){echo '<br /><div class="alert alert-danger" role="alert">' . $alertMessage . '</div>';} ?>
                <div class="review-wrapper" style="margin-top:10px;">
                    <div class="review-top">
                        <div class="review-title"><h3 style="margin-top:-18px;"><div style="margin-top:10px;margin-left:2px;zoom:120%;">
                    <input onclick="" type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_<?php if(!$go && $rating >= 1){ echo "full"; } else echo "empty"; ?>.png" id="1" value="1" class="star-large-a first-star-large" /><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_<?php if(!$go && $rating >= 2){ echo "full"; } else echo "empty"; ?>.png" value="2" class="star-large-a" id="2"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_<?php if(!$go && $rating >= 3){ echo "full"; } else echo "empty"; ?>.png" value="3" class="star-large-a" id="3"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_<?php if(!$go && $rating >= 4){ echo "full"; } else echo "empty"; ?>.png" value="4" class="star-large-a" id="4"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_<?php if(!$go && $rating == 5){ echo "full"; } else echo "empty"; ?>.png" value="5" class="star-large-a" id="5"/><input name="rating" type="hidden" id="hidden-rating" value="<?php if(!$go){ echo $rating; } ?>"/>
                            <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>"/>
                </div></h3></div>
                        <div class="review-user"><h4>You are posting as: <i style="font-weight:600;"><?php $sql = "SELECT * FROM `restaurantwebapp`.`accounts` WHERE `user_id` = ".$_SESSION["user_id"].";";
                            if($res = $conn->query($sql)){
                                while($obj = $res->fetch_object()){
                                    if($obj->uses_name_or_username == 0){
                                        echo $obj->first_name . " " . substr($obj->last_name, 0, 1) . ".";
                                    } if($obj->uses_name_or_username == 1){
                                        echo $obj->username;
                                    }
                                }
                            }
                            ?></i></h4></div></div>
                    <textarea class="review-content review-content-textarea" name="reviewcontent" placeholder="Start typing here..."><?php if(!$go){ echo $reviewcontent; } ?></textarea>
                    <button type="submit" class="review-submit"><h4>Post my review!</h4></button>
                    
                </div></form>
                <?php } ?>
                
        </div>
       </div>
      </div>
    </div>
<?php 

} 
ELSE {
?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
		
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo $errorMessage; ?></h1>
			
    <div id="disqus_thread"></div>
    


        </div>
      </div>
    </div>

<?php 

}

?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
     <script src="js/main.js"></script>
  </body>
</html>



