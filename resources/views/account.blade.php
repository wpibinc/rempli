@extends('layouts.main')

@section('title')

@section('content')
{{--    @if(!Auth::user()->isPaid())--}}
        {{--here remember block--}}
    {{--@endif--}}
<div class="col-md-12 main-start-page">
    <div class="tabs col-md-8 col-md-offset-2">
        @if(isset($time_to_pay) && $time_to_pay)
            <div style="color: red;">{{$time_to_pay}}</div>
            <button class="invoice_page btn" style="display: block;margin-bottom: 15px;">Оплатить</button>
        @endif
        <ul class="col-md-3">
            <li><i class="fa fa-user" aria-hidden="true"></i>   Учетная запись <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-list-alt" aria-hidden="true"></i>   История заказов <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-usd" aria-hidden="true"></i>   Счета ({{$invoices->count()}})<i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-phone" aria-hidden="true"></i>   Адреса <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-bullhorn" aria-hidden="true"></i>   Подписка <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-barcode" aria-hidden="true"></i>   Промо-коды <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-book" aria-hidden="true"></i>   Правила <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><i class="fa fa-list-alt" aria-hidden="true"></i>   Cписок заказов <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
            <li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>   Выход</a> <i class="fa fa-angle-right" aria-hidden="true" style="float: right"></i></li>
        </ul>
        <div class="col-md-9">
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
                                <td>
                                    <form action="https://money.yandex.ru/eshop.xml" method="post">
                                        <input name="shopId" value="78360" type="hidden">
                                        <input name="scid" value="79048" type="hidden">
                                        <input name="customerNumber" value="{{$user->id}}" type="hidden">
                                        {{--<input name="paymentType" value="AC" type="hidden"/>--}}
                                        <input name="sum" value="{{$invoice->price}}" type="hidden"><!-- Сумма покупки (руб.) -->
                                        <input name="orderNumber" value="{{$invoice->id}}" type="hidden" />
                                        <input type="submit" class="btn buy-bill" value="Оплатить">
                                    </form>
                                </td>
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
<p>
Rempli предоставляет Вам возможность воспользоваться удобной подпиской на доставку продуктов.<br>
Во время работы над сервисом перед нашей командой стояла задача сделать покупку продуктов наиболее простой и выгодной для наших клиентов. Именно поэтому мы разработали пакет подписок на 4, 8, 12 и 30 доставок в месяц.<br>
Каковы его преимущества?<br>
1. Себестоимость одной доставки в среднем меньше на 35%;<br>
2. Пользователям подписки также доступна доставка из магазинов "Metro" и "LaMaree";<br>
3. Если доставки, приобретенные в рамках пакета закончатся, Вы можете докупить дополнительные доставки по стоимости ниже на 10% за каждую.<br>
<br>
</p>
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingTwo">
<h4 class="panel-title">
<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
Основные положения
</a>
</h4>
</div>
<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
<div class="panel-body">
- Подписка приобретается сроком на 1 месяц. На Ваш выбор имеются 4 пакета из 4, 8, 12 и 30 доставок на срок действия подписки;<br>
- Неиспользованные доставки по истечению срока действия подписки сгорают;<br>
- Доставки в рамках пакета по умолчанию рассчитаны на заказы до 8кг. В случае превышения веса клиенту вставляется счет на 300р. в личный кабинет;<br>
- Пользователю доступна функция автопродления подписки. Включить ее можно на странице "Подписка" в личном кабинете. При включенной функции автопродления подписка на следующий месяц автоматически продляется согласно выбранным условиям за три дня до истечения срока действия текущего пакета. При этом пользователю в личный кабинет выставляется счет на сумму, выбранную при включении функции автопродения;<br>
- После того, как доставки, приобретенные в рамках пакета, закончатся, стоимость доставки становится равной 500р. Так же Вы можете приобрести дополнительные доставки на странице "Подписка" в личном кабинете по более выгодной цене.</div>
</div>
</div><br>
<p> Выберите количество доставок в месяц:</p><br>
                    <input id="ex1" data-provide="slider"
                           data-slider-ticks="[1, 2, 3, 4]"
                           data-slider-ticks-labels='["4", "8", "12","30"]'
                           data-slider-min="1"
                           data-slider-max="4"
                           data-slider-step="1"
                           data-slider-value="3"
                           data-slider-tooltip="hide"/>
                    <p class="finalPriceSubscription"><span>4200</span> руб</p>
                    <form action="https://money.yandex.ru/eshop.xml" method="post">
                    <input name="shopId" value="78360" type="hidden">
                        <input name="scid" value="79048" type="hidden">
                        <input name="customerNumber" value="{{$user->id}}" type="hidden">
                        {{--<input name="paymentType" value="AC" type="hidden"/>--}}
                        <input name="sum" value="4200" type="hidden" id="step1-sum">
                        <input name="label" value="12" type="hidden" id="step1-label">
                        <input type="submit" class="btn buy-bill" value="Купить">
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
                                <span><input min="1" type="number" name="input-dop" class="input-dop" value="1"><button class='btn buy-dop'>Купить дополнительные доставки</button></span></br>
                                Цена: <span class="dop-price">450руб</span>
                            </td>
                        </tr>
                        @endif
                        @if(!isset($current_quantity))
{{--                            {{dd(isset($next_subscription))}}--}}
{{--                            {{dd($next_subscription->total_quantity)}}--}}
                        <tr>
                            <td colspan="1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="auto_subscription" @if($subscription->auto_subscription == 1) checked @endif class="auto_subscription" value="1"> Автопродление подписки
                                    </label>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="1">
                                @if(isset($next_subscription))
                                    <input id="ex2"  data-provide="slider"
                                           data-slider-ticks="[1, 2, 3, 4]"
                                           data-slider-ticks-labels='["4", "8", "12","30"]'
                                           data-slider-min="4"
                                           data-slider-max="30"
                                           data-slider-step="1"
                                           @if($next_subscription->total_quantity == 4)
                                           data-slider-value="1"
                                           @elseif($next_subscription->total_quantity == 8)
                                           data-slider-value="2"
                                           @elseif($next_subscription->total_quantity == 12)
                                           data-slider-value="3"
                                           @else
                                           data-slider-value="4"
                                           @endif
                                           data-slider-tooltip="hide"/>
                                @else
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
                                           data-slider-tooltip="hide"/>
                                    @endif

                                </br>
                                <p class="finalPriceSubscriptions hideDiv"><span></span> руб</p>
                                <button class="btn btn-default editSubscription Dsp-none" disabled type="button">Изменить условия</button>
                                <button class="btn btn-default editsSubscription hideDiv" type="button">Изменить</button>
                            </td>
                        </tr>
                        @else
                            {{--{{dd($next_subscription->total_quantity)}}--}}
                            <tr>
                                <td colspan="1">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="auto_subscription_promocode" @if($has_next_subscription) checked @endif value="1" class="auto_subscription_promocode"> Продление подписки
                                        </label>
                                    </div>
                                </td>

                            </tr>
                            <tr>

                                <td colspan="1">
                                    @if(isset($next_subscription))
                                        <input id="ex2"  data-provide="slider"
                                               data-slider-ticks="[1, 2, 3, 4]"
                                               data-slider-ticks-labels='["4", "8", "12","30"]'
                                               data-slider-min="4"
                                               data-slider-max="30"
                                               data-slider-step="1"
                                               @if($next_subscription->total_quantity == 4)
                                               data-slider-value="1"
                                               @elseif($next_subscription->total_quantity == 8)
                                               data-slider-value="2"
                                               @elseif($next_subscription->total_quantity == 12)
                                               data-slider-value="3"
                                               @else
                                               data-slider-value="4"
                                               @endif
                                               data-slider-tooltip="hide"/>
                                    @else
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
                                               data-slider-tooltip="hide"/>
                                        @endif
                                        </br>
                                    <p class="finalPriceSubscriptions hideDiv"><span></span> руб</p>
                                    {{--<button class="btn btn-default editSubscription Dsp-none" disabled type="button">изменить условия</button>--}}
                                    @if(!$has_next_subscription)
                                        {{--<button class="btn btn-default editsSubscriptionPromocode hideDiv" type="button">Продлить</button>--}}
                                        <input class="btn btn-default editsSubscriptionPromocode hideDiv" name="button_action" value="Продлить" type="button">
                                    @else
                                        <button class="btn btn-default editsSubscription" type="button">Изменить</button>
                                        <input class="btn btn-default editsSubscriptionPromocode" name="button_action" value="Удалить" type="button">
                                    @endif
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
            <div class='rules wrapper-acaunt'>
