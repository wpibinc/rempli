@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Зарегистрироваться или <a href="/login">Войти</a></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        {{--<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">--}}
                                {{--<input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Логин">--}}
                                {{--@if ($errors->has('username'))--}}
                                    {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('username') }}</strong>--}}
                                    {{--</span>--}}
                                {{--@endif--}}
                        {{--</div>--}}

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <input id="phone " required  type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Телeфон">
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('fname') ? ' has-error' : '' }}">
                            <input id="fname" required  type="text" class="form-control" name="fname" value="{{ old('fname') }}" placeholder="Имя">
                            @if ($errors->has('fname'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('sname') ? ' has-error' : '' }}">
                            <input id="sname" required  type="text" class="form-control" name="sname" value="{{ old('sname') }}" placeholder="Фамилия">
                            @if ($errors->has('sname'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('sname') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" required  type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" required  type="password" class="form-control" name="password"  placeholder="Пароль">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input id="password-confirm" required  type="password" class="form-control" name="password_confirmation" placeholder="Пароль повторно">
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn-signin btn btn-primary btn-block" id="loginButton">Зарегистрироваться</button>
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
