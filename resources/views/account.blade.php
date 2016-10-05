@extends('layouts.main')

@section('title')

@section('content')
<div class="col-md-12">
    <div class="tabs col-md-12">
        <ul class="col-md-2">
            <li><i class="fa fa-user" aria-hidden="true"></i> Учетная запись <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-list-alt" aria-hidden="true"></i> История заказов <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-phone" aria-hidden="true"></i> Адреса <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-bullhorn" aria-hidden="true"></i> Подписка <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-book" aria-hidden="true"></i> Правила <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a> <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
        </ul>
        <div class="col-md-10 ">
            <div class='account '>
                
                <div class="wrapper-acaunt col-md-12">
                    <h4>ИЗМЕНИТЬ ПАРОЛЬ</h4>
                    <div class='password col-md-12'>
                        <label class="col-md-2">Пароль</label>
                        <input type='password' class="col-md-3" value='1111'>
                        <p class="error"></p>
                    </div>
                    <button class='change-password acount-btn-custom'>Изменить</button>
                </div>
                <div class="wrapper-acaunt col-md-12">
                    <h4>ЛИЧНАЯ ИНФОРМАЦИЯ</h4>
                    
                    <div class='email col-md-12'>
                        <label class="col-md-2">Email</label>
                        <input type='text' name='email' class="col-md-3" value='{{$user->email}}'>
                        <p class="error"></p>
                    </div>
                    <div class='phone col-md-12'>
                        <label class="col-md-2">Телефон</label>
                        <input type='text' name='phone' class="col-md-3 phone-input" value='{{$user->phone}}'>
                        <p class="error"></p>
                    </div>
                    <div class='fname col-md-12'>
                        <label class="col-md-2">Имя</label>
                        <input type='text' name='fname' class="col-md-3" value='{{$user->fname}}'>

                    </div>
                    <div class='sname col-md-12'>
                        <label class="col-md-2">Фамилия</label>
                        <input type='text' name='sname' class="col-md-3" value='{{$user->sname}}'>

                    </div>
                    <button class='change-user-info acount-btn-custom'>Изменить</button>
                </div>

                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            </div>
            <div class='orders wrapper-acaunt'>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>#</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($orders as $order)
                            <tr>
                                <td><?php echo ++$i ?></td>
                                <td><a class='get-order-details' href='javascript:void(0)'>{{$order->cost}} руб</a></td>
                                <td>{{$order->status}}</td>
                                <td><button data-id="{{$order->id}}" class="order-get-more">Подробнее</button><div class="order-details"></div></td>

                            </tr>
                        @endforeach
                    </table>
                </div>
                {{$orders->appends(['section' => 'orders'])->render()}}
            </div>
            <div class='adresses wrapper-acaunt'>
                <a href="#" class="add-form-btn"><i class="fa fa-plus" aria-hidden="true"></i> Добавить адрес</a>
                <div class='add-form'>
                    <i class="fa fa-times close-form" aria-hidden="true"></i>
                    <div class="form-group">
                        <label class=" control-label" for="home-inputt">Адрес </label>
                        <input id="street-input" class="form-control" type="text" placeholder="Улица" autofocus="" name="street" value="">
                        <label class=" control-label" for="inputName"> </label>
                            <input id="user" type="hidden"  value="1">
                            <input id="house" class="form-control twoad" type="text" placeholder="Дом">
                            <label id="flatlab" for="korp"></label>
                            <input id="korp" class="form-control twoad" type="text" placeholder="Корпус">
                            <label id="flatlab" for="exampleInputEmail2"></label>
                            <input id="flat" class="form-control  twoad" type="text" placeholder="Квартира">
                            <p class="help-block text-danger"></p>

                    </div>
                    <buttod class='btn add-adress'>Добавить</buttod>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Улица</th>
                            <th>Дом</th>
                            <th>Корпус</th>
                            <th>Квартира</th>
                            <th></th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($adresses as $adress)
                            <tr>
                                <td>{{$adress->street}}</td>
                                <td>{{$adress->home}}</td>
                                <td>{{$adress->korp}}</td>
                                <td>{{$adress->flat}}</td>
                                <td><a class='adress-del' data-id='{{$adress->id}}' href='javascript:void(0)'>Удалить</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div> 
            </div>
            <div class='subscription wrapper-acaunt'>
                <input type="hidden" value="0" class="subscriptionHide">
                <input type="hidden" value="{{$user->id}}">
                <div class="falseSubscription">
                    <h3>Подписка</h3>
                    <div>Текст Подписки</div>
                    <p class="costSubscription"><span>500</span> руб</p>
                    <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="4" data-slider-max="28" data-slider-step="1" data-slider-value="4"/>
                    <p class="finalPriceSubscription"><span>0</span> руб</p>
                    <button type="button" class="buySubscription btn btn-default">Купить</button>
                </div>
                <div class="trueSubscription hideDiv">
                    <h3>Подписка</h3>
                    <table class="table-striped ">
                        <tbody>
                        <tr>
                            <td><span>количество оставшихся доставок/количество доставок всего</span> </td>
                            <td><span class="countDelivery"></span>/<span class="countDeliveryAll"></span></td>
                        </tr>

                        <tr>
                            <td colspan="1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> автопродление подписки
                                    </label>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="1"><button class="btn btn-default editSubscription" type="button">изменить условия</button> </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class='rules wrapper-acaunt'>Правила</div>
        </div>
    </div>
    <div class="bg-shadows"></div>

    <script>
        $(document).on('click','.editSubscription',function () {
            $('.trueSubscription').addClass('hideDiv');
            $('.falseSubscription').removeClass('hideDiv')
        });
        $(document).on('click','.buySubscription',function () {
            var countDelivery = $('#ex1').val();
            $('.falseSubscription').addClass('hideDiv');
            $('.trueSubscription').removeClass('hideDiv');
            $('.countDeliveryAll').html(countDelivery);
            $('.countDelivery').html(countDelivery);
        });
        $(document).on('change','#ex1',function () {
            var countDelivery = parseInt($('#ex1').val());
            var costSubscription = parseInt($('.costSubscription').text());
            var finalPriceSubscription = 0;
            finalPriceSubscription = countDelivery * costSubscription;
            $('.finalPriceSubscription span').html(finalPriceSubscription);
        });

        $(document).ready(function(){
            if($('.subscriptionHide').val() == 0){
                $('.trueSubscription').addClass('hideDiv');
                $('.falseSubscription').removeClass('hideDiv');
            } else {
                $('.falseSubscription').addClass('hideDiv');
                $('.trueSubscription').removeClass('hideDiv');
            }
            var countDelivery = 4;
            var costSubscription = parseInt($('.costSubscription').text());
            var finalPriceSubscription = 0;
            finalPriceSubscription = countDelivery * costSubscription;
            $('.finalPriceSubscription span').html(finalPriceSubscription);
            var costSubscription = parseInt($('.costSubscription span').text());
            $("input#ex1").bootstrapSlider();
            $(".tabs").lightTabs();
            switch(window.location.search){
                case '?section=orders': showPage(1);
                    break;
                case '?section=adress': showPage(2);
                    break;
                case '?section=rules': showPage(3);
                    break;
                case '?section=subscription': showPage(4);
                    break;
                default: showPage(0);
                    break;
            }
            if(window.location.search.indexOf('section=orders') > 0){
                console.log(window.location.search.indexOf('section=orders'));
                showPage(1);
            }
        });

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
        $(".add-form-btn").on('click',function () {
            $('.bg-shadow').show();
            $('.add-form').show();
        });
        $(".add-adress").on('click',function () {
            $('.bg-shadow').hide();
            $('.add-form').hide();
        });

        $(".order-get-more").on('click',function () {
            $('.bg-shadows').show();
            $(this).next().addClass('activeItems');
        });
        $(".bg-shadows").on('click',function () {
            $('.bg-shadows').hide();
            $(".order-details").removeClass('activeItems');
        });
        jQuery(function($){
            $(".phone-input").mask("+7 (999) 999-9999");
        });
    </script>
</div>
@endsection

