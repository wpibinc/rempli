@extends('layouts.main')

@section('content')
@foreach($errors->get('code') as $message)
<p class="error">{{$message}}</p>
@endforeach
    {{ Form::open(array('url' => '/confirm-code', 'method' => 'post')) }}
        <div class="form-group">
            {!! Form::label('Введите код') !!}
            {!! Form::text('code', null,
                array('required',
                      'placeholder'=>'код')) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Отправить',
              array('class'=>'btn btn-primary')) !!}
        </div>
    {{ Form::close() }}
@endsection

