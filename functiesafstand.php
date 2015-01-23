<?php

 function getDistance($from, $to)
{  
     $request_url = file_get_contents(("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=car"));
    $json = json_decode($request_url,true);
    return $json["rows"][0]["elements"][0]["distance"]["value"];
}

function notTooFar($distance, $from, $to){
    if( $distance > getDistance($from, $to) ){
        return true;
    } else {
        return false;
    }
}
//var_dump(getDistance(urlencode("5632DX"), urlencode("1722HG")));
var_dump(notTooFar(1, "1722HG", "1728AB"));
  ?>
