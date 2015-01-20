<!DOCTYPE html>
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

        var addresses = new Array("Amsterdam", "Domino's Pizza Rotterdam Centrum, Mariniersweg, Rotterdam", "Dordrecht", "Arnhem", "Breda", "Tilburg", "Groningen", "Leeuwarden", "Maastricht");
             <?php if(isset($_GET["addresses"])){
        echo "addresses = new Array(";
    $addresses = json_decode($_GET["addresses"],true);
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
        var contents = new Array("Chinees", "Pizza", "Villa", "Italian", "Fastfood", "Pizza", "Indisch", "Wok", "Gastronomisch", "Frans", "Italian", "Thais");
        for(i=0; i<addresses.length; i++){
          markers = codeAddress(addresses[i], contents[i]);
        }
      }
           google.maps.event.addDomListener(window, 'load', initialize);
	     
	   </script>
  </head>
    <body style="padding:0;margin:0;background:#f5f5f5;">
    <div id="map" style="width:100%;height:100vh;border:none;padding:0;margin:0;"></div>
  </body>
</html>