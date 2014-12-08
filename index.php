<?php ob_start();
function checkIfPostalCode($postcode){
    $remove = str_replace(" ","", $postcode);
    $upper = strtoupper($remove);

    if(preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return $upper;
    } else {
        return false;
    }
}
function checkIfsearchQuery($query){    
    if(trim($query)!='') {
        return true;
    } else {
        return false;
    }
}
if(!isset($_GET['postalCode']) && !isset($_GET["searchQuery"])){
    header("Location: postalCode.php");
} else if(!checkIfPostalCode($_GET['postalCode']) && !isset($_GET["searchQuery"])){
        header("Location: postalCode.php?error=1");
    } else if(!checkIfsearchQuery($_GET['searchQuery']) && (!checkIfPostalCode($_GET['postalCode']) || !isset($_GET["postalCode"])) ) {
        header("Location: postalCode.php?error=2");
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
                      <select class="form-control" name="kind-of-rest" id="kind-of-rest">
                          <option>Select a type</option>
                          <option>Fast food</option>
                          <option>Italian</option>
                          <option>Chinese</option>
                          <option>Dutch</option>
                      </select><br />
                </div>
                <label for="radius"><p>
                    Do you want to order?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="radius" id="radius">
                            <option>Select an answer</option>
                            <option>Yes</option>
                            <option>No</option>
                    </select>
                </div><br />
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
                    <input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" id="1" value="1" class="star-large" />
                    <input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="2" class="star-large" id="2"/>
                    <input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="3" class="star-large" id="3"/>
                    <input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="4" class="star-large" id="4"/>
                    <input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="5" class="star-large" id="5"/>
                </div>
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main results">
            <div class="header"><h3>Results for <?php echo $postalCode ?></h3><div style="right:30px;" class="something-absolute"><div class="something-0"><div class="sort-by-div">
                <label for="sort-by" >Sort by:</label>
                <select class="form-control" name="sort-by">
                    <option>Best reviews</option>  
                    <option>Newest</option>
                </select>
                </div></div></div></div>
            <div class="result-content-wrapper">
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
                                <div style="float:left;margin-top:15px;">
                                    <p>1 review &bull;</p></div>
                                    <div style="float:left;margin-left:17px;width:100px;overflow:hidden">
                                    <?php
        $outOfFiveStars = 3.45;
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
                var fullSrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_full.png';
                this.src = fullSrc;
                for(a=0;a<$(this).val();a++){
                    $("#"+a+"").attr("src", fullSrc);
                }
            }, function(){
                var emptySrc = 'https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png';
                this.src = emptySrc;
                for(a=0;a<$(this).val();a++){
                    $("#"+a+"").attr("src", emptySrc);
                }
            });
        </script>
  </body>
</html>
<?php
}
    ?>