@extends('layouts.main')

@section('title')

@section('content')
    <div class='reviews'>
        @if(!empty($reviews))
            @foreach($reviews as $review)
            <div class="review-item">
                <span class="title">{{$review->name}}</span>
                <p class="content">{{$review->content}}</p>
            </div>
            @endforeach
        @endif
    </div>
    @if(Auth::user())
        {{ Form::open(array('url' => '/reviews', 'method' => 'post')) }}

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
    @endif
@endsection