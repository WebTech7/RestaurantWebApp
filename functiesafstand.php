<?php
function getLanLon($address){
  $Address = ;// moet een straat zijn
  $Address = urlencode($Address);
  $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
  $xml = simplexml_load_file($request_url) or die("url not loading");
  $status = $xml->status;
  if ($status=="OK") {
      $Lat = $xml->result->geometry->location->lat;
      $Lon = $xml->result->geometry->location->lng;
  }
 return $Lat;
 return $Lon;
 } 
 function getDistance( $latitude1, $longitude1, $latitude2, $longitude2 )
{  
    $earth_radius = 6371;

    $dLat = deg2rad( $latitude2 - $latitude1 );  
    $dLon = deg2rad( $longitude2 - $longitude1 );  

    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);  
    $c = 2 * asin(sqrt($a));  
    $d = $earth_radius * $c;  

    return $d;  
}

$distance = getDistance( , , ,  );
if( $distance < 40 ){
    // variable bepaalden waarde op basis hiervan geven?
} else {
    // zoniet??
} 
  
  ?>
