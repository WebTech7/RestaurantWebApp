<?php ob_start();
function checkIfPostalCode($postcode){
    $remove = str_replace(" ","", $postcode);
    $upper = strtoupper($remove);

    if( preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return $upper;
    } else {
        return false;
    }
}
if(!isset($_GET['postalCode'])){
    header("Location: postalCode.php");
} else if(!checkIfPostalCode($_GET['postalCode'])){
        header("Location: postalCode.php?error=1");
    } else {
    $postalCode = strtoupper($_GET['postalCode']);
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Restaurant Info, Reviews and Orders">
    <meta name="author" content="WebTech7">

    <title>RestaurantWebApp</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="postalcode.php">RestaurantWebApp</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="postalcode.php">Front Page</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search for restaurants">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar specify">
            <div class="header">
                <h3>
                    Specify
                </h3>
            </div>
            <div class="specify-content">
                <label for="kind-of-rest"><p>
                    What kind of restaurant are you looking for?
                    </p></label>
                <div class="specify-option-content">
                      <select class="form-control"name="kind-of-rest" id="kind-of-rest">
                          <option>Select a type</option>
                          <option>Fast food</option>
                          <option>Italian</option>
                          <option>Chinese</option>
                          <option>Dutch</option>
                      </select><br />
                </div>
                <label for="radius"><p>
                    In what radius do you want to search?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="radius" id="radius">
                        <option>Select a radius</option>  
                        <option>2 km</option>
                          <option>5 km</option>
                          <option>10 km</option>
                          <option>25 km</option>
                            <option>50 km</option>
                      </select><br />
                </div>
                <label for="min-rating"><p>
                    Minimum rating:</p></label><br />
                <div class="specify-option-content">
                    <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star-large"/>
                    <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star-large"/>
                    <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star-large"/>
                    <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star-large"/>
                    <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star-large"/>
                </div>
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main results">
            <div class="header"><h3>Results for <?php echo $postalCode ?></h3></div>
            <div class="result-content">
                        <?php
        for($i=0;$i<15;$i++){
            if($i % 2 == 0){
                ?><div class="row"><?php
            }
        ?>
                    <div class="col-lg-6">
                        <div class="result-box">
                            <div class="result-image" style="background:url(http://www.foodnavigator-usa.com/var/plain_site/storage/images/publications/food-beverage-nutrition/foodnavigator-usa.com/regulation/subway-removing-controversial-dough-conditioner-baking-expert-deems-ingredient-unnecessary/8754193-1-eng-GB/Subway-removing-controversial-dough-conditioner-baking-expert-deems-ingredient-unnecessary.jpg);background-size:cover;background-position:center;"></div>
                            <div class="result-content">
                                <h4>Subway</h4>
                                <p class="description-short">
                                    Some description...
                                </p>
                                <p class="reviews-short">
                                    1 review &bull;<span style="font-size:8px;">&nbsp;</span>
                                    <?php
        $outOfFiveStars = 4;
        for($j=0;$j<5;$j++){
                                    if($j < $outOfFiveStars){
                                    ?>
                                    <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png" class="star"/>
                                    <?php } else {
                                     ?> <img src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" class="star"/> <?php   
                                    } }
        ?>
                                </p>
                            </div>
                        </div>
                        <?php
                        if($i % 1 == 0){
                ?></div><?php } } ?>
                    
            </div>
        </div>
      </div>
    </div>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
        <script>
            $(".star-large").hover(function(){
                this.src = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png'; 
            }, function(){
                this.src = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';    
            });
        </script>
  </body>
</html>
<?php
}
    ?>