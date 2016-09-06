@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Войти или <a href="/register">Зарегистрироваться</a></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">


                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Телефон">

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif

                        </div>

                        {{--<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">--}}


                                {{--<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Логин">--}}

                                {{--@if ($errors->has('username'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('username') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}

                        {{--</div>--}}

                        {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                            {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                            {{--<div class="col-md-6">--}}
                                {{--<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">--}}

                                {{--@if ($errors->has('email'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Пароль">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        </div>

                        {{--<div class="form-group">--}}
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox" name="remember"> Запомнить--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <button type="submit" class="btn-signin btn btn-primary btn-block" id="loginButton">Вход</button>
                                <a class="btn-link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($){
        $("#phone").mask("+7 (999) 999-9999");
    });
</script>
@endsection
