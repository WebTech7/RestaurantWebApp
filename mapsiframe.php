<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>Map</title>

    <link rel="stylesheet" type="text/css" href="labels.css">
   
     <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
     <script src="https://maps.googleapis.com/maps/api/geocode/output?parameters"></script>
     <script type="text/javascript" src="markers.js"></script> 
     <script type="text/javascript" src="MarkerWithLabel.js"></script>
  
	   <script>
       var geocoder;
       var map;
	     function initialize() {
        geocoder = new google.maps.Geocoder();
        var myLatlng = new google.maps.LatLng(51.448610,5.490715); 
        var mapOptions = {
          zoom: 14,
          center: myLatlng
        }
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
             addresses = new Array('Amsterdam');
             contents = new Array('Contents');
             <?php if(isset($_SESSION["addresses-json-results"])){
        echo "addresses = new Array(";
    $addresses = json_decode($_SESSION["addresses-json-results"],true);
    $a=0;
    foreach($addresses as $address){
        $a++;
        if($a != count($addresses)){
        echo "'$address',";
        } else {
            echo "'$address'";
        }
    }
    echo ");\n";  } ?>
             <?php 
             if(isset($_GET["location"])){
                 echo 'addresses = new Array("'.$_GET["location"].'");';
                 echo "contents = new Array('$_GET[name]');";
             } else if(isset($_SESSION["contents-json-results"])){
        echo "contents = new Array(";
    $contents = json_decode($_SESSION["contents-json-results"],true);
    $contents2 = json_decode($_SESSION["contents2-json-results"],true);
    $a=0;
//    var_dump($contents2);
    foreach($contents as $content){
        $a++;
        if($a != count($contents)){
        echo "'". html_entity_decode ($content.$contents2[$a-1]) ."',";
        } else {
            echo "'". html_entity_decode ($content.$contents2[$a-1]) ."'";
        }
    }
    echo ");\n";  }
             ?>
             
        for(i=0; i<addresses.length; i++){
          codeAddress(addresses[i], contents[i]);
        }
      }
//            map.fitBounds (bounds);
           google.maps.event.addDomListener(window, 'load', initialize);
	     
	   </script>
  </head>
    <body style="padding:0;margin:0;">
    <div id="map" style="width:100%;height:100vh;border:none;padding:0;margin:0;"></div>
  </body>
</html>