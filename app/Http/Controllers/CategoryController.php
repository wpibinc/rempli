<?php

namespace App\Http\Controllers;

use App\MeCategory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use DB;
use App\LaCategory;
use App\LaProduct;

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
        $shop = session('shop');
        //global $id;
        $id = (int) $request->input('id');
        $json;
        switch($shop){
            case 'Me':
                $json = $this->getMeCategories($id);
                break;
            case 'La':
                $json = $this->getLaCategories($id);
                break;
            default:
                $json = $this->getAvCategories($id);
            break;
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
        $shop = session('shop');
        $json = array();
        switch($shop){
            case 'Me': $json = $this->getMeSubCategories($id);
                break;
            case 'La': $json = $this->getLaSubCategories($id);
                break;
            default: $json = $this->getAvSubCategories($id);
                break;
        }
        
        
        return response()->json($json);
    }
    
    protected function getAvCategories($id)
    {
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
                $weight = $product->weight;
                if($product->amount == 'за 1кг'||$product->amount == 'за 1кг.'){
                    $price = $product->price/10;
                    $amount = 'за 100 гр';
                    $weight = 100;
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
                    'weight'        => $weight,
                    'description'   => $product->description,
                    'updatedAt'     => (string) $product->updated_at,
                    'shop' => ''
                ];
            }
        }
        if(!empty($category->avProducts)){
            foreach($category->avProducts as $product){
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
                    'shop' => 'Av'
                );
            }
        }
        
        return $json;
    }
    
    protected function getLaCategories($id)
    {
        $json = array(
            'avCategories' => array(),
            'products' => array(),
        );
        $category = \App\Category::where('category_id', '=', $id)->first();
        foreach($category->lacategories as $laCat){
            $json['avCategories'][] = array(
                'id' => $laCat->id,
                'name' => $laCat->name
            );
            
            foreach($laCat->products as $product){
                $json['products'][] = array(
                    'objectId' => $product->id,
                    'cvalues' => '',
                    'ctitles' => '',
                    'img_sm' => $product->image,
                    'category' => $id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'amount' => $product->price_style,
                    'weight' => '',
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at,
                    'shop' => $product->shop
                );
            }
            
            
        }
        return $json;
    }
    
    protected function getLaSubCategories($id)
    {
        $products = LaCategory::find($id)->products;
        $json = array();
        if(!empty($products)){
            foreach($products as $product){
                $price = $product->price;
                $amount = $product->price_style;
                $category = $product->laCategory->categories->first();
                $json[] = array(
                    'objectId' => $product->id,
                    'cvalues' => '',
                    'ctitles' => '',
                    'img_sm' => $product->image,
                    'category' => $category->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'amount' => $amount,
                    'weight' => '',
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at,
                    'shop' => 'La'
                );
            }
        }
        
        return $json;
    }

    protected function getMeCategories($id)
    {
        $json = array(
            'avCategories' => array(),
            'products' => array(),
        );
        $category = \App\Category::where('category_id', '=', $id)->first();
        foreach($category->mecategories as $meCat){
            $json['avCategories'][] = array(
                'id' => $meCat->id,
                'name' => $meCat->name
            );

            foreach($meCat->products as $product){
                $json['products'][] = array(
                    'objectId' => $product->id,
                    'cvalues' => '',
                    'ctitles' => '',
                    'img_sm' => $product->image,
                    'category' => $id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'amount' => $product->price_style,
                    'weight' => '',
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at,
                    'shop' => $product->shop
                );
            }
        }
        return $json;
    }

    protected function getMeSubCategories($id)
    {
        $products = MeCategory::find($id)->products;
        $json = array();
        if(!empty($products)){
            foreach($products as $product){
                $price = $product->price;
                $amount = $product->price_style;
                $category = $product->meCategory->categories->first();
                $json[] = array(
                    'objectId' => $product->id,
                    'cvalues' => '',
                    'ctitles' => '',
                    'img_sm' => $product->image,
                    'category' => $category->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'amount' => $amount,
                    'weight' => '',
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at,
                    'shop' => 'Me'
                );
            }
        }

        return $json;
    }
    
    protected function getAvSubCategories($id)
    {
        $products = \App\AvCategory::find($id)->products;
        $json = array();
        if(!empty($products)){
            foreach($products as $product){
                $price = $product->price;
                $amount = $product->price_style;
                $weight = $product->original_typical_weight;
                if($product->price_style == '1 кг'){
                    $price = $product->price/10;
                    $amount = '100 гр';
                    $weight = 100;
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
                    'weight' => $weight,
                    'description' => $product->description,
                    'updatedAt' => $product->updated_at,
                    'shop' => 'Av'
                );
            }
        }
        
        return $json;
    }
}
