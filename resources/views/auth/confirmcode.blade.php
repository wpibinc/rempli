@extends('layouts.main')

@section('content')

    <div class="container custom-style">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 style="text-align: center">Введите код подтверждения из SMS</h3></div>
                 <div class="panel-body">
                        {{ Form::open(array('url' => '/confirm-code', 'method' => 'post')) }}
                        <div class="form-group">

                            {!! Form::text('code', null,
                                array('required',
                                      'placeholder'=>'SMS код','class'=>'form-control')) !!}
                            @foreach($errors->get('code') as $message)
                                <p class="error">{{$message}}</p>
                            @endforeach
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Отправить',
                              array('class'=>'btn-signin btn btn-primary btn-block')) !!}
                        </div>
                        {{ Form::close() }}
                 </div>
                </div>
            </div>
            </div>
        </div>
    </div>


@endsection

