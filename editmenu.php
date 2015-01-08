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
 require "functions.php";
 $nameError="";
 $priceError="";
 $categoriesError="";
 $descriptionError="";
 $check="";
 $loggedIn="";
session_start();
if (isset($_SESSION["logged_in"]) ){
$loggedIn = TRUE;
$userId= $_SESSION["user_id"];
$allGood = true;


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
	
if (empty($_POST["price"])) {
	$priceError= "Required";
	$allGood= false;
	
	}


if ($allGood == true){
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
$sql = "SELECT id FROM restaurants WHERE user_id='$userId'"; //$userId
$idFirst=$conn->query($sql);
$idSecond=mysqli_fetch_assoc($idFirst);
$id=$idSecond["id"];
$names = $_POST["dish_name"];
$descriptions = $_POST["dish_descr"];
$categories = $_POST["categories"];
$prices = $_POST["price"];

$number = count($names);
$number = $number-1;


for($i=0; $i <= $number; $i++){
$sql = "INSERT INTO dishes (id, categories, dish_name, dish_descr, dish_price) VALUES ('$id', '$categories[$i]', '$names[$i]', '$descriptions[$i]', '$prices[$i]')"; 
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
    
	<div class="container">
	<div class="jumbotron">
	
	
<?php
showHeader("titel", false);
if ($loggedIn == TRUE ){
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

echo "Please log in first";

?>	
	
	
	</div>
	</div>
<?php
} // else niet ingelogged
?>	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
