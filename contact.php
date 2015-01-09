<?php session_start();
require_once("functions.php");
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$submitted = false;
$submittedsuccess = false;
$alertMessage = "";
$mailWorks = false;

?>
      
    <?php
showHeader("Contact", false);
?>
<div class="image-background jumbotron" style="background:url(http://www.comohotels.com/metropolitanbangkok/sites/default/files/styles/background_image/public/images/background/metbkk_bkg_nahm_restaurant.jpg?itok=5wdbKYQA) !important;background-size:cover !important;background-position:center !important;min-height:calc(100vh - 50px);margin-bottom:0;" id="image-background">
  <div class="container">
      <div id='Enzodiv'>
        <h2>Contact</h2>  
        <ul class="menu">  
          <li>  
              <strong>Who are we?</strong>   
              <em>Coen de Vente</em>  
          </li>
          <li>  
              <em>Max van Hattum </em>  
          </li>
          <li>  
              <em>Enzo Lucas </em>  
          </li>  
           <li>  
              <em>Thijs Visser</em>  
          </li>
          <li>  
              <em>Group 7 </em>  
          </li>     
          <li>  
              <strong>Project for</strong>   
              <em>2ID60 Webtechnolgy Tu/e 2014/15</em>  
          </li>  
          <li>  
              <strong>E-mail us</strong>   
              <em><a href="mailto:2ID60@example.com">2ID60@example.com</a></em>  
          </li>  
        </ul> 
      <div>
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