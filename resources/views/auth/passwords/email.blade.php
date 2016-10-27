@extends('layouts.main')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Сброс пароля</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            @foreach($errors->get('phone') as $message)
                                <p class="error">{{$message}}</p>
                            @endforeach
                            <label for="phone" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-custom-reset">
                                    Восстановить
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery(function($){
        $("#phone").mask("+7 (999) 999-9999");
    });
</script>
@endsection
