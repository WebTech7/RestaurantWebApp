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
                <div class="round-in-middle-content">
                    <h1>RestaurantWebApp</h1>
                    <h3>What is your postal code?</h3>
                    <form action="index.php" method="GET" id="front-form">
                        <input type="text" name="postalCode" <?php if($_GET["error"] == 1){
    ?>
                               style="background-color:#D5423D;color:#FFF;"
                               <?php
} ?> autocomplete="off" placeholder="1234AB" class="input-one round-in-middle-input"/>
                        <div class="something-abolute"><div class="something-0"><div class="arrow-button" onclick="$('#front-form').submit();"></div></div></div>
                    </form>
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
    </body>
</html>