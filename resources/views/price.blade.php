@extends('layouts.main')

@section('title')

@section('content')
    <div class="col-md-13 main-start-page">

        <div class="tabs col-md-8 col-md-offset-2">
    <div class="tabs col-md-12">
        <ul class="col-md-3">
            <li><i class="fa fa-pencil-square" aria-hidden="true"></i> Оформление заказа <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-map" aria-hidden="true"></i> Территория доставки <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Стоимость доставки <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-comments-o" aria-hidden="true"></i> Вопросы/ответы <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-clock-o" aria-hidden="true"></i> Время доставки <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
        </ul>
<div class="col-md-8" style="box-sizing:border-box;margin-left:30px">
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
                    <div>
На данный момент мы работаем только в центре Москвы - внутри Садового кольца и Центральном административном округе. Но не волнуйтесь – прямо сейчас наши специалисты трудятся над расширением территории доставки, чтобы Вы могли заказывать продукты на дом в любом месте.
                    </div>

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
                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&key=AIzaSyCfY6bVPAKPGnrrlTPVB-HYunHISJTcrAk"></script>
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
                             //mapTypeId: google.maps.MapTypeId.TERRAIN
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

                   // google.maps.event.addDomListener(window, 'load', initialize);
                </script>
            </div>
            <div>

                    <div class="">

<div class="panel panel-default">
<div class="panel-body">
<h1>
Стоимость разовой доставки
</h1>
<div>
Команда Rempli долго думала над тем, как сделать доставку наиболее простой и выгодной для Вас. Для этого мы разработали наиболее прозрачные условия оплаты наших услуг. Вы не переплачиваете за продукты, нет никаких сложных процентов за доставку, все просто:
<br>
Сумма заказа складывается из стоимости продуктов по чеку магазина и стоимости доставки.
<br>
Стоимость разовой доставки в Rempli:<br>
- 500р. – при любом заказе до 8кг;<br>
- 800р. – при любом заказе свыше 8кг.<br>
</div>
</div>
</div>
<br>
<div class="panel panel-default">
<div class="panel-body">
<h1>
Подписка</h1>
<div>
Всем пользователям Rempli доступна месячная подписка на доставку продуктов.<br> В рамках подписки доставка бесплатна и Вы оплачиваете только стоимость товаров по чеку. Вы можете выбрать между пакетами из 4, 8, 12 и 30 доставок. <br>Стоимость пакетов:<br>
- 1600р. - 4 доставки в месяц;<br>
- 3000р. - 8 доставок в месяц;<br>
- 4200р. - 12 доставок в месяц;<br>
- 7500р. - 30 доставок в месяц.<br>
</div>
</div>
</div>

                        </div>



            </div>
            <div>
                <h1>
                    Вопросы/ответы
                </h1>
                
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingTwo">
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
Где мы берем продукты?
</a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
<div class="panel-body">
Всю продукцию для доставки курьеры Rempli покупают в магазинах «Азбука Вкуса», «Metro» и «LaMaree» рядом с Вами. После получения заказа Ваши продукты собираются в магазине и наш курьер доставляет их до Вас за кратчайшее время. <br>
Внимание! Пользователям, не использующим подписку, доступна доставка только из магазинов «Азбука Вкуса».
</div>
</div>
</div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                Что если в магазине не окажется заказанного товара?
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            Все товары на сайте совпадают с реальным ассортиментом магазинов. Но если какого-либо товара в магазине не окажется, наш курьер позвонит Вам и вежливо уточнит - можно ли купить схожий товар или лучше вернуть Вам деньги.
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
                    Время доставки
                </h1>
<div>Время доставки из разных магазинов зависит от времени их работы и местоположения.</div><br>
<p>
Азбука Вкуса:<br>
Ежедневно с 10:00 до 23:00. Минимальное время доставки - 1 час.<br><br>
Metro и LaMaree (только для пользователей подписки):<br>
Ежедневно с 12:00 до 23:00. Минимальное время доставки - 3 часа.
</p>
            </div>
        </div>
    </div>
</div>
    <script>
        var initMap = false;
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
                        console.log($(this).attr("data-page"));
                        if($(this).attr("data-page")=='1'&&!initMap){
                            initMap = true;
                            initialize();
                        }
                        showPage(parseInt($(this).attr("data-page")));
                    });
                };
                return this.each(createTabs);
            };
        })(jQuery);
        $(document).ready(function(){
            
            $(".tabs").lightTabs();
//            switch(window.location.search){
//                case '?page=orders': showPage(1);
//                    break;
//                case '?page=adress': showPage(2);
//                    break;
//                case '?page=rules': showPage(3);
//                    break;
//                default: showPage(0);
//                    break;
//            }
        });
    </script>
@endsection
