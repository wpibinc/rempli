@extends('layouts.main')

@section('title')

@section('content')
<div class="col-md-12">
    <div class="tabs col-md-12">
        <ul class="col-md-2">
            <li>Учетная запись</li>
            <li>История заказов</li>
            <li>Адреса</li>
            <li>Правила</li>
            <li><a href="/logout">Выход</a></li>
        </ul>
        <div class="col-md-10">
            <div class='orders'>Первое содержимое</div>
            <div>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($orders as $order)
                            <tr>
                                <td><?php echo ++$i ?></td>
                                <td><a class='get-order-details' href='javascript:void(0)'>{{$order->cost}} руб</a></td>
                                <td>{{$order->status}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div> 
            </div>
            <div>Третье содержимое</div>
            <div>4 содержимое</div>
            <div>5 содержимое</div>
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
</div>
@endsection

