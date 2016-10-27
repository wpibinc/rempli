<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\MeCategory;
use App\MeProduct;
use Illuminate\Http\Request;
use App\AvProduct;
use App\Product;
use App\Review;
use Auth;
use DB;
use App\LaCategory;
use App\LaProduct;
use Illuminate\Contracts\Auth\Guard;
use View;
use Carbon\Carbon;

class MainController extends Controller
{
    public function __construct(Guard $auth)
    {
        if (! \App::runningInConsole()) {
            $shop = session('shop');
            switch($shop){
                case 'Me':
                    $categories = Category::whereHas('mecategories', function($q){
                        $q->whereNotNull('category_id');
                    })->get();
                    break;
                case 'La':
                    $categories = Category::whereHas('lacategories', function($q){
                        $q->whereNotNull('category_id');
                    })->get();
                    break;
                default:
                    $categories = Category::all()->sortBy("order");
                    break;
            }

            view()->share('categories', $categories);
        }
        $now = Carbon::now();
        $userId = $auth->id();
        $haveSubs = false;

        $subscription = \App\Subscription::where('user_id', $userId)
                ->where('end_subscription', '>', $now)
                ->first();

        if($subscription){
            if($subscription->auto_subscription == 0){
                $haveSubs = true;
            }elseif ($subscription->is_free){
                $haveSubs = true;
            } else {
                $subs = $subscription->invoices()->where('title', 'Продление подписки')->first();
                if($subs->is_paid){
                    $haveSubs = true;
                }
            }
        }
        //dd($haveSubs);
//        foreach($subscriptions as $subsciption){
//            $start = new Carbon($subsciption->start_subscription);
//            $end = new Carbon($subsciption->end_subscription);
//            if($now->between($start, $end)){
//                $haveSubs = true;
//            }
//        }
        
        View::share('subscription', $haveSubs);
    }
    
    public function index()
    {
        return view('index');
    }
    
    public function price()
    {
        return view('price');
    }
    
    public function reviews(Request $request)
    {
        $user = Auth::user();
        if($request->isMethod('POST')){
            if($user){
                $this->validate($request, [
                    'message' => 'required'
                ]);

                $review = new Review();
                $review->user_id = $user->id;
                $review->name = $user->fname;
                $review->content = $request->input('message');
                $review->save();
            }
        }
        $reviews = DB::table('reviews')
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

        return view('where', [
            'reviews' => $reviews,            
        ]);
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function contacts()
    {
        return view('contacts');
    }
    
    public function startPage()
    {
        return view('startpage');
    }
    
    public function rules(Request $request)
    {
        return view('rules');
    }
    
    public function productAutocompleteSearch(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            abort(404);
        }
        $term = $request->input('term');
        if(!$term){
            abort(404);
        }
        
        $shop = session('shop');
        $json = array();
        switch($shop){
            case 'Me':
                $json = $this->meAutocompleteSearch($term);
                break;
            case 'La':
                $json = $this->laAutocompleteSearch($term);
                break;
            default:
                $json = $this->avAutocompleteSearch($term);
                break;
        }
        
        return response()->json($json);
    }
    
