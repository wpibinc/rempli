@extends('layouts.main2')

@section('title')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="css/order.css">
@endsection

@section('content')
    <div class="container">
        <div class="jumbotron content">
            <div class="orderheader"> Информация для доставки</div>
            <div class="form-group">
                <label for="inputAddress" class="col-sm-0 control-label">
                </label>
                <div class="col-sm-12" id="order_text">
                    <!-- 	После заполнения информации снизу, вы сможете оплатить заказ по любой банковской карте и мы доставим Ваш заказ меньше чем через 1 час! -->
                </div>
            </div>
            <div class="form-group  col-md-9 col-md-offset-3 col-sm-12 col-sm-offset-0">
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="val-1" checked>
                        ввести адрес
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="val-2">
                        выбрать адрес
                    </label>
                </div>
            </div>
            @if($user->adresses)
            <div class="form-group col-md-12" id="val-2">
                <div class="col-sm-3">

                    <label for="selectAddress" class=" control-label">Адрес <!-- <span class="red">*</span> -->
                    </label>
                </div>
                <div class="col-md-9 col-sm-12 p-l-15">
                    <select name="selectAddress" id="selectAddress">
                        @foreach($user->adresses as $adress)
                            <?php
                            $addressfull = $adress->street.' '.$adress->home;
                            if(!empty($adress->korp)){
                                $addressfull .= ' корп. '.$adress->korp;
                            }
                            if(!empty($adress->flat)){
                                $addressfull .= ' кв. '.$adress->flat;
                            }
                            ?>
                            <option value="{{$adress->id}}"><?php echo $addressfull ?></option>
                        @endforeach
                    </select>
                </div>

            </div>
            @endif
            <div class="" id="val-1">
            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">Адрес <!-- <span class="red">*</span> -->
                </label>
                <div class="col-sm-9">
                    <!-- <div class="input-wrap col-sm-9"><input autofocus id="pac-input" class="controls" type="text" placeholder="Куда доставить?"></div> -->
                    <input type="text" value="" name="city" autofocus class="form-control" placeholder="Улица" id="pac-input">
                    <p class="help-block text-danger"></p>
                    <p class="help-block text-danger wrongplace">К сожалению, мы пока не доставляем по Вашему адресу. Подробнее Вы можете прочитать в разделе <a href="about.html"><u>О НАС</u></a></p>
                </div>
            </div>


            <div class="form-group">
                <label for="inputName"  class="col-sm-3 control-label">
                </label>
                <div class="col-sm-9 ">
                    <div class="row">
                        <!-- <input type="text"  value="" required class="form-control" name="flat" placeholder="" id="flat"> -->
                        <input type="hidden" id="user" value="{{Auth::user()->id or ''}}">
                        <div class="form-group inline col-md-4 col-sm-12">
                            <input type="text" class="form-control twoad" id="house" placeholder="Дом">
                        </div>
                        <div class="form-group inline col-md-4 col-sm-12">

                            <input type="text" class="form-control twoad" id="korp" placeholder="Корпус">
                        </div>
                        <div class="form-group inline col-md-4 col-sm-12">

                            <input type="text" class="form-control twoad" id="flat" placeholder="Квартира">
                        </div>
                        <p class="help-block text-danger"></p>
                    </div>

                </div>
            </div>
            </div>
        <!-- 	<div class="form-inline">
	  <div class="form-group inline">
	    <label for="exampleInputName2">Name</label>
	    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
	  </div>
	  <div class="form-group inline">
	    <label for="exampleInputEmail2">Email</label>
	    <input type="email" class="form-control" id="exampleInputEmail2" placeholder="jane.doe@example.com">
	  </div>
	</div> -->

            <div class="form-group">

                <label for="inputAddress" class="col-sm-3 control-label">Ваше имя <!-- <span class="red">*</span> -->
                </label>
                <div class="col-sm-9">
                    <input type="text" required value="{{$user->fname}}" class="form-control" name="first_name" placeholder="" id="name">
                    <p class="help-block text-danger"></p>
                </div>
            </div>

            <div class="form-group">
                <label for="inputMobile" required class="col-sm-3 control-label">Контактный номер <!-- <span class="red">*</span> -->
                </label>
                <div class="col-sm-9">
                    <input type="tel" required class="form-control" value="{{$user->phone}}" name="phone" placeholder="" id="phone">
                    <p class="help-block text-danger"></p>
                </div>
            </div>


            <div class="form-group">
                <label for="inputName"  class="col-sm-3 control-label">Время доставки
                </label>
                <div class="col-sm-9">
                    <script type="text/javascript">
                        function date() {
                            var d = new Date();
                            var h = d.getHours() + 1;
                            var m = (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();
                            document.write('<b>' + h + ':' + m + '</b>');
                        } date();
                    </script>
                    <p class="help-block text-danger"></p>
                </div>
            </div>


            <div class="col-md-12">
                <div class="row">
                    <div class="form-group">
                        <label for="inputName"  class="col-sm-3 control-label">Другие инструкции?</label>
                        <div class="col-sm-9">
                            <label class="radio-inline"><input type="radio" name="comment" id="nocomment" value="123" checked="checked"> Нет</label><br>
                            <label class="radio-inline"><input type="radio" name="comment" id="yescomment" value="213"> Да</label><br>
                            <textarea class="form-control" rows="3" placeholder="" id="comment"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="clearfix"></div>
            <div class="col-lg-12 text-center" id="submitOrder">
                <div id="success"></div>
                <input class="hidden" type="submit" value="Register" id="submit_order_data">
            </div>
            <p id="fillall">Пожалуйста, заполните все поля сверху</p>


            <nav>
                <ul class="pager">

                    <li class="previous"><a id="backToMain" href="/" class="backForth">
<span aria-hidden="true">&larr;
</span> Назад</a>
                    </li>

                    <li id="tt" class="next" >
                        {{--<a href="/payment" id="toPay" class="backForth">Оплата--}}
                            {{--<span aria-hidden="true">&rarr;</span></a>--}}
                        <a href="#" id="toPay" class="backForth">Оплата
                            <span aria-hidden="true">&rarr;</span></a>
                    </li>

                </ul> </nav>
        </div>
    </div>
    </div>
    <script>
        $(document).on("ready",function () {
            if($("#optionsRadios1").prop('checked')){
                $('#val-1').addClass('activeClassradio').removeClass('radiocustom');
                $('#val-2').addClass('radiocustom').removeClass('activeClassradio');
                console.log("sdasdsa");
            } else{
                $('#val-2').addClass('activeClassradio').removeClass('radiocustom');
                $('#val-1').addClass('radiocustom').removeClass('activeClassradio');
            }
        });
        $('.radio input').on("click",function () {
            if($("#optionsRadios1").prop('checked')){
                $('#val-1').addClass('activeClassradio').removeClass('radiocustom');
                $('#val-2').addClass('radiocustom').removeClass('activeClassradio');
            } else{
                $('#val-2').addClass('activeClassradio').removeClass('radiocustom');
                $('#val-1').addClass('radiocustom').removeClass('activeClassradio');
            }
        });
    </script>
@endsection