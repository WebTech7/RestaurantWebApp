<?php
require "functions.php";
$allGood="";
session_start();
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
$conn->query($sql);

}
}
?>
 </head>
  
  
  <body>
  <?php
  showHeader("Remove a dish",false);
  ?>
  <div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
  <div class= "container">
  <div id='EnzoJumbo'>
  
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
		<form method= 'POST' action=" . htmlspecialchars($_SERVER["PHP_SELF"]) . ">
		Click here to remove dish '".$row["unique_ID"]."': <input id='submit' type='submit' name='submit' value = '".$row["unique_ID"]."'>
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
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
