@extends('layouts.main')

@section('title')

@section('content')
<div class="col-md-12">
    <div class="tabs col-md-12">
        <ul class="col-md-2">
            <li><i class="fa fa-user" aria-hidden="true"></i> Учетная запись <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-list-alt" aria-hidden="true"></i> История заказов <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-usd" aria-hidden="true"></i> Страница Счета  <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-phone" aria-hidden="true"></i> Адреса <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-bullhorn" aria-hidden="true"></i> Подписка <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-barcode" aria-hidden="true"></i> Промо-коды <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-book" aria-hidden="true"></i> Правила <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-list-alt" aria-hidden="true"></i> Cписок заказов <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
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

            <div class='orders wrapper-acaunt'>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>номер счета</th>
                            <th>дата выставления счета</th>
                            <th>назначение</th>
                            <th></th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($orders as $order)
                            <tr>
                                <td><?php echo ++$i ?></td>
                                <td><a class='get-order-details' href='javascript:void(0)'>{{$order->cost}} руб</a></td>
                                <td>{{$order->status}}</td>
                                <td><button type="button" class="btn buy-bill">оплатить</button></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
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
                <input type="hidden" value="{{$user->id}}" class="userId">
                <input type="hidden" value="{{isset($subscription) ? $subscription->current_quantity : 0}}" class="subscriptionHide">
                <div class="falseSubscription">
                    <h3>Подписка</h3>
                    <p class="costSubscription"><span>500</span> руб</p>
                    <input id="ex1" data-provide="slider" data-slider-orientation="vertical"
                           data-slider-ticks="[1, 2, 3,4]"
                           data-slider-ticks-labels='["1 раз в неделю (4 раза в месяц) - 1600", "2 раза в неделю (8 раз в месяц) - 3000", "3 раза в неделю (12 раз в месяц) - 4200","Каждый день (30 доставок в месяц) - 7500"]'
                           data-slider-min="1"
                           data-slider-max="4"
                           data-slider-step="1"
                           data-slider-value="3"
                           data-slider-tooltip="hide"/>
                    <p class="finalPriceSubscription"><span>0</span> руб</p>
                    <button type="button" class="buySubscription btn btn-default" >Купить</button>
                </div>
                <div class="trueSubscription">
                    @if(isset($subscription))
                    <input type="hidden" name="subscription_id" value="{{$subscription->id}}">
                    <h3>Подписка</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><span>Срок действия подписки до: {{\Carbon\Carbon::parse($subscription->end_subscription)->format('d-m-Y')}}</span> </td>
                        </tr>
                        <tr>
                            <td><span>Количество оставшихся доставок/количество доставок всего</span> <span class="countDelivery">{{$subscription->current_quantity}}</span>/<span class="countDeliveryAll">{{$subscription->total_quantity}}</span></td>
                        </tr>
                        <tr class="dop-wrapper hideDiv">
                            <td colspan="2">
                                <span>Количество доставок израсходовано</span></br>
                                <span><input min="1" type="number" neme="input-dop" class="input-dop" value="1"><buttod class='btn buy-dop'>купить доп. Доставку</buttod></span></br>
                                Цена: <span class="dop-price">450руб</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="auto_subscription" @if($subscription->auto_subscription == 1) checked @endif class="auto_subscription" value="1"> автопродление подписки
                                    </label>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="1">
                                <input id="ex2" data-slider-orientation="vertical" class="hideDiv" data-provide="slider"
                                       data-slider-ticks="[1, 2, 3,4]"
                                       data-slider-ticks-labels='["1 раз в неделю (4 раза в месяц) - 1600", "2 раза в неделю (8 раз в месяц) - 3000", "3 раза в неделю (12 раз в месяц) - 4200","Каждый день (30 доставок в месяц) - 7500"]'
                                       data-slider-min="1"
                                       data-slider-max="4"
                                       data-slider-step="1"
                                       data-slider-value="{{$subscription->current_quantity}}"
                                       data-slider-tooltip="hide"/></br>
                                <p class="finalPriceSubscriptions"><span>0</span> руб</p>
                                <button class="btn btn-default editSubscription" disabled type="button">изменить условия</button>
                                <button class="btn btn-default editsSubscription hideDiv" type="button">изменить</button>
                            </td>

                        </tr>
                        </tbody>
                    </table>
                    @endif
                </div>

            </div>
            <div class='promoCode wrapper-acaunt'>
                <input type="text" name="promocode">
                <a href="#" class="activate-promocode btn btn-default">Активировать</a>
            </div>
            <div class='rules wrapper-acaunt'>Правила</div>
            <div class='lists wrapper-acaunt'>
                Список заказов
                <table class="table">
                    <tr>
                        <th>фото</th>
                        <th>цена</th>
                        <th>название</th>
                    </tr>
                    @if(count($listProducts))
                        @foreach($listProducts as $product)
                        <?php 
                           switch($product->shop){
                                case 'Av':
                                    $title = $product->product->name;
                                    $img = 'http://av.ru'.$product->product->image;
                                    $price = $product->product->price;
                                    if($product->product->price_style == '1 кг'){
                                        $price = $product->product->price/10;
                                    }
                                    $weight = $product->product->original_typical_weight;
                                break;
                                default:
                                    $title = $product->product->product_name;
                                    $img = $product->product->img;
                                    $price = $product->product->price;
                                    if($product->product->price_style == 'за 1кг'){
                                        $price = $product->product->price/10;
                                    }
                                    $weight = $product->product->weight;
                                break;
                            }
                        ?>
                        <tr class="product-list" data-shop="{{$product->shop}}" data-id="{{$product->product_id}}" data-weight="{{$weight}}" data-category="{{$product->product->category_id}}">
                            <td><img width="100" height="100" src="{{$img}}" alt="product"></td>
                            <td>{{$price}}</td>
                            <td>{{$title}}</td>
                        </tr>
                        @endforeach
                    @endif
                </table>
                 @if(count($listProducts))
                    {{$listProducts->appends(['section' => 'order-list'])->render()}}
                 @endif
                <button href="javascript:void(0)" data-weight="70" class="btn add-to-cart-from-list">Добавить в корзину</button>
            </div>
        </div>
    </div>
    <div class="bg-shadows"></div>

    <script>

        $(document).on('ready',function () {
            $('table .slider-vertical').addClass('visb-h');
        });
        $(document).on('click','.editSubscription',function () {
            $('.slider-vertical').removeClass('visb-h');
            $('.editSubscription').addClass('hideDiv');
            $('.editsSubscription').removeClass('hideDiv');
        });

        $(document).on('click','.editsSubscription',function () {
            $('.slider-vertical').addClass('visb-h');
            $('.editSubscription').removeClass('hideDiv');
            $('.editsSubscription').addClass('hideDiv');
            var countDelivery = parseInt($('#ex2').val());
            if(countDelivery == 1){
                $('.countDeliveryAll').html('4');
                $('.countDelivery').html('4');
            }
            if(countDelivery == 2){
                $('.countDeliveryAll').html('8');
                $('.countDelivery').html('8');
            }
            if(countDelivery == 3){
                $('.countDeliveryAll').html('12');
                $('.countDelivery').html('12');
            }
            if(countDelivery == 4){
                $('.countDeliveryAll').html('30');
                $('.countDelivery').html('30');
            }

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
            var finalPriceSubscription = 0;
            if(countDelivery == 1){
                finalPriceSubscription = 1600;
            }
            if(countDelivery == 2){
                finalPriceSubscription = 3000;
            }
            if(countDelivery == 3){
                finalPriceSubscription = 4200;
            }
            if(countDelivery == 4){
                finalPriceSubscription = 7500;
            }
            $('.finalPriceSubscription span').html(finalPriceSubscription);
        });
        $(document).on('change','#ex2',function () {
            var countDelivery2 = parseInt($('#ex2').val());

            var finalPriceSubscription2 = 0;
            if(countDelivery2 == 1){
                finalPriceSubscription2 = 1600;
            }
            if(countDelivery2 == 2){
                finalPriceSubscription2 = 3000;
            }
            if(countDelivery2 == 3){
                finalPriceSubscription2 = 4200;
            }
            if(countDelivery2 == 4){
                finalPriceSubscription2 = 7500;
            }
            $('.finalPriceSubscriptions span').html(finalPriceSubscription2);
        });
        $(document).on('click','.auto_subscription',function () {
            var $el = $(this);
            if($el.prop('checked') == true){
                $('.editSubscription').removeAttr('disabled');
                $('.editsSubscription').removeAttr('disabled');
            } else {
                $('.editSubscription').attr('disabled','disabled');
                $('.editsSubscription').attr('disabled','disabled');
            }
        });
        $(document).on('click','.buy-dop',function () {
            var dopBuy = $('.input-dop').val();
            var bopPrice = dopBuy * 450;
            $('.countDeliveryAll').html(dopBuy);
            $('.countDelivery').html(dopBuy);
        });
        $(document).on('input','.input-dop',function () {
            var dopBuy = $('.input-dop').val();
            var bopPrice = dopBuy * 450;
            $('.dop-price').html(bopPrice+'руб');
        });
        $(document).ready(function(){
            var dopCount = $('.countDelivery').text();
            if(parseInt(dopCount) == 0){
                $('.dop-wrapper').removeClass('hideDiv');
            }
            $("input#ex2").bootstrapSlider();
            var ex2 = $('#ex2').val();

            if($('.subscriptionHide').val() == 0){
                $('.trueSubscription').addClass('hideDiv');
                $('.falseSubscription').removeClass('hideDiv');
            } else {
                $('.falseSubscription').addClass('hideDiv');
                $('.trueSubscription').removeClass('hideDiv');
            }
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
                case '?section=order-list': showPage(6);
                    break;
                default: showPage(0);
                    break;
            }
            if(window.location.search.indexOf('section=orders') > 0){
                showPage(1);
            }
            if(window.location.search.indexOf('section=order-list') > 0){
                showPage(6);
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
        $(document).ready(function(){
            $(document).on('click','.buySubscription',function() { //устанавливаем событие отправки для формы с id=form
                $_token = "{!! csrf_token() !!}";
                var user_id = $('.userId').val();
                var price = $('.finalPriceSubscription span').text();
                var quantity = $('#ex1').val();
                if(quantity == 1){
                    quantity = 4;
                }
                if(quantity == 2){
                    quantity = 8;
                }
                if(quantity == 3){
                    quantity = 12;
                }
                if(quantity == 4){
                    quantity = 30;
                }
                $.ajax({
                    type: "POST", //Метод отправки
                    url: "/subscription/create", //путь до php фаила отправителя
                    data: {
                        'user_id':user_id,
                        '_token':$_token,
                        'current_quantity':quantity,
                        'total_quantity':quantity,
                        'price':price
                    },
                    success: function() {
                        //код в этом блоке выполняется при успешной отправке сообщения
                        location.reload();
//                        alert("Подписка оформлена!");
                    }
                    });
            });


            $(document).on('click','.editsSubscription',function() { //устанавливаем событие отправки для формы с id=form
                $_token = "{!! csrf_token() !!}";
                var subscription_id = $('input[name="subscription_id"]').val();
                var user_id = $('.userId').val();
                var price = $('.finalPriceSubscriptions span').text();
                var quantity = $('#ex2').val();
                if(quantity == 1){
                    quantity = 4;
                }
                if(quantity == 2){
                    quantity = 8;
                }
                if(quantity == 3){
                    quantity = 12;
                }
                if(quantity == 4){
                    quantity = 30;
                }
                var checkboxs = 0;
                if($('.auto_subscription').prop('checked') == true){
                    checkboxs = 1;
                }
                var auto_subscription = checkboxs;
                $.ajax({
                    type: "POST", //Метод отправки
                    url: "/subscription/update", //путь до php фаила отправителя
                    data: {
                        'user_id':user_id,
                        'id':subscription_id,
                        '_token':$_token,
                        'current_quantity':quantity,
                        'total_quantity':quantity,
                        'price':price,
                        'auto_subscription':auto_subscription
                    },
                    success: function() {
                        //код в этом блоке выполняется при успешной отправке сообщения
//                        alert("Подписка оформлена!");
                    }
                });
            });

            $(document).on('click','.buy-dop',function() { //устанавливаем событие отправки для формы с id=form
                $_token = "{!! csrf_token() !!}";
                var subscription_id = $('input[name="subscription_id"]').val();
                var user_id = $('.userId').val();
                var price = $('.dop-price').text();
                var quantity = $('.input-dop').val();
                var checkboxs = 0;
                if($('.auto_subscription').prop('checked') == true){
                    checkboxs = 1;
                }
                var auto_subscription = checkboxs;
                $.ajax({
                    type: "POST", //Метод отправки
                    url: "/subscription/update", //путь до php фаила отправителя
                    data: {
                        'user_id':user_id,
                        'id':subscription_id,
                        '_token':$_token,
                        'current_quantity':quantity,
                        'total_quantity':quantity,
                        'price':price,
                        'auto_subscription':auto_subscription
                    },
                    success: function() {
                        //код в этом блоке выполняется при успешной отправке сообщения
//                        alert("Подписка оформлена!");
                    }
                });
            });
        });

        $(document).on('click','.activate-promocode',function() { //устанавливаем событие отправки для формы с id=form
            $_token = "{!! csrf_token() !!}";
            var promocode = $('input[name="promocode"]').val();
            var user_id = $('.userId').val();
            $.ajax({
                type: "POST", //Метод отправки
                url: "/promo-code/activate", //путь до php фаила отправителя
                data: {
                    'user_id':user_id,
                    'promocode': promocode,
                    '_token':$_token
                },
                success: function(data) {
                    if(!data.status) {
                        alert('Введён неправильный промо-код!');
                    }
                    return false;
                }
            });
        });
    </script>
</div>
@endsection

