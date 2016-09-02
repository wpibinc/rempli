@extends('layouts.main')

@section('title')

@section('content')
    <div class="tabs col-md-12">
        <ul class="col-md-2">
            <li>Оформление заказа</li>
            <li>Территория доставки </li>
            <li>Сколько стоит</li>
            <li>Вопросы/ответы</li>
            <li>Как мы работаем</li>
        </ul>
        <div class="col-md-10">
            <div >
                <h1>
                    Оформление заказа
                </h1>
            </div>
            <div>
                <div class="">
                    <h1>
                        Территория доставки
                    </h1>
                    <p>
                        На данный момент мы работаем только в центре Москвы. Но не волнуйтесь – прямо сейчас наши специалисты трудятся над расширением территории доставки, чтобы Вы могли заказывать продукты на дом в любом месте.
                    </p>

                    <div id="map-canvas">

                    </div>
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
            </div>
            <div>

                    <div class="">
                        <h1>
                            Сколько стоит
                        </h1>
                        <p>
                            Мы в Rempli долго думали над тем, как сделать доставку наиболее простой и выгодной для Вас. Для этого мы разработали наиболее прозрачные условия оплаты наших услуг. Вы не переплачиваете за продукты, нет никаких сложных процентов за доставку, все просто:
                            <br>
                            Сумма заказа - стоимость продуктов по чеку магазина + стоимость доставки.
                            <br>
                            Стоимость доставки в Rempli:<br>
                            - 500р. – при любом заказе до 8кг.<br>
                            - 800р. – при любом заказе свыше 8кг.

                        </p>


                    </div>

            </div>
            <div>
                <h1>
                    Вопросы/ответы
                </h1>

            </div>
            <div>
                <h1>
                    Как мы работаем
                </h1>

            </div>
        </div>
    </div>


    <script>
        (function($){
            jQuery.fn.lightTabs = function(options){

                var createTabs = function(){
                    tabs = this;
                    i = 0;

                    showPage = function(i){
                        $(tabs).children("div").children("div").hide();
                        $(tabs).children("div").children("div").eq(i).show();
                        $(tabs).children("ul").children("li").removeClass("active");
                        $(tabs).children("ul").children("li").eq(i).addClass("active");
                    }

                    showPage(0);

                    $(tabs).children("ul").children("li").each(function(index, element){
                        $(element).attr("data-page", i);
                        i++;
                    });

                    $(tabs).children("ul").children("li").click(function(){
                        showPage(parseInt($(this).attr("data-page")));
                    });
                };
                return this.each(createTabs);
            };
        })(jQuery);
        $(document).ready(function(){
            $(".tabs").lightTabs();
            switch(window.location.search){
                case '?page=orders': showPage(1);
                    break;
                case '?page=adress': showPage(2);
                    break;
                case '?page=rules': showPage(3);
                    break;
                default: showPage(0);
                    break;
            }
        });
    </script>
@endsection