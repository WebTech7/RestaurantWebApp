<?php
$geo = 'http://maps.google.com/maps/api/geocode/xml?latlng='.htmlentities(htmlspecialchars(strip_tags($_GET['latlng']))).'&sensor=true';
$xml = simplexml_load_file($geo);

foreach($xml->result->address_component as $component){
	if($component->type=='postal_code'){
		$geodata['postcode'] = $component->long_name;
	}
}

echo $geodata['postcode'][0];
?>