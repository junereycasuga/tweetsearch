<!DOCTYPE html>
<html>
    <head>
        <title>Tweet Search</title>
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div id="map" style="width: 100%; height: 600px;"></div>
    </body>

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 4
        });
    }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyVoe53P44XZmO5uR3wwBBqbJssstTq1E&callback=initMap" async defer></script>
</html>