    protected function avAutocompleteSearch($term)
    {
        $json = array();
        $avProducts = AvProduct::where('name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(3)
                ->get();
        $products = Product::where('product_name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(3)
                ->get();
        
        foreach($avProducts as $product){
            $price = $product->price;
            $amount = $product->price_style;
            $weight = $product->original_typical_weight;
            if($product->price_style == '1 кг'){
                $price = $product->price/10;
                $amount = '100 гр';
                $weight = 100;
            } elseif ($product->price_style == '100 г'){
                $amount = $product->price_style;
            } elseif ($product->original_typical_weight == '0') {
                $amount = $product->price_style;
            }
            $json[] = array(
                'label' => $product->name,
                'image' => 'http://av.ru'.$product->image,
                'id' => $product->id,
                'price' => $price,
                'weight' => $weight,
                'category' => $product->category_id,
                'shop' => 'Av',
            );
        }
        foreach($products as $product){
            if(count($json) >= 3){
                break;
            }
            $price = $product->price;
            $amount = $product->amount;
            $weight = $product->weight;
            if($product->amount == 'за 1кг'||$product->amount == 'за 1кг.'){
                $price = $product->price/10;
                $amount = 'за 100 гр';
                $weight = 100;
            }
            $json[] = array(
                'label' => $product->product_name,
                'image' => $product->img,
                'id' => $product->id,
                'price' => $price,
                'weight' => $weight,
                'category' => $product->category_id,
                'shop' => ''
            );
        }
        
        return $json;
    }
    
    protected function laAutocompleteSearch($term)
    {
        $json = array();
        $products = LaProduct::where('name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(3)
                ->get();
        
        foreach($products as $product){
            $category = $product->laCategory->categories->first();
            $categId = $category?$category->id:'';
            $json[] = array(
                'label' => $product->name,
                'image' => $product->image,
                'id' => $product->id,
                'price' => $product->price,
                'weight' => '',
                'category' => $categId,
                'shop' => $product->shop,
            );
        }
        
        return $json;
    }

    protected function meAutocompleteSearch($term)
    {
        $json = array();
        $products = MeProduct::where('name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(3)
                ->get();

        foreach($products as $product){
            $category = $product->meCategory->categories->first();
            $categId = $category?$category->id:'';
            $json[] = array(
                'label' => $product->name,
                'image' => $product->image,
                'id' => $product->id,
                'price' => $product->price,
                'weight' => '',
                'category' => $categId,
                'shop' => $product->shop,
            );
        }

        return $json;
    }
    
    public function mainSearch(Request $request)
    {
        $word = $request->input('word');
        if(!$word){
            return response()->json(['success' => false]);
        }
        $shop = session('shop');
        $json;
        switch($shop){
            case 'Me': $json = $this->meSearch($word);
                break;
            case 'La': $json = $this->laSearch($word);
                break;
            default:
                $json = $this->avSearch($word);
            break;
        }
        
        
        return response()->json($json);
    }
    
    protected function avSearch($word)
    {
        $avProducts = AvProduct::where('name', 'like', '%'.$word.'%')
                ->orderBy('updated_at')
                ->get();
        $products = Product::where('product_name', 'like', '%'.$word.'%')
                ->orderBy('updated_at')
                ->get();
        $json = array(
            'success' => true,
            'products' => array(),
        );
        if(!count($avProducts)&&!count($products)){
            return response()->json(['success' => false]);
        }
        if(count($avProducts)){
            foreach($avProducts as $product){
                $price = $product->price;
                $amount = $product->price_style;
                $weight = $product->original_typical_weight;
                if($product->price_style == '1 кг'){
                    $price = $product->price/10;
                    $amount = '100 гр';
                    $weight = 100;
                } elseif ($product->price_style == '100 г'){
                    $amount = $product->price_style;
                } elseif ($product->original_typical_weight == '0') {
                    $amount = $product->price_style;
                }
                $json['products'][] = array(
                    'objectId' => $product->id,
                    'cvalues' => explode(";", $product->cvalues),
                    'ctitles' => explode(";", $product->ctitles),
                    'img_sm' => 'http://av.ru' . $product->image,
                    'category' => $product->category_id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'amount' => 'за ' . $amount,
                    'weight' => $weight,
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at,
                    'shop' => 'Av',
                );
            }
        }
        
        if(count($products)){
            foreach($products as $product){
                $price = $product->price;
                $amount = $product->amount;
                $weight = $product->weight;
                if($product->amount == 'за 1кг'||$product->amount == 'за 1кг.'){
                    $price = $product->price/10;
                    $amount = 'за 100 гр';
                    $weight = 100;
                }
                $json['products'][] = array(
                    'objectId'      => $product->id,
                    'cvalues'       => explode(",", $product->cvalues),
                    'ctitles'       => explode(",", $product->ctitles),
                    'img_sm'        => $product->img,
                    'category'      => $product->category_id,
                    'product_name'  => $product->product_name,
                    'price'         => $price,
                    'amount'        => $amount,
                    'weight'        => $weight,
                    'description'   => $product->description,
                    'updatedAt'     => (string) $product->updated_at,
                    'shop' => '',
                );
            }
        }
        
        return $json;
    }
    
    protected function laSearch($word)
    {
        $products = LaProduct::where('name', 'like', '%'.$word.'%')
                ->orderBy('updated_at')
                ->get();
        $json = array(
            'success' => true,
            'products' => array(),
        );
        if(!count($products)){
            return response()->json(['success' => false]);
        }
        
        
        foreach($products as $product){
            $category = $product->laCategory->categories->first();
            $categId = $category ? $categId = $category->id : '';
            $json['products'][] = array(
                'objectId' => $product->id,
                'cvalues' => '',
                'ctitles' => '',
                'img_sm' => $product->image,
                'category' => $categId,
                'product_name' => $product->name,
                'price' => $product->price,
                'amount' => $product->price_style,
                'weight' => '',
                'description' => $product->description,
                'updatedAt' => $product->updated_at,
                'shop' => $product->shop
            );
        }
        
        return $json;
    }

    protected function meSearch($word)
    {
        $products = MeProduct::where('name', 'like', '%'.$word.'%')
                ->orderBy('updated_at')
                ->get();
        $json = array(
            'success' => true,
            'products' => array(),
        );
        if(!count($products)){
            return response()->json(['success' => false]);
        }


        foreach($products as $product){
            $category = $product->meCategory->categories->first();
            $categId = $category ? $categId = $category->id : '';
            $json['products'][] = array(
                'objectId' => $product->id,
                'cvalues' => '',
                'ctitles' => '',
                'img_sm' => $product->image,
                'category' => $categId,
                'product_name' => $product->name,
                'price' => $product->price,
                'amount' => $product->price_style,
                'weight' => '',
                'description' => $product->description,
                'updatedAt' => $product->updated_at,
                'shop' => $product->shop
            );
        }

        return $json;
    }

    public function checkAlertInvoice()
    {

        $late_invoice = Invoice::where('is_paid', '0')
            ->where('last_pay_day', '<', Carbon::now())->first();
        if(isset($late_invoice)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}

