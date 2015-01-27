<?php ob_start; session_start(); require_once('functions.php'); ?><!DOCTYPE html>
      <?php
showHeader("API How to", false);
?>
      
      <div style="overflow:hidden;">
      <?php /*
if(!isset($_POST["close-noscript"]) && !isset($_SESSION["close-noscript"])){
?>
      <noscript>
          <div class="noscript-alert"><form action="" method="post"><div class="close-noscript-wrapper"><input class="close-noscript" src="img/close.png" type="image" name="close-noscript" value="true"/></div></form><p>This webpage might not look the way it should look, because your browser does not support JavaScript. Download a modern browser, like <a href="https://www.google.nl/intl/nl/chrome/browser/" target="_blank">Google Chrome</a>, to solve this.</p></div>
      </noscript>
      <?php } else {$_SESSION["close-noscript"] = "true";} */ ?>
      <div id="top"></div>
      
    
      <!--<div class="header-background" id="header-background"></div>
      <div class="something-absolute">
          <div class="header-background-opacity" id="header-background-opacity"></div>
      </div>
      <div class="something-absolute">-->
      
      <div id="lastSearch" style="display:none"></div>
      <div class="image-background jumbotron" style="background:url('http://th06.deviantart.net/fs70/PRE/i/2014/084/d/8/web_developer_wallpaper__code__by_plusjack-d7bmt54.jpg') !important;background-size:cover !important;background-position:center !important;text-align:center;min-height:180px;margin:0;" id="image-background">
    <div class="container">
        <h1 class="lead howto" style="cursor:pointer;text-align:center;margin:0;margin-bottom:0;margin-top:20px;" onclick="document.location.href = 'howto.php';">How to use the RestaurantApp API</h1>
        
    </div><!-- /.container -->
    </div>
          <style>
          body {
            background:#eee;  
          }
          </style>
      <div id="search-ref" class="link-ref"></div>
      <div class="light jumbotron" style="min-height:calc(100vh - 364px);margin:0;">
      <div class="container search" style="text-align:left !important">
          <div class="row">
          
              <div class="col-md-3"><ul style="list-style:none;" class="functions-list">
                  <h4>API methods:</h4>
                  <li><a href="?f=1">Reviews</a></li>
                  <li><a href="?f=2">Restaurants</a></li>
                  <li><a href="?f=3">Dishes</a></li>
                  <li><a href="?f=4">Orders</a></li>
                  </ul></div>  
              <div class="col-md-9">
                  <?php 
                  if(isset($_GET["f"]) && $_GET["f"] == 1){
                  ?>   
                        <h2 class="howto-p">Reviews</h2>
                  <p class="howto-p">Returns reviews of a restaurant (or of all restaurants).</p>
<p class="howto-p">URL examples: <br />
    <a href="http://restaurantwebapp.pe.hu/api?review=true&id=all&format=xml">http://restaurantwebapp.pe.hu/api?review=true&id=all&format=xml</a><br />
                  
                  <a href="http://restaurantwebapp.pe.hu/api?review=true&id=restaurant-id&format=xml">http://restaurantwebapp.pe.hu/api?review=true&id=restaurant-id&format=xml</a></p>
<p class="howto-p">Sample XML Response:
<span class="code-text">
    <pre><?php
    $code = "<results>
<reviews>
<item0>
<review>
<comment_id>1</comment_id>
<user_id>4</user_id>
<id>fictie-eten</id>
<gmt_date_time_published>2015-01-11 21:14:29</gmt_date_time_published>
<summary>Good restaurant.</summary>
<full_comment>Good restaurant.</full_comment>
<rating>4</rating>
</review>
</item0>
</reviews>
</results>
";echo htmlentities($code);
    ?></pre></span>
</p><p class="howto-p">
Sample JSON Response:
<br />
          <span class="code-text"><pre>{
	"reviews": [
		{
			"review": {
				"comment_id": "1",
				"user_id": "4",
				"id": "fictie-eten",
				"gmt_date_time_published": "2015-01-11 21:14:29",
				"summary": "Good restaurant.",
				"full_comment": "Good restaurant.",
				"rating": "4"
			}
		}
        ]
}</pre></span></p>
                  <?php } else if(isset($_GET["f"]) && $_GET["f"] == 2){
                  ?>   
                        <h2 class="howto-p">Restaurants</h2>
                  <p class="howto-p">Returns restaurants. You can search by several data.</p>

<p class="howto-p">URL examples: <br />
    <a href="http://restaurantwebapp.pe.hu/api?restaurant=true&id=all">http://restaurantwebapp.pe.hu/api?restaurant=true&id=all</a><br />
                  
                  <a href="http://restaurantwebapp.pe.hu/api?restaurant=true&id=restaurant-id">http://restaurantwebapp.pe.hu/api?restaurant=true&id=restaurant-id</a><br />
                  
                  <a href="http://restaurantwebapp.pe.hu/api?restaurant=true&city=eindhoven">http://restaurantwebapp.pe.hu/api?restaurant=true&city=eindhoven</a><br />
                  
                  <a href="http://restaurantwebapp.pe.hu/api?restaurant=true&postal=5037SP">http://restaurantwebapp.pe.hu/api?restaurant=true&postal=5037SP</a></p>
<p class="howto-p">Sample XML Response:<br />
<span class="code-text">
    <pre><?php
    $code = "<results>
<restaurants>
<item0>
<restaurant>
<unique_ID>15</unique_ID>
<user_id>1</user_id>
<id>eet-gezellig</id>
<phone>0135444447</phone>
<postal_code>5037SP</postal_code>
<online_orders>Y</online_orders>
<address_street>Straat</address_street>
<address_number>14</address_number>
<city>Tilburg</city>
<country_code>NL</country_code>
<name>Eet Gezellig</name>
<yelp/>
<yelp_id/>
<categories/>
<distance>0</distance>
</restaurant>
</item0>
</restaurants>
</results>
";echo htmlentities($code);
    ?></pre></span>
</p>
                  <?php } else if(isset($_GET["f"]) && $_GET["f"] == 3){
                  ?>   <h2 class="howto-p">Dishes</h2>
                  <p class="howto-p">Returns the dishes of a menu.</p>
	

<p class="howto-p">URL examples: <br />
    <a href="http://restaurantwebapp.pe.hu/api?dishes=true&id=all">http://restaurantwebapp.pe.hu/api?dishes=true&id=all</a><br />
                  
                  <a href="http://restaurantwebapp.pe.hu/api?dishes=true&id=restaurant-unique-id">http://restaurantwebapp.pe.hu/api?dishes=true&id=restaurant-unique-id</a><br />
                  
                  
<p class="howto-p">Sample XML Response:<br />
<span class="code-text">
    <pre><?php
    $code = "<results>
<dishes>
<item0>
<dish>
<unique_ID>34</unique_ID>
<id>15</id>
<categories>33</categories>
<dish_name>Friet schotel</dish_name>
<dish_descr>Heel veel friet... in een schotel.</dish_descr>
<dish_price>199.90</dish_price>
</dish>
</item0>
</results>
</dishes>
";echo htmlentities($code);
    ?></pre></span>
</p>
                  <?php } else if(isset($_GET["f"]) && $_GET["f"] == 4){
                  ?>   
                        <h2 class="howto-p">Orders</h2>
                  <p class="howto-p">Returns amount of orders.</p>
	

<p class="howto-p">URL examples: <br />
    <a href="http://restaurantwebapp.pe.hu/api?orders=true&id=all">http://restaurantwebapp.pe.hu/api?orders=true&id=all</a><br />
                  
                  <a href="http://restaurantwebapp.pe.hu/api?orders=true&id=restaurant-id">http://restaurantwebapp.pe.hu/api?orders=true&id=restaurant-id</a><br />
                  
                  
<p class="howto-p">Sample XML Response:<br />
<span class="code-text">
    <pre><?php
    $code = "<results>
<results>
<orders>
<orders>
<number>29</number>
</orders>
</orders>
</results>
";echo htmlentities($code);
    ?></pre></span>
</p>
                  <?php } else { ?>
        <h2 class="howto-p">Introduction</h2>
<p class="howto-p">The RestaurantApp is RESTful, and is hosted on <a href="">http://restaurantwebapp.pe.hu/api</a>. The only required parameter in every request is ‘id’. If ‘id’ is ‘all’, all results will be given. This way, developers can write their own preferred search function. A parameter, which is always optional, is ‘format’. This can be XML, any other value will return a JSON from.<br/ ><br />You can get reviews, restaurants, dishes and orders.</p><?php } ?>

              </div>  
              
          </div>
    </div><!-- /.container -->
      </div>
      
      
          
      
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>
    
  </body>
</html>