<h1>Пользовательское соглашение</h1>
<p>
Настоящее Пользовательское Соглашение ООО «ВИБ» (далее Rempli) является публичной офертой и считается заключенным с момента совершения Пользователем одного из следующих конклюдентных действий:<br>
•	регистрации на сайте rempli.ru (далее «Сайт»);<br>
•	оформления заказа Пользователем на Сайте;<br>
•	оформление заказа через Приложение Rempli.<br>
<br>
Настоящие Пользовательское Соглашение приравнивается к договору, составленному в письменной форме. Заключение Пользовательского соглашения означает, что Пользователь в необходимой для него степени ознакомился с условиями настоящего Пользовательского соглашения и полностью и безоговорочно согласен с ними, в том числе в части предоставления согласия Rempli на обработку персональных данных Пользователя на условиях, указанных в разделе 5 настоящего Пользовательского соглашения, и в части предоставления согласия Rempli на получение e-mail, sms и иных видов рассылок информационного и рекламного содержания.<br>
<br>
1. Предмет Пользовательского Соглашения<br>
<br>
1.1 Rempli предлагает Вам свои услуги на условиях, являющихся предметом настоящего Пользовательского Соглашения (ПС).<br>
1.2 Соглашение может быть изменено нами без какого-либо специального уведомления, новая редакция Соглашения вступает в силу по истечении 3 (трех) дней с момента ее размещения, если иное не предусмотрено новой редакцией Соглашения. Действующая редакция ПС всегда находится на странице по адресу http://rempli.ru/rules. <br>
<br>
2. Описание услуг<br>
<br>
2.1 Сервис Rempli предлагает пользователям широкие возможности для быстрого и простого поиска и заказа продуктов из сетей магазинов Азбука Вкуса, Метро, La Maree, а также принимает от Пользователей денежные средства в счет оплаты заказов.<br>
2.2 Пользователь оформляет Заказ на Сайте, либо через официальное приложение.<br>
2.3 При оформлении единичной доставки Пользователь может заказать продукты в сети магазинов Азбука Вкуса. Одна доставка включает в себя заказ  продуктов общим весом до 5 килограммов. В случае если вес заказа превышает установленный лимит, Пользователь осуществляет доплату в размере 300 рублей.<br>
2.4 Сервис Rempli предусматривает возможность приобретения подписки на пакеты из 4, 8, 12 и 30 доставок. Приобретение подписки дает Пользователю право заказывать продукты из  сетей магазинов Азбуки Вкуса, Метро, La Maree.<br>
•	2.4.1 Каждая доставка любой из подписок включает в себя заказ  продуктов общим весом до 5 килограммов. В случае если вес заказа превышает установленный лимит, Пользователь осуществляет доплату в размере 300 рублей путем оплаты счета в личном кабинете. В случае неоплаты счета до окончания срока действия текущего пакета доставок Пользователь лишается возможности осуществлять заказы в сервисе Rempli до оплаты задолженности.<br>
•	2.4.2 Срок действия каждого пакета доставок составляет один месяц. В случае если доставок, купленных с пакетом, не достаточно Пользователь имеет право докупить дополнительные доставки по льготной цене.<br>
•	2.4.3 Сервисом Rempli предусмотрена опция по автоматическому продлению удобного для Пользователя пакета доставок на следующий месяц. Для включение данной опции необходимо нажать галочку в строке «Автопродление подписки». При включении автоматического продления за 3 суток до окончания срока действия текущего пакета доставок Пользователю в личном кабинете предоставляется счет на оплату пакета доставок на будущий месяц. В случае неоплаты счета в указанный срок Пользователь лишается возможности осуществлять заказы в сервисе Rempli до оплаты счета.<br>
2.5 В случае, если указанный в заказе товар отсутствует в магазине, Пользователь вправе заменить данный товар на другой либо вовсе его исключить. При этом доставка оплачивается исходя из конечного веса продуктов.<br>
2.6 Отмена всего заказа возможна только при условии, что все продукты, указанные в нем, отсутствуют в магазине.<br>
2.7  Если весовых продуктов не будет ровно столько, сколько указано в заказе, то Rempli оставляет за собой право уменьшить вес таким образом, чтобы он был наиболее близок к заявленному и вернуть Пользователю деньги за оставшиеся граммы по карте, либо запросить меньше при оплате наличными.<br>
<br>
3. Оплата<br>
3.1 Оплата услуг при заказе единичной доставки продуктов.<br>
При заказе единичной доставки представленная к оплате сумма включает в себя как стоимость продуктов, так и оплату услуг по их доставке. Пользователь может произвести оплату несколькими способами:<br>
•	3.1.1 Непосредственно при получении заказа наличными денежными средствами лично курьеру;<br>
•	3.1.2 on-line оплата на Сайте rempli.ru банковской картойчерез платежную систему Яндекс.Касса. Все дополнительные расходы по перечислению денежных средств за заказ несёт Rempli;<br>
3.2 Оплата услуг при оформлении подписки на пакет доставок.<br>
В случае если Пользователь приобрел подписку на пакет доставок, при оформлении или получении заказа оплате подлежит только стоимость продуктов.<br>
Пользователь может произвести оплату несколькими способами:<br>
•	3.2.1 Непосредственно при получении заказа наличными денежными средствами лично курьеру;<br>
•	3.2.2 on-line оплата на Сайте rempli.ru банковской картой VISA/MasterCard через платежную систему Яндекс.Касса. Все дополнительные расходы по перечислению денежных средств за заказ несёт Rempli;<br>
3.3 При наличии вопросов по совершенному платежу Пользователь может обратиться в службу поддержки клиентов по адресу sup@rempli.ru.<br>
3.4 Возврат денежных средств и доплата.<br>
•	3.4.1 Для безналичного расчета.<br>
В случае если конечная сумма заказа уменьшилась в результате замены продуктов, либо заказ был отменен	Пользователь имеет право на возврат денежных средств на карту, с которой проводилась оплата. Время возврата денежных средств определяется банком. Если при замене товара конечная стоимость доставки увеличилась, доплата осуществляется наличными средствами курьеру при получении заказа.<br>
•	3.4.2 Для наличной оплаты.<br>
В случае если конечная сумма заказа изменилась в результате замены продуктов, Пользователь вправе оплатить только продукты по чеку и  стоимость доставки в зависимости от веса, независимо от того, какая бы сумма была указана в заказе. При этом оплата осуществляется лично курьеру при получении заказа.<br>
<br>
4. Обязательства по регистрации и пользовании сайтом<br>
<br>
4.1 Для того чтобы воспользоваться услугами Rempli, Пользователь соглашается предоставить правдивую, точную и полную информацию о себе по вопросам, предлагаемым в форме регистрации, пройти процедуру регистрации на Сайте, заполнив форму регистрации и выразив согласие с условиями Соглашения, путем подтверждения пункта «Я принимаю условия Соглашения».<br>
4.2 Если Пользователь предоставляет неверную информацию или у Rempli есть серьезные основания полагать, что предоставленная им информация неверна, неполна или неточна, Rempli имеет право приостановить либо отменить регистрацию пользователя и отказать ему в использовании своих служб (услуг).<br>
<br>
5. Регистрация, пароль и безопасность<br>
<br>
5.1 По завершении процесса регистрации Пользователь получает логин и пароль для доступа в личный кабинет.<br>
5.2 Пользователь несет ответственность за безопасность своего логина и пароля, а также за все, что будет сделано на rempli.ru под его логином и паролем.<br>
5.3 Пользователь соглашается с тем, что он обязан немедленно уведомить Rempli о любом случае неавторизованного (не разрешенного) доступа со своим логином и паролем и/или о любом нарушении безопасности.<br>
<br>
6. Конфиденциальность<br>
<br>
6.1 Персональные данные Пользователя обрабатываются в соответствии с ФЗ «О персональных данных» №152-ФЗ и Положением о защите персональных данных Клиентов Rempli.<br>
6.2 При регистрации на сайте rempli.ru, Пользователь предоставляет следующую информацию: Имя, адрес электронной почты, номер контактного телефон, адрес доставки товара.<br>
6.3 Предоставляя свои персональные данные при регистрации/оформлении заказа на rempli.ru Пользователь соглашается на их обработку Rempli, в том числе и в целях выполнения Rempli обязательств перед Пользователем в рамках настоящего Пользовательского соглашения, информирования Пользователей о своих услугах, продвижения Rempli товаров и услуг, проведения электронных и sms опросов, контроля маркетинговых акций, клиентской поддержки, организации доставки товара Пользователям, контроля удовлетворенности Пользователя, а также качества услуг, оказываемых службами доставки. Не считается нарушением предоставление Rempli информации партнерам, агентам и третьим лицам, действующим на основании договора с Rempli, для исполнения обязательств перед Пользователем.<br>
6.4 Под обработкой персональных данных понимается любое действие (операция) или совокупность действий (операций), совершаемых с использованием средств автоматизации или без использования таких средств с персональными данными, включая сбор, запись, систематизацию, накопление, хранение, уточнение (обновление, изменение) извлечение, использование, передачу (в том числе передачу третьим лицам, не исключая трансграничную передачу, если необходимость в ней возникла в ходе исполнения обязательств), обезличивание, блокирование, удаление, уничтожение персональных данных.<br>
6.5 Rempli имеет право отправлять информационные, в том числе рекламные сообщения, на электронную почту и мобильный телефон Пользователя с его согласия. Пользователь вправе отказаться от получения рекламной и другой информации без объяснения причин отказа. Сервисные сообщения, информирующие Пользователя о заказе и этапах его обработки, отправляются автоматически и не могут быть отклонены Пользователем.<br>
Отзыв согласия на обработку персональных данных осуществляется путем отправки сообщения на адрес info@rempli.ru
6.6 Rempli не несет ответственности за сведения, предоставленные Пользователем на Сайте в общедоступной форме.<br>
<br>
7. Общие положения<br>
<br>
7.1 Настоящее соглашение регулируется нормами российского законодательства.<br>
7.2 Все возможные споры по поводу Соглашения разрешаются согласно нормам действующего российского законодательства.<br>
<br>
</p>
</div>
            <div class='orders lists wrapper-acaunt '>
                @if((\Auth::user()&&\Auth::user()->isAdmin())||(isset($subscription) && $subscription))
                <ul class='shops'>
