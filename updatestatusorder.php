<?php session_start(); require "functions.php"; 
$loggedIn = $_SESSION["logged_in"];
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
  showHeader("Edit your restaurant",false);
var_dump($_POST);
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
?>