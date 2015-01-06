<?php ob_start(); session_start();
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
require_once("fb.php");

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
            $unsigned_url = $url . $restaurantID;

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
            $restaurantRatingStars  = "";
            $restaurantPhone  = $result->display_phone;
            $restaurantCurrency  = "";
            $restaurantCategory  = $result->categories;
            $restaurantDeals  = "";
            $restaurantRatingImg = $result->rating_img_url;
            $restaurantUrl = $result->url;
            $restaurantImg = $result->image_url;
            $reviewUser = $result->reviews[0]->user->name; 
            $reviewExcerpt = $result->reviews[0]->excerpt;
            $reviewRating = $result->reviews[0]->rating;


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
require_once("functions.php");
showHeader("", false); ?>

    <div class="container-fluid">
      <div class="row result-content-main">
        <div class="col-sm-3 col-md-2 sidebar">
			<p><?php print $restaurantName ?><br /></p>
                <div>
                    <?php
                        $outOfFiveStars = $restaurantRating;
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
                                        ?>
                                
                </div><br />
            <p><br />
                <?php print $restaurantAdres; ?><br />
                <?php print $restaurantCity; ?> <br />
                <?php print $restaurantCountry; ?><br /><br />
                <?php print $restaurantPhone; ?> <br / >
                <?php    if(isset($restaurantCategory)) {
                        $tags = count($restaurantCategory);

                        for($j = 0; $j < $tags; ++$j){
                                echo $restaurantCategory[$j][0];
                                echo " ";
                        }
                }
                else{
                        echo "None ";    
                }; ?>
            </P>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php print $restaurantName ?></h1>
            <div id="EnzoLeft">
				<p> Reviews from Yelp: <br /><br />
                    Review from: <?php print $reviewUser; ?> <br / >
                    User rating: 
                        <div>
                        <?php
                            $pxWidthOfStar = 13;
                            $pxMarginLeft = 3;
                            for($k=0;$k<5;$k++){
                                        if($k < $reviewRating){
                                            if($reviewRating - $k < 1){
                        ?>
                                            <div style="float:left;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div><div style="position:absolute;z-index:1;width:0;height:0;"><div style="z-index:1;position:relative;width:<?php echo ($outOfFiveStars - $k)*$pxWidthOfStar; ?>px;left:<?php echo ($pxWidthOfStar+$pxMarginLeft)*$k + $pxMarginLeft; ?>px;overflow:hidden;"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star" style="margin-left:0 !important;"/></div></div>
                                        <?php
                                            } else {
                                        ?>
                                            <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star"/></div>
                                        <?php } } else {
                                            ?> <div class="star-wrapper"><img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/></div> <?php   
                                        } }
                                            ?>
                                    
                        </div><br /><br />
                    <?php print $reviewExcerpt; ?> <br / >
                    For more reviews and information visit: <a href=<?php print $restaurantUrl; ?>><?php print $restaurantUrl; ?></a> <br / ><br />


					Reviews from our site <br />
					<br />
				</p>
        </div>
        <div id="EnzoRight">
            <img src=<?php print $restaurantImg; ?>>
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



