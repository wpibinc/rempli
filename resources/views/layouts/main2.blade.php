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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    {{--<link rel="stylesheet" type="text/css" href="css/bootstrap-select.css">--}}
    {{--<link href="css/css" rel="stylesheet" type="text/css">--}}
    {{--<link href="css/css(1)" rel="stylesheet" type="text/css">--}}
    {{--<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="css/neobsos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/order.css">


        {{--Js--}}

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script src="http://www.parsecdn.com/js/parse-1.4.2.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&region=RU"></script>
    <script type="text/javascript" src="js/gmaps.js"></script>

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">


</head>
<body>

<div class="header headerOrder navbar-fixed-top">
    <nav class="navbar fluid-container">
        <div class="navbar-header">
            <a href="/"><img class="logo" id="logo_icon" src="img/first.png" height="30"></a>
            @if(Auth::user())
            <a href="/logout" class="orderlogin">Выход</a>
            @else
            <a href="/login" class="orderlogin">Вход / Регистрация</a>
            @endif
        </div>

        <div class="navbar-collapse collapse navbar-right"></div> </nav>
</div>




<div id="container-fluid1" class="container-fluid content">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 main-block">
            @yield('content')
        </div>
    </div>
</div>

<footer class="col-md-12 col-xs-12 col-sm-12">
    <a href="#" class="logo col-md-1 col-sm-3 col-xs-4"><img src="img/first.png" alt="rempli"></a>
    <div class="col-md-10 col-sm-6 col-xs-4"><span class="footer-copy">{{ Config('rempli.copyright') }}</span> </div>
    <a href="#" class="col-md-1 col-sm-3 col-xs-4"><img src="img/av5.png" alt="rempli"></a>
</footer>


{{--<script type="text/javascript" src="js/bootstrap-select.min.js"></script>--}}
{{--<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>--}}
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/cart.js"></script>
{{--<script type="text/javascript" src="js/categories.js"></script>--}}
<script type="text/javascript" src="/data/categories.json"></script>

@if (Request::is('payment'))
    <script type="text/javascript" src="js/payment.js"></script>
@endif
@if (Request::is('order'))
<script type="text/javascript" src="js/order.js"></script>
@endif

@if (Request::is('/'))
<script type="text/javascript" src="js/func.js"></script>
@endif
@if (Request::is('success'))
<script type="text/javascript" src="/js/success.js"></script>
@endif

<script type="text/javascript">

    $(document).on('click', ".dropdown-toggle", function(){
        $(this).after('<div class="dropdown-backdrop"></div>')
    });

</script>


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

</body>
</html>