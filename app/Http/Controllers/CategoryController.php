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
        $query = "SELECT * FROM products "
                . "WHERE category_id = $id";
        $products = DB::select($query);
        $json = array();
        if(!empty($products)){
            foreach($products as $product){
                $json[] = [
                    //''=> '',
                    'objectId'      => $product->id,
                    'cvalues'       => explode(",", $product->cvalues),
                    'ctitles'       => explode(",", $product->ctitles),
                    'img_sm'        => $product->img,
                    'category'      => $product->category_id,
                    'product_name'  => $product->product_name,
                    'price'         => $product->price,
                    'amount'        => $product->amount,
                    'weight'        => $product->weight,
                    'description'   => $product->description,
                    'updatedAt'     => (string) $product->updated_at
                ];
            }
        }
        $query = "SELECT * FROm av_products "
                . "WHERE category_id = (SELECT id FROM categories "
                . "WHERE category_id = $id)";
        $avProduct = DB::select($query);
        if(!empty($avProduct)){
            foreach($avProduct as $product){
                $json[] = array(
                    'objectId' => $product->id,
                    'cvalues' => explode(";", $product->cvalues),
                    'ctitles' => explode(";", $product->ctitles),
                    'img_sm' => 'http://av.ru' . $product->image,
                    'category' => $product->category_id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'amount' => 'за ' . $product->original_price_style,
                    'weight' => $product->original_typical_weight,
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at
                );
            }
        }
        return response()->json($json);
    }
}
