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
        $order = (int) DB::table('la_categories')->max('order');
        $i = 0;
        foreach($categoryLinks as $categoryLink){
            $liClass = $categoryLink->attr('class');
            if(!$liClass){
                $a = $categoryLink->find('a');
                if(!$a){
                    continue;
                }
                $link = $a->attr('href');
                $name = trim($a->text());;
                $parent = 0;
                $laCategory = LaCategory::where('link', $link)->first();
                if(!$laCategory){
                    LaCategory::create([
                        'name' => $name,
                        'link' => $link,
                        'parent_id' => $parent,
                        'order' => $order
                    ]);
                    $order++;
                    $i++;
                }
            }
        }
        
        return redirect('admin/parser-la')->with('status', 'Добавлено '.$i.'  категорий');
    }
    
    public function getProducts()
    {
        
        return redirect('admin/parser-la')->with('status', 'Ok');
    }
}
