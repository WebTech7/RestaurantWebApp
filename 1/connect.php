<!--<?php
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

$sql = "SELECT * FROM `$db`.`reviews`";
$res = mysql_query($sql);
echo mysql_error();
while($row = mysql_fetch_array($res)){
    echo "great";
}
echo "Connected successfully";
?>-->