 <?php
 require "functions.php";
 $nameError="";
 $priceError="";
 $categoriesError="";
 $descriptionError="";
 $check="";
 $loggedIn="";
 $allGood="";
session_start();
if (isset($_SESSION["logged_in"]) ){
$loggedIn = TRUE;
$userId= $_SESSION["user_id"];

$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id FROM restaurants where user_id='$userId'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
$allGood = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (empty($_POST["dish_name"])) {
	$nameError= "Required";
	$allGood= false;
	
	}
	
if (empty($_POST["dish_descr"])) {
	$descriptionError= "Required";
	$allGood= false;
	
	}
	
if (empty($_POST["categories"])) {
	$categoriesError= "Required";
	$allGood= false;
	
	}
	
if (empty($_POST["price"]) AND preg_match ('/[0-9. ]/', $_POST["price"])) {
	$priceError= "Required";
	$allGood= false;
	
	}


if ($allGood == true){

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT unique_ID FROM restaurants WHERE user_id='$userId'"; //$userId
$idFirst=$conn->query($sql);
$idSecond=mysqli_fetch_assoc($idFirst);
$id=$idSecond["unique_ID"];
$names = $_POST["dish_name"];
$descriptions = $_POST["dish_descr"];
$categories = $_POST["categories"];
$prices = $_POST["price"];

$number = count($names);
$number = $number-1;


for($i=0; $i <= $number; $i++){

$sql = "SELECT * FROM menu_categories WHERE id = '$id' AND categorie='$categories[$i]' ";
$result=$conn->query($sql);
if ($result->num_rows == 0) {
$sql = "INSERT INTO menu_categories (id, categorie) VALUES ('$id', '$categories[$i]')";
$conn->query($sql);
}
$sql = "SELECT unique_ID FROM menu_categories WHERE categorie='$categories[$i]' AND id='$id'"; 
$uniqueIdFirst=$conn->query($sql);
$uniqueIdSecond=mysqli_fetch_assoc($uniqueIdFirst);
$uniqueId=$uniqueIdSecond["unique_ID"];
$sql = "INSERT INTO dishes (id, categories, dish_name, dish_descr, dish_price) VALUES ('$id', '$uniqueId', '$names[$i]', '$descriptions[$i]', '$prices[$i]')"; 
 $conn->query($sql);
 }

$check ="Everything went well!";
}	
	
}

} else {
$loggedIn = false;
}
?> 
  </head>
  <body>
 <?php
showHeader("Add a dish",false);
?> <div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
	<div class="container">
	<div id='EnzoJumbo'>
	
	
<?php
if ($loggedIn == TRUE AND $allGood == TRUE ){
?>	
<form method= "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" role="form" class="form-horizontal">
<fieldset>

<legend>Add dish to menu</legend>

<div class="input">
<div class="control-group">
  <label class="control-label" for="dish_name">Dish name</label>
  <div class="controls">
    <input id="dish_name" name="dish_name[]" placeholder="" class="input-xlarge" type="text">
    <p class="help-block">This is the place for the name for your dish <?php echo "<br />" . $nameError	?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="dish_descr">Dish description</label>
  <div class="controls">
    <input id="dish_descr" name="dish_descr[]" placeholder="" class="input-xlarge" type="text">
    <p class="help-block">This is the place for the description for your dish <?php echo "<br />" .$descriptionError	?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="categories">Categorie</label>
  <div class="controls">
    <input id="categories" name="categories[]" placeholder="" class="input-xlarge" type="text">
    <p class="help-block">The categorie for your dish <?php echo "<br />" .$categoriesError	?></p>
  </div>
</div>


<div class="control-group">
  <label class="control-label" for="price">Dish price</label>
  <div class="controls">
    <input id="price" name="price[]" placeholder="" class="input-xlarge" type="text">
    <p class="help-block">Only numbers and dots, format must be like this: 90.95 <?php echo "<br />" .$priceError	?></p>
  </div>
</div>

</div>



<br />
<div class="control-group">
<div class ="controls">
<button type="submit" class="btn btn-default">Submit</button>
<p class="help-block">Click to submit!</p>
</div>
</div>
</form>
</fieldset>
</form>

<?php
echo $check;
} else{ // if ingelogged 

echo "Please log in first and own a restaurant";

?>	
	
	
	</div>
	</div>
</div>
<?php
} // else niet ingelogged
?>	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      <script src="js/main.js"></script>
  </body>
</html>
