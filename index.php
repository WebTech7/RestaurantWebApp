<?php
ob_start();session_start();
require_once("functions.php");
if(!isset($_GET["place"]) && !isset($_COOKIE["place"])){
    header("Location: postalcode.php");
} else if((!isset($_GET["place"]) || trim($_GET["place"]) == "" ) && (!isset($_COOKIE["place"]) || trim($_COOKIE["place"]) == "") ) {
    header("Location: postalcode.php?error=2");
} else {
    if(isset($_GET["place"])){
    $place = makeInputSafe($_GET["place"]);
    setcookie("place", $place);
    }
    $place = makeInputSafe($_COOKIE["place"]);
    $title = $place;
    if(isset($_GET["q"])){
        $q = makeInputSafe($_GET["q"]);
        setcookie("q", $q);
        if(trim($q) != ""){
            $title = $q . " | " . $place;
        }
    } else {
        $q = $_COOKIE["q"];
    }
    $_COOKIE["get"] = "";
    if(isset($_GET["place"]) || isset($_GET["q"])){
        header("Location: index.php");
    }
    showHeader($title, true);
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar specify" id="specify">
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
                          <option value="">No preference</option>
<option value="Afghan">Afghan</option>
<option value="African">African</option>
<option value="American">American</option>
<option value="Arabian">Arabian</option>
<option value="Argentine">Argentine</option>
<option value="asianfusion">Asian Fusion</option>
<option value="Australian">Australian</option>
<option value="Austrian">Austrian</option>
<option value="Bangladeshi">Bangladeshi</option>
<option value="Barbeque">Barbeque</option>
<option value="Basque">Basque</option>
<option value="beerhall">Beer Hall</option>
<option value="Belgian">Belgian</option>
<option value="Bistros">Bistros</option>
<option value="Brasseries">Brasseries</option>
<option value="breakfast_brunch">Breakfast &amp; brunch</option>
<option value="British">British</option>
<option value="Buffets">Buffets</option>
<option value="Burgers">Burgers</option>
<option value="Burmese">Burmese</option>
<option value="Cafes">Cafes</option>
<option value="Cafetaria">Cafetaria</option>
<option value="Cajun">Cajun</option>
<option value="Cambodian">Cambodian</option>
<option value="Caribbean">Caribbean</option>
<option value="Cheesesteaks">Cheesesteaks</option>
<option value="Chech">Chech</option>
<option value="Chinese">Chinese</option>
<option value="Creperies">Creperies</option>
<option value="Cuban">Cuban</option>
<option value="Delis">Delis</option>
<option value="Diners">Diners</option>
<option value="Ethiopian">Ethiopian</option>
<option value="hotdogs">Fast Food</option>
<option value="Filipino">Filipino</option>
<option value="fishnchips">Fish &amp; Chips</option>
<option value="Fondue">Fondue</option>
<option value="French">French</option>
<option value="Gastropubs">Gastropubs</option>
<option value="German">German</option>
<option value="Giblets">Giblets</option>
<option value="fluten_free">Gluten-free</option>
<option value="Greek">Greek</option>
<option value="Halal">Halal</option>
<option value="Hawaiian">Hawaiian</option>
<option value="Himalayan">Himalayan</option>
<option value="hotdog">Hot Dogs</option>
<option value="Hungarian">Hungarian</option>
<option value="Indian">Indian</option>
<option value="Indonesian">Indonesian</option>
<option value="Irish">Irish</option>
<option value="Italian">Italian</option>
<option value="Japanese">Japanese</option>
<option value="Korean">Korean</option>
<option value="Kosher">Kosher</option>
<option value="Laotian">Laotian</option>
<option value="Lebanese">Lebanese</option>
<option value="raw_food">Live/Raw Food</option>
<option value="Malaysian">Malaysian</option>
<option value="Mediterranean">Mediterranean</option>
<option value="Mexican">Mexican</option>
<option value="mideastern">Middle Eastern</option>
<option value="Mongolian">Mongolian</option>
<option value="Moroccan">Moroccan</option>
<option value="Pakistani">Pakistani</option>
<option value="Peruvian">Peruvian</option>
<option value="Pizza">Pizza</option>
<option value="Polish">Polish</option>
<option value="Portuguese">Portuguese</option>
<option value="Russian">Russian</option>
<option value="Salad">Salad</option>
<option value="Sandwiches">Sandwiches</option>
<option value="Seafood">Seafood</option>
<option value="Scandinavian">Scandinavian</option>
<option value="Singaporean">Singaporean</option>
<option value="soulfood">Soul Food</option>
<option value="Soup">Soup</option>
<option value="Southern">Southern</option>
<option value="Spanish">Spanish</option>
<option value="steak">Steakhouses</option>
<option value="sushi">Sushi Bars</option>
<option value="Taiwanese">Taiwanese</option>
<option value="tapas">Tapas Bars</option>
<option value="tapasmallplates">Tapas/Small Plates</option>
<option value="Turkish">Turkish</option>
<option value="Ukrainian">Ukrainian</option>
<option value="Vegan">Vegan</option>
<option value="Vegetarian">Vegetarian</option>
<option value="Vietnamese">Vietnamese</option>
<option value="Wok">Wok</option>
                      </select><br />
                </div>
                <label for="order">
                    <p>
                        Do you want to order or pick up?
                    </p>
                </label>
                <div class="specify-option-content">
                    <select class="form-control" name="order" id="order">
                        <option value="">No preference</option>
                        <option value="order">Order</option>
                        <option value="no">No</option>
                    </select>
                </div><br />
                <div id="postal-wrapper" style="display:none;">
                    <label for="postal-code">
                        <p>
                            What is your postal code?
                        </p>
                    </label>
                    <div class="specify-option-content">
                        <input type="text" id="postal-code" name="postal-code" class="form-control" value="<?php
                            if(checkIfPostalCode($place)){
                                echo $place;
                            }
                                                                                                           ?>"/>
                    </div>
                    <br />
                </div>
                <label for="radius"><p>
                    In what radius do you want to search?
                    </p></label>
                <div class="specify-option-content">
                        <select class="form-control" name="radius" id="radius">
                        <option value="">No preference</option>
                        <option value="2000">2 km</option>
                          <option value="5000">5 km</option>
                          <option value="10000">10 km</option>
                          <option value="25000">25 km</option>
                            <option value="40000" >40 km</option>
                      </select><br />
                </div>

                <label for="min-rating"><p>
                    Minimum rating:</p></label><br />
                <div class="specify-option-content star-specify-option-content">
                    <input onclick="" type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" id="1" value="1" class="star-large first-star-large" /><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="2" class="star-large" id="2"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="3" class="star-large" id="3"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="4" class="star-large" id="4"/><input type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/star_empty.png" value="5" class="star-large" id="5"/><input style="display:none;" type="image" src="https://cdn0.iconfinder.com/data/icons/Hand_Drawn_Web_Icon_Set/128/bullet_deny.png" class="star-large-none"/><span style="display:none;" id="hidden-rating">0</span>
                </div>
          </div>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main results">
            <div id="results-loading"></div>
            <div class="header" id="results-for-header" style="overflow:hidden;"><h3 style="float:left !important;margin-right:20px;"><span id="amount-results-show"></span> results for <span id="results-for"><?php if(isset($q) && trim($q)!=""){echo "<i>" . $q . "</i> around ";} echo "<i>".$place."</i>"; ?></span></h3>

                <div style="float:left;">
                    <div id="sort-wrap"><div class="sort-by-div"></div>
                    <label style="float:left;padding-top:5px;" for="sort-by">Sort by:</label>
                    <select style="float:left;width:150px;margin-top:-2px;margin-left:5px;" class="form-control" id="sort-by" name="sort-by">
                        <option value="0">Best matched</option>
                        <option value="1">Distance</option>
                        <option value="2">Highest rated</option>
                    </select>

                <nav>
  <ul class="pagination list-or-map" style="margin:-2px 0 0 10px;">
      <li id="choose-list" class="active"><a onclick="showList();" style="cursor:pointer;"><span aria-hidden="true"><div style="border-bottom:2px solid #222;width:20px;margin-top:3px;"></div><div style="border-bottom:2px solid #222;width:20px;margin-top:4px;"></div>
      <div style="border-bottom:2px solid #222;width:20px;margin-top:4px;margin-bottom:3px;"></div></span>
      <li id="choose-map"><a onclick="showMap();" style="cursor:pointer;"><img src="https://cdn2.iconfinder.com/data/icons/pittogrammi/142/93-48.png" height="17"/><span class="sr-only">(current)</span></a></li>
  </ul>
                    </div>
                </div>
            </div>
            <div id="results-content-wrapper" class="result-content-wrapper">
                        <?php require_once("refreshResults.php"); ?>
                
<div id="map" style="display:none;background:#f5f5f5;">
    <iframe id="map-iframe" style="border:none;" width="100%" height="100%" src="mapsiframe.php"></iframe>
</div>
                </div>
              </div>
            </div>
          </div>
      </div>
</div></div></div></div></div></div>
<?php

    ?>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/cookies.js"></script>
    <script src="js/main.js"></script>
    <script>
//            $.cookie('contents-json-results','');
//            $.cookie('addresses-json-results', $("#addresses-json-results").html());
//            $.cookie('contents-json-results', $("#contents-json-results").html());
//            $.cookie('contents2-json-results', $("#contents2-json-results").html());
            refreshMap();</script>
    <script>
        if(typeof $.cookie('showMap') != 'undefined'){
            if($.cookie('showMap') == 1){
                showMap();
                hideList();
            } else if($.cookie('showMap') == 0) {
                showList();
                hideMap();
            }
        }
</script>
<script>
    $("document").ready(function(){
       $("#amount-results-show").html($("#amount-results-dont-show").html()); 
    });
</script>
  </body>
</html>
<?php
}
    ?>
