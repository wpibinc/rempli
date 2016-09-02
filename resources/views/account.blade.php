@extends('layouts.main')

@section('title')

@section('content')
<div class="col-md-12">
    <div class="tabs col-md-12">
        <ul class="col-md-2">
            <li>Первая вкладка</li>
            <li>Вторая вкладка</li>
            <li>Третья вкладка</li>
            <li>4 вкладка</li>
            <li>5 вкладка</li>
        </ul>
        <div class="col-md-10">
            <div>Первое содержимое</div>
            <div>Второе содержимое</div>
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
        });
    </script>
</div>
@endsection

