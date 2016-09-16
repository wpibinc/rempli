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

    <div class="modal fade success-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Спасибо за заказ!</h4>
                </div>
                <div class="modal-body">
                    <p>Ваш заказ был нами успешно получен. В ближайшие несколько минут, мы позвоним Вам для уточнения информации.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
