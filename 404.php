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
showHeader("404 Not found", false);
?>
<style>
body {
    padding:0 !important;
    margin:0 !important;
    background:#dfdfdf;
}
canvas {
    background-size:cover;
    padding:0 !important;
    margin:0 !important;
}
</style><br /><Br />
<div style="text-align:center;">
          <canvas id="c" height="400" style="margin-bottom:-300px;"></canvas><div style="position:relative;top:-175px;"><h1 style="color:#FFF;text-shadow:0 0 4px #000;">That's an error.</h1><br /><br /><h3  style="color:#FFF;text-shadow:0 0 4px #000;word-wrap: break-word;"><?php if(isset($_SERVER["HTTP_REFERER"])){ echo $_SERVER["HTTP_REFERER"]; } else {echo "The requested file";} ?> was not found on this server.<br />Click <a href="index.php">here</a> to go to the home page.</h3></h1></div>

</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/main.js"></script>
    <script src="js/balls.js"></script>
  </body>
</html>