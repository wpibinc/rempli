<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AvProduct;
use App\Product;
use App\Review;
use Auth;

class MainController extends Controller
{
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
        $reviews = Review::all();

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
    
    public function productSearch(Request $request)
    {
        $term = $request->input('term');
        if(!$term){
            abort(404);
        }
        $avProducts = AvProduct::where('name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(5)
                ->get();
        $products = Product::where('product_name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(5)
                ->get();
        $json = array();
        foreach($avProducts as $product){
            $json[] = array(
                'label' => $product->name,
                'image' => 'http://av.ru'.$product->image,
                'id' => $product->id,
                'price' => $product->price,
                'weight' => $product->original_typical_weight,
                'category' => $product->category_id,
            );
        }
        foreach($products as $product){
            if(count($json) >= 5){
                break;
            }
            $json[] = array(
                'label' => $product->product_name,
                'image' => $product->img,
                'id' => $product->id,
                'price' => $price,
                'weight' => $product->weight,
                'category' => $product->category_id,
            );
        }
        return response()->json($json);
    }
    
    public function rules(Request $request)
    {
        return view('rules');
    }
}

