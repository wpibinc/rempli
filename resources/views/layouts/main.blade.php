<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', Config('rempli.title'))</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="Доставка продуктов в центре Москвы за 1 час. Сходим за Вас в Азбуку Вкуса!">

    {{--Style--}}
    <link rel="stylesheet" type="text/css" href="/js/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    {{--<link href="css/css" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    @if (Request::is('login') or Request::is('register'))
    <link rel="stylesheet" type="text/css" href="css/signin.css">
    @endif
    <link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
    <link href="/css/neobsos.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">
    <link href="/js/bootstrap-slider-master/css/bootstrap-slider.min.css" rel="stylesheet">
    @yield('style')

    {{--Js--}}

    <script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
    <script src="http://www.parsecdn.com/js/parse-1.4.2.min.js"></script>
    <script type="text/javascript" src="/js/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-slider-master/bootstrap-slider.min.js"></script>
    <script>
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>
@if (session('order'))
    <script>
        sessionStorage.clear();
        localStorage.clear();
    </script>
@endif
</head>
<body>
<div class="popup-alcogol col-md-12">
<p class="alcogol">Продажа алкоголя с <span>18+</span></p>
<a href="#" class="ok-popup btn btn-warning">Согласен</a>
<a href="#" class="close-popup btn btn-default">Отмена</a>
</div>
<header class="header">
    <div class="topline col-md-12">
        <a href="/" class="logo"><img src="img/first.png" alt="rempli"></a>
        @if($subscription)
        <form id='change-shop-form' action="" method="get">
            <select name="shop">
                @if(session('shop') == 'Av')
                    <option value="Av" selected="selected">Азбука Вкуса</option>
                @else
                    <option value="Av">Азбука Вкуса</option>
                @endif
                @if(session('shop') == 'La')
                    <option value="La" selected="selected">La Maree</option>
                @else
                    <option value="La">La Maree</option>
                @endif
            </select>
        </form>
        @endif
        <a href="#" id="dd_btn">
            <button class="cart-btn"><img src="img/cart.png">Корзина <span id="cart-number">0</span></button>
        </a>
        @if(Auth::user())
<!--            <a href="/logout" class="login">Выход </a>-->
                <a href="#" class="login">Личный кабинет <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                <ul class="my-account">
                    <li><a href="/my-account"><i class="fa fa-user" aria-hidden="true"></i> Учётная запись</a></li>
                    <li><a href="/my-account?section=orders"><i class="fa fa-list-alt" aria-hidden="true"></i> История заказов</a></li>
                    <li><a href="/my-account?section=adress"><i class="fa fa-phone" aria-hidden="true"></i> Адреса</a></li>
                    <li><a href="/my-account?section=subscription"><i class="fa fa-bullhorn" aria-hidden="true"></i> Подписка</a></li>
                    <li><a href="/my-account?section=order-list"><i class="fa fa-list-alt" aria-hidden="true"></i> Cписок заказов</a></li>
                    <li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход </a></li>
                    <li><a href="/rules"><i class="fa fa-book" aria-hidden="true"></i> Правила сайта</a></li>
                </ul>
        @else
            <a href="/login" class="login">Вход / Регистрация </a>
        @endif
    </div>
    <br class="clear">
    <h1 class="col-md-8 col-md-offset-2">Доставка продуктов за 1 час в центре Москвы</h1>
    <h3 class="col-md-8 col-md-offset-2">Первая	доставка бесплатно</h3>
</header>


<div>
    <div class="backdrop"></div>

    <div id="dd_body">
        <div class="result-serch">
            <table class="table">
                <thead>

                </thead>
                <tbody >
                <tr data-category="5" class="ordered-item" id="cart-32526">
                    <td class="quantity"> x 1<br>
                        <a href="#" class="cart-change cart-add"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span><span class="cart-del-txt"> Добавить</span></a>
                        <br><a href="#" class="cart-change cart-min"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span><span class="cart-del-txt"> Убрать</span></a>
                    </td>
                    <td class="image hidden-xs hidden-sm">
                        <span class="helper"></span><img src="http://av.ru/images/cms/data/items/220174/card/220174.jpg" alt=""></td>
                    <td class="name">
                        <a href="#" data-toggle="modal" data-target="#idt32526">Майонез Слобода на перепелиных яйцах 67% 200 г с дозатором Россия</a></td>
                    <td class="price">
                        <span class="priceShow">56.7</span>р</td>
                    <td class="total">
                        <span class="weight" style="display:none">200</span><span class="totalShow">57</span>р<a href="#" class="cart-change cart-add-t">+</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div id="cart_white">
            <input class="autocomplete" placeholder="Поиск" type="text">
            <h2>Корзина товаров</h2>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="cart-total">

            <table>
                <tbody>
                <th>

                </th>
                </tbody>
            </table>
            <button id="add-to-order-list" class="btn btn-primary checkout_button" >Добавить в список заказов</button>
            <button class="checkout_button btn btn-primary" id="orderBtn">Заказать <span id="cototal"><span id="cart-price">100</span> руб</span></button>
            <p id="notmin">Извините, минимальная сумма заказа: 200р</p>

        </div>


        <div class="cart-info dropdown-menu2 cart" id="cart-items">
            
            <table class="table">
                <thead>
                
                </thead>
                <tbody id="ordered-items">
                </tbody>
            </table>
        </div>
    </div>
