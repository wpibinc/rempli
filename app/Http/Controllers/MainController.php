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
        $avProducts = AvProduct::where('name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(3)
                ->get();
        $products = Product::where('product_name', 'like', $term.'%')
                ->orderBy('updated_at')
                ->take(3)
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
            if(count($json) >= 3){
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
    
    public function mainSearch(Request $request)
    {
        $word = $request->input('word');
        if(!$word){
            return response()->json(['success' => false]);
        }
        $avProducts = AvProduct::where('name', 'like', '%'.$word.'%')
                ->orderBy('updated_at')
                ->take(3)
                ->get();
        $products = Product::where('product_name', 'like', '%'.$word.'%')
                ->orderBy('updated_at')
                ->take(3)
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
                $json['products'][] = array(
                    'label' => $product->name,
                    'image' => 'http://av.ru'.$product->image,
                    'id' => $product->id,
                    'price' => $product->price,
                    'weight' => $product->original_typical_weight,
                    'category' => $product->category_id,
                );
            }
        }
        
        if(count($products)){
            foreach($products as $product){
                $json['products'][] = array(
                    'label' => $product->product_name,
                    'image' => $product->img,
                    'id' => $product->id,
                    'price' => $price,
                    'weight' => $product->weight,
                    'category' => $product->category_id,
                );
            }
        }
        
        return response()->json($json);
    }
    
}

