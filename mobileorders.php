<?php session_start();
require_once("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$submitted = false;
$submittedsuccess = false;
$alertMessage = "";
$mailWorks = true;

?>
      
    <?php
showHeader("Contact", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.comohotels.com/metropolitanbangkok/sites/default/files/styles/background_image/public/images/background/metbkk_bkg_nahm_restaurant.jpg?itok=5wdbKYQA) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
  <div class="container">
      <div class="user-drop-info" id="user-drop-info"><?php 
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db) or die("No connection");
                            $amountFinishes = 0;
if(isset($_SESSION["user_id"]) && $_SESSION["logged_in"] == 1){
                            $sql = "SELECT * FROM `orders` WHERE `user_id` = $_SESSION[user_id] AND `status` != 'Deleted' ORDER BY `order_date` DESC";
                            if($res = $conn->query($sql)){
                                while($row = $res->fetch_object()){
                                    $amountFinishes++;
                                }
                            }
                            if($amountFinishes>0){
                                ?>
<div id="finished-wrap">
                          <div class="user-drop-header" id="finished-order">
                                Finished orders:
                          </div>
                          <?php
                            }
                            if($res = $conn->query($sql)){
                                ?>
                          
                          <?php
                                
                                while($row = $res->fetch_object()){
                                    $tot=0;
	                               $jsonOrders=$row->orders;
                                    $jsonOrders=json_decode($jsonOrders,true);
                                    for($a=0;$a<count($jsonOrders);$a++){
                                        $tot += $jsonOrders[$a]["dish_price"]*$jsonOrders[$a]["amount"];
                                    }
                                ?>
            <div id="order-<?php echo $row->order_id; ?>" style="display:none;">
                <div class="user-drop-header" id="finished-order">
                    <div class="user-drop-price">
                        € <?php     $dish_price = $tot;
                                    echo str_replace(".", "," ,($dish_price));
                                    $explodeArray = explode(".", $dish_price);
                                    if(count($explodeArray) == 1){
                                        echo ",00";
                                    } else if(strlen($explodeArray[1]) == 1){
                                        echo "0";
                                    } ?>
                    </div>
                    order-id: <?php echo $row->order_id; ?>
                </div>
                <?php for($a=0;$a<count($jsonOrders);$a++){
                                       ?>
                <div class="user-drop-item">
                    <div class="user-drop-price">
                        <?php echo $jsonOrders[$a]["amount"] ?> &times; € <?php $dish_price = $jsonOrders[$a]["dish_price"]; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
                    </div>
                                <?php echo $jsonOrders[$a]["dish_name"]; ?>
                                </div>
                                <?php
                                    } ?>
                        </div>
                          <div class="user-drop-item finished-order user-drop-item-hover" id="finished-order-<?php echo $row->order_id; ?>" onclick="showOrderSpec(<?php echo $row->order_id; ?>);" style="cursor:pointer;">
                              <div class="user-drop-price">€ <?php $dish_price = $tot; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?></div>
                                <span class="rest-link"><?php $sql2 = "SELECT * FROM `restaurants` WHERE `id` = '$row->id'";
                                    $restaurantExists = false;
                              if($res2 = $conn->query($sql2)){
                                while($row2 = $res2->fetch_object()){
                                    $restaurantExists = true;
                                    echo $row2->name;
                                }
                              } if(!$restaurantExists) {echo "<i>Unknown restaurant</i>";} ?></span> 
                              <div class="user-order-status"><?php echo $row->status; ?></div>
                          </div>
                          <?php
                                } }
                                    
                            ?>
                              <?php
    if($amountFinishes>0){
                                ?>
                          </div>
                          <?php
                            }
    
} $amountUnfinishes = 0;
                                $cookies = json_encode($_COOKIE);
                                if(strpos($cookies,'dish-')){
                                    ?>
                          <?php
                                    $dishes = array();
                                    $restaurants = array();
                                    $expl = explode("dish-", $cookies);
                                    for($a=1;$a<count($expl);$a++){
                                        $expl2 = explode("\"",$expl[$a]);
                                        $id = $expl2[0];
//                                        echo $id . " ";
                                        $sql = "SELECT * FROM `dishes` WHERE `unique_ID` = $id";
                                        if($res = $conn->query($sql)){
                                            while($row = $res->fetch_object()){
                                                $restaurantID = $row->id;
                                                $inArray = false;
                                                for($b=0;$b<count($restaurants);$b++){
                                                    if($restaurants[$b] == $restaurantID){
                                                        $inArray = true;
                                                    }
                                                }
                                                $dishes[] = array("dish" => $id, "restaurant" => $restaurantID, "price" => $row->dish_price);
                                                if(!$inArray){
                                                    $restaurants[] = $restaurantID;
                                                }
                                            }
                                        }
                                    }
                          for($a=0;$a<count($restaurants);$a++){
                                        $total = 0;
                                        for($b=0;$b<count($dishes);$b++){
                                            if($dishes[$b]["restaurant"] == $restaurants[$a]){
                                                $total += $dishes[$b]["price"] * $_COOKIE["dish-".$dishes[$b]["dish"]];
                                            }
                                        }
                                        if($total != 0){
                          $amountUnfinishes++;
                            }
                          } if($amountUnfinishes > 0){ ?>
                          <div class="user-drop-header">
                                Unfinished orders:
                          </div>
                          <?php }
                                    for($a=0;$a<count($restaurants);$a++){
                                        $total = 0;
                                        for($b=0;$b<count($dishes);$b++){
                                            if($dishes[$b]["restaurant"] == $restaurants[$a]){
                                                $total += $dishes[$b]["price"] * $_COOKIE["dish-".$dishes[$b]["dish"]];
                                            }
                                        }
                                        if($total != 0){
                                        $sql = "SELECT * FROM `restaurants` WHERE `unique_ID` = $restaurants[$a]";
                                        if($res = $conn->query($sql)){
                                            while($row = $res->fetch_object()){
                                        ?>
                          <div class="user-drop-item user-drop-item-hover" style="cursor:pointer;" onclick="document.location.href = 'restaurant.php?id=<?php echo $row->id; ?>';">
                                <div class="user-drop-price">€ <?php echo str_replace(".", "," ,($total)); $explodeArray = explode(".", $total); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?></div>
                                <?php echo $row->name; ?>
                          </div>
                              <?php             } 
                                            }
                                        }
                                    }
                                    ?>
                              <?php
                                } if($amountFinishes == 0 && $amountUnfinishes == 0){?><div class="user-drop-item"><i>You don't have any orders yet.</i></div><?php }
                            ?></div>
          <div id="order-spec-wrap"><div id="order-spec" style="display:none;left:0;"><div class="user-drop-info" style="" id="order-spec-content"></div></div></div>
      
      
      
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/main.js"></script>
    
  </body>
</html>