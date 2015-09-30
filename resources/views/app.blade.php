<!DOCTYPE html>
<html>
    <head>
        <title>Tweet Search</title>
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div id="map" style="width: 100%; height: 600px;"></div>
            </div>
            <div class="row">
                <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                <input type="text" id="city-input" placeholder="Enter a City">
            </div>
        </div>
    </body>

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script>
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

            input = (document.getElementById('city-input'));

            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            infowindow = new google.maps.InfoWindow();
            marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);

                place = autocomplete.getPlace();
                geometry['lat'] = place.geometry.location.H;
                geometry['long'] = place.geometry.location.L;

                if(place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(20);
                }

                var search_results = searchTweets(geometry['lat'], geometry['long']);
                console.log(search_results);

                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
            });
        }

        function searchTweets(lat, long) {
            $.ajax({
                url: 'search',
                method: 'POST',
                data: {
                    lat: lat,
                    long: long,
                    _token: token
                }
            })
            .done(function(data) {
                console.log(data);
                return data;
            });
        }

        function handleLocationError(browseHasGeoLocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browseHasGeoLocation ? 
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyVoe53P44XZmO5uR3wwBBqbJssstTq1E&libraries=places&callback=initMap" async defer></script>
</html>
