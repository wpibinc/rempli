@extends('layouts.main')

@section('title')

@section('content')
    <h2 class="header_cat"></h2>
    <div id="item-wrap-inner" class="products-wrap">
        <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12">

<div class="panel panel-default">
  <div class="panel-heading">
<font size=6>
Акции</font>
</div>
  <div class="panel-body">Позвольте нам проявить себя. Всем новым клиентам первая доставка при заказе по телефону <u>бесплатно</u>!
</div>
</div>

            <br>
<div class="panel panel-default">
  <div class="panel-heading"><font size=6>Новости</font></div>
  <div class="panel-body"><u>17.08.2016</u><br>
С 18 августа всем клиентам Rempli доступна доставка алкоголя из магазинов "Азбука Вкуса" с 10:00 до 23:00.<br>
- Заказы на алкоголь будут приниматься до 22:00,<br>
- На выбор доступны алкогольные напитки и энотека,<br>
- При получении заказа на алкоголь клиент расписывается в агентском договоре и получает на руки чек из магазина.<br>
Мы постоянно работаем над улучшением нашего сервиса и в ближайшее время запустим ночную доставку продуктов и алкогольных напитков для наших клиентов.<br>

Rempli - проще, чем Вы думаете.<br>
            <br>
<u>15.08.2016</u><br>
Уважаемые клиенты, по причине технических неполадок нам пришлось на время убрать из AppStore наше официальное приложение. В ближайшее время оно будет восстановлено.
</div>
</div>        </div>
     </div>
        <script>
            var rubric=[];
            rubric = {!! json_encode($categories->pluck('alias')->toArray()) !!};
            var {!! implode(',', $categories->pluck('alias')->toArray()) !!} = '';
        </script>
@endsection

<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-82627253-1', 'auto');
ga('send', 'pageview');

</script>
