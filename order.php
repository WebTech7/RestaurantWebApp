<?php
ob_start(); session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require_once("functions.php");
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
$restaurantName = "";
$restaurantCity = "";
$restaurantAdres = "";
$restaurantCountry = "";
$restaurantPhone = "";
$restaurantCategory = array();
$restaurantRating = "";
$restaurantExists = false;
$tot = 0;
$rightForm = false;
$alertMessage = "";
if(isset($_POST["restaurant-id"])){
    $restaurantId = $_POST["restaurant-id"];
    $sql = "SELECT * FROM restaurants WHERE id = '".$restaurantId."'";
    if($res = $conn->query($sql)){
        while($row = $res->fetch_object()){
            $restaurantExists = true;
            $restaurantName = $row->name;
            $restaurantLogo  = "";
            $restaurantCountry  = $row->country_code;
            $restaurantAdres  = $row->address_street . " " . $row->address_number;
            $restaurantCity = $row->city;            
            $restaurantUniqueID = $row->unique_ID;
            $restaurantRating  = "";
            $restaurantRatingStars  = "";
            $restaurantPhone  = $row->phone;
            $restaurantCurrency  = "";
            $restaurantCategory  = "";
            $restaurantDeals  = "";
            $orderedDishes = array();
            $sql2 = "SELECT * FROM dishes WHERE id = '$restaurantUniqueID'";
            if($res2 = $conn->query($sql2)){
                while($row2 = $res2->fetch_object()){
                    if(isset($_POST["amount-dishes-".$row2->unique_ID]) && ($_POST["amount-dishes-".$row2->unique_ID]) != 0 && is_numeric($_POST["amount-dishes-".$row2->unique_ID])){
                        $orderedDishes[count($orderedDishes)] = json_decode(json_encode($row2),true);
                        $orderedDishes[count($orderedDishes)-1]["amount"] = $_POST["amount-dishes-".$row2->unique_ID];
                        $tot = $tot + $_POST["amount-dishes-".$row2->unique_ID] * $row2->dish_price;
                    }
                }
            } else {
                $restaurantExists = false;
            }
        }
    }
}
if(isset($_POST["user_id"])){
    $rightForm = true;
    if(strlen(trim($_POST["name"])) <= 1){
        $rightForm = false;
        $alertMessage .= "Your first name needs to be longer than one character.<br />";
    }
    if(strlen(trim($_POST["last_name"])) <= 1){
        $rightForm = false;
        $alertMessage .= "Your last name needs to be longer than one character.<br />";
    }
    if(strlen(trim($_POST["street_name"])) <= 2){
        $rightForm = false;
        $alertMessage .= "Your street name needs to be longer than two character.<br />";
    }
    if(strlen(trim($_POST["street_number"])) < 1){
        $rightForm = false;
        $alertMessage .= "Not a valid streetnumber.<br />";
    }
    if(strlen(trim($_POST["city"])) < 1){
        $rightForm = false;
        $alertMessage .= "Your city name needs to be longer than two characters.<br />";
    }
    if(strlen(trim($_POST["postal_code"])) < 1){
        $rightForm = false;
        $alertMessage .= "Your postal code needs to be longer than two characters.<br />";
    }
    if($rightForm){
        $name = addslashes(makeInputSafe($_POST["name"]));
        $last_name = addslashes(makeInputSafe($_POST["last_name"]));
        $postal_code = addslashes(makeInputSafe($_POST["postal_code"]));
        $street_name = addslashes(makeInputSafe($_POST["street_name"]));
        $street_number = addslashes(makeInputSafe($_POST["street_number"]));
        $city = addslashes(makeInputSafe($_POST["city"]));
        $postal_code = addslashes(makeInputSafe($_POST["postal_code"]));
//        $sql = "INSERT INTO orders (user_id, id, orders,  address_street, address_number, postal_code, city, name, last_name, pay_method, paid) VALUES ('$_SESSION[user_id]', '$restaurantId', '".json_encode($orderedDishes)."', '$street_name', '$street_number', '$postal_code', '$city', '$name', '$last_name', 'cash', 'N')";
        if(isset($_SESSION["ordered-dishes-json"])){
            $orders = $_SESSION["ordered-dishes-json"];
        } else {
            $orders = json_encode($orderedDishes);
        }
        $user_id = 0;
        if(isset($_SESSION["user_id"])){
            $user_id = $_SESSION["user_id"];
            $sql2 = "UPDATE accounts SET `street_name` = '$street_name $street_number', `postal_code` = '$postal_code', `city` = '$city' WHERE `user_id` = $user_id;";
            $conn->query($sql2);
        }
        $sql = "INSERT INTO `restaurantwebapp`.`orders` (`order_id`, `user_id`, `id`, `orders`, `order_date`, `address_street`, `address_number`, `postal_code`, `city`, `name`, `last_name`, `pay_method`, `paid`) VALUES (NULL, '$user_id', '$restaurantId', '$orders', CURRENT_TIMESTAMP, '$street_name', '$street_number', '$postal_code', '$city', '$name', '$last_name', 'cash', 'N');";
        $conn->query($sql);
        $orderId = mysqli_insert_id($conn);
    }

}
if($restaurantExists && !$rightForm){
    showHeader("Place your order", false);
    $_SESSION["ordered-dishes-json"] = json_encode($orderedDishes);
?>

    <div class="container-fluid">
      <div class="row result-content-main">
        <div class="col-sm-3 col-md-2 sidebar" id="restaurant-small" style="padding:0;margin:0;">
            <br />
            <a href="#" id="top-ref">
                <div class="information-box">
                    <img height="15" style="margin-top:-3px;margin-right:5px;" src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678085-house-32.png" alt=""/><?php echo "<i>" . $restaurantName . "</i> in $restaurantCity"; ?>
                </div>
            </a>
                <div class="information-box"><img height="15" style="margin-top:-3px;" src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/location-pointer.png" alt=""/>
                <?php print $restaurantAdres; ?><br />
                <?php print $restaurantCity; ?>, 
                <?php print $restaurantCountry; ?>
                    
            </div>
            <?php if(isset($restaurantPhone) && $restaurantPhone != ""){ ?><div class="information-box"><img height="15" style="margin-top:-3px;" src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/telephone.png" alt=""/>
                <?php print '<a href="callto:'.str_replace(" ","", str_replace("+", "", $restaurantPhone)).'">'.$restaurantPhone."</a>"; ?>
            </div><?php } ?>
            <div class="information-box">
                <img height="15" style="margin-top:-3px;" src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/paste.png" alt=""/> Categories:
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
            
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-2 main" style="padding:0;overflow:hidden;padding-bottom:30px;" id="restaurant-broad">
            
          
            <div style="padding:0px 10px 0 10px;width:100%;">
                <div id="order-wrapper" style="position:relative;top:-61px;"></div>
                <div class="order-step-wrapper">
                    <div class="order-step-count">
                        1
                    </div>
                    <div class="order-step-title">
                        Check your order
                    </div>
                </div>
                <div class="order-check-wrapper">
                    <div class="order-check-table">
                        <div class="order-check-title">
                            Your order
                        </div>
                        <?php for($a=0;$a<count($orderedDishes);$a++){ ?>
                        <div class="order-check-item">
                            <div class="order-check-item-price-amount">
                                <div class="order-check-item-price">
                                    € <?php $dish_price = $orderedDishes[$a]["dish_price"]; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
                                </div>
                                <div class="order-check-item-amount">
                                    <?php echo $orderedDishes[$a]["amount"] ?> &times;
                                </div>
                            </div>
                            <div class="order-check-item-title">
                                <?php echo $orderedDishes[$a]["dish_name"] ?>
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $orderedDishes[$a]["dish_descr"] ?>
                            </div>

                        </div>
                        <?php } ?>
                    </div>
                    <div class="order-conclusion-wrapper" style="margin-top:10px;">
                        <div style="width:200px;float:right;">
                                <div id="error"></div>
                            <div class="order-conclusion-top">
                                <div class="total">
                                    Total: € <span id="total-script"><?php echo str_replace(".", "," ,($tot)); $explodeArray = explode(".", $tot); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
                                </div>
                            </div>
                                    <button class="order-conclusion-bottom" onclick="document.location.href='restaurant.php?id=<?php echo $restaurantId; ?>';">Click here to edit your order...</button>
                        </div>
                    </div>
                </div>
                    <hr />
                <div class="order-step-wrapper">
                    <div id="data-jump" style="position:relative;top:-61px;"></div>
                    <div class="order-step-count">
                        2
                    </div>
                    <div class="order-step-title">
                        Fill in your data
                    </div>
                </div>
                <form method="post" action="order.php#data-jump" class="order-data-wrapper">
                    <br />
                    <?php
    if(isset($alertMessage) && $alertMessage != ""){
        echo '<div class="alert alert-danger" role="alert">' . $alertMessage . '</div>';
    }
    ?>
                    <?php
                    for($a=0;$a<count($orderedDishes);$a++){
                        ?>
                    <input type="hidden" id="amount-dishes-<?php echo $orderedDishes[$a]["unique_ID"]; ?>-hidden" name="amount-dishes-<?php echo $orderedDishes[$a]["unique_ID"] ?>" value="<?php echo $orderedDishes[$a]["amount"] ?>" />
                    <?php
                    }
                    ?>
                    <div class="two-inputs">
                        <div class="two-inputs-part-1" style="width: calc(40% - 10px);">
                            <label for="name">First name:</label>
                            <input type="text" class="form-control" name="name" value="<?php if($alertMessage != ""){echo addslashes($_POST["name"]);}else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= ""){$sql = "SELECT * from accounts where user_id = $_SESSION[user_id];"; if($res = $conn->query($sql)){while($row = $res->fetch_object()){echo $row->first_name;}}} ?>" id="name" />
                        </div>
                        <div class="two-inputs-part-2" style="width: calc(60% - 10px);">
                            <label for="last_name">Last name:</label>
                            <input type="text" class="form-control" id="last_name" value="<?php if($alertMessage != ""){echo addslashes($_POST["last_name"]);}else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= ""){$sql = "SELECT * from accounts where user_id = $_SESSION[user_id];"; if($res = $conn->query($sql)){while($row = $res->fetch_object()){echo $row->last_name;}}} ?>" name="last_name" />
                        </div>
                    </div>
                    <div class="two-inputs">
                        <div class="two-inputs-part-1" style="width: calc(70% - 10px);">
                            <label for="street_name">Street name:</label>
                            <input type="text" value="<?php if($alertMessage != ""){echo addslashes($_POST["street_name"]);}else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= ""){$sql = "SELECT * from accounts where user_id = $_SESSION[user_id];"; if($res = $conn->query($sql)){while($row = $res->fetch_object()){if(isset($row->street_name) && strlen($row->street_name) > 0){ $expl = explode(" ", $row->street_name);}else{$expl = array();} echo $expl[0];}}} ?>" class="form-control" id="street_name" name="street_name" />
                        </div>
                        <div class="two-inputs-part-2" style="width: calc(30% - 10px);">
                            <label for="street_number">Street number:</label>
                            <input type="text" value="<?php if($alertMessage != ""){echo addslashes($_POST["street_number"]);}else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= ""){$sql = "SELECT * from accounts where user_id = $_SESSION[user_id];"; if($res = $conn->query($sql)){while($row = $res->fetch_object()){if(isset($row->street_name) && strlen($row->street_name) > 0){ $expl = explode(" ", $row->street_name);}else{$expl = array();} echo $expl[1];}}} ?>" class="form-control" id="street_number" name="street_number" />
                        </div>
                    </div>
                    <div class="two-inputs">
                        <div class="two-inputs-part-1" style="width: calc(60% - 10px);">
                            <label for="city">City:</label>
                            <input type="text" value="<?php if($alertMessage != ""){echo addslashes($_POST["city"]);}else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= ""){$sql = "SELECT * from accounts where user_id = $_SESSION[user_id];"; if($res = $conn->query($sql)){while($row = $res->fetch_object()){echo $row->city;}}} ?>" class="form-control" id="city" name="city" />
                        </div>
                        <div class="two-inputs-part-2" style="width: calc(40% - 10px);">
                            <label for="postal_code">Postal code:</label>
                            <input type="text" value="<?php if($alertMessage != ""){echo addslashes($_POST["postal_code"]);}else if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]!= ""){$sql = "SELECT * from accounts where user_id = $_SESSION[user_id];"; if($res = $conn->query($sql)){while($row = $res->fetch_object()){echo $row->postal_code;}}} ?>" class="form-control" id="postal_code" name="postal_code" />
                        </div>
                    </div>
                    <button class="order-submit">Submit your order definitely</button>
                    <input type="hidden" value="<?php if(isset($_SESSION["user_id"])){echo $_SESSION["user_id"];}else {echo "0";} ?>" name="user_id" />
                    <input type="hidden" value="<?php echo $_POST["restaurant-id"]; ?>" name="restaurant-id" />
                </form>
            </div>
       </div>
      </div>
    </div>
<?php 
} else if($rightForm){
    showHeader("Place your order", false);
?>

    <div class="container-fluid">
      <div class="row result-content-main">
        <div class="col-sm-3 col-md-2 sidebar" id="restaurant-small" style="padding:0;margin:0;">
            <br />
            <a href="#" id="top-ref">
                <div class="information-box">
                    <img height="15" style="margin-top:-3px;margin-right:5px;" src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678085-house-32.png" alt=""/><?php echo "<i>" . $restaurantName . "</i> in $restaurantCity"; ?>
                </div>
            </a>
                <div class="information-box"><img height="15" style="margin-top:-3px;" src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/location-pointer.png" alt=""/>
                <?php print $restaurantAdres; ?><br />
                <?php print $restaurantCity; ?>, 
                <?php print $restaurantCountry; ?>
                    
            </div>
            <?php if(isset($restaurantPhone) && $restaurantPhone != ""){ ?><div class="information-box"><img height="15" style="margin-top:-3px;" src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/telephone.png" alt=""/>
                <?php print '<a href="callto:'.str_replace(" ","", str_replace("+", "", $restaurantPhone)).'">'.$restaurantPhone."</a>"; ?>
            </div><?php } ?>
            <div class="information-box">
                <img height="15" style="margin-top:-3px;" src="https://cdn0.iconfinder.com/data/icons/20-flat-icons/128/paste.png" alt=""/> Categories:
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
            
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-2 main" style="padding:0;overflow:hidden;padding-bottom:30px;" id="restaurant-broad">
            
          
            <div style="padding:0px 10px 0 10px;width:100%;">
                <div id="order-wrapper" style="position:relative;top:-61px;"></div>
                <div class="order-step-wrapper">
                    <div class="order-step-count" style="background:url(https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678134-sign-check-128.png);background-size:100%;">
                        
                    </div>
                    <div class="order-step-title">
                        You are done!
                    </div>
                </div>
                <div class="order-check-wrapper">
                    <div class="order-check-table">
                        <div class="order-check-title">
                            Your order <?php echo "(order-id = ".$orderId.")";?>
                        </div>
                        <?php for($a=0;$a<count($orderedDishes);$a++){ ?>
                        <div class="order-check-item">
                            <div class="order-check-item-price-amount">
                                <div class="order-check-item-price">
                                    € <?php $dish_price = $orderedDishes[$a]["dish_price"]; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
                                </div>
                                <div class="order-check-item-amount">
                                    <?php echo $orderedDishes[$a]["amount"] ?> &times;
                                </div>
                            </div>
                            <div class="order-check-item-title">
                                <?php echo $orderedDishes[$a]["dish_name"] ?>
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $orderedDishes[$a]["dish_descr"] ?>
                            </div>

                        </div>
                        <?php } ?>
                    </div>
                    <div class="order-conclusion-wrapper" style="margin-top:10px;" style="border-radius:5px;">
                        <div style="width:200px;float:right;">
                                <div id="error"></div>
                            <div class="order-conclusion-top" style="border-radius:5px;">
                                <div class="total">
                                    Total: € <span id="total-script"><?php echo str_replace(".", "," ,($tot)); $explodeArray = explode(".", $tot); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <hr />
                <div class="order-check-wrapper">
                    <div class="order-check-table">
                        <div class="order-check-title">
                            Your information
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                First name:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $name; ?>
                            </div>
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                Last name:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $last_name; ?>
                            </div>
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                Postal code:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $postal_code ?>
                            </div>
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                Street name:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $street_name; ?>
                            </div>
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                Street number:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $street_number; ?>
                            </div>
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                City:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $city; ?>
                            </div>
                        </div>
                        <div class="order-check-item">
                            <div class="order-check-item-title">
                                Postal code:
                            </div>
                            <div class="order-check-item-description">
                                <?php echo $postal_code; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
       </div>
      </div>
    </div>
<?php 
    
} ELSE {
        showHeader("Place your order", false);
?>
        
?>

    <div class="container-fluid">
      <div class="row result-content-main">
        <div class="col-sm-3 col-md-2 sidebar" id="restaurant-small" style="padding:0;margin:0;">
            <p>Something went wrong.</p>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-12 col-md-offset-2 main" style="padding:0;overflow:hidden" id="restaurant-broad">
            
            <div id="EnzoLeft" style="padding:0px 10px 0 10px;width:100%;">
                <h3>We are very sorry about this, but something went wrong when you were trying to order. Please try again. If this problem keeps reoccuring, please call the restaurant to place your order and/or tell us about your problem by contacting us.</h3>
                </div>
            </div>
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
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
     <script src="js/main.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/cookies.js"></script>
  </body>
</html>