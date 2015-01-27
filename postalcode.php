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
           <div class="waiting-cat">
                <h1>Looking for restaurants...</h1>
           </div>
       <div class="postal-background">
            <div class="round-in-middle">
                <div class="round-in-middle-content"><h3><br /></h3>
                    <form action="index.php?useq=1" method="GET" id="front-form">
                    <h1 onclick="location.href='index.php';" class="header1-on-front" style="margin-top:-20px;" ><img src="img/default.png" style="border-radius:50px;margin-top:-7px;" height="45" alt="" />&nbsp;<img src="img/logo.png" style="border-radius:50px;margin-left:-5px;" height="45" alt="" /></h1>
                        <p style="margin:-20px 0 -5px 3px;color:#000;font-weight:300;">Free for owners, cheaper for you.</p>
                    <h3 class="question">What do you want to eat?</h3>
                        <input type="text" name="q" style="<?php if(isset($_GET["error"]) && $_GET["error"] == 1){ ?>background-color:#D5423D;color:#FFF;<?php } ?>width:235px;padding-right:20px !important;" autocomplete="off" id="q-input" placeholder="Italian, Domino's" <?php if(isset($_COOKIE["q"])){echo "value='".$_COOKIE["q"]."'";} ?> class="input-one round-in-middle-input"/>
                        
                        <h3 class="question">And where?</h3>
                                                                                         <input type="text" name="place" style=" <?php if(isset($_GET["error"]) && $_GET["error"] == 2){ ?> background-color:#D5423D;color:#FFF; <?php } ?> width:235px;" autocomplete="off" id="place-input" placeholder="1234AB, Eindhoven" class="input-one round-in-middle-input" <?php if(isset($_COOKIE["place"])){echo "value='".$_COOKIE["place"]."'";} ?>/>
                                                                                         
                                                                                         <div class="something-abolute"><div class="something-0"><div style="margin-left:278px" class="arrow-button" onclick="showWaitingCat();$('#front-form').submit();"></div></div></div>
                        <h5 style="color:#FFF;margin:3px 0;">or</h5>
                    </form>
                    
                        <button class="find-location" id="find-location" onclick="showWaitingCat();getLocation();">Find my location and search</button>
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
            <li>
                <a href="restaurantowner.php">I'm an owner!</a>
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
            var backgroundImageArray = ["http://www.restaurantampersand.nl/wp-content/uploads/2013/10/restaurant.jpeg", "http://www.comohotels.com/metropolitanbangkok/sites/default/files/styles/background_image/public/images/background/metbkk_bkg_nahm_restaurant.jpg?itok=5wdbKYQA", "http://hirportal.sikerado.hu/images/kep/201408/etterem.jpg", "http://www.torrecatalunya.com/en/img/Visual-Eje-__H8.jpg"];
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
            $(".input-one").keypress(function(e) {
    if(e.which == 13) {
        $('#front-form').submit();
    }
});
        </script>
        <script>
        

function getLocation() {
    document.getElementById("find-location").innerHTML = '<img src="http://upload.wikimedia.org/wikipedia/commons/5/53/Loading_bar.gif" alt="Loading" width="170" />';
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert("Geolocation is not supported by this browser.");
        hideWaitingCat();
    }
}

function showPosition(position) {
    str = position.coords.latitude + ',' + position.coords.longitude;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.location.href = 'index.php?q='+$("#q-input").val()+'&place='+xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "geo.php?latlng=" + str, true);
        xmlhttp.send();
}

            function showWaitingCat(){
                $('.waiting-cat').css('z-index',1);$('.waiting-cat').css('opacity',0.9);
            }
            
            function hideWaitingCat(){
                $('.waiting-cat').css('z-index',-20);$('.waiting-cat').css('opacity',0);
            }
        </script>
    </body>
</html>