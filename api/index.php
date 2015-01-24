<?php

//******OPTIES************************************************************************************************************************************************************************
//**/api.php?review=true&id="all" ** /api.php?review=true&id="restaurant-id" ** 
//**/api.php?restaurant=true&id="all" ** /api.php?restaurant=true&id="restaurant-id" ** /api.php?restaurant=true&city="eindhoven" ** /api.php?restaurant=true&postal="5037SP" ** 
//**/api.php?dishes=true&id="all" ** /api.php?dishes=true&id="restaurant-unique-id" ** 
//**/api.php?orders=true&id="all" ** /api.php?orders=true&id="restaurant-id" ** 
//************************************************************************************************************************************************************************************
$servername = "www.db4free.net";
$username = "webtech7";
$password = "W€btek678";
$db = "restaurantwebapp";
$output = '{"error":"No input"}';
// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
if (isset($_GET["review"]) OR isset($_GET["restaurant"]) OR isset($_GET["dishes"]) OR isset($_GET["orders"])) {



//
// reviews
// paramaters review=true en id kan restaurant id zijn of "all"
//   
if (isset($_GET["review"]) and preg_match("/^[a-zA-Z0-9\-]*$/",$_GET['review']) and isset($_GET["id"]) ) {
$id=$_GET["id"];
if ($id == "all"){
$sql = "SELECT * FROM reviews "; //$userId
$result = $conn->query($sql);
$reviews = array();
if ($result->num_rows > 0) {
while($review = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$reviews[] = array('review'=>$review);
}
}
$output = json_encode(array('reviews' => $reviews), JSON_PRETTY_PRINT);

} //id all

 else {

$sql = "SELECT * FROM reviews WHERE id='$id'"; 
$result = $conn->query($sql);
$reviews = array();
if ($result->num_rows > 0) {
while($review = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$reviews[] = array('review'=>$review);
}
$output = json_encode(array('reviews' => $reviews), JSON_PRETTY_PRINT);
}
}//id else
}//review


//^^reviews^^

//
// restaurants 
// parameters zijn restaurant= true id= "all" of naam restaurant city= naam stad postal= postcode.
//

if (isset($_GET["restaurant"]) and preg_match("/^[a-zA-Z0-9\-]*$/",$_GET['restaurant'])) { 
if (isset($_GET["id"])){
$id=$_GET["id"];
if ($id=="all"){
$sql = "SELECT * FROM restaurants "; 
$result = $conn->query($sql);
$restaurants = array();
if ($result->num_rows > 0) {
while($restaurant = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$restaurants[] = array('restaurant'=>$restaurant);
}
$output= json_encode(array('restaurants'=>$restaurants), JSON_PRETTY_PRINT);
}
}
else{
$sql = "SELECT * FROM restaurants WHERE id='$id' "; 
$result = $conn->query($sql);
$restaurants = array();
if ($result->num_rows > 0) {
while($restaurant = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$restaurants[] = array('restaurant'=>$restaurant);
}
$output= json_encode(array('restaurants'=>$restaurants), JSON_PRETTY_PRINT);
}
}




}//id isset

if (isset($_GET["city"])){
$city=$_GET["city"];
$sql = "SELECT * FROM restaurants where city='$city'"; 
$result = $conn->query($sql);
$restaurants = array();
if ($result->num_rows > 0) {
while($restaurant = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$restaurants[] = array('restaurant'=>$restaurant);
}
$output= json_encode(array('restaurants'=>$restaurants), JSON_PRETTY_PRINT);
}


}//city isset

if(isset($_GET["postal"])){
$postal=$_GET["postal"];
$sql = "SELECT * FROM restaurants where postal_code='$postal'"; 
$result = $conn->query($sql);
$restaurants = array();
if ($result->num_rows > 0) {
while($restaurant = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$restaurants[] = array('restaurant'=>$restaurant);
}
$output= json_encode(array('restaurants'=>$restaurants), JSON_PRETTY_PRINT);
}
}//postal isset
}//restaurant isset

//^^restaurants^^



//
//Dishes
//dishes=true id= "all" of restaurant unique_id 
//
if (isset($_GET["dishes"])){
if (isset($_GET["id"])){
$id=$_GET["id"];
if ($id=="all"){
$sql = "SELECT * FROM dishes"; 
$result = $conn->query($sql);
$dishes = array();
if ($result->num_rows > 0) {
while($dish = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$dishes[] = array('dish'=>$dish);
}
$output= json_encode(array('dishes'=>$dishes), JSON_PRETTY_PRINT);
}
}//id =all
else{
$sql = "SELECT * FROM dishes where id='$id'"; 
$result = $conn->query($sql);
$dishes = array();
if ($result->num_rows > 0) {
while($dish = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$dishes[] = array('dish'=>$dish);
}
$output= json_encode(array('dishes'=>$dishes), JSON_PRETTY_PRINT);
}
}//else id anders
}//id isset
}//dishes isset

//
//Orders
//orders=true id= "all" of id restaurant
//
if (isset($_GET["orders"])){
if (isset($_GET["id"])){
$id=$_GET["id"];
if ($id=="all"){
$sql = "SELECT count(*) AS number FROM orders"; 
$result = $conn->query($sql);
$orders = array();
if ($result->num_rows > 0) {
while($order = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$orders = array('orders'=>$order);
}

$output= json_encode($orders, JSON_PRETTY_PRINT);
}
}//id = all
else {
$sql = "SELECT id, count(*) AS number FROM orders WHERE id='$id'"; 
$result = $conn->query($sql);
$orders = array();
if ($result->num_rows > 0) {
while($order = mysqli_fetch_array($result, MYSQL_ASSOC)) {
$orders = array('orders'=>$order);
}
$output= json_encode($orders, JSON_PRETTY_PRINT);
}
}//id is niet all
}//isset id
}//isset orders
}//alle issets
echo "<pre>" . $output . "<pre>";

?>
