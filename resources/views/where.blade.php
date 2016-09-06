@extends('layouts.main')

@section('title')

@section('content')
    <div class='reviews'>
        @if(!empty($reviews))
            @foreach($reviews as $review)
            @endforeach
        @endif
    </div>
    {{ Form::open(array('url' => '/reviews', 'method' => 'post')) }}
    <div class="form-group">
    {!! Form::label('Ваше имя') !!}
    {!! Form::text('name', $userName, 
        array('required', 
              'class'=>'form-control', 
              'placeholder'=>'имя')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Ваш E-mail') !!}
        {!! Form::text('email', $userEmail, 
            array('required', 
                  'class'=>'form-control', 
                  'placeholder'=>'e-mail')) !!}
    </div>

    <div class="form-group">
        {!! Form::label('Ваш отзыв') !!}
        {!! Form::textarea('message', null, 
            array('required', 
                  'class'=>'form-control', 
                  'placeholder'=>'отзыв')) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Отправить', 
          array('class'=>'btn btn-primary')) !!}
    </div>
    {{ Form::close() }}
@endsection