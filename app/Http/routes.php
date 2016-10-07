<?php



//Главная - магазин
Route::get('/', 'MainController@index');

Route::any('/reviews', 'MainController@reviews');

Route::get('/about', 'MainController@about');

Route::get('/contacts', 'MainController@contacts');

Route::get('/price', 'MainController@price');

Route::get('autocomplete-product-search', 'MainController@productAutocompleteSearch');

Route::get('search', 'MainController@mainSearch');

Route::get('/enter', function () {
    return view('auth.enter');
});

Route::get('/category', 'CategoryController@getCategory');
Route::get('/getavcategory', 'CategoryController@getAvCategory');

Route::any('/confirm-code', 'UserController@confirmCode');

Route::get('/rules', 'MainController@rules');
//Закрытые роуты

Route::group(['middleware' => 'auth'], function () {

    Route::any('/order', 'OrderController@index');


    Route::get('/payment', 'OrderController@payment');

    Route::any('/success', 'OrderController@success');
    
    Route::any('/my-account', 'UserController@myAccount');
    
    Route::post('change-user-info', 'UserController@changeInfo');
    
    Route::get('get-order-details', 'UserController@getOrderDetails');
    
    Route::post('add-adress', 'UserController@addAdress');
    Route::post('delete-adress', 'UserController@deleteAdress');

    Route::post('/subscription/create', 'SubscriptionController@create');
    Route::post('/subscription/update', 'SubscriptionController@update');
    
    Route::post('add-to-order-list', 'UserController@addToOrderList');
});

#---------ПАРС--------------------------------
Route::get('av', '\App\Http\Controllers\ParseController@index');
Route::get('av/menu', '\App\Http\Controllers\ParseController@menu');



Route::post('/enter', '\App\Http\Controllers\Auth\AdminAuthController@login');

Route::auth();

#---------ПЕРЕНЕСТИ В КОНТРОЛЛЕР--------------------------------


Route::get('/products/json', function () {
    ini_set('memory_limit','256M');
    //$products = \App\Product::take(10)->get();


        $products = \App\AvProduct::all();
        foreach ($products as $product) {
            $category=$product->avcategory->categories->first();
            //dd((is_null($category)) ? 0 : $category->alias);
            $json[] = [
                //'objectId' => (string)$product['av_category_id'] . '_' . (string)$product['id'],
                'objectId' => (is_null($category)) ? 'none' : $category->alias . '_' . (string)$product['id'],
                'cvalues' => explode(";", $product['cvalues']),
                'ctitles' => explode(";", $product['ctitles']),
                'img_sm' => 'http://av.ru' . $product['image'],
                'category' => (is_null($category)) ? 0 : $category->alias,
                'product_name' => $product['name'],
                'price' => $product['price'],
                'amount' => 'за ' . $product['original_price_style'],
                'weight' => $product['original_typical_weight'],
                'description' => $product['description'],
                'updatedAt' => (string)$product->updated_at
            ];
        }

        $products = \App\Product::all();
        foreach ($products as $product) {
            $category = $product->category;
            $json[] = [
                //''=> '',
                // 'objectId'      => (string) $product['objectId'],
                //'objectId'      => (string) $product['id'],
                'objectId' => (is_null($category)) ? 'none' : $category->alias . '_' . (string)$product['id'],
                'cvalues' => explode(",", $product['cvalues']),
                'ctitles' => explode(",", $product['ctitles']),
                'img_sm' => $product['img'],
                'category' => $product->category->alias,
                'product_name' => $product['product_name'],
                'price' => $product['price'],
                'amount' => $product['amount'],
                'weight' => $product['weight'],
                'description' => $product['description'],
                'updatedAt' => (string)$product->updated_at
            ];
        }


    $path = public_path() . '/data/categories.json';

    // File::put($path,  json_encode($json,TRUE));
    File::put($path,  'var json =' . json_encode($json, JSON_UNESCAPED_UNICODE));

    return redirect()->back()->with('success_message', 'Файл сохранен.');

});



Route::get('/products/json_old', function () {
    ini_set('memory_limit','256M');
    //$products = \App\Product::take(10)->get();

    if (request()->get('av')) {
        $products = \App\AvProduct::all();
        foreach ($products as $product) {
            $category=$product->avcategory->categories->first();
           //dd((is_null($category)) ? 0 : $category->alias);
            $json[] = [
                'objectId' => (string)$product['av_category_id'],
                'cvalues' => explode(";", $product['cvalues']),
                'ctitles' => explode(";", $product['ctitles']),
                'img_sm' => 'http://av.ru' . $product['image'],
                'category' => (is_null($category)) ? 0 : $category->alias,
                'product_name' => $product['name'],
                'price' => $product['price'],
                'amount' => 'за ' . $product['original_price_style'],
                'weight' => $product['original_typical_weight'],
                'description' => $product['description'],
                'updatedAt' => (string)$product->updated_at
            ];
        }
    }
    else
    {
        $products = \App\Product::all();
        foreach ($products as $product)
            $json[] = [
                //''=> '',
                'objectId'      => (string) $product['objectId'],
                'cvalues'       => explode(",", $product['cvalues']),
                'ctitles'       => explode(",", $product['ctitles']),
                'img_sm'        => $product['img'],
                'category'      => $product->category->alias,
                'product_name'  => $product['product_name'],
                'price'         => $product['price'],
                'amount'        => $product['amount'],
                'weight'        => $product['weight'],
                'description'   => $product['description'],
                'updatedAt'     => (string) $product->updated_at
            ];
    }


    $path = public_path() . '/data/categories.json';

    // File::put($path,  json_encode($json,TRUE));
    File::put($path,  'var json =' . json_encode($json, JSON_UNESCAPED_UNICODE));

    return redirect()->back()->with('success_message', 'Файл сохранен.');

});





#---------ТЕСТОВЫЕ------------------------------------------------

Route::get('changeadminpassword', function(){
    $user = \App\User::find(1);
    $user->password = bcrypt(1111);
    $user->save();
});

Route::get('/ordertest', function () {

    $r = [
        'name'=>'lol',
        'items' => [
                    ['objectId'=>'00001'],
                    ['objectId'=>'00002'],
        ],

    ];
    $items = array_only($r,'items');
   // dd($items['items']);
    $order=App\Order::create(array_except($r,['items']));
    $items = $order->items()->createMany($items['items']);

});

Route::get('/testsms', function () {
    $apiId = 'BAFD72FC-2E9F-6C9F-77BF-4F2BDEEBD21F';
    $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));

//    $sms1 = new \Zelenin\SmsRu\Entity\Sms($phone1, $text1);
//
//    $client->smsSend($sms1);
//
//    $client->smsSend(new \Zelenin\SmsRu\Entity\SmsPool([$sms1]));


    dd($client->myLimit());
    //return $client->smsStatus($smsId);
});

Route::get('/test', function () {

//    $p = App\Product::findOrFail(6291);
//
//    $pg=$p->category;
    $poststring = ['page_23' => 3];
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, 'http://shop.lamaree.ru/catalog/zhivaya-produktciya/?page_23=3' );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_REFERER, "http://shop.lamaree.ru/catalog/zhivaya-produktciya/");
    $result = curl_exec( $ch );
    echo $result;
});


Route::get('/menu', function () {
    $categories = \App\Category::all();

    return view('menu', compact('categories'));

});

Route::get('startpage', 'MainController@startPage');

Route::get('allusersactive', 'TestController@allusersactive');