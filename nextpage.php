<!DOCTYPE html>
<html lang="en">


  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

    
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php
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
	IF (preg_match("/^[a-zA-Z\-]*$/",$_GET['id'])) { 		//Checkt of de ID alleen uit spaties, dashes (-) en letters bestaat.
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
					$restaurantName = "All good indeed";									//Hier kunnen alle gegevens uit de api in variables gezet worden.
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

}
?>


  </head>

  <body>
<?php IF ($errorRestaurantId == TRUE ){ ?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">OurEatingsitesName</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Home</a></li>
            <li><a href="#">References</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
			<p>Hier kan de rating <br /> naam<br /> locatie<br /> etc van het restaurant komen.</P>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Restaurant name</h1>
				<p> Hier kan bijvoorbeeld het menu, het logo, de reviews en een map komen. <br />
					Ik weet alleen niet wat er allemaal uit de api gehaald kan worden, dus dit kon ik nog niet precies indelen. <br />
					Ik heb al wel een stel variable waarvan ik vermoed dat ze er in staan boven aan het document leeg gezet. <br />
				</p>



        </div>
      </div>
    </div>
<?php 

} 
ELSE {
?>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">OurEatingsitesName</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Home</a></li>
            <li><a href="#">References</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
		
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header"><?php echo $errorMessage; ?></h1>
			



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
  </body>
</html>



