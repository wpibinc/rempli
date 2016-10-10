@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<a href="/admin/la-get-categories">Получить категории</a>
<a href="/admin/la-get-products">Получить продукты</a>

