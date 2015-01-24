<?php session_start();
require_once("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$submitted = false;
$submittedsuccess = false;
$alertMessage = "";
$mailWorks = true;

?>
      
    <?php
showHeader("Contact", false);
?>
<div class="image-background jumbotron" style="background-color:#DDD;/*background-image:url(http://media.creativebloq.futurecdn.net/sites/creativebloq.com/files/images/2012/08/error16.jpg);background-repeat:no-repeat;background-size:contain;*/margin-bottom:0;" id="image-background">
      <div class="container" style="text-align:center;">
    <h1>404 Not Found</h1>
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