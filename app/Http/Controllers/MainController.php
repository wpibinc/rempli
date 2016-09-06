<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\AvProduct;
use App\Product;

class MainController extends BaseController
{
    public function index()
    {
//        $categories = \App\Category::all();
        return view('index');
    }
    
    public function price()
    {
        return view('price');
    }
    
    public function where()
    {
        return view('where');
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
}

