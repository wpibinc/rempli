@extends('layouts.main')

@section('title')

@section('content')
    <div class="container">
        <h1>
            Где работаем
        </h1>
        <p>
            На данный момент мы работаем только в центре Москвы. Но не волнуйтесь – прямо сейчас наши специалисты трудятся над расширением территории доставки, чтобы Вы могли заказывать продукты на дом в любом месте.
        </p>
        <nav>
            <ul class="pager">
                <li class="previous"><a id="backToMain" href="/" class="backForth"><span aria-hidden="true">&larr;</span> На главную</a>
                </li>
            </ul>
        </nav>

    </div>

    <style>
        html, body, #map-canvas {
            height: 600px;

        }
        .container, #map-canvas {
            margin-top: 40px;
            width: 700px!important;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
    <script>
        var citymap = {};
        citymap['Moscow'] = {
            center: new google.maps.LatLng(55.7505, 37.619)
        };


        var cityCircle;

        function initialize() {
            // Create the map.
            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng(55.753854, 37.623539),
                // mapTypeId: google.maps.MapTypeId.TERRAIN
            };

            var map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);

            // Construct the circle for each value in citymap.
            // Note: We scale the area of the circle based on the population.
            for (var city in citymap) {
                var populationOptions = {
                    strokeColor: '#66cc66',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: '#66cc66',
                    fillOpacity: 0.4,
                    map: map,
                    center: citymap[city].center,
                    radius: 3000
                };
                // Add the circle for this city to the map.
                cityCircle = new google.maps.Circle(populationOptions);
            }
        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
@endsection