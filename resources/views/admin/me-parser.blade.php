@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<a href="/admin/me-get-categories">Получить категории</a>|
<a href="/admin/me-get-products">Получить продукты</a>

