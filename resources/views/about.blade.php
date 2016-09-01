@extends('layouts.main')

@section('title')

@section('content')
    <div class="container">
        <div class="panel-group " id="accordion" role="tablist" aria-multiselectable="true">
            <h1>О нас</h1>
            <p>
                Rempli – сервис экспресс-доставки продуктов в центре Москвы.<br>
Наша команда имеет большой опыт работы в сфере доставки как в России, так и в Германи, Италии, Франции, Швейцарии и США.<br>
Преимущества нашего сервиса:<br>
- Скорость. Моментальная доставка в любую точку ЦАО;<br>
- Выбор. Никаких посторонних товаров или поставщиков - только знакомый Вам, проверенный ассортимент магазина «Азбука Вкуса»;<br>
- Комфорт. Совершайте покупки в удобное для Вас время. Если заказ сделан в нерабочие часы - мы свяжемся с Вами по указанному телефону и уточним наиболее удобное время доставки; <br>
- Свежесть. Мы следим за качеством товара и стараемся привезти только самое свежее;<br> 
- Низкие цены и удобные тарифы на наши услуги; <br>
Забудьте об утомительных поездках по пробкам, постоянных мыслях о списке покупок, простаивании в очередях и тяжелых сумках.<br>
Доверьте поход за продуктами нам.
                <br>
                <br>
                Время работы:
                <br>
Мы работаем для Вас 7 дней в неделю с 10:00 до 23:00. Заказы принимаются в любое время.                <br><br>
                Где мы берем продукты:<br>
                Всю продукцию для доставки курьеры Rempli покупают в магазинах «Азбука Вкуса» рядом с Вами. После получения заказа Ваши продукты собираются в «Азбуке Вкуса» и наш курьер доставляет их до Вас за кратчайшее время.            </p>
        </div>
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

        <nav>
            <ul class="pager">
                <li class="previous"><a id="backToMain" href="/" class="backForth">
                    <span aria-hidden="true">&larr;</span> На главную</a>
                </li>


            </ul>
        </nav>

    </div>
@endsection