<li class="{{ session('shop')=='Av'||!session('shop') ? 'active' : '' }}"><a href='my-account?section=order-list&shop=Av'>Азбука Вкуса</a></li>
<li class="{{ session('shop')=='La' ? 'active' : '' }}"><a href='my-account?section=order-list&shop=La'>La Maree</a></li>
<li class="{{ session('shop')=='Me' ? 'active' : '' }}"><a href='my-account?section=order-list&shop=Me'>Metro</a></li>
                </ul>
                @endif
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

//            $('table .slider-horizontal').addClass('visb-h');
//            $('.falseSubscription .slider-horizontal').removeClass('visb-h');
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
            var finalCountSubscription = 0;
            if(countDelivery == 1){
                finalPriceSubscription = 1600;
                finalCountSubscription = 4;
            }
            if(countDelivery == 2){
                finalPriceSubscription = 3000;
                finalCountSubscription = 8;
            }
            if(countDelivery == 3){
                finalPriceSubscription = 4200;
                finalCountSubscription = 12;
            }
            if(countDelivery == 4){
                finalPriceSubscription = 7500;
                finalCountSubscription = 30;
            }
            $('.finalPriceSubscription span').html(finalPriceSubscription);
            $('#step1-label').val(finalCountSubscription);
            $('#step1-sum').val(finalPriceSubscription);
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
        $(document).on('click','.auto_subscription_promocode',function () {
            var $el = $(this);
            if($el.prop('checked') == true){
                $('.slider-horizontal').removeClass('visb-h');
                $('.finalPriceSubscriptions').removeClass('hideDiv');
//                $('.editsSubscriptionPromocode').addClass('hideDiv');
                $('.editsSubscriptionPromocode').removeClass('hideDiv');
            } else {
                $('.slider-horizontal').addClass('visb-h');
                $('.finalPriceSubscriptions').addClass('hideDiv');
//                $('.editsSubscriptionPromocode').removeClass('hideDiv');
                $('.editsSubscriptionPromocode').addClass('hideDiv');
            }
        });

        $(document).on('ready',function () {
            if($('.auto_subscription_promocode').prop('checked') == true){
                $('.slider-horizontal').removeClass('visb-h');
                $('.finalPriceSubscriptions').removeClass('hideDiv');
            } else {
                $('.slider-horizontal').addClass('visb-h');
                $('.finalPriceSubscriptions').addClass('hideDiv');
            }
        });


        $(document).on('click','.auto_subscription, .delSubscription',function () {
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
            {{--$(document).on('click','.buySubscription',function() { //устанавливаем событие отправки для формы с id=form--}}
                {{--$_token = "{!! csrf_token() !!}";--}}
                {{--var user_id = $('.userId').val();--}}
                {{--var price = $('.finalPriceSubscription span').text();--}}
                {{--var quantity = $('#ex1').val();--}}

                {{--if(quantity == 2){--}}
                    {{--quantity = 8;--}}
                {{--}--}}
                {{--if(quantity == 3){--}}
                    {{--quantity = 12;--}}
                {{--}--}}
                {{--if(quantity == 4){--}}
                    {{--quantity = 30;--}}
                {{--}--}}
                {{--if(quantity == 1){--}}
                    {{--quantity = 4;--}}
                {{--}--}}
                {{--$.ajax({--}}
                    {{--type: "POST", //Метод отправки--}}
                    {{--url: "/subscription/create", //путь до php фаила отправителя--}}
                    {{--data: {--}}
                        {{--'user_id':user_id,--}}
                        {{--'_token':$_token,--}}
                        {{--'current_quantity':quantity,--}}
                        {{--'total_quantity':quantity,--}}
                        {{--'price':price--}}
                    {{--},--}}
                    {{--success: function(data) {--}}
                        {{--var alert_class = '';--}}
                        {{--if(!data.status) {--}}
                            {{--alert_class = 'warning';--}}
                            {{--$('.message').show();--}}
                        {{--} else {--}}
                             {{--alert_class = 'success';--}}
                            {{--$('.message').show();--}}
                        {{--}--}}
                        {{--$('.message').html(--}}
                                {{--'<div class="alert alert-' + alert_class + ' alert-message">' +--}}
                                {{--'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +--}}
                                {{--'<span aria-hidden="true">×</span>' +--}}
                                {{--'</button>' +--}}
                                {{--data.msg+--}}
                                {{--'</div>'--}}
                        {{--);--}}
                        {{--return false;--}}
                    {{--}--}}
                    {{--});--}}
            {{--});--}}


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


            $(document).on('click','.editsSubscriptionPromocode',function() { //устанавливаем событие отправки для формы с id=form


                $_token = "{!! csrf_token() !!}";
                var subscription_id = $('input[name="subscription_id"]').val();
                var user_id = $('.userId').val();
                var price = $('.finalPriceSubscriptions span').text();
                var quantitys = $('#ex2').val();
                var button_action = $('input[name="button_action"]').val();
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
                /*if($('.auto_subscription_promocode').prop('checked') == true){
                    checkboxs = 1;
                }
                var auto_subscription = checkboxs;*/
                $.ajax({
                    type: "POST", //Метод отправки
                    url: "/subscription/update-promocode", //путь до php фаила отправителя
                    data: {
                        'user_id':user_id,
//                        'id':subscription_id,
                        '_token':$_token,
                        'current_quantity':quantitys,
                        'total_quantity':quantitys,
                        'price':price,
                        'button_action':button_action
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
        $(document).on('ready',function () {
                $('.falseSubscription .slider-horizontal').removeClass('visb-h');

        });
    </script>
</div>
@endsection

