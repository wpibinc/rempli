@extends('layouts.main')

@section('title')

@section('content')
{{--    @if(!Auth::user()->isPaid())--}}
        {{--here remember block--}}
    {{--@endif--}}
<div class="col-md-12 main-start-page">
    <div class="tabs col-md-10 col-md-offset-1">
        @if(isset($time_to_pay) && $time_to_pay)
            <div style="color: red;">{{$time_to_pay}}</div>
            <button class="invoice_page btn" style="display: block;margin-bottom: 15px;">Оплатить</button>
        @endif
        <ul class="col-md-2">
            <li><i class="fa fa-user" aria-hidden="true"></i> Учетная запись <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-list-alt" aria-hidden="true"></i> История заказов <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-usd" aria-hidden="true"></i> Счета ({{$invoices->count()}})<i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
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
                            <th>Номер счета</th>
                            <th>Дата выставления счета</th>
                            <th>Оплатить до</th>
                            <th>Назначение</th>
                            <th>Стоимость</th>
                            <th></th>
                        </tr>
                        <?php $i = 0; ?>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td><?php echo ++$i ?></td>
                                <td>{{\Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d H:i')}}</td>
                                <td>{{\Carbon\Carbon::parse($invoice->last_pay_day)->format('Y-m-d H:i')}}</td>
                                @if($invoice->title == 'Дополнительные доставки')
                                    <td>{{$invoice->title .' ('. $invoice->extra_deliveries . ')'}}</td>
                                @else
                                    <td>{{$invoice->title}}</td>
                                @endif
                                <td>{{$invoice->price}} руб.</td>
                                {{--<td><button type="button" class="btn buy-bill">оплатить</button></td>--}}
                                <form action="https://demomoney.yandex.ru/eshop.xml" method="POST">
                                    <input name="shopId" value="78360" type="hidden">
                                    <input name="scid" value="545092" type="hidden">
                                    <input name="customerNumber" value="{{$user->id}}" type="hidden"><!-- Идентификатор вашего покупателя -->
                                    <input name="paymentType" value="AC" type="hidden"/>
                                    <input name="sum" value="10.00"><!-- Сумма покупки (руб.) -->
                                    <input name="orderNumber" value="{{$invoice->id}}" type="hidden" />
                                    <input type="submit" value="Оплатить">
                                </form>
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
                <div class="message"></div>
                <input type="hidden" value="{{$user->id}}" class="userId">

                @if(!isset($subscription))
                <input type="hidden" value="0" class="subscriptionHide">
                @else
                    <input type="hidden" value="{{$subscription->current_quantity}}" >
                @endif
                <div class="falseSubscription">

                    <h3>Подписка</h3>
                    <input id="ex1" data-provide="slider"
                           data-slider-ticks="[1, 2, 3, 4]"
                           data-slider-ticks-labels='["4", "8", "12","30"]'
                           data-slider-min="1"
                           data-slider-max="4"
                           data-slider-step="1"
                           data-slider-value="3"
                           data-slider-tooltip="hide"/>
                    <p class="finalPriceSubscription"><span>4200</span> руб</p>
                    {{--<button type="button" class="buySubscription btn btn-default" >Купить</button>--}}
                    <form action="https://demomoney.yandex.ru/eshop.xml" method="POST">
                        <input name="shopId" value="78360" type="hidden">
                        <input name="scid" value="545092" type="hidden">
                        <input name="customerNumber" value="{{$user->id}}" type="hidden"><!-- Идентификатор вашего покупателя -->
                        <input name="paymentType" value="AC" type="hidden"/>
                        <input name="sum" value="10.00"><!-- Сумма покупки (руб.) -->
                        <input name="quantity" value="4200"><!-- Сумма покупки (руб.) -->
                        <input type="submit" value="Оплатить">
                    </form>
                </div>
                <div class="trueSubscription">
                    @if(isset($subscription))
                    <input type="hidden" name="subscription_id" value="{{$subscription->id}}">
                    <input type="hidden" name="price" value="{{$subscription->price}}">
                    @if(isset($has_next_subscription) && isset($is_paid_next_subscription))
                    <input type="hidden" name="has_next_subscription" value="{{$has_next_subscription}}">
                    <input type="hidden" name="is_paid_next_subscription" value="{{$is_paid_next_subscription}}">
                    @endif
                    <h3>Подписка</h3>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td><span>Срок действия подписки до: {{\Carbon\Carbon::parse($subscription->end_subscription)->format('d-m-Y')}}</span> </td>
                        </tr>
                        <tr>
                            <td><span>Количество оставшихся доставок/количество доставок всего:</span> </br><span class="countDelivery">{{isset($current_quantity) ? $current_quantity : $subscription->current_quantity}}</span><span class="dots">/</span><span class="countDeliveryAll">{{$subscription->total_quantity}}</span></td>
                        </tr>
                        @if (\Carbon\Carbon::now() < $subscription->end_subscription && $subscription->current_quantity == 0 || (isset($current_quantity) && $current_quantity == 0))
                        <tr class="dop-wrapper hideDiv">
                            <td colspan="2">
                                <span>Количество доставок израсходовано</span></br>
                                <span><input min="1" type="number" name="input-dop" class="input-dop" value="1"><button class='btn buy-dop'>купить доп. Доставку</button></span></br>
                                Цена: <span class="dop-price">450руб</span>
                            </td>
                        </tr>
                        @endif
                        @if(!isset($current_quantity))
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
                                <input id="ex2"  data-provide="slider"
                                       data-slider-ticks="[1, 2, 3, 4]"
                                       data-slider-ticks-labels='["4", "8", "12","30"]'
                                       data-slider-min="4"
                                       data-slider-max="30"
                                       data-slider-step="1"
                                       @if($subscription->current_quantity == 4)
                                       data-slider-value="1"
                                       @elseif($subscription->current_quantity == 8)
                                       data-slider-value="2"
                                       @elseif($subscription->current_quantity == 12)
                                       data-slider-value="3"
                                       @else
                                       data-slider-value="4"
                                       @endif
                                       data-slider-tooltip="hide"/></br>
                                <p class="finalPriceSubscriptions hideDiv"><span></span> руб</p>
                                <button class="btn btn-default editSubscription Dsp-none" disabled type="button">изменить условия</button>
                                <button class="btn btn-default editsSubscription hideDiv" type="button">изменить</button>
                            </td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            <div class='promoCode wrapper-acaunt'>
                <div class="messages"></div>
                <input type="text" name="promocode">
                <a href="#" class="activate-promocode btn btn-default">Активировать</a>
            </div>
            <div class='rules wrapper-acaunt'>Правила</div>
            <div class='orders lists wrapper-acaunt '>
                @if(isset($subscription) && $subscription)
                <ul class='shops'>
                    <li class="{{ session('shop')=='Av'||!session('shop') ? 'active' : '' }}"><a href='my-account?section=order-list&shop=Av'>Азбука Вкуса</a></li>
                    <li class="{{ session('shop')=='La' ? 'active' : '' }}"><a href='my-account?section=order-list&shop=La'>La Maree</a></li>
                    <li class="{{ session('shop')=='Me' ? 'active' : '' }}"><a href='my-account?section=order-list&shop=Me'>Metro</a></li>
                </ul>
                @endif
                Список заказов
                <div class="table-responsive">
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
                                    case 'La':
                                        $title = $product->product->name;
                                        $img = $product->product->image;
                                        $price = $product->product->price;
                                        if($product->product->price_style == '1 кг'){
                                            $price = $product->product->price/10;
                                        }
                                        $weight = $product->product->weight;
                                        break;
                                    case 'Me':
                                        $title = $product->product->name;
                                        $img = $product->product->image;
                                        $price = $product->product->price;
//                                        if($product->product->price_style == '1 кг'){
//                                            $price = $product->product->price/10;
//                                        }
                                        $weight = $product->product->weight;
                                        break;
                                    default:
                                        $title = $product->product->name;
                                        $img = 'http://av.ru'.$product->product->image;
                                        $price = $product->product->price;
                                        if($product->product->price_style == '1 кг'){
                                            $price = $product->product->price/10;
                                        }
                                        $weight = $product->product->original_typical_weight;
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
                </div>

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

            $('table .slider-horizontal').addClass('visb-h');
        });
        $(document).on('click','.editSubscription',function () {
          $('.slider-horizontal').removeClass('visb-h');
           $('.finalPriceSubscriptions').removeClass('hideDiv');
          $('.editSubscription').addClass('hideDiv');
         $('.editsSubscription').removeClass('hideDiv');
        });

        $(document).on('click','.editsSubscription',function () {
            $('.slider-horizontal').addClass('visb-h');
            $('.finalPriceSubscriptions').addClass('hideDiv');
            $('.editSubscription').removeClass('hideDiv');
            $('.editsSubscription').addClass('hideDiv');
            var countDelivery = parseInt($('#ex2').val());
//            if(countDelivery == 1){
//                $('.countDeliveryAll').html('4');
//                $('.countDelivery').html('4');
//            }
//            if(countDelivery == 2){
//                $('.countDeliveryAll').html('8');
//                $('.countDelivery').html('8');
//            }
//            if(countDelivery == 3){
//                $('.countDeliveryAll').html('12');
//                $('.countDelivery').html('12');
//            }
//            if(countDelivery == 4){
//                $('.countDeliveryAll').html('30');
//                $('.countDelivery').html('30');
//            }

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

//            $('.thisIframe').attr('src','https://money.yandex.ru/embed/small.xml?account=410013085842859&quickpay=small&any-card-payment-type=on&button-text=02&button-size=m&button-color=orange&targets=expfood&default-sum='+finalPriceSubscription+'&successURL=http://rempl?sucssess=1/');

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
            var checkboxs = 0;
            if($('.auto_subscription').prop('checked') == true){
                checkboxs = 1;
            }
            var auto_subscription = checkboxs;
            $_token = "{!! csrf_token() !!}";
            var user_id = $('.userId').val();
            var subscription_id = $('input[name="subscription_id"]').val();
            var price = $('input[name="price"]').val();
            var quantity = $('.countDeliveryAll').text();

            $.ajax({
                type: "POST", //Метод отправки
                url: "/subscription/update-onclick", //путь до php фаила отправителя
                data: {
                    'user_id':user_id,
                    'id':subscription_id,
                    '_token':$_token,
                    'current_quantity':quantity,
                    'total_quantity':quantity,
                    'price':price,
                    'auto_subscription':auto_subscription
                },
                success: function(data) {
                    var alert_class = '';
                    if(!data.status) {
                        alert_class = 'warning';
                        $('.message').show();
                    } else {
//                        alert_class = 'success';
                        $('.message').hide();
                    }
                    $('.message').html(
                            '<div class="alert alert-' + alert_class + ' alert-message">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                            '<span aria-hidden="true">×</span>' +
                            '</button>' +
                            data.msg+
                            '</div>'
                    );
                    return false;
                }
            });

            var $el = $(this);
            if($el.prop('checked') == true){
//                $('.slider-horizontal').removeClass('visb-h');
//                $('.finalPriceSubscriptions').removeClass('hideDiv');
//                $('.editsSubscription').removeClass('hideDiv');
                $('.editSubscription').removeClass('Dsp-none');
                $('.editSubscription').removeAttr('disabled');
                $('.editsSubscription').removeAttr('disabled');
            } else {
//                $('.slider-horizontal').addClass('visb-h');
//                $('.finalPriceSubscriptions').addClass('hideDiv');
//                $('.editsSubscription').addClass('hideDiv');
                $('.editSubscription').addClass('Dsp-none');
                $('.editSubscription').attr('disabled','disabled');
                $('.editsSubscription').attr('disabled','disabled');
            }
        });
        $(document).on('click','.buy-dop',function () {
            var dopBuy = $('.input-dop').val();
            var bopPrice = dopBuy * 450;
            $('.countDelivery').html(dopBuy);
        });
        $(document).on('input','.input-dop',function () {
            var dopBuy = $('.input-dop').val();
            var bopPrice = dopBuy * 450;
            $('.dop-price').html(bopPrice+'руб');
        });

        $(document).ready(function(){
            $('.auto_subscription').prop('checked',false);
            var dopCount = $('.countDelivery').text();
            console.log(dopCount);
            if(dopCount == 0){
                $('.dop-wrapper').removeClass('hideDiv');
            }
            $("input#ex2").bootstrapSlider();
            var ex2 = $('#ex2').val();
            if(ex2 == 1){
                var exval = 1600;
            }
            if(ex2== 2){
                var exval = 3000;
            }
            if(ex2 == 3){
                var exval = 4200;
            }
            if(ex2 == 4){
                var exval = 7500;
            }
            $('.finalPriceSubscriptions span').html(exval);
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
                case '?section=adress': showPage(3);
                    break;
                case '?section=rules': showPage(6);
                    break;
                case '?section=subscription': showPage(4);
                    break;
                case '?section=invoice': showPage(2);
                    break;
                case '?section=order-list': showPage(7);
                    break;
                default: showPage(0);
                    break;
            }
            if(window.location.search.indexOf('section=orders') > 0){
                showPage(1);
            }
            if(window.location.search.indexOf('section=order-list') > 0){
                showPage(7);
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
            if($('input[name="has_next_subscription"]').val()) {
                $('.auto_subscription').prop('checked', true);
                $('.editSubscription').removeClass('Dsp-none');
                if($('input[name="is_paid_next_subscription"]').val() == ""){
                    $('.editSubscription').removeAttr('disabled');
                }
            }
            if($('input[name="is_paid_next_subscription"]').val()) {
                $('.auto_subscription').attr("disabled", true);

            }
            $(document).on('click','.buySubscription',function() { //устанавливаем событие отправки для формы с id=form
                $_token = "{!! csrf_token() !!}";
                var user_id = $('.userId').val();
                var price = $('.finalPriceSubscription span').text();
                var quantity = $('#ex1').val();

                if(quantity == 2){
                    quantity = 8;
                }
                if(quantity == 3){
                    quantity = 12;
                }
                if(quantity == 4){
                    quantity = 30;
                }
                if(quantity == 1){
                    quantity = 4;
                }
                $.ajax({
                    type: "POST", //Метод отправки
                    url: "/subscription/create", //путь до php фаила отправителя
//                    url: "/yandex-kassa/paymentaviso", //путь до php фаила отправителя
                    data: {
                        'user_id':user_id,
                        '_token':$_token,
                        'current_quantity':quantity,
                        'total_quantity':quantity,
                        'price':price
                    },
                    success: function(data) {
                        var alert_class = '';
                        if(!data.status) {
                            alert_class = 'warning';
                            $('.message').show();
                        } else {
                             alert_class = 'success';
                            $('.message').show();
                        }
                        $('.message').html(
                                '<div class="alert alert-' + alert_class + ' alert-message">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">×</span>' +
                                '</button>' +
                                data.msg+
                                '</div>'
                        );
                        return false;
                    }
                    });
            });


            $(document).on('click','.editsSubscription',function() { //устанавливаем событие отправки для формы с id=form


                $_token = "{!! csrf_token() !!}";
                var subscription_id = $('input[name="subscription_id"]').val();
                var user_id = $('.userId').val();
                var price = $('.finalPriceSubscriptions span').text();
                var quantitys = $('#ex2').val();

                if(quantitys == 2){
                    quantitys = 8;
                }
                if(quantitys == 3){
                    quantitys = 12;
                }
                if(quantitys == 4){
                    quantitys = 30;
                }
                if(quantitys == 1){
                    quantitys = 4;
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
                        'current_quantity':quantitys,
                        'total_quantity':quantitys,
                        'price':price,
                        'auto_subscription':auto_subscription
                    },
                    success: function(data) {
                        var alert_class = '';
                        if(!data.status) {
                            alert_class = 'warning';
                            $('.message').show();
                        } else {
                            alert_class = 'success';
                            $('.message').show();
                        }
                        $('.message').html(
                                '<div class="alert alert-' + alert_class + ' alert-message">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">×</span>' +
                                '</button>' +
                                data.msg+
                                '</div>'
                        );
                        return false;
                    }
                });
            });

            $(document).on('click','.buy-dop',function() { //устанавливаем событие отправки для формы с id=form
                $_token = "{!! csrf_token() !!}";
                var subscription_id = $('input[name="subscription_id"]').val();
                var user_id = $('.userId').val();
                var price = $('.dop-price').text();
                var quantity = $('.input-dop').val();
                var input_dop = 1;
                $.ajax({
                    type: "POST", //Метод отправки
                    url: "/subscription/update", //путь до php фаила отправителя
                    data: {
                        'user_id':user_id,
                        'id':subscription_id,
                        '_token':$_token,
                        'dop_quantity':quantity,
                        'price':price,
                        'input_dop':input_dop
                    },
                    success: function(data) {
                        var alert_class = '';
                        if(!data.status) {
                            alert_class = 'warning';
                            $('.message').show();
                        } else {
                            alert_class = 'success';
                            $('.message').show();
                        }
                        $('.message').html(
                                '<div class="alert alert-' + alert_class + ' alert-message">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                '<span aria-hidden="true">×</span>' +
                                '</button>' +
                                data.msg+
                                '</div>'
                        );
                        return false;
                    }
                });
            });
        });

        $(document).on('click','.activate-promocode',function() { //устанавливаем событие отправки для формы с id=form
            $_token = "{!! csrf_token() !!}";
            var promocode = $('input[name="promocode"]').val();
            if(promocode.length) {
                $('.message').html('');
            }
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
                    var alert_class = '';
                    if(!data.status) {
                        alert_class = 'warning';
                        $('.messages').show();
                    } else {
                        alert_class = 'success';
                        $('.messages').show();
                    }
                    $('.messages').html(
                            '<div class="alert alert-' + alert_class + ' alert-message">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                                    '<span aria-hidden="true">×</span>' +
                                '</button>' +
                                data.msg+
                            '</div>'
                    );
                    return false;
                }
            });
        });
    </script>
    <script>
        $('.invoice_page').on('click',function () {
            $('ul li[data-page="2"]').trigger('click');
        });
    </script>
</div>
@endsection

