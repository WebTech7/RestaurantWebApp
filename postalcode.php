<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Restaurant Info, Reviews and Orders">
        <meta name="author" content="WebTech7">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="postal-body">
       <div class="postal-background">
            <div class="round-in-middle">
                <div class="round-in-middle-content"><h3><br /></h3>
                    <h1 onclick="location.href='index.php';" class="header1-on-front">RestaurantWebApp</h1>
                    <h3 id="question"><?php if($_GET["error"] == 2){ echo 'What are you looking for?'; } else echo "What is your postal code?";?></h3>
                    <form action="index.php" method="GET" id="front-form">
                        <input type="text" name="<?php if($_GET["error"] == 2){ echo 'searchQuery'; } else echo "postalCode";?>" <?php if($_GET["error"] == 1 || $_GET["error"] == 2){
    ?>
                               style="background-color:#D5423D;color:#FFF;"
                               <?php
} ?> autocomplete="off" id="front-input" placeholder="<?php if($_GET["error"] == 2){ echo 'Eindhoven, Italian or Max\'s'; } else echo "1234AB";?>" class="input-one round-in-middle-input"/>
                        <div class="something-abolute"><div class="something-0"><div class="arrow-button" onclick="$('#front-form').submit();"></div></div></div>
                    </form>
                    <span id="other-search-method-wrapper"><p onclick="changeSearchType(<?php if($_GET["error"] == 2){ echo 'false'; } else echo "true";?>);" id="other-search-method"><?php if($_GET["error"] == 2){ echo 'Or search by postal code...'; } else echo "Or search by name of restaurant,<br />place or type of food...";?></p></span>
                </div>
           </div>
        </div> 
        <div class="front-footer"><ul>
            <li>
                &copy; Copyright WebTech7 2014 <?php $y=date('Y'); if($y != 2014){echo "- $y";} ?>
            </li>
            <li>
                <a href="contact.php">Contact</a>
            </li>
            <li>
                <a href="about.php">About</a>
            </li>
            </ul></div>
        <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
        <script>
            var backgroundImageArray = ["http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg", "http://www.comohotels.com/metropolitanbangkok/sites/default/files/styles/background_image/public/images/background/metbkk_bkg_nahm_restaurant.jpg?itok=5wdbKYQA", "http://www.torrecatalunya.com/en/img/Visual-Eje-__H8.jpg"];
            var a = 0;
            function setNewBackground(url){
                $("body").css('background', 'url('+url+')');
                if(a == backgroundImageArray.length - 1){
                    a = 0;
                } else {
                    a++;
                }
                setTimeout(function(){setNewBackground(backgroundImageArray[a])}, 5000);
            }
            $(document).ready(function(){ 
                setNewBackground(backgroundImageArray[a]);
            });
        </script>
        <script>
            function changeSearchType(status) {
                 $("#front-input").css('background', '#FFF'); 
                if(status){
               document.getElementById("other-search-method-wrapper").innerHTML = '<p onclick="changeSearchType(false);" id="other-search-method">Or search by postal code...</p>'; 
                    document.getElementById("question").innerHTML = 'What are you looking for?'; 
                    document.getElementById("front-input").placeholder = 'Eindhoven, Italian or Max\'s'; 
                    $("#front-input").attr('name', 'searchQuery');
                } else {
                    document.getElementById("other-search-method-wrapper").innerHTML = '<p onclick="changeSearchType(true);" id="other-search-method">Or search by name of restaurant,<br />place or type of food...</p>'; 
                    document.getElementById("question").innerHTML = 'What is your postal code?'; 
                    document.getElementById("front-input").placeholder = '1234AB';
                    $("#front-input").attr('name', 'postalCode');
                }
            }
        </script>
    </body>
</html>