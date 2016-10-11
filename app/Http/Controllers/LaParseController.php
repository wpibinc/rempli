<?php
namespace App\Http\Controllers;

use duzun\hQuery;
use File;
use DB;
use Illuminate\Support\Facades\Artisan;
use SleepingOwl\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\LaCategory;
use App\LaProduct;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LaParseController extends AdminController
{
    const URL_CATALOG = 'http://shop.lamaree.ru/catalog/';
    const URL = 'http://shop.lamaree.ru/';
    
    protected $productCount = 0;
    protected $categoryCount = 0;
    protected $categoryId;
    
    public function __construct(Request $request)
    {
        $this->path = public_path() . '/parser/cache/';
    }
    
    public function index(Request $request)
    {
        return $this->renderContent(view('admin.la-parser'));
    }
    
    public function getCategories()
    {
        $doc = hQuery::fromUrl(self::URL_CATALOG);
        $categoryLinks = $doc->find('#catalog > li');
        foreach($categoryLinks as $categoryLink){
            $liClass = $categoryLink->attr('class');
            if(!$liClass){
                $a = $categoryLink->find('a');
                if(!$a){
                    continue;
                }
                $link = $a->attr('href');
                $name = trim($a->text());
                $parent = 0;
                $laCategory = LaCategory::where('link', $link)->first();
                if(!$laCategory){
                    LaCategory::create([
                        'name' => $name,
                        'link' => $link,
                        'parent_id' => $parent,
                    ]);
                    $this->categoryCount++;
                }
            }
        }
        
        return redirect('admin/parser-la')->with('status', 'Добавлено '.$this->categoryCount.'  категорий');
    }
    
    public function getProducts()
    {
        $products = LaProduct::all();
        foreach($products as $product){
            $product->delete();
        }
        $categories = LaCategory::all();
        if(!count($categories)){
            return redirect('admin/parser-la')->with('status', 'Необходимо получить категории');
        }
        foreach($categories as $category){
            $this->categoryId = $category->id;
            $doc = hQuery::fromUrl($category->link);
            $ul = $doc->find('#catalog > li.active > ul');
            if($ul){
                $as = $ul->find('a');
                foreach($as as $a){
                    $link = $a->attr('href');
                    $name = trim($a->text());
                    $parent = $category->id;
                    $laCategory = LaCategory::where('link', $link)->first();
                    if($laCategory){
                        continue;
                        
                    }
                    LaCategory::create([
                        'name' => $name,
                        'link' => $link,
                        'parent_id' => $parent,
                    ]);
                    $this->categoryCount++;
                    $subDoc = hQuery::fromUrl($link);
                    $this->getProductsFormLink($subDoc);
                }
            }else{
                $this->getProductsFormLink($doc);
            }
        }
        
        return redirect('admin/parser-la')->with('status', 'Добавлено '.$this->productCount.'  товаров, '.$this->categoryCount.' категорий');
    }
    
    protected function getProductsFormLink($doc)
    {
        $products = $doc->find('.catalog .product_holder > .product_grid a');
        if(!$products){
            return;
        }
        foreach($products as $product){
            $link = $product->attr('href');
            if(!$link){
                continue;
            }
            $productDoc = hQuery::fromUrl($link);
            $this->getProductInfo($productDoc, $link);
        }
        $this->pagination($doc);
    }
    
    protected function getProductInfo($doc, $link)
    {
        $articul = $doc->find('#content #article_price #left_side_right > p:first-child');
        if(!$articul){
            return;
        }
        $articul = trim($articul->text());

        $ps = $doc->find('#content #article_price #left_side_right p');
        if(!$ps){
            return;
        }
        $i = 0;
        $priceStyle;
        foreach($ps as $p){
            if($i === 1){
                $priceStyle = trim($p->text());
            }
            $i++;
        }
        if(!$priceStyle){
            $priceStyle = '1 шт';
        }

        $name = $doc->find('#content #article_price #left_side > h1');
        if(!$name){
            return;
        }
        $name = trim($name->text());
        $categoryId = $this->categoryId;
        $originalPrice = $doc->find('#content #article_price #left_side_right > p.weight');
        if(!$originalPrice){
            $originalPrice = 0;
        }
        $originalPrice = (float) trim($originalPrice->text());
        $price = $doc->find('#content #article_price #left_side_right > p.pcs');
        if(!$price){
            return;
        }
        $price = (float) trim($price->text());
        $image = $doc->find('#content > img');
        if($image){
            $image = $image->attr('src');
        }else{
            $image = null;
        }
        $description = $doc->find('#tabcontent_1');
        if(!$description){
            $description = '';
        }else{
            $description = trim($description->text());
        }
        LaProduct::create([
            'articul' => $articul,
            'name' => $name,
            'link' => $link,
            'la_category_id' => $this->categoryId,
            'original_price' => $originalPrice,
            'price' => $price,
            'image' => $image,
            'price_style' => $priceStyle,
            'description' => $description,
        ]);
        $this->productCount++;
    }
    
    protected function pagination($doc)
    {
        $paginationLinks = $doc->find('.catalog > .catalog_tab');
        if(!$paginationLinks){
            return;
        }
        $nextLink = $paginationLinks->find('.ctrlNext a');
        if(!$nextLink){
            return;
        }
        $nextLink = $nextLink->attr('href');
        $nextDoc = hQuery::fromUrl($nextLink);
        $this->getProductsFormLink($nextDoc);
        
    }
}
