<?php
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

require_once("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$submitted = false;
$submittedsuccess = false;
$alertMessage = "";
$mailWorks = false;

//$sql = "INSERT INTO orders (user_id, id, orders,  address_street, address_number, postal_code, city, name, last_name, pay_method, paid)
//VALUES ('1', '1', 'piemels', 'test', 'test', 'test', 'test', 'John', 'Doe', 'test', 'y')";

//if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
//} else {
//    echo "Error: " . $sql . "<br>" . $conn->error;
//}

$conn->close();
?>

<?php
showHeader("Order", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
    <div class="container">
      <form id="form-order" method="post" action="order.php" class="form-signin" role="form">
            <h3>Place your order here</h3><br />
          <?php
if($alertMessage != ""){
    ?>
          <div class="alert-message alert <?php if($submittedsuccess){echo "alert-success";} else { echo "alert-danger"; } ?>">
            <p><?php echo $alertMessage; ?></p>
          </div>
          <?php
} if(!$submittedsuccess){
?>
          <p>What would you like to order</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="orders" placeholder="Big Black Cock" /> <br /><br />
          <p>Where should we deliver</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="street" placeholder="street" /><br /><br />
          <p>Where should we deliver</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="number" placeholder="number" /><br /><br />
          <p>Where should we deliver</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="postal" placeholder="postal" /><br /><br />
          <p>Where should we deliver</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="city" placeholder="city" /><br /><br />
          <p>What is your first name?</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="firstName" placeholder="First Name" /><br /><br />
          <p>What is your last name</p>
          <input autocomplete="off" style="padding-right:43px;" type="text" name="lastName" placeholder="Last Name" />
          <div class="something-abolute"><div class="something-0"><div class="arrow-button" style="margin-left:202px;height:38px;width:38px;top:-38px;"  onclick="$('#form-signin').submit();"></div></div></div>
        </form>
        <?php } ?>
    </div><!-- /.container -->
</div>
          
      
      
      
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