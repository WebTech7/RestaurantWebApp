<?php 
session_start(); $loggedIn = $_SESSION["logged_in"];
$userId = $_SESSION["user_id"];
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
$alreadyOwner="";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

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
$result = $conn->query($sql);
?>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
	$jsonOrders=$row['orders'];
	$jsonOrders=json_decode($jsonOrders,true);echo "<!--";var_dump($jsonOrders);echo "-->";
        
        echo '<div class="col-lg-4 owner-order-wrapper">';
       
?>
        <div class="owner-order"><div class="jumpto" id="<?php echo $row["order_id"]; ?>"></div>
        <div class="owner-order-title">
            <?php echo "Order id: " . $row["order_id"] . "<br />" .$row["order_date"]; ?>
        </div>
            <form action='ownerorder.php#<?php echo $row[order_id]; ?>' method="post">
        <?php for($a=0;$a<count($jsonOrders);$a++){ ?>
        <div class="order-check-item">
            <div class="order-check-item-price-amount">
                <div class="order-check-item-price">
                     € <?php $dish_price = $jsonOrders[$a]["dish_price"]; echo str_replace(".", "," ,($dish_price)); $explodeArray = explode(".", $dish_price); if(count($explodeArray) == 1){echo ",00";}else if(strlen($explodeArray[1]) == 1){echo "0";} ?>
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
                    echo "This customer has paid already.";
                } else if($row["paid"] == "N"){
                    echo "This customer has NOT paid yet.";
                } else {
                    echo "Something went wrong with paying. We are not sure whether the costumer has paid already or not.";
                } ?>
            </div>
        </div>
        <div class="order-check-item">
            <div class="alert alert-warning" role="alert">Current status: <strong><?php
		echo $row["status"];
        ?></strong></div>
            
            
		<input type='hidden' name = 'Update' value='<?php echo $row["order_id"]; ?>'>
            <div style="text-align:center;"><h4>Set status:</h4></div><br />
				<?php $status = "New order"; ?><input name="value" style="width:100%;" type="submit" value="<?php echo $status; ?>" class="btn btn-default" />
				<?php $status = "Preparation"; ?><input name="value" style="width:100%;" type="submit" value="<?php echo $status; ?>" class="btn btn-default" />
				<?php $status = "Order on its way"; ?><input name="value" style="width:100%;" type="submit" value="<?php echo $status; ?>" class="btn btn-default" />
				<?php $status = "Delivered"; ?><input name="value" style="width:100%;" type="submit" value="<?php echo $status; ?>" class="btn btn-default" />
		</form>
        </div>
        </div>
</div>
<?php
        echo '</div>';
    }
} else {
    echo "0 results";
}


