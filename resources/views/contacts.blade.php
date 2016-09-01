@extends('layouts.main')

@section('title')

@section('content')
    <div class="container">
        <h1>
            Контакты
        </h1>
        <p>Адрес: Смоленская пл. 3, Москва, торгово-деловой комплекс Смоленский Пассаж, офис 762<br>
            Телефон: +7-499-955-26-98<br>
            E-mail: <a href="mailto:info@rempli.ru">info@rempli.ru</a><br>

        </p>


        <iframe width="700" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?language=ru&q=place_id:ChIJ16hApbZLtUYRdIUojtKc49k&key=AIzaSyD9TjPOYJ7gzi6RZQ4_2LEZdXzkKo0akHo" allowfullscreen></iframe>

        <nav>
            <ul class="pager">

                <li class="previous"><a id="backToMain" href="/" class="backForth">
                        <span aria-hidden="true">&larr;</span> На главную</a>
                </li>


            </ul>
        </nav>
    </div>

@endsection