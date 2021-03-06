<?php

//Главная панель админки
Route::get('', ['as' => 'admin.dashboard', function () {
	$content = 'Define your dashboard here.';
	return AdminSection::view($content, 'Dashboard');

}]);

//Экспорт продуктов из базы в JSON для сайта
Route::get('export', ['as' => 'admin.export', function () {
	$content = '
    <!--a href="/products/json/?av=1" class="btn-actions">Сохранить каталог продуктов (новый)</a><br><br><br-->
    <a href="/products/json" class="btn-actions">Сохранить каталог продуктов</a>
    ';
	return AdminSection::view($content, 'Экспорт продуктов');
}]);

//Очистить кеш
Route::get('cache', ['as' => 'admin.cache', function () {
    $content = '<a href="/admin/parser/clear" class="btn-actions">Очистить кеш</a>';
    return AdminSection::view($content, 'Кеш');
}]);

//Generate promo code index
Route::get('promo-code', ['as' => 'admin.promo-code', function () {

    $subscriptions = DB::table('subscriptions')
        ->where('promocode', '!=', NULL)
        ->paginate(15);
    $content = view('admin.promocode', compact('subscriptions'));
	return AdminSection::view($content, 'Промо Коды');
}]);
Route::post('promo-code/create', ['as' => 'admin.promocodecreate', 'uses' => '\App\Http\Controllers\SubscriptionController@promoCodeCreate']);

//Панель парса
Route::get('parser', ['as' => 'admin.parser', 'uses' => '\App\Http\Controllers\ParseController@admin']);

//Парсинг всех продуктов для выбранных категорий
Route::get('parser/all', ['as' => 'admin.parser.all', 'uses' => '\App\Http\Controllers\ParseController@getAllProducts']);

//Парсинг все категорий
Route::get('parser/category', ['as' => 'admin.parser.cat', 'uses' => '\App\Http\Controllers\ParseController@gatAllCategory']);

//Информация о продукте по ID
Route::get('parser/{id}/info', ['as' => 'admin.parser.id_info', 'uses' => '\App\Http\Controllers\ParseController@getProductInfo']);

//Все продукты категории
Route::get('parser/{category_id}/all', ['as' => 'admin.parser.id_info', 'uses' => '\App\Http\Controllers\ParseController@getProductOfCategory']);

//Общее число продуктов в категории (тестовый)
Route::get('parser/{category_id}/total', ['as' => 'admin.parser.total', 'uses' => '\App\Http\Controllers\ParseController@getTotalItem']);

//Возвращает статус парсинга
Route::get('parser/status', ['as' => 'admin.parser.status', 'uses' => '\App\Http\Controllers\ParseController@status']);

//Очистка кеша
Route::get('parser/clear', ['as' => 'admin.parser.clear', 'uses' => '\App\Http\Controllers\ParseController@clear']);

Route::get('parser-la', '\App\Http\Controllers\LaParseController@index');


Route::get('parser-me', '\App\Http\Controllers\MeParseController@index');

Route::get('la-get-products', ['as' => 'admin.la_get_products', 'uses' => '\App\Http\Controllers\LaParseController@getProducts']);
Route::get('la-get-categories', ['as' => 'admin.la_get_categories', 'uses' => '\App\Http\Controllers\LaParseController@getCategories']);
Route::get('me-get-products', ['as' => 'admin.me_get_products', 'uses' => '\App\Http\Controllers\MeParseController@getProducts']);
Route::get('me-get-categories', ['as' => 'admin.me_get_categories', 'uses' => '\App\Http\Controllers\MeParseController@getCategories']);

//Users
//Route::get('/users', ['as' => 'admin.users', 'uses' => '\App\Http\Controllers\UserController@index']);

