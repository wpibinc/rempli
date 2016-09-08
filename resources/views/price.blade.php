@extends('layouts.main')

@section('title')

@section('content')
        <div class="tabs col-md-12">
        <ul class="col-md-2">
            <li><i class="fa fa-pencil-square" aria-hidden="true"></i> Оформление заказа <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-map" aria-hidden="true"></i> Территория доставки <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Стоимость доставки <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-comments-o" aria-hidden="true"></i> Вопросы/ответы <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-coffee" aria-hidden="true"></i> Как мы работаем <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
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
                   #map-canvas {
                        height: 400px;

                    }
                    .container, #map-canvas {
                        margin-top: 40px;
                        width: 100%!important;
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
                            Стоимость доставки
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
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Как сделать заказ?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            - с помощью сайта,<br>
                            - через официальное приложение Rempli в AppStore,<br>
                            - по телефону +7-499-955-26-98.
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Что если в магазине не окажется заказанного товара?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            Все товары на сайте совпадают с реальным ассортиментом магазинов «Азбука Вкуса». Но если какого-либо товара в магазине не окажется, наш курьер позвонит Вам и вежливо уточнит - можно ли купить схожий товар или лучше вернуть Вам деньги.
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Как с Вами связаться?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body">
                            По всем интересующим Вас вопросам Вы можете обращаться по номеру телефона или адресу электронной почты, указанным на странице Контакты.
                        </div>
                    </div>
                </div>


            </div>
            <div>
                <h1>
                    Как мы работаем
                </h1>
                <h4>Где работаем</h4>
                На данный момент мы работаем только в центре Москвы.<br> Но не волнуйтесь – прямо сейчас наши специалисты трудятся над расширением территории доставки, чтобы Вы могли заказывать продукты на дом в любом месте.
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