@extends('layouts.main')

@section('title')

@section('content')
    <h2 class="header_cat"></h2>
    <div class="av-categ-menu"></div>
    <div style="clear:both"></div>
    <div id="item-wrap-inner" class="products-wrap">
        <div class="col-md-8 col-md-offset-2 col-sm-12 col-xs-12 main-start-page">
            <img src="/img/main_title.png" alt='main' >
            <div class="col-md-12">
                <div class="col-md-6">
                    <img src="/img/main_girl.png" alt='main' >
                </div>
                <div class="col-md-6">
                    <h4>1. Выбор продуктов</h4>
                    <p>В нашем магазине вы можите выбрать из тысяч продуктов</p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <h4>1. Выбор продуктов</h4>
                    <p>В нашем магазине вы можите выбрать из тысяч продуктов</p>
                </div>
                <div class="col-md-6">
                    <img src="/img/main_girl2.png" alt='main' >
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <img src="/img/main_guys.png" alt='main' >
                </div>
                <div class="col-md-6">
                    <h4>1. Выбор продуктов</h4>
                    <p>В нашем магазине вы можите выбрать из тысяч продуктов</p>
                </div>
            </div>
        </div>

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
