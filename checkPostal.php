<?php

 function getDistance2($from, $to) {  
     $request_url = file_get_contents(("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&mode=car&API_key=AIzaSyAixI8QmfgTUJUrvWn_4mC7trEZP8PbkJA"));
    $json = json_decode($request_url,true);
    return $json["rows"][0]["elements"][0]["distance"]["value"];
}

function notTooFar2($distance, $from, $to){
    if( $distance >= getDistance2(urlencode($from), urlencode($to)) ){
        return true;
    } else {
        return false;
    }
}
$distance = $_GET["distance"];
if(isset($resFrom)){
    $postalcode = $resFrom;
    $ingegevenPostalcode = $resTo;
    $distance = $resDistance;
} else {
    $postalcode = $_GET["from"];
    $ingegevenPostalcode = $_GET["to"];
    if(!isset($_COOKIE["postal_code"])){
        setcookie("postal_code", $ingegevenPostalcode);
    } else {
        $_COOKIE["postal_code"] = $ingegevenPostalcode;
    }
}
if(notTooFar2(str_replace(" ", "", $distance), str_replace(" ", "", $postalcode), str_replace(" ", "", $ingegevenPostalcode)) && (getDistance2(str_replace(" ", "", $postalcode), str_replace(" ", "", $ingegevenPostalcode)) != 0 || str_replace(" ", "", $postalcode) == str_replace(" ", "", $ingegevenPostalcode)) && str_replace(" ", "", $distance) != "" && str_replace(" ", "", $postalcode) != "" && str_replace(" ", "", $ingegevenPostalcode) != ""){
    echo '<div class="alert alert-success" role="alert">This restaurant orders at your place!</div>';
} else {
    echo '<div class="alert alert-danger" role="alert">Unfortunately, this restaurant does not order at your place.</div>';
}
?>