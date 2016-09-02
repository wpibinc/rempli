@extends('layouts.main2')

@section('title')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="css/order.css">
@endsection

@section('content')
    <div class="container">
        <div class="jumbotron content paybox">

            <div class="orderheader">Оплата</div>



            <form class="form-horizontal">

                <div class="form-group howtopay">
                    <label class="radio-inline howpayradio">
                        <input type="radio" name="howpay" id="creditcard" value="CreditCard" checked="checked"> Картой сейчаc
                    </label>
                    <br>
                    <label class="radio-inline howpayradio radiocash">
                        <input type="radio" name="howpay" id="cash" value="Cash"> Наличными при получении
                    </label>
                    <p class="help-block text-danger" id="kwarn">Извините, при заказе на более чем 3000 рублей, оплата только картой</p>

                </div>



                <div class="form-group col-md-6 padding-0">
                    <label for="inputPassword3" class="col-sm-4 col-md-6 control-label padding-0" style="font-size: 13px;">Продуктов на </label>
                    <div type="text" class="col-sm-8 col-md-6" id="payProducts"></div>
                </div>

                <div class="form-group col-md-6 padding-0">
                    <label for="inputPassword3" class="col-sm-4 col-md-6 control-label payLong padding-0" style="font-size: 13px;">Стоимость доставки</label>
                    @if($freeDelivery)
                    <div type="text" class="col-sm-8 col-md-6 free" id="dCostPay"></div>
                    @else
                    <div type="text" class="col-sm-8  col-md-6" id="dCostPay"></div>
                    @endif
                </div>


                <div class="form-group ">
                    <label for="inputPassword3" class="col-sm-4 control-label payLong totalPayLaber">Итого к оплате </label>
                    <div type="text" class="col-sm-8 totalPay" id="payTotal"></div>
                </div>





            </form>

            <nav>
                <ul class="pager">
                    <li class="previous">
                        <a href="/order" id="backToOrder" class="backForth"><span aria-hidden="true">&larr;</span> Назад</a>
                    </li>
                    <li id="tt" class="next">
                        <iframe style="float: right" frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=410013085842859&quickpay=small&any-card-payment-type=on&button-text=02&button-size=l&button-color=white&targets=expfood&default-sum=123&successURL=http://rempli.ru/success" width="195" height="54"></iframe>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


    </div>
@endsection