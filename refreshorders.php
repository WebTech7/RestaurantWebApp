<?php 
session_start(); $loggedIn = $_SESSION["logged_in"];
$userId = $_SESSION["user_id"];
$servername = "mysql.hostinger.nl";
$username = "u831903280_web7";
$password = "webtech7";
$db = "u831903280_rest";
$alreadyOwner="";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
if(isset($_GET["showstatus"])){
    $showstatus = $_GET["showstatus"];
    if($_GET["showstatus"] == 'current'){
        if(isset($_SESSION["showstatus"])){
            $showstatus = $_SESSION["showstatus"];
        } else {
            $showstatus = "All";
        }
    }
} else {
    $showstatus = "All";
}
$statusArray = array("New order","Preparation","Order on its way","Delivered", "Deleted");
$_SESSION["showstatus"] = $showstatus;
$sql = "SELECT unique_ID FROM restaurants where user_id='$userId'"; //
$result=$conn->query($sql);
if ($result->num_rows > 0) {
$alreadyOwner=true;
$idFirst=$conn->query($sql);
$idSecond=mysqli_fetch_assoc($idFirst);
$id=$idSecond["unique_ID"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
$orderId=$_POST['Update'];
$orderStatus=$_POST['value'];
$sql = "UPDATE orders SET status='$orderStatus' WHERE order_id='$orderId'";
$conn->query($sql);

}
}
$sql = "SELECT * FROM orders WHERE user_id='$userId' ORDER BY `order_date` DESC"; //$userId
$result = $conn->query($sql);echo "<div style='margin-bottom:20px;margin-left:20px;margin-top:-5px;'>";
?>
<button style="margin-top:5px;" class="btn <?php if("All" == $showstatus){echo "active";} ?> btn-default" onclick="refreshOrders('All');">All</button>
<?php
foreach($statusArray as $status){
?>
<button style="margin-top:5px;" class="btn <?php if($status == $showstatus){echo "active";} ?> btn-default" onclick="refreshOrders('<?php echo $status; ?>');"><?php echo $status; ?></button>
<?php 
}echo '</div>';$q=0;echo '<span id="showloading"></span>';
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
        if(($showstatus == "All" && strtolower(trim($row["status"])) != trim(strtolower("Deleted"))) || $showstatus == $row["status"]){$tot = 0;
            $q++;
	$jsonOrders=$row['orders'];
	$jsonOrders=json_decode($jsonOrders,true);echo "<!--";var_dump($jsonOrders);echo "-->";
        echo '<div class="col-lg-4 owner-order-wrapper">';
       
?>
        <div class="owner-order"><div class="jumpto" id="<?php echo $row["order_id"]; ?>"></div>
        <div class="owner-order-title">
            <?php echo "order-id: " . $row["order_id"] . "<br />" .$row["order_date"]; ?>
        </div>
            
        <?php for($a=0;$a<count($jsonOrders);$a++){ ?>
        <div class="order-check-item">
            <div class="order-check-item-price-amount">
                <div class="order-check-item-price">
                     € <?php $tot += $jsonOrders[$a]["dish_price"]*$jsonOrders[$a]["amount"]; $dish_price = $jsonOrders[$a]["dish_price"]; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
                </div>
                <div class="order-check-item-amount">
                    <?php echo $jsonOrders[$a]["amount"]; ?> &times;
                </div>
            </div>
            <div class="order-check-item-title margin-owner-order">
                <?php echo $jsonOrders[$a]["dish_name"]; ?>
            </div>
        </div>
        <?php
       } ?>
            <div class="order-check-item">
                <div class="order-check-item-price-amount">
                    <div class="order-check-item-price"><strong>€ <?php $dish_price = $tot; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?></strong></div></div>
            <div class="order-check-item-title margin-owner-order"><h4 style="margin-top:2px;">Total:</h4></div>
                
        </div>
        <div class="order-check-item">
            <div class="order-check-item-title margin-owner-order">
                <h4 style="margin-bottom:5px;">Delivery place information</h4>
                <?php echo $row["address_street"] . " " . $row["address_number"] . "<br />" . $row["postal_code"] . " ". $row["city"]; ?>
            </div>
        </div>
        <div class="order-check-item">
            <div class="order-check-item-title margin-owner-order">
                <h4 style="margin-bottom:5px;">Customer information</h4>
                <?php echo "Name: " . $row["name"] . " " . $row["last_name"] . "<br />" . "Pay method: " . $row["pay_method"] . "<br />";
                if($row["paid"] == "Y"){
                    echo "Paid: Yes";
                } else if($row["paid"] == "N"){
                    echo "Paid: No";
                } else {
                    echo "Something went wrong with paying. We are not sure whether the costumer has paid already or not.";
                } ?>
            </div>
        </div>
        <div class="order-check-item">
            <div class="alert alert-warning" role="alert">Current status: <strong id="status-<?php echo $row["order_id"]; ?>"><?php
		echo $row["status"];
        ?></strong></div>
            
            <div style="text-align:center;"><h4>Set status:</h4></div><br />
            <?php
                foreach($statusArray as $status){
                    ?><button name="value" style="width:100%;" onclick="updateStatus(<?php echo $row["order_id"].", '".$status."'"; ?>);" id="" value="<?php echo $status; ?>" class="btn btn-default"><?php echo $status; ?></button> <?php
                }
            ?>
                
        </div>
        </div>
</div>
<?php
        echo '</div>'; } 
    }if($q==0){echo '<div class="alert alert-warning" role="alert" style="margin-left:20px;">';if($showstatus == "All"){echo "No orders yet.";} else {echo "No orders in '$showstatus'.";}echo "</div>";}
} else {
    echo "0 results";
}
?>