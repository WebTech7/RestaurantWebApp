<?php
$geo = 'http://maps.google.com/maps/api/geocode/xml?latlng='.htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))).'&sensor=true';
$xml = simplexml_load_file($geo);

if(isset($xml->result->address_component) && !empty($xml->result->address_component)){
    foreach($xml->result->address_component as $component){
        if($component->type=='postal_code'){
            $returnPlace = $component->long_name;
        } else if(isset($xml->result[0]->formatted_address) && !empty($xml->result[0]->formatted_address)){
            $returnPlace = $xml->result[0]->formatted_address;
        } else {
            $returnPlace = "";
        }
    }
} else {
    $returnPlace = "";
}

//echo ( $xml->result[0]->formatted_address  );
echo $returnPlace;
?>