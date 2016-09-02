<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use DB;

class CategoryController extends BaseController
{

    public function get() {
        $path = resource_path() . '/json/';
        $categories= 'categories.json';
        $json = File::get($path . $categories);

        //dd(json_decode($json, true));

        $data = json_decode($json, true);

        foreach ($data as $item) {
            $category[] = $item['category'];
        }
        return  array_unique($category);
    }


    public function save () {
        $path = resource_path() . '/json/';
        $categories= 'categories.json';
        $json = File::get($path . $categories);

        //dd(json_decode($json, true));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $category[] = $item['category'];
        }
        $u_category = array_unique($category);

        foreach ($u_category as $key =>$value) {
            \App\Category::updateOrCreate(['category_id' => $key], array('alias' => $value));
        }
    }

    public function getCategory(Request $request)
    {
        if(!$request->isXmlHttpRequest())
        {
            abort(404);
        }
        global $id;
        $id = (int) $request->input('id');
        $category = \App\Category::with('avProducts', 'products', 'avcategories')->where('category_id', '=', $id)->first();
        $category->getRelations();
        $json = array(
            'avCategories' => array(),
            'products' => array(),
        );
        if(!empty($category->avcategories)){
            foreach($category->avcategories as $avCateg){
                $json['avCategories'][] = array(
                    'id' => $avCateg->id,
                    'name' => $avCateg->name
                );
            }
        }
        
        if(!empty($category->products)){
            foreach($category->products as $product){
                $price = $product->price;
                $amount = $product->amount;
                if($product->amount == 'за 1кг'){
                    $price = $product->price/10;
                    $amount = 'за 100 гр';
                }
                $json['products'][] = [
                    'objectId'      => $product->id,
                    'cvalues'       => explode(",", $product->cvalues),
                    'ctitles'       => explode(",", $product->ctitles),
                    'img_sm'        => $product->img,
                    'category'      => $product->category_id,
                    'product_name'  => $product->product_name,
                    'price'         => $price,
                    'amount'        => $amount,
                    'weight'        => $product->weight,
                    'description'   => $product->description,
                    'updatedAt'     => (string) $product->updated_at
                ];
            }
        }
        if(!empty($category->avProducts)){
            foreach($category->avProducts as $product){
                $price = $product->price;
                $amount = $product->original_price_style;
                
                if($product->original_price_style == '1 кг'){
                    $price = $product->price/10;
                    $amount = '100 гр';
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
                    'weight' => $product->original_typical_weight,
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at
                );
            }
        }
        return response()->json($json);
    }
    
    public function getAvCategory(Request $request)
    {
        if(!$request->isXmlHttpRequest())
        {
            abort(404);
        }
        $id = $request->input('id');
        $products = \App\AvCategory::find($id)->products;
        $json = array();
        if(!empty($products)){
            foreach($products as $product){
                $price = $product->price;
                $amount = $product->original_price_style;
                
                if($product->original_price_style == '1 кг'){
                    $price = $product->price/10;
                    $amount = '100 гр';
                }
                $json[] = array(
                    'objectId' => $product->id,
                    'cvalues' => explode(";", $product->cvalues),
                    'ctitles' => explode(";", $product->ctitles),
                    'img_sm' => 'http://av.ru' . $product->image,
                    'category' => $product->category_id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'amount' => 'за ' . $amount,
                    'weight' => $product->original_typical_weight,
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at
                );
            }
        }
        
        return response()->json($json);
    }
}
