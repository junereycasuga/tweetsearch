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

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -33.8688, lng: 151.2195},
                zoom: 13
              });

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
                console.log(geometry);
            });
        }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyVoe53P44XZmO5uR3wwBBqbJssstTq1E&libraries=places&callback=initMap" async defer></script>
</html>
