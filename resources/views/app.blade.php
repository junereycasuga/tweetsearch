<!DOCTYPE html>
<html>
    <head>
        <title>Tweet Search</title>
        <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <style>
            body, html {
                height: 100%;
                width: 100%;
            }

            #map-container {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>
    <body>
        @yield('content')
    </body>

    <script src="/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyVoe53P44XZmO5uR3wwBBqbJssstTq1E&libraries=places&callback=initMap" async defer></script>
</html>
