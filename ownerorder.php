<?php
session_start();
if (isset($_SESSION["logged_in"]) or 1==1){
//$loggedIn = $_SESSION["logged_in"];
//$userId = $_SESSION["user_id"];
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

$sql = "SELECT unique_ID FROM restaurants where user_id='45'"; //$userId
$result=$conn->query($sql);
if ($result->num_rows > 0) {
$alreadyOwner=true;
$idFirst=$conn->query($sql);
$idSecond=mysqli_fetch_assoc($idFirst);
$id=$idSecond["unique_ID"];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
$orderId=$_POST['Update'];
$sql = "UPDATE orders SET status='Delivered' WHERE order_id='$orderId'";
$conn->query($sql);

}
}
$sql = "SELECT * FROM orders WHERE user_id='45'"; //$userId
$result = $conn->query($sql);

if ($result->num_rows > 0) {
 
    while($row = $result->fetch_assoc()) {
	$jsonOrders=mysqli_fetch_assoc($result);
	$jsonOrders=$jsonOrders['orders'];
	$jsonOrders=json_decode($jsonOrders);

       echo "Order id: " . $row["order_id"]. "  -- Orders:  "; 

		echo "  -- Order date: " . $row["order_date"] . "  -- Address : " . $row["address_street"]. " " . $row["address_number"]. " " . $row["postal_code"]. " " . $row["city"] . "  -- Person information: " .$row["name"] . " " . $row["last_name"] . " --  Pay method: " . $row["pay_method"] . "  -- Paid: " . $row["paid"]. "  -- Status: " . $row["status"] .
		"<form method= 'POST' action=" . htmlspecialchars($_SERVER["PHP_SELF"]) . ">
		<input type='hidden' name = 'Update' value='".$row["order_id"]."'>
		<input type='submit' name='submit' value='Update'>
		</form>";
    }
} else {
    echo "0 results";
}



}

else {
echo "You are no restaurant owner";

}
?>