</div><!-- /.navbar-collapse -->

<div class="menu-neobsos">
    <ul class="col-md-6 col-md-offset-3 col-sm-8 col-xs-12">
        <li><a href="/" {!! (Request::is('/')) ? 'class="active"' : '' !!}>Магазин</a></li>
        <li><a href="/about" {!! (Request::is('about')) ? 'class="active"' : '' !!}>О нас</a></li>
        <li><a href="/reviews" {!! (Request::is('reviews')) ? 'class="active"' : '' !!}>Отзывы</a></li>
        <li><a href="/price" {!! (Request::is('price')) ? 'class="active"' : '' !!}>Доставка и оплата</a></li>
        <li><a href="/contacts" {!! (Request::is('contacts')) ? 'class="active"' : '' !!}>Контакты</a></li>
    </ul>
    <input type="text" name="site-search" class="col-md-offset-1 col-md-2 search-neobsos" id="search" placeholder="Поиск товаров">
</div>



<div id="container-fluid1" class="container-fluid content">
    <div class="row">

        @if (Request::is('/'))
            @include('misc.menu')
        @endif

        <div class="col-md-12 col-sm-12 col-xs-12 main-block">
            @yield('content')
        </div>
    </div>
</div>
<div  id="map-canvas"></div>


<footer class="col-md-12 col-xs-12 col-sm-12 navbar-bottom">
    <a href="#" class="logo col-md-1 col-sm-3 col-xs-4"><img src="img/first.png" alt="rempli"></a>
    <div class="col-md-10 col-sm-6 col-xs-4 text-center"><span class="footer-copy">{{ Config('rempli.copyright') }}</span> </div>
    <a href="#" class="col-md-1 col-sm-3 col-xs-4"><img src="img/av5.png" alt="rempli"></a>
</footer>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/cart.js"></script>
{{--<script type="text/javascript" src="js/categories.js"></script>--}}
{{--<script type="text/javascript" src="js/categories2.js"></script>--}}
<!--<script type="text/javascript" src="/data/categories.json"></script>-->
<script type="text/javascript" src="/js/func.js"></script>
<script type="text/javascript" src="/js/func2.js"></script>
@if(Request::is('my-account'))
    
    <script type="text/javascript" src="/js/account.js"></script>
@endif
<!-- <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> -->


@if (Request::is('/test'))
    <!-- BEGIN JIVOSITE CODE {literal} -->
    <script type='text/javascript'>
        (function(){ var widget_id = 'lS8jinVThZ';
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = 'http://code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
    <!-- {/literal} END JIVOSITE CODE -->
@endif

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-56789746-5', 'auto');
    ga('send', 'pageview');

</script>
<div class="center" style="display:none">
  <div class="bouncywrap">
        
        <div class="dotcon dc1">
        <div class="dot"></div>
        </div>
    
        <div class="dotcon dc2">
        <div class="dot"></div>
        </div>
    
        <div class="dotcon dc3">
        <div class="dot"></div>
        </div>

  </div>
</div>
<div class="bg-shadow" style="display:none">
</div>
<div class="modal fade success-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Готово!</h4>
            </div>
            <div class="modal-body">
                <p>Мы получили Ваш заказ. В ближайшее время мы свяжемся с Вами для подтверждения.</p>
            </div>
            <div class="modal-footer" style="text-align: center">
                <button type="button" class="btn btn-default" data-dismiss="modal" >Закрыть</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@if (session('order'))
    <script>
        $('.success-modal').modal('show');
    </script>
@endif
<script>
    //$('.success-modal').modal('show');
    $('.cart-btn').on('click',function () {
        $('#dd_body').addClass('activeMenu');
    });
    $('.backdrop').on('click',function () {
        $('#dd_body').removeClass('activeMenu');
    });
    
    $('.bg-shadow').on('click',function () {
        $('.add-form').hide();
        $('.bg-shadow').hide();
        $('.yesPopup').fadeOut();
    });
    $('.close-form').on('click',function () {
        $('.add-form').hide();
        $('.bg-shadow').hide();
    });
    /*
     * 
     */
    
</script>
</body>
</html>
