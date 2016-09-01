<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{


    public function get()
    {
        $product = \App\Product::find(1);
        dd($product->img_sm);
        $path = resource_path() . '/json/';
        $categories = 'categories.json';
        $json = File::get($path . $categories);
        $data = json_decode($json, true);

        return $data;
    }


    public function save()
    {
        $path = resource_path() . '/json/';
        $path = resource_path() . '/json/';
        $categories = 'categories.json';
        $json = File::get($path . $categories);
        $data = json_decode($json, true);

        foreach ($data as $item) {
            \App\Product::updateOrCreate(['objectId' => $item['objectId']],
                [
                    'objectId' => $item['objectId'],
                    'category_id' => \App\Category::where('alias', $item['category'])->first()->category_id,
                    'img' => $item['img_sm'],
                    'product_name' => $item['product_name'],
                    'price' => $item['price'],
                    'amount' => $item['amount']
                ]
            );
        }

        return $data;
    }
}
