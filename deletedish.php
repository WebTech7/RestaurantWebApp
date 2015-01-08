<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 
<?php
session_start();
require "functions.php";
if (isset($_SESSION['logged_in'])){

$allGood = true;
$userId = $_SESSION['user_id'];
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

$sql = "SELECT unique_ID FROM restaurants where user_id='$userId'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
$alreadyOwner=true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$dishId=$_POST['submit'];
$sql = "DELETE FROM dishes WHERE unique_ID = '$dishId'";
conn->query($sql);

}

?>
 </head>
  
  
  <body>
  <?php 
  showHeader("titel",false);
  ?>
  <div class= "container">
  <div class="jumbotron">
  
<?php
  if ($allGood==TRUE AND $alreadyOwner == TRUE){

$sql = "SELECT unique_ID FROM restaurants WHERE user_id='$userId'"; //$userId
$idFirst=$conn->query($sql);
$idSecond=mysqli_fetch_assoc($idFirst);
$id=$idSecond["unique_ID"];
$sql = "SELECT unique_ID, categories, dish_name, dish_descr, dish_price FROM dishes WHERE id = '$id' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()) {
        echo "Dish id: " . $row["unique_ID"]. " - Name: " . $row["dish_name"]. " - Dish description: " . $row["dish_descr"]. " - Price " .$row["dish_price"] . " 
		<form method= "POST" action=" . htmlspecialchars($_SERVER["PHP_SELF"]); . ">
		<input id='submit' type='submit' name='submit'    value = '".$row["unique_ID"]."'>
		</form>
		<br />";
    }
} else {
    echo "0 results";
}
} else {
echo "Log in or become a restaurant owner";
}

?>


</div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
