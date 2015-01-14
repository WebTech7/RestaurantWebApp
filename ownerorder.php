<?php 
session_start();require "functions.php"; 
$loggedIn = $_SESSION["logged_in"];
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
  showHeader("Edit your restaurant",false);
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
if(!isset($_SESSION["showstatus"])){
    $_SESSION["showstatus"] = "All";
}
?>

</head>
  <body>
  	<div class="image-background jumbotron" style="background:url(http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
 <div class="container"> 
<div id='EnzoJumbo3'>
    <div class="row" style="padding:10px 0;margin:0 0 0 -10px;overflow:hidden" id="refreshDiv">
        
<?php
if (!isset($_SESSION["logged_in"]) ){
    
echo "You are not a restaurant owner.";

} else {
//    require_once("refreshorders.php");
}
?>
        </div>
</div>
</div>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
        refreshOrders('<?php echo $_SESSION["showstatus"]; ?>');
        function goToByScroll(id){
                  // Remove "link" from the ID
                id = id.replace("link", "");
                  // Scroll
                $('html,body').animate({
                    scrollTop: $("#"+id).offset().top},
                    'slow');
            }
        
        $("document").ready(function(){
            refreshtimeout = setTimeout(function(){refreshOrders();}, 5000);
        });
        function refreshOrders(showstatus){
            if(typeof showstatus === 'undefined'){
                showstatus = 'All';
            }
            if(showstatus != 'current'){
                $("#showloading").html('<img src="http://scriptsteam.com/scripts/img/load.gif" alt="Loading..." style="margin-left:20px;margin-top:-20px;width:75px;" />');
            }
            $.get( "refreshorders.php?showstatus="+showstatus, function(data) {
                    $("#refreshDiv").html('');
                    $("#refreshDiv").html(data);
                    refreshtimeout = setTimeout(function(){refreshOrders('current');}, 5000);
                    $("#showloading").html('');
            });
        }
    </script>
      <script>
      function updateStatus(id, status){clearTimeout(refreshtimeout);
          $("#status-"+id).html('<img src="http://scriptsteam.com/scripts/img/load.gif" alt="Loading..." height="15" style="margin-top:-2px;" />');
          
          // Send the data using post
          var posting = $.post( 'updatestatusorder.php', { Update: id, value: status } );
          // Put the results in a div
            posting.done(function( data ) {
                refreshOrders('current');
          });
      }
      </script>
      <script src="js/main.js"></script>
  </body>
</html>