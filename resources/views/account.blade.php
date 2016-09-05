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
            <div class='account'>
                <div class='email'>                
                    <label>Email</label>
                    <input type='text' name='email' value='{{$user->email}}'>
                    <button class='change-user-info'>Изменить</button>
                </div>
                <div class='password'>                
                    <label>Пароль</label>
                    <input type='password' name='password' value='{{$user->password}}'>
                    <button class='change-user-info'>Изменить</button>
                </div>
                <div class='phone'>                
                    <label>Телефон</label>
                    <input type='text' name='phone' value='{{$user->phone}}'>
                    <button class='change-user-info'>Изменить</button>
                </div>
                <div class='fname'>                
                    <label>Имя</label>
                    <input type='text' name='fname' value='{{$user->fname}}'>
                    <button class='change-user-info'>Изменить</button>
                </div>
                <div class='sname'>                
                    <label>Фамилия</label>
                    <input type='text' name='sname' value='{{$user->sname}}'>
                    <button class='change-user-info'>Изменить</button>
                </div>
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            </div>
            <div class='orders'>
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
            </div>
            <div class='adresses'>
                <div class='add-form'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="home-inputt">Адрес </label>
                        <div class="col-sm-9">
                        <input id="street-input" class="form-control" type="text" placeholder="Улица" autofocus="" name="street" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputName"> </label>
                        <div class="col-sm-9 form-inline">
                            <input id="user" type="hidden" value="1">
                            <div class="form-group inline">
                                <input id="house" class="form-control twoad" type="text" placeholder="Дом">
                            </div>
                            <div class="form-group inline">
                                <label id="flatlab" for="korp"></label>
                                <input id="korp" class="form-control twoad" type="text" placeholder="Корпус">
                            </div>
                            <div class="form-group inline">
                                <label id="flatlab" for="exampleInputEmail2"></label>
                                <input id="flat" class="form-control twoad" type="text" placeholder="Квартира">
                            </div>
                            <p class="help-block text-danger"></p>
                        </div>
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
            <div class='rules'>Правила</div>
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

