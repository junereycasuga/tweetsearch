var map,
    input,
    autocomplete,
    infowindow,
    marker,
    place,
    geometry = [];
    token = $("#_token").val();

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13
      });

    if($('#city-input').val()) {
        place = $('#city-input').val();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address':place}, function(results, status) {
            if(status == google.maps.GeocoderStatus.OK) {
                geometry['lat'] = results[0].geometry.location.lat();
                geometry['lng'] = results[0].geometry.location.lng();

                map.setCenter(results[0].geometry.location);
                map.setZoom(12);

                searchTweets(place, geometry['lat'], geometry['lng'], map);
            } else {
                alert("Can't look for results.");
            }
        });   
    }  else {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                map.setCenter(pos);
            }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            handleLocationError(false, infoWindow, map.getCenter());
        }
    }

    $('#searchBtn').on('click', function() {
        place = $('#city-input').val();

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address':place}, function(results, status) {
            if(status == google.maps.GeocoderStatus.OK) {
                geometry['lat'] = results[0].geometry.location.lat();
                geometry['lng'] = results[0].geometry.location.lng();

                map.setCenter(results[0].geometry.location);
                map.setZoom(12);

                searchTweets(place, geometry['lat'], geometry['lng'], map);
            } else {
                alert("Can't look for results.");
            }
        });
    });
}

function searchTweets(city, lat, lng) {
    $.ajax({
        url: 'search',
        method: 'POST',
        data: {
            city: city,
            lat: lat,
            lng: lng,
            _token: token
        }
    })
    .done(function(data) {
        marker = new google.maps.Marker({
            map: null
        });
        $.each(data, function(key, value) {
            var data = value;
            var new_pos = {
                    lat: data.coordinates.lng,
                    lng: data.coordinates.lat
                };
            marker = new google.maps.Marker({
                position: new_pos,
                icon: data.user.image,
                map: map,
                title: data.text
            });

            newInfoWindow = new google.maps.InfoWindow();
            marker.addListener('click', function() {
                var content = 'Tweet: ' + data.text + '<br>When: ' + data.tweeted_at;
                newInfoWindow.setContent(content);
                newInfoWindow.open(map, this);
            });
        });
    });
}

function handleLocationError(browseHasGeoLocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browseHasGeoLocation ? 
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
}