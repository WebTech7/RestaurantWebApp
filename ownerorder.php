<?php 
session_start();require "functions.php";
  showHeader("Edit your restaurant",false);
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
        refreshOrders();
        function goToByScroll(id){
                  // Remove "link" from the ID
                id = id.replace("link", "");
                  // Scroll
                $('html,body').animate({
                    scrollTop: $("#"+id).offset().top},
                    'slow');
            }
        
        $("document").ready(function(){
            refreshOrders();
            setTimeout(function(){refreshOrders();}, 5000);
        });
        function refreshOrders(){
            var xmlhttp;
            if (window.XMLHttpRequest)
              {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("refreshDiv").innerHTML="";
                document.getElementById("refreshDiv").innerHTML=xmlhttp.responseText;
                 setTimeout(function(){refreshOrders();}, 5000);
                }
              }
            xmlhttp.open("GET","refreshorders.php",true);
            xmlhttp.send();
        }
    </script>
  </body>
</html>