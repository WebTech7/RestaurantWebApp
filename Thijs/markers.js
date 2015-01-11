  function codeAddress(addresses,infocontent) {
    var address = addresses;
    var infocontents = infocontent;
    var restauranticon = 'http://google-maps-icons.googlecode.com/files/restaurant.png';
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);

            var marker = new google.maps.Marker({
              position: (results[0].geometry.location),
              draggable: false,
              raiseOnDrag: true,
              icon: restauranticon,
              map: map,
            });

            var infowindow = new google.maps.InfoWindow({
              content: infocontents
            });

            google.maps.event.addListener(marker, 'click', function() {
              infowindow.open(map,marker);
            });

            
      } else {
        alert("Geocode was not successful for the following reason: " + status); //don't do anything if the address is non-existent
      }
    });

  }