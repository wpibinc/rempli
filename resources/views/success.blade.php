@extends('layouts.main2')

@section('title')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="css/order.css">
@endsection

@section('content')
    <div class="container">

        <div class="jumbotron content">

            <h1 class="orderheader">Спасибо за заказ!</h1>

            <h2  id="successinfo">Ваш заказ был нами успешно получен. В ближайшие несколько минут, мы позвоним Вам для уточнения информации.</h2>
        </div>
    </div>
@endsection