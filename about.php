<?php session_start();
require_once("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$submitted = false;
$submittedsuccess = false;
$alertMessage = "";
$mailWorks = true

?>
      
    <?php
showHeader("About", false);
?>
<div class="image-background jumbotron" style="background:url(http://hirportal.sikerado.hu/images/kep/201408/etterem.jpg) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
  <div class="container">
      <div id='Enzodiv'>
        <h2>About</h2>  <br />
          <div id="Enzodiv2">
              <div class='row'>For a project for the course 2ID60, we were instructed to create a website which uses multiple API services in an interesting way. </div> <br />       
              <div class='row'>Our group, group 7, has accomplished this by use of Goolge.maps, Flickr, Yelp and our own API's.</div><br />
              <div class='row'>This way we can get revies, pictures and show the locations of restaurants all around the world. </div><br />
              <div class='row'>And we allow visitors to create an account for our own API service which enables them to write reviews themselves, or claim ownership of a restaurant, which allows for even more options.</div><br />
      </div>